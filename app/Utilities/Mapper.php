<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/09/2015
 * Time: 08:24 PM
 */

namespace CivicApp\Utilities;
use CivicApp\Entities\Base\BaseEntity;
use Illuminate\Contracts\Foundation\Application as App;
use Illuminate\Database\Eloquent\Model ;
use Illuminate\Support\Collection;
use Mockery\CountValidator\Exception;
use CivicApp\Utilities\Enums;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Cast\Object_;


class Mapper implements IMapper
{

    protected $app;

  //  protected $entityClass;
  //  protected $modelClass;
  //  protected $customMapToModel = array();
  //  protected $customMapToEntity = array();

//    protected $entitiesMap = array();
 //   protected $modelsMap = array();



  //  protected $customMapToModels =  array();
  //  protected $customMapToEntities = array();

    const BASIC_MAP_TO_ENTITY ='basicMapToEntity';
    const BASIC_MAP_TO_MODEL = 'basicMapToModel';

    protected $mapperConfig =  [];
    protected $customMapConfig = [];

    public function addMap($fromClass, $toClass,  $typeMapper)
    {

        if(isset($mapperConfig[$fromClass][$toClass])) {
            throw new MapperException('the configuration map has already exist for ' . $fromClass . ' & ' . $toClass);
        }

        if($typeMapper == Enums\MapperConfig::toEntity) {
            $this->mapperConfig[$fromClass][$toClass] = self::BASIC_MAP_TO_ENTITY;
        }
        elseif($typeMapper == Enums\MapperConfig::toModel) {
            $this->mapperConfig[$fromClass][$toClass] = self::BASIC_MAP_TO_MODEL;
        }
        else
        {
            throw new MapperException('Type mapper not exist');
        }

        $this->customMapConfig[$fromClass][$toClass] = [];


    }


    function  __construct(App $ap)
    {
        $this->app= $ap;

    }
/*
    public function setClasses( $entityClass, $modelClasee)
    {
        $this->entityClass = $entityClass;
        $this->modelClass = $modelClasee;
    }
*/

    public function map( $fromClass , $toClass, $obj)
    {
        if(!isset($this->mapperConfig[$fromClass][$toClass]))
        {
            throw new MapperException("The configuration map ".$fromClass."-".$toClass." not exist");
        }

        $method=$this->mapperConfig[$fromClass][$toClass];

        $objResult = $this->$method($fromClass,$toClass, $obj);

        return $this->executeCustomMap($fromClass,$toClass,$obj,$objResult );

        
    }

    public function mapArray($toClass, $array)
    {

        $arrayResult = $this->basicMapArrayToEntity($toClass, $array);

        return $this->executeCustomArrayMap($toClass,$array,$arrayResult );


    }

/*
    public function mapToModel(BaseEntity $entity)
    {
        $model = $this->basicMapToModel($entity);

       // printf("\n nuevo model:\n");

     //   var_dump($model);


        return $this->executeCustomMapToModel($entity, $model);

    }

    public function mapToEntity(Model $model)
    {
        $entity = $this->basicMapToEntity($model);

        return $this->executeCustomMapToEntity($model,$entity);

    }

    public function basicMapToModelOLD(BaseEntity $paramentity)
    {
        $this->validate($paramentity, $this->entityClass);
        $model = $this->makeModel();
        foreach( $paramentity->getters as $attribute)
        {
            if(!is_object($paramentity->$attribute))
            {
                $model->$attribute = $paramentity->$attribute;

            }
        }
        return $model;
    }

*/
    /**
     * @param $ModelToMap
     *        Clase Model hacia la cual se desea Mapear
     * @param $fromEntity
     *        Clase Entity desde la cual se desea Mapear
     * @param BaseEntity $paramentity
     * @return mixed
     * @throws MapperException
     */
    protected function basicMapToModel($fromEntity, $ModelToMap ,  $paramentity)
    {

        $returnModel = null;

        if(!isset($this->mapperConfig[$fromEntity][$ModelToMap]))
            throw new MapperException('Model Mapper for '.$ModelToMap.'not exist');

        if(is_array($paramentity))
        {
            $modelArray = [];
            foreach($paramentity as $entity)
            {
                $this->validate($entity, $fromEntity);
                $modelNew = $this->makeModel($ModelToMap);
                foreach( $entity->getters as $attribute)
                {
                    if(!is_object($entity->$attribute))
                    {
                        $modelNew->$attribute = $entity->$attribute;

                    }
                }
                array_push($modelArray,$modelNew);
            }

            $returnModel = $modelArray;

        }
        else {

            $this->validate($paramentity, $fromEntity);
            $model = $this->makeModel($ModelToMap);
            foreach ($paramentity->getters as $attribute) {
                if (!is_object($paramentity->$attribute) && !is_null($paramentity->$attribute)) {
                    $model->$attribute = $paramentity->$attribute;

                }
            }
            $returnModel = $model;
        }
        return $returnModel;
    }

    /**
     * @param $fromModel
     *         Clase Model desde la cual se desea mapear
     * @param $EntityToMap
     *         Clase Entidad hacea la cual se desea mapear
     * @param Model $paramModel
     * @return BaseEntity
     * @throws MapperException
     */
    protected function basicMapToEntity($fromModel, $EntityToMap, $paramModel)
    {

        $returnEntity= null;
        if(is_array($paramModel))
        {
            $entityArray = [];

            foreach($paramModel as $model)
            {
                if(!isset($this->mapperConfig[$fromModel][$EntityToMap]))
                    throw new MapperException('Model Mapper for '.$EntityToMap.'not exist');
                $this->validate($model,$fromModel);
                $entityNew = $this->makeEntity($EntityToMap);
                foreach( $model->getAttributes() as $attribute => $attrValue)
                {
                    if(!is_object($model->$attribute) && !Utilities::Endswith($attribute,'_id'))
                    {
                        $entityNew->$attribute = $model->$attribute;
                    }
                }
                array_push($entityArray,$entityNew);
            }

            $returnEntity = $entityArray;


        }
        else {

            if (!isset($this->mapperConfig[$fromModel][$EntityToMap]))
                throw new MapperException('Model Mapper for ' . $EntityToMap . 'not exist');
            $this->validate($paramModel, $fromModel);
            $entity = $this->makeEntity($EntityToMap);
            foreach ($paramModel->getAttributes() as $attribute => $attrValue) {
                if (!is_object($paramModel->$attribute) && !Utilities::Endswith($attribute,'_id')) {
                    $entity->$attribute = $paramModel->$attribute;

                }
            }

            $returnEntity = $entity;
        }
        return $returnEntity;
    }

    protected function basicMapArrayToEntity($EntityToMap, $paramArray)
    {

        $returnEntity= null;

        $entity = $this->makeEntity($EntityToMap);
        foreach ($paramArray as $attribute => $attrValue) {
            if (!is_array($paramArray[$attribute])) {
                $entity->$attribute = $attrValue;
            }
        }

        $returnEntity = $entity;

        return $returnEntity;
    }

    private function executeCustomArrayMap($toClass,  $array, $objResult)
    {

        if(isset($this->customMapConfig['Array'][$toClass]) &&
            !is_null(isset($this->customMapConfig['Array'][$toClass])))
            foreach ($this->customMapConfig['Array'][$toClass] as $callback) {
                $objResult = $callback($array, $objResult);
            }


        return $objResult;
    }


/*
    private function basicMapToEntityOLD(Model $paramModel)
    {
        $this->validate($paramModel, $this->entityClass);
        $entity = $this->makeEntity($this->entityClass);
        foreach( $paramModel->getAttributes() as $attribute)
        {
            if(!is_object($paramModel->$attribute))
            {
                $entity->$attribute = $paramModel->$attribute;

            }
        }
        return $entity;
    }
*/
    private function executeCustomMap($fromClass,$toClass,  $objFrom, $objTo)
    {

        if(is_array($objFrom))
        {
            $ret = [];
            for( $i =0; $i <  count($objFrom); $i++)
            {
                foreach ($this->customMapConfig[$fromClass][$toClass] as $callback) {
                    $objTo[$i] = $callback($objFrom[$i], $objTo[$i]);
                }
            }
        }
        else {
            foreach ($this->customMapConfig[$fromClass][$toClass] as $callback) {
                $objTo = $callback($objFrom, $objTo);
            }
        }

        return $objTo;
    }
/*
    private function executeCustomMapToModelOLD(BaseEntity $entity,  Model $model)
    {
        foreach($this->customMapToModel as $callback)
        {
            $model = $callback($entity, $model);
        }

        return $model;
    }

    private function executeCustomMapToModel( $ModelToMap, BaseEntity $entity,  Model $model)
    {
        foreach($this->customMapToModels[$ModelToMap] as $callback)
        {
            $model = $callback($entity, $model);
        }

        return $model;
    }

    private function executeCustomMapToEntity( Model $model, BaseEntity $entity)
    {
        foreach($this->customMapToEntity as $callback)
        {
            $model = $callback($model, $entity);
        }

        return $model;
    }
*/
    public function addCustomMap($classFrom, $classTo, $callbackCustom)
    {

        if(!isset($this->customMapConfig[$classFrom][$classTo]))
            throw new MapperException('the configuration map '.$classFrom.'-'.$classTo.' not exist');

        $this->customMapConfig[$classFrom][$classTo][] = $callbackCustom;
    }

    public function addCustomMapArray($classTo, $callbackCustom)
    {

        if(!isset($this->customMapConfig['Array'][$classTo]))
            $this->customMapConfig['Array'][$classTo] = [];
            //throw new MapperException('the configuration map '.'Array-'.$classTo.' not exist');

        $this->customMapConfig['Array'][$classTo][] = $callbackCustom;
    }
/*
    public function addCustomMapToModel($callbackCustom)
    {
        $this->customMapToModel[] = $callbackCustom;
    }

    public function addCustomMapToEntity($callbackCustom)
    {
        $this->customMapToEntity[] = $callbackCustom;
    }
*/


    protected function validate($ent, $entityClass)
    {
        $classEntity = $entityClass;
        if(!$ent instanceof $classEntity)
            throw new MapperException("Entity must be an instance of ".$classEntity);
    }
/*
    protected function makeModelOLD() {
        $model = $this->app->make($this->modelClass);

        if (!$model instanceof Model)
            throw new MapperException("Class {$this->modelClass} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $model;
    }
*/
    private function makeModel($model) {
        $model = $this->app->make($model);

        if (!$model instanceof Model)
            throw new MapperException("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $model;
    }

    private function makeEntity($entityClass) {
        $entity = $this->app->make($entityClass);

        if (!$entity instanceof BaseEntity)
            throw new MapperException("Class {$entityClass} must be an instance of CivicApp\\Entities\\Base\\BaseEntity");

        return $entity;
    }

}