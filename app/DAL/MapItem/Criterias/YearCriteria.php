<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 26/05/2016
 * Time: 01:13 AM
 */

namespace CivicApp\DAL\MapItem\Criterias;


use CivicApp\DAL\Repository\Criteria;
use CivicApp\DAL\Repository\IRepository;
use Illuminate\Database\Eloquent\Model;

class YearCriteria extends Criteria {

    private $_year ;
    public function __construct($year)
    {
        $this->_year = $year;
    }
    /**
     * @param Model       $model
     * @param IRepository $repository
     *
     * @return mixed
     */
    public function apply($model, IRepository $repository)
    {
        return $model->where('year',$this->_year);

    }}