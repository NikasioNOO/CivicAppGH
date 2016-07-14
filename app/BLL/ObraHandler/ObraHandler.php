<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 13/06/2016
 * Time: 09:21 PM
 */

namespace CivicApp\BLL\ObraHandler;


use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\DAL\MapItem\IMapItemRepository;
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

        $this->ValidateObra($obra);


        Logger::endMethod($method);

        $obra->mapItemType = App::make(MapItemType::class);

        $obra->mapItemType->id = 1;

        if($obra->id == 0)
          return  $this->mapItemRepository->SaveObra($obra);
        else
            return $this->mapItemRepository->UpdateObra($obra);


    }

    public function DeleteObra($id)
    {
        $method = 'DeleteObra';
        Logger::startMethod($method);

        if( is_null($this->mapItemRepository->GetMapItem($id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0201'),0201);

        $this->mapItemRepository->DeleteObra($id);


        Logger::endMethod($method);
    }

    public  function  GetAllObras()
    {
        $method = 'GetAllObras';
        Logger::startMethod($method);

        return $this->mapItemRepository->GetAllObras();


    }

    private function ValidateObra(MapItem $obra)
    {
        if( is_null($this->catalogRepo->GetBarrio($obra->barrio->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El barrio']),0200);

        if(is_null($this->catalogRepo->GetCpc($obra->cpc->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El cpc']),0200);

        if(is_null($this->catalogRepo->GetCategory($obra->category->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'La categoría']),0200);

        if(is_null($this->catalogRepo->GetStatus($obra->status->id)))
            throw new ObraValidateException(trans('mapitemserrorcodes.0200',['catalog'=>'El estado']),0200);

    }

    public function ValidateObraValues(Collection $obra)
    {
        if($obra->has('ano'))
        {
            $currentYear = date('Y')+1;
            if($obra->ano <= $currentYear && $obra->ano > ($currentYear-10))
                $obra->put('isValidYear',true);
            else
                $obra->put('isValidYear',false);
        }
        else
            $obra->put('isValidYear',false);

        if($obra->has('cpc')&& isset($obra->cpc) && !is_null($obra->cpc) &&  trim($obra->cpc) != ''
            && !is_null($this->catalogRepo->FindCpc($obra->cpc)))
            $obra->put('isValidCpc', true);
        else
            $obra->put('isValidCpc',false);

        if($obra->has('barrio')&& isset($obra->barrio) && !is_null($obra->barrio) &&  trim($obra->barrio) != ''
            && !is_null($this->catalogRepo->FindBarrio($obra->barrio)))
            $obra->put('isValidBarrio', true);
        else
            $obra->put('isValidBarrio',false);

        if($obra->has('categoria')&& isset($obra->categoria) && !is_null($obra->categoria) &&  trim($obra->categoria) != ''
            && !is_null($this->catalogRepo->FindCategory($obra->categoria)))
            $obra->put('isValidCategory', true);
        else
            $obra->put('isValidCategory',false);

        if($obra->has('titulo')&& isset($obra->titulo) && !is_null($obra->titulo) &&  trim($obra->titulo) != '')
            $obra->put('isValidTitle', true);
        else
            $obra->put('isValidTitle',false);

        if($obra->has('presupuesto')&& isset($obra->presupuesto) && !is_null($obra->presupuesto) &&  trim($obra->presupuesto) != ''
            && is_numeric($obra->presupuesto))
            $obra->put('isValidBudget', true);
        else
            $obra->put('isValidBudget',false);

        if($obra->has('estado')&& isset($obra->estado) && !is_null($obra->estado) &&  trim($obra->estado) != ''
            && !is_null($this->catalogRepo->FindStatus($obra->estado)))
            $obra->put('isValidStatus', true);
        else
            $obra->put('isValidStatus',false);


        if($obra->has('ubicacion')&& isset($obra->ubicacion))
            if(is_null($obra->ubicacion) ||  trim($obra->ubicacion) == '') {
                $obra->put('isValidAddress', true);
                $obra->put('location', null);
            }
            else
            {
                $location = Utilities::GeoCodeAdrress($obra->ubicacion);
                if($location['status']=='OK')
                {
                    $obra->put('isValidAddress', true);
                    $obra->put('location', $location['lat'].','.$location['lng']);
                }
                else {
                    $obra->put('isValidCategory', false);
                    $obra->put('location', null);
                }
            }
        else {
            $obra->put('isValidCategory', false);
            $obra->put('location', null);
        }

        return $obra;

    }



}