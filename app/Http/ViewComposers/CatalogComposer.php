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
        $categories = json_encode(collect($this->catalogRepository->GetAllCategories())
            ->map(function($item,$key){
                return ['id'=>$item->id,'value'=>$item->category,'label'=>$item->category];
            }));
        $barrios = json_encode(collect($this->catalogRepository->GetAllBarrios())
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
        $view->with(['categories'=>$categories,'barrios'=>$barrios,'statuses'=>$statuses,
            'cpcs'=>$cpcs, 'years'=>$years]);



    }

}