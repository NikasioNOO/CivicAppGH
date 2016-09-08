<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 06/09/2016
 * Time: 12:02 AM
 */

namespace CivicApp\DAL\Post\Criterias;


use CivicApp\DAL\Repository\Criteria;
use CivicApp\DAL\Repository\IRepository;
use Illuminate\Database\Eloquent\Model;

class PostsByObra extends Criteria {


    private $_obraId ;
    public function __construct($obraId)
    {
        $this->_obraId = $obraId;
    }
    /**
     * @param Model            $model
     * @param IRepository $repository
     *
     * @return mixed
     */
    public function apply($model, IRepository $repository)
    {
         return $model->with('status','postType','user','photos','postMarkers','postComplaints','positiveCount')
            ->whereHas('mapItem',function($query){
                $query->where('id',$this->_obraId);
            })->withCount('postMarkers');
    }}