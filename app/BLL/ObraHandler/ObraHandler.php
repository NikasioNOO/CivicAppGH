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



}