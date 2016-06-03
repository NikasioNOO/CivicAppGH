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
        $barrios = json_encode( $this->catalogRepository->GetAllBarrios());
        $statuses = json_encode($this->catalogRepository->GetAllStatuses());
        $cpcs = json_encode($this->catalogRepository->GetAllCpcs());

        $view->with(['categories'=>$categories,'barrios'=>$barrios,'statuses'=>$statuses,
            'cpcs'=>$cpcs]);



    }

}