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

abstract class Repository implements IRepository, ICriteria {

    private  $app;

    protected  $model;

    public function  __construct(App $app){

        $this->app = $app;
        $this->model = $this->makemodel();
    }

    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract function model();

    abstract protected function entity();

    abstract function mapToModel($entity);

    abstract function mapToEntity($dataModel);

    protected function validateEntity($ent)
    {
        $classEntity = $this->entity();
        if(!$ent instanceof $classEntity)
            throw new IlegalEntityAuthException("Entity must be an instance of ".$classEntity);
    }

    protected function basicMapToModel($entity)
    {
        $this->validateEntity($entity);
        $model = $this->makeModel();
        foreach( $entity->getters as $attribute)
        {
            if(!is_object($entity->$attribute))
            {
                $model->$attribute = $entity->$attribute;

            }

        }
        return $model;
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $model;
    }

    /**
     *
     * @param array $columns : Columna que se requiere retornar para todos los registros
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data) {


        return $this->mapToEntity($this->model->create($this->mapToModel($data)->toArray()));
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
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
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