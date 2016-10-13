<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 13/06/2016
 * Time: 09:21 PM
 */

namespace CivicApp\BLL\Obra;


use CivicApp\BLL\Post\PostHandler;
use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\DAL\MapItem\Criterias\BarrioCriteria;
use CivicApp\DAL\MapItem\Criterias\CategoryCriteria;
use CivicApp\DAL\MapItem\Criterias\ObrasCriteria;
use CivicApp\DAL\MapItem\Criterias\YearCriteria;
use CivicApp\DAL\MapItem\IMapItemRepository;
use CivicApp\DAL\Post\IPostRepository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Entities\MapItem\MapItem;
use CivicApp\Utilities\Logger;
use CivicApp\Entities\MapItem\MapItemType;
use CivicApp\Utilities\Utilities;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ObraHandler {

    private $mapItemRepository;
    private $catalogRepo;

    public function __construct(IMapItemRepository $mapItemRepo, ICatalogRepository $catalogRepo)
    {
        $this->mapItemRepository = $mapItemRepo;
        $this->catalogRepo = $catalogRepo;


    }

    public function SaveObra(MapItem $obra)
    {
        $method = 'SaveObra';
        Logger::startMethod($method);

        if(!is_null($obra->location) && $obra->location->id==0 &&
            (is_null($obra->location->location)|| trim($obra->location->location)=='' ) )
            $obra->location = null;

        $this->ValidateObra($obra);


        Logger::endMethod($method);

        $obra->mapItemType = App::make(MapItemType::class);

        $obra->mapItemType->id = 1;



        if($obra->id == 0)
          return  $this->mapItemRepository->SaveObra($obra);
        else
            return $this->mapItemRepository->UpdateObra($obra);


    }

    public function BulkCreateObra(MapItem $obra)
    {
        $method = 'SaveObra';
        Logger::startMethod($method);

        try {
            $obra->category        = $this->catalogRepo->FindCategory($obra->category->category);
            $obra->barrio          = $this->catalogRepo->FindBarrio($obra->barrio->name);
            $obra->cpc             = $this->catalogRepo->FindCpc($obra->cpc->name);
            $obra->status          = $this->catalogRepo->FindStatus($obra->status->status);
            $obra->mapItemType->id = 1;
            if (is_null($obra->category) || is_null($obra->barrio) || is_null($obra->cpc) || is_null($obra->status)) {
                Logger::logError($method, 'Error grabando obra importada desde archivo.'.$obra->toJson().'Error:'.trans('mapitemserrorcodes.0200',
                        [ 'catalog' => 'El barrio o el CPC o la Categoría o el estado' ]));
                return false;
            }

            $this->mapItemRepository->SaveObra($obra);
        }
        catch(\Exception $ex)
        {
            return false;
        }

        Logger::endMethod($method);
        return true;

    }

    public function DeleteObra($id, PostHandler $postHandler)
    {
        $method = 'DeleteObra';
        Logger::startMethod($method);

        if( is_null($this->mapItemRepository->GetMapItem($id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0201'),0201);

        $photos = $postHandler->GetPhotosByMapItemId($id);

        $this->mapItemRepository->DeleteObra($id);
        $deleteflag = true;

        if(!is_null($photos) && $photos->count() > 0) {
            foreach ($photos as $photo) {

                if(!$postHandler->DeletePhysicalPhoto($photo->path))
                    $deleteflag = false;
            }
        }

        Logger::endMethod($method);

        return$deleteflag;
    }

    public  function  GetAllObras()
    {
        $method = 'GetAllObras';
        Logger::startMethod($method);

        return $this->mapItemRepository->GetAllObras();


    }


    public  function  GetAllObrasJson()
    {
        $method = 'GetAllObrasJson';
        Logger::startMethod($method);

        return $this->mapItemRepository->GetAllObrasJson();


    }

    public function SearchByCriteria($criteria)
    {
        $method = 'SearchByCriteria';
        Logger::startMethod($method);

        $this->mapItemRepository->pushCriteria(new ObrasCriteria());

        if( array_has($criteria,'year') && $criteria["year"]!=null )
        {
            $this->mapItemRepository->pushCriteria(new YearCriteria($criteria["year"]));
        }

        if( array_has($criteria,'category') && $criteria["category"]!=null )
        {
            $this->mapItemRepository->pushCriteria(new CategoryCriteria($criteria["category"]));
        }

        if( array_has($criteria,'barrio') && $criteria["barrio"]!=null )
        {
            $this->mapItemRepository->pushCriteria(new BarrioCriteria($criteria["barrio"]));
        }

        $result = $this->mapItemRepository->SearchCriteria();
        Logger::endMethod($method);

        return $result;


    }

    private function ValidateObra(MapItem $obra)
    {
        $barrio = $this->catalogRepo->GetBarrio($obra->barrio->id);
        if(is_null($obra->barrio) || is_null($barrio))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El barrio']),0200);

        if( is_null($obra->location)  && is_null($barrio->location))
            throw new ObraValidateException(trans('mapitemserrorcodes.0202'),0202);

        if(is_null($obra->cpc) || is_null($this->catalogRepo->GetCpc($obra->cpc->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El cpc']),0200);

        if(is_null($obra->category) || is_null($this->catalogRepo->GetCategory($obra->category->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'La categoría']),0200);

        if(is_null($obra->status) || is_null($this->catalogRepo->GetStatus($obra->status->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El estado']),0200);

    }

    public function ValidateObraValues(Collection $obra)
    {
        $isValid = true;

        if($obra->has('ano'))
        {
            $currentYear = date('Y')+1;
            if($obra["ano"] <= $currentYear && $obra["ano"] > ($currentYear-10))
                $obra->put('isValidYear',1);
            else {
                $obra->put('isValidYear', 0);
                $isValid = false;
            }
        }
        else {
            $obra->put('isValidYear', 0);
            $isValid = false;
        }

        if($obra->has('cpc')&& isset($obra["cpc"]) && !is_null($obra["cpc"]) &&  trim($obra["cpc"]) != ''
            && !is_null($this->catalogRepo->FindCpc($obra["cpc"])))
            $obra->put('isValidCpc', 1);
        else {
            $obra->put('isValidCpc', 0);
            $isValid = false;
        }

        $barrio = $this->catalogRepo->FindBarrio($obra["barrio"]);
        if($obra->has('barrio')&& isset($obra["barrio"]) && !is_null($obra["barrio"]) &&  trim($obra["barrio"]) != ''
            && !is_null($barrio))
            $obra->put('isValidBarrio', 1);
        else {
            $isValid = false;
            $obra->put('isValidBarrio', 0);
        }

        if($obra->has('categoria')&& isset($obra["categoria"]) && !is_null($obra["categoria"]) &&  trim($obra["categoria"]) != ''
            && !is_null($this->catalogRepo->FindCategory($obra["categoria"])))
            $obra->put('isValidCategory', 1);
        else {
            $isValid = false;
            $obra->put('isValidCategory', 0);
        }

        if($obra->has('titulo')&& isset($obra["titulo"]) && !is_null($obra["titulo"]) &&  trim($obra["titulo"]) != '')
            $obra->put('isValidTitle', 1);
        else {
            $isValid = false;
            $obra->put('isValidTitle', 0);
        }

        if(!$obra->has('presupuesto') || !isset($obra["presupuesto"]) || is_null($obra["presupuesto"]) ||  trim($obra["presupuesto"]) == '' )
            $obra->put('isValidBudget', 1);
        else if($obra->has('presupuesto')&& isset($obra["presupuesto"]) && !is_null($obra["presupuesto"]) &&  trim($obra["presupuesto"]) != ''
            && is_numeric($obra["presupuesto"]))
            $obra->put('isValidBudget', 1);
        else {
            $isValid = false;
            $obra->put('isValidBudget', 0);
        }

        if($obra->has('estado')&& isset($obra["estado"]) && !is_null($obra["estado"]) &&  trim($obra["estado"]) != ''
            && !is_null($this->catalogRepo->FindStatus($obra["estado"])))
            $obra->put('isValidStatus', 1);
        else {
            $isValid = false;
            $obra->put('isValidStatus', 0);
        }


        if($obra->has('ubicacion')&& isset($obra["ubicacion"]))
            if(is_null($obra["ubicacion"]) ||  trim($obra["ubicacion"]) == '') {
                if(!is_null($barrio) && !is_null($barrio->location) && !is_null($barrio->location->location)) {
                    $obra->put('isValidAddress', 1);
                    $obra->put('location', null);
                }
                else
                {
                    $obra->put('isValidAddress', 0);
                    $obra->put('location', null);
                    $isValid = false;
                }
            }
            else
            {
                if($obra->has('location')&& isset($obra["location"])
                    && !is_null($obra["location"]) && trim($obra["location"]) != '' )
                {
                    $obra->put('isValidAddress', 1);
                }
                else {

                    $location = Utilities::GeoCodeAdrress($obra["ubicacion"]);
                    if ($location['status'] == 'OK') {
                        $obra->put('isValidAddress', 1);
                        $obra->put('location', $location['lat'] . ',' . $location['lng']);
                    } else {
                        $obra->put('isValidAddress', 0);
                        $obra->put('location', null);
                        $isValid = false;
                    }
                }
            }
        else {
            if(!is_null($barrio) && !is_null($barrio->location) && !is_null($barrio->location->location)) {
                $obra->put('isValidAddress', 1);
                $obra->put('location', null);
            }
            else {
                $obra->put('isValidAddress', 0);
                $obra->put('location', null);
                $isValid = false;
            }
        }

        $obra->put('isValid',$isValid);

        return $obra;

    }


    public function GetObra($id)
    {
        $method = 'GetObra';
        try{
            Logger::startMethod($method);

            return $this->mapItemRepository->GetMapItem($id);
        }
        catch(RepositoryException $ex)
        {
            throw $ex;
        }
        catch(\Exception $ex)
        {
            Logger::logError($method,$ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }
    }

    function UpdateStatusObra($obraId, $statusId)
    {
        $method = 'UpdateStatusObra';
        Logger::startMethod($method);
        $this->mapItemRepository->UpdateStatusObra($obraId,$statusId);
    }

}