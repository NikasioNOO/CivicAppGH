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

    /** @var
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

    public function  __construct(App $app, IMapper  $mapperparam  ){

        $this->app = $app;
        $this->resetScope();
        $this->makemodel();
        $this->mapper = $mapperparam;
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
    public function all($columns = array('*')) {
        $this->applyCriteria();
        return new Collection($this->mapper->map( $this->model(), $this->entity(), $this->model->get($columns)->toArray()));
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data) {

        return $this->model->create(($this->mapper->map( $this->entity() ,$this->model(),$data)));
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
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
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

        foreach($this->getCriteria() as $criteria) {
            if($criteria instanceof Criteria)
                $this->model = $criteria->apply($this->model, $this);
        }

        return $this;
    }
}