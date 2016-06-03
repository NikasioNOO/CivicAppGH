<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 26/05/2016
 * Time: 10:19 PM
 */

namespace CivicApp\DAL\Catalog;


use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Models\Category;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Logger;
use Illuminate\Database\QueryException;
use CivicApp\Models;
use CivicApp\Entities;
use Exception;

class CatalogRepository implements  ICatalogRepository {

    private $mapper;


    public function __construct(IMapper  $mapperparam){
        $this->mapper = $mapperparam;
    }



    function GetAllCategories()
    {
        $method='getAllCategories';
        try{
        Logger::startMethod($method);

            $categories = Category::all();

            return collect($this->mapper->map(Models\Category::class, Entities\MapItem\Category::class,$categories->all()));

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }

    }


    function GetAllBarrios()
    {
        $method='GetAllBarrios';
        try{
            Logger::startMethod($method);

            $barrios = Models\Barrio::all();

            return $this->mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,$barrios->all());

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0401'),0401);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0401'),0401);
        }
    }


    function GetAllCpcs()
    {
        $method='GetAllCpcs';
        try{
            Logger::startMethod($method);

            $cpc = Models\Cpc::all();

            return $this->mapper->map(Models\Cpc::class, Entities\MapItem\Cpc::class,$cpc->all());

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0402'),0402);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0402'),0402);
        }
    }


    function GetAllStatuses()
    {
        $method='GetAllStatuses';
        try{
            Logger::startMethod($method);

            $cpc = Models\Status::all();

            return $this->mapper->map(Models\Status::class, Entities\MapItem\Status::class,$cpc->all());

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0403'),0402);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0403'),0402);
        }
    }


    function AddCategory(Entities\MapItem\Category $category)
    {
        $method = 'AddCategory';
        Logger::startMethod($method);
        try
        {
            /** @var Category $categoryModel */
            $categoryModel = $this->mapper->map(Entities\MapItem\Category::class, Category::class, $category);
            $categoryModel->save();

            return $this->mapper->map(Category::class, Entities\MapItem\Category::class,  $categoryModel);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function AddBarrio(Entities\MapItem\Barrio $barrio)
    {
        // TODO: Implement AddBarrio() method.
    }


    function AddCpc(Entities\MapItem\Cpc $cpc )
    {
        // TODO: Implement AddCpc() method.
    }

    function AddStatus(Entities\MapItem\Status $status)
    {
        // TODO: Implement AddStatus() method.
    }


    function FindCategory($category)
    {
        $method = 'FindCategory';
        Logger::startMethod($method);
        try
        {
            $categoryDB = Models\Category::where('category','like',$category)->first();

            if(is_null($categoryDB))
                return null;
            else
                return $this->mapper->map(Models\Category::class, Entities\MapItem\Category::class,$category);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }

    }


    function FindBarrio($barrio)
    {
        $method = 'FindBarrio';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function FindCpc($cpc)
    {
        $method = 'FindCpc';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function FindStatus($status)
    {
        $method = 'FindStatus';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function GetCategory($id)
    {
        $method = 'GetCategory';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function GetBarrio($id)
    {
        $method = 'GetBarrio';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function GetCpc($id)
    {
        $method = 'GetCpc';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }


    function GetStatus($id)
    {
        $method = 'GetStatus';
        Logger::startMethod($method);
        try
        {

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),0400);
        }
    }
}