<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 26/05/2016
 * Time: 10:20 PM
 */

namespace CivicApp\DAL\Catalog;


use CivicApp\Entities\MapItem\Barrio;
use CivicApp\Entities\MapItem\Category;
use CivicApp\Entities\MapItem\Cpc;
use CivicApp\Entities\MapItem\Status;

interface ICatalogRepository {


    function GetAllCategories();

    function GetAllBarrios();

    function GetAllCpcs();

    function GetAllStatuses();

    function AddCategory(Category $category);

    function AddBarrio(Barrio $barrio);

    function UpdateBarrio(Barrio $barrio);

    function AddCpc(Cpc $cpc);

   // function AddStatus(Status $status);

    function FindCategory($category);

    function FindBarrio($barrio);

    function FindCpc($cpc);

    function FindStatus($status);

    function GetPostType($id);

    function GetCategory($id);

    function GetBarrio($id);

    function GetCpc($id);

    function GetStatus($id);

    function SaveCategoryImages($id, $images);

}