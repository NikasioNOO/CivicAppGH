<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 12:12 AM
 */

namespace CivicApp\DAL\Repository;
use CivicApp\DAL\Auth\IlegalEntityAuthException;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Container\Container as App;
use CivicApp\Utilities\Mapper;
use CivicApp\Utilities\IMapper;
use Illuminate\Support\Collection;

abstract class Repository implements IRepository, ICriteria {
    /** @var App
     */
    private  $app;

    /** @var Model
     * */
    protected  $model;

    /**
     * @var Collection
     */
    protected $criteria;


    /** @var Mapper $mapper */
    protected $mapper;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    public function  __construct(App $app, IMapper  $mapperparam, Collection $criteria  ){

        $this->app = $app;
        $this->resetScope();
        $this->makemodel();
        $this->mapper = $mapperparam;
        $this->criteria = $criteria;
    }

    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract function model();

    abstract protected function entity();


    protected function validateEntity($ent)
    {
        $classEntity = $this->entity();
        if(!$ent instanceof $classEntity)
            throw new IlegalEntityAuthException("Entity must be an instance of ".$classEntity);
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model->newQuery();
    }

    /**
     *
     * @param array $columns : Columna que se requiere retornar para todos los registros
     * @return mixed
     */
    protected function all($columns = ['*']) {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function create($data) {

        $newModel = $this->mapper->map( $this->entity() ,$this->model(),$data);
        $newModel->save();
        return $newModel;//$this->model->create($arr);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->where('id',$id)->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    protected function find($id, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    public function findById($id, $columns = ['*']) {

        return $this->mapper->map($this->model(), $this->entity() , $this->model->find($id, $columns));
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*']) {
        $this->applyCriteria();
       return $this->model->where($attribute, '=', $value)->first($columns);

    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByRetEntity($attribute, $value, $columns = ['*']) {
        $this->applyCriteria();
        $res = $this->model->where($attribute, '=', $value)->first($columns);
        if(isset($res) )
        {
            return $this->mapper->map( $this->model() ,$this->entity() ,$res);
        }
        else
            return $res;
    }

    /**
     * @return $this
     */
    public function resetScope() {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true){
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria() {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria) {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria) {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function  applyCriteria() {
        if($this->skipCriteria === true)
            return $this;

        $criterias = $this->getCriteria();
        if(isset($criterias)) {
            foreach ($this->getCriteria() as $criteria) {
                if ($criteria instanceof Criteria)
                    $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
    * @param Model $dbModel
    * @param Model $updatedModel
     */
    protected function UpdatModelAttribute($dbModel, $updatedModel)
    {
        foreach($updatedModel->getAttributes() as $attribute => $attrValue)
        {
            if (!is_object($updatedModel->$attribute))
                $dbModel->$attribute = $updatedModel->$attribute;
        }

    }

    public function SearchCriteria()
    {
        $method = "SearchCriteria";
        try {

            Logger::startMethod($method);

            $itemas = $this->all();

            $itemsEntities = $this->mapper->map($this->model(), $this->entity(), $itemas->all());

            Logger::endMethod($method);

            return $itemsEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql() );
            throw new RepositoryException(trans('repositoryerrorcodes.0200'),0103);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('repositoryerrorcodes.0200'),0103);
        }

    }
}