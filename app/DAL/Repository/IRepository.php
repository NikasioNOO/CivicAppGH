<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 12:02 AM
 */

namespace CivicApp\DAL\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface IRepository
 * Interfaz de repositorio Base
 * @package CivicApp\DAL\Base
 */
interface IRepository {

    /**
     *
     * @param array $columns : Columna que se requiere retornar para todos los registros
     * @return mixed
     */
  //  function search($columns = ['*']);

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    function findById($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByRetEntity($attribute, $value, $columns = ['*']);



    public function findOrFail($id);
}