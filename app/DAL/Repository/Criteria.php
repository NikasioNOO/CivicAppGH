<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 12:46 AM
 */

namespace CivicApp\DAL\Repository;


abstract class Criteria {
    /**
     * @param $model
     * @param IRepository $repository
     * @return mixed
     */
    public abstract function apply($model, IRepository $repository);
}