<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 19/05/2016
 * Time: 12:27 AM
 */

namespace CivicApp\DAL\MapItem;


use CivicApp\DAL\Repository\Repository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Models;
use CivicApp\Entities;
use CivicApp\Utilities\Constants;
use CivicApp\Utilities\Logger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class MapItemRepository extends Repository implements IMapItemRepository {

    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    function model()
    {
        return Models\MapItem::class;
    }


    protected function entity()
    {
        return Entities\MapItem\MapItem::class;
    }


    /**
     * Return all Obras Presupuesto Participativo
     * @return mixed
     * @throws RepositoryException
     */
    public function GetAllObras()
    {
        $method = "GetAllObras";
        try {

            Logger::startMethod($method);

            $obras = $this->model->with('mapItemType','category','status','barrio','cpc','location')
                ->whereHas('mapItemType',function($query){
                    $query->where('type',Constants::typeObra);
                })->get();

            $obrasEntities = $this->mapper->map(Models\MapItem::class, Entities\MapItem\MapItem::class, $obras->all());

            Logger::endMethod($method);

            return $obrasEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo);
            throw new RepositoryException(trans('mapitemserrorcodes.0103'),0103);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->errorInfo);
            throw new RepositoryException(trans('mapitemserrorcodes.0103'),0103);
        }

    }

    public function SearchCriteria()
    {
        $method = "GetAllObras";
        try {

            Logger::startMethod($method);

            $obras = $this->all();

            $obrasEntities = $this->mapper->map($this->model(), $this->entity(), $obras->all());

            Logger::endMethod($method);

            return $obrasEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql() );
            throw new RepositoryException(trans('mapitemserrorcodes.0103'),0103);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('mapitemserrorcodes.0103'),0103);
        }

    }


    /**
     * @param Entities\MapItem\MapItem $obra
     */
    public function SaveObra(Entities\MapItem\MapItem $obra )
    {
        $method = 'SaveObra';
        Logger::startMethod($method);
        try {
            DB::beginTransaction();
            /** @var Models\MapItem $obraModel */
            $obraModel = $this->mapper->map($this->entity(), $this->model(), $obra);

            if (!is_null( $obraModel->location )) {
                $obraModel->location->save();
                $obraModel->Location()->associate($obraModel->location->id);
            }

             $obraModel->save();

            DB::commit();


            Logger::endMethod($method);

            return $obraModel->id;

        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('mapitemserrorcodes.0100'),0100);

        }
        catch(Exception $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('mapitemserrorcodes.0100'),0100);

        }

    }

    public function UpdateObra(Entities\MapItem\MapItem $obra ){
        $method = 'UpdateObra';
        Logger::startMethod($method);

        try {
            DB::beginTransaction();
            /** @var Models\MapItem $obraModel */
            $obraModel = $this->mapper->map($this->entity(), $this->model(), $obra);

            /** @var Models\MapItem $obraModelDB */
            $obraModelDB = $this->findOrFail($obraModel->id);

            $this->UpdatModelAttribute($obraModelDB,$obraModel);

            if ( ! is_null($obraModel->location)) {
                /** @var Model $locationDB */
                $locationDB = Models\GeoPoint::findOrFail($obraModel->location->id);
                $this->UpdatModelAttribute($locationDB, $obraModel->location);
                $locationDB->save();
            }

            $obraModelDB->save();

            DB::commit();

            Logger::endMethod($method);
            return $obraModelDB->id;



        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('mapitemserrorcodes.0101'),0100);

        }
        catch(ModelNotFoundException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('mapitemserrorcodes.0102'),0101);

        }
        catch(Exception $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('mapitemserrorcodes.0101'),0100);

        }
    }


}