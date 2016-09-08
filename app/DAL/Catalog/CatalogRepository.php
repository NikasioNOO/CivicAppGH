<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 26/05/2016
 * Time: 10:19 PM
 */

namespace CivicApp\DAL\Catalog;


use CivicApp\DAL\Repository\Repository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Models\Category;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Logger;
use Illuminate\Database\QueryException;
use CivicApp\Models;
use CivicApp\Entities;
use Exception;
use DB;

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
            throw new RepositoryException(trans('catalogerrorcodes.0400'),400);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0400'),400);
        }

    }


    /**
     * @return mixed
     * @throws RepositoryException
     */
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
            throw new RepositoryException(trans('catalogerrorcodes.0404'),404);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0404'),404);
        }
    }


    function AddBarrio(Entities\MapItem\Barrio $barrio)
    {
        $method = 'AddBarrio';
        Logger::startMethod($method);
        try
        {
            DB::beginTransaction();
            $barrioModel = $this->mapper->map(Entities\MapItem\Barrio::class, Models\Barrio::class, $barrio);
            if (!is_null( $barrioModel->location )) {
                $barrioModel->location->save();
                $barrioModel->Location()->associate($barrioModel->location->id);
            }
            $barrioModel->save();

            DB::commit();

            return $this->mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,  $barrioModel);
        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0405'),405);
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0405'),405);
        }
    }

    function UpdateBarrio(Entities\MapItem\Barrio $barrio)
    {
        $method = 'AddBarrio';
        Logger::startMethod($method);
        try
        {
            DB::beginTransaction();
            $barrioModel = $this->mapper->map(Entities\MapItem\Barrio::class, Models\Barrio::class, $barrio);

            /** @var Models\Barrio $barrioDB */
            $barrioDB = Models\Barrio::findOrFail($barrio->id);

            $barrioDB->name = $barrioModel->name;


            if (!is_null( $barrioModel->location )) {

                if($barrioModel->location->id != 0) {
                    /** @var Model $locationDB */
                    $locationDB = Models\GeoPoint::findOrFail($barrioModel->location->id);
                    $locationDB->location = $barrioModel->location->location;
                    $locationDB->save();
                }
                else
                {
                    $newLocation = new Models\GeoPoint();
                    $newLocation->location = $barrioModel->location->location;
                    $newLocation->save();
                    $barrioDB->location()->associate($newLocation);
                    //$barrioDB->location()->associate($barrioDB->location->id);
                }

            }
            else if(!is_null($barrioDB->location))
            {
                $id= $barrioDB->location->id;
                $barrioDB->location()->dissociate();
                Models\GeoPoint::destroy($id);
            }
            $barrioDB->save();

            DB::commit();

           // return $this->mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,  $barrioModel);
        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0405'),405);
        }
        catch(Exception $ex)
        {


                        Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0405'),405);
        }
    }

    function AddCpc(Entities\MapItem\Cpc $cpc )
    {
        $method = 'AddCpc';
        Logger::startMethod($method);
        try
        {

            $cpcModel = $this->mapper->map(Entities\MapItem\Cpc::class, Models\Cpc::class, $cpc);
            $cpcModel->save();

            return $this->mapper->map(Models\Cpc::class, Entities\MapItem\Cpc::class,  $cpcModel);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0406'),405);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0406'),405);
        }
    }

    /*function AddStatus(Entities\MapItem\Status $status)
    {
        $method = 'AddStatus';
        Logger::startMethod($method);
        try
        {
            $statusModel = $this->mapper->map(Entities\MapItem\Status::class, Models\Status::class, $status);
            $statusModel->save();

            return $this->mapper->map(Models\Status::class, Entities\MapItem\Status::class,  $statusModel);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0407'),407);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0407'),407);
        }
    }*/


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
                return $this->mapper->map(Models\Category::class, Entities\MapItem\Category::class,$categoryDB);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0408'),408);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0408'),408);
        }

    }


    /**
     * @param $barrio
     *
     * @return Entities\MapItem\Barrio
     * @throws RepositoryException
     */
    function FindBarrio($barrio)
    {
        $method = 'FindBarrio';
        Logger::startMethod($method);
        try
        {
            $barrioDB = Models\Barrio::where('name','like',$barrio)->first();

            if(is_null($barrioDB))
                return null;
            else
                return $this->mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,$barrioDB);

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0409'),409);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0409'),409);
        }
    }


    function FindCpc($cpc)
    {
        $method = 'FindCpc';
        Logger::startMethod($method);
        try
        {
            $cpcDB = Models\Cpc::where('name','like',$cpc)->first();

            if(is_null($cpcDB))
                return null;
            else
                return $this->mapper->map(Models\Cpc::class, Entities\MapItem\Cpc::class,$cpcDB);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0410'),410);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0410'),0410);
        }
    }


    function FindStatus($status)
    {
        $method = 'FindStatus';
        Logger::startMethod($method);
        try
        {
            $statusDB = Models\Status::where('status','like',$status)->first();

            if(is_null($statusDB))
                return null;
            else
                return $this->mapper->map(Models\Status::class, Entities\MapItem\Status::class,$statusDB);
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('catalogerrorcodes.0411'),0411);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('catalogerrorcodes.0411'),0411);
        }
    }


    /**
     *
     * @param $id
     *
     * @return Entities\MapItem\Category
     * @throws RepositoryException
     */
    public function GetPostType($id)
    {
        $method = 'GetPostType';
        Logger::startMethod($method);
        try
        {
            $postType =  Models\PostType::find($id);
            if(is_null($postType))
                return null;
            else
                return $this->mapper->map(Models\PostType::class, Entities\Post\PostType::class, $postType);

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('catalogerrorcodes.0412'));
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('catalogerrorcodes.0412'));
        }
    }


    /**
     *
     * @param $id
     *
     * @return Entities\MapItem\Category
     * @throws RepositoryException
     */
    function GetCategory($id)
    {
        $method = 'GetCategory';
        Logger::startMethod($method);
        try
        {
            $categoryDB =  Models\Category::find($id);
            if(is_null($categoryDB))
                return null;
            else
                return $this->mapper->map(Models\Category::class, Entities\MapItem\Category::class, $categoryDB);

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
            $barrioDb = Models\Barrio::find($id);

            if(is_null($barrioDb))
                return null;
            else
                return $this->mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,$barrioDb);

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
            $cpcDb = Models\Cpc::find($id);

            if(is_null($cpcDb))
                return null;
            else
                return$this->mapper->map(Models\Cpc::class, Entities\MapItem\Cpc::class, $cpcDb);

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
            $statusDb = Models\Status::find($id);

            if(is_null($statusDb))
                return null;
            else
                return $this->mapper->map(Models\Status::class, Entities\MapItem\Status::class, $statusDb);

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

    function SaveCategoryImages($id, $images)
    {
        $method = 'SaveCategoryImages';
        Logger::startMethod($method);
        try
        {
            $categoryDB =  Models\Category::find($id);
            if(is_null($categoryDB))
                throw new RepositoryException(trans('catalogerrorcodes.0454'),0454);

            $categoryDB->images = $images;

            $categoryDB->save();

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


    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    function model()
    {
        // TODO: Implement model() method.
    }


    protected function entity()
    {
        // TODO: Implement entity() method.
    }
}