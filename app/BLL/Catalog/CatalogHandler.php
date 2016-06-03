<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 27/05/2016
 * Time: 12:15 AM
 */

namespace CivicApp\BLL\Catalog;


use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\Entities\MapItem\Category;
use CivicApp\Utilities\Logger;

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

}