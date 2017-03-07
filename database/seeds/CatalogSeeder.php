<?php

use Illuminate\Database\Seeder;

use CivicApp\Models\Category;
use CivicApp\Models\Barrio;
use CivicApp\Models\Cpc;
use CivicApp\Models\MapItemType;
use CivicApp\Models\Status;
use CivicApp\Models\PostType;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->Categories();
        $this->Barrios();
        $this->Cpcs();
        $this->MapItemType();
        $this->Statuses();

    }

    private function Statuses()
    {

        Status::create([
            'status' => 'Comprometido',
        ]);

        Status::create([
            'status' => 'Ejecución',
        ]);

        Status::create([
            'status' => 'Finalizado',
        ]);

        Status::create([
            'status' => 'No ejecutado',
        ]);
    }

    private function MapItemType()
    {

        MapItemType::create([
            'type' => 'Obras del Presupuesto Paticipativo',
        ]);

        MapItemType::create([
            'type' => 'Espacios Verdes',
        ]);
    }

    private function Cpcs()
    {

        Cpc::create([
            'name' => 'CPC Centro América',
        ]);

        Cpc::create([
            'name' => 'CPC Villa Libertador',
        ]);
    }

    private function Barrios()
    {

        Barrio::create([
            'name' => 'Cofico',
        ]);

        Barrio::create([
            'name' => 'Alta Córdoba',
        ]);
    }

    private function Categories()
    {

        Category::create([
            'category' => 'Transito',
        ]);

        Category::create([
            'category' => 'Espacios Verdes',
        ]);
    }


}
