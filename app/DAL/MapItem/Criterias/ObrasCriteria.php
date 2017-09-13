<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 26/05/2016
 * Time: 01:57 AM
 */

namespace CivicApp\DAL\MapItem\Criterias;


use CivicApp\DAL\Repository\Criteria;
use CivicApp\DAL\Repository\IRepository;
use CivicApp\Utilities\Constants;

class ObrasCriteria extends Criteria {

    /**
     * @param             $model
     * @param IRepository $repository
     *
     * @return mixed
     */
    public function apply($model, IRepository $repository)
    {
        return $model->with('mapItemType','category','status','barrio','cpc','location')
            ->whereHas('mapItemType',function($query){
                $query->where('type',Constants::typeObra);
            });
    }}