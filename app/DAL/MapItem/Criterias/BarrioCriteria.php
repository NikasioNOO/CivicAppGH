<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 09/08/2016
 * Time: 12:19 AM
 */

namespace CivicApp\DAL\MapItem\Criterias;


use CivicApp\DAL\Repository\Criteria;
use CivicApp\DAL\Repository\IRepository;
use Illuminate\Database\Eloquent\Model;

class BarrioCriteria extends Criteria {

    private $_barrioId ;
    public function __construct($barrioId)
    {
        $this->_barrioId = $barrioId;
    }

    /**
     * @param Model $model
     * @param IRepository $repository
     *
     * @return mixed
     */

    public function apply($model, IRepository $repository)
    {
       // return $model->where('barrio_id',$this->_barrioId);
        return $model->whereHas('barrio',function($query){
            $query->where('id',$this->_barrioId);
        });
    }}