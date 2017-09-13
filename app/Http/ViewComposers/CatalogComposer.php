<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 29/05/2016
 * Time: 06:46 PM
 */

namespace CivicApp\Http\ViewComposers;


use CivicApp\DAL\Catalog\ICatalogRepository;
use Illuminate\Contracts\View\View;

class CatalogComposer {

    private $catalogRepository ;
    public  function __construct(ICatalogRepository $catalogRepo)
    {
        $this->catalogRepository = $catalogRepo;
    }

    public function compose(View $view)
    {
        $categoriesArray = $this->catalogRepository->GetAllCategories();
        $categories = json_encode(collect($categoriesArray)
            ->map(function($item,$key){
                return ['id'=>$item->id,'value'=>$item->category,'label'=>$item->category];
            }));
        $barriosArray = $this->catalogRepository->GetAllBarrios();
        $barrios = json_encode(collect($barriosArray)
            ->map(function($item,$key){

                return ['id'=>$item->id,'value'=>$item->name, 'label'=>$item->name, 'location'=> !is_null($item->location)?$item->location->location : null ];
            }));



        $cpcs = json_encode(collect($this->catalogRepository->GetAllCpcs())
            ->map(function($item,$key){
                return ['id'=>$item->id,'value'=>$item->name, 'label'=>$item->name];
            }));

        $years = [];

        $currentYear = date('Y')+1;


        for($i = $currentYear; $i > ($currentYear-10);$i-- )
        {
            $years[] =   $i;
        }

        $statuses = $this->catalogRepository->GetAllStatuses();

        $genders = [['value'=>'M','name'=>'Masculino']
                    ,['value'=>'F','name'=>'Femenino']];
        $view->with(['categories'=>$categories,'barrios'=>$barrios,'statuses'=>$statuses,
            'cpcs'=>$cpcs, 'years'=>$years, 'barriosArray'=>$barriosArray, 'categoriesArray'=>$categoriesArray,
            'genders'=>$genders] );



    }

}