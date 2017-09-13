<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 27/05/2016
 * Time: 12:15 AM
 */

namespace CivicApp\BLL\Catalog;


use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\Entities\Common\GeoPoint;
use CivicApp\Entities\MapItem\Barrio;
use CivicApp\Entities\MapItem\Category;
use CivicApp\Entities\MapItem\Cpc;
use CivicApp\Utilities\Logger;
use Illuminate\Support\Collection;

class CatalogHandler {

    /** @var ICatalogRepository  */
    private $catalogRepository;

    public function __construct(ICatalogRepository $repository)
    {

        $this->catalogRepository = $repository;
    }

    public function GetAllCategories()
    {
        Logger::startMethod('GetAllCategories');
        return $this->catalogRepository->GetAllCategories();
    }

    public function GetAllStatuses()
    {
        Logger::startMethod('GetAllStatuses');
        return $this->catalogRepository->GetAllStatuses();
    }

    public function GetAllBarrios()
    {
        Logger::startMethod('GetAllBarrios');
        return $this->catalogRepository->GetAllBarrios();
    }

    public function GetAllCpcs()
    {
        Logger::startMethod('GetAllCpcs');
        return $this->catalogRepository->GetAllCpcs();
    }

    public function AddCategory($category)
    {
        $method = 'AddCatalog';
        Logger::startMethod($method);

        if(is_null($category)) {
            throw new CatalogValidateException(trans('catalogerrorcodes.0450'),0450);
        }

        $categoryExist=$this->catalogRepository->FindCategory($category);

        if(!is_null($categoryExist))
            throw new CatalogValidateException(trans('catalogerrorcodes.0451'),0451);

        $categoryExist = new Category();

        $categoryExist->category = $category;

        return $this->catalogRepository->AddCategory($categoryExist);

    }

    public function AddCpc($cpc)
    {
        $method = 'AddCpc';
        Logger::startMethod($method);

        if(is_null($cpc)) {
            throw new CatalogValidateException(trans('catalogerrorcodes.0450'),0450);
        }

        $cpcExist=$this->catalogRepository->FindCpc($cpc);

        if(!is_null($cpcExist))
            throw new CatalogValidateException(trans('catalogerrorcodes.0452'),0451);

        $cpcExist = new Cpc();

        $cpcExist->name = $cpc;

        return $this->catalogRepository->AddCpc($cpcExist);

    }

    public function AddBarrio($barrio)
    {
        $method = 'AddBarrio';
        Logger::startMethod($method);

        if(is_null($barrio)) {
            throw new CatalogValidateException(trans('catalogerrorcodes.0450'),0450);
        }

        $barrioExist=$this->catalogRepository->FindBarrio($barrio);

        if(!is_null($barrioExist))
            throw new CatalogValidateException(trans('catalogerrorcodes.0452'),0451);

        $barrioExist = new Barrio();

        $barrioExist->name = $barrio;

        return $this->catalogRepository->AddBarrio($barrioExist);

    }

    public function SaveCategoriesImages($categoryId, Collection $images)
    {
        $method = 'SaveCategoriesImages';
        Logger::startMethod($method);


       $categoryExist = $this->catalogRepository->GetCategory($categoryId);

        if(is_null($categoryExist)) {
            throw new CatalogValidateException(trans('catalogerrorcodes.0454',['catalog'=>'La categoría']),454);
        }


        if( is_null($categoryExist->images) || trim($categoryExist->images) == '')
        {
            $this->catalogRepository->SaveCategoryImages($categoryId, $images->implode(','));
        }

        $catImages = collect(explode(',',$categoryExist->images))->unique();

        $catImages = $catImages->reject(function ($value, $key) {
            return trim($value) == '';
        });

        foreach($images as $img)
        {
            if(!$catImages->contains($img))
                $catImages->push($img);
        }

        $this->catalogRepository->SaveCategoryImages($categoryId, $catImages->sort()->implode(','));

        Logger::endMethod($method);

    }

    public function SaveBarrioLocation($barrioId, $location)
    {
        $method = 'SaveBarrioLocation';
        Logger::startMethod($method);


        $barrio = $this->catalogRepository->GetBarrio($barrioId);

        if(is_null($barrio)) {
            throw new CatalogValidateException(trans('catalogerrorcodes.0454',['catalog'=>'El barrio']),454);
        }

        if(is_null($barrio->location))
        {
            $barrio->location = new GeoPoint();
            $barrio->location->location = $location;
        }
        else
        {
            $barrio->location->location = $location;
        }

        $this->catalogRepository->UpdateBarrio($barrio);

        Logger::endMethod($method);

    }



}