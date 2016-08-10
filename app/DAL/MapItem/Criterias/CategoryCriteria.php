<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 09/08/2016
 * Time: 12:12 AM
 */

namespace CivicApp\DAL\MapItem\Criterias;


use CivicApp\DAL\Repository\Criteria;
use CivicApp\DAL\Repository\IRepository;

use Illuminate\Database\Eloquent\Model;

class CategoryCriteria extends Criteria {

    private $_categoryId ;
    public function __construct($categoryId)
    {
        $this->_categoryId = $categoryId;
    }

    /**
     * @param Model $model
     * @param IRepository $repository
     *
     * @return mixed
     */

    public function apply($model, IRepository $repository)
    {
        //return $model->where('category_id',$this->_categoryId);
        return $model->whereHas('category',function($query){
            $query->where('id',$this->_categoryId);
        });
    }}