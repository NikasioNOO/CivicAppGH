<?php

use Illuminate\Database\Seeder;

class NewCatalogSeeder extends Seeder
{
    public function run()
    {
        $this->Statuses();

    }

    private function Statuses()
    {
        $status = new \CivicApp\Models\Status();
        $status->status = 'Comprometido';

        $status->save();


    }

    private function MapItemType()
    {
        DB::table('map_item_types')->insert([
            'type' => 'Obras del Presupuesto Paticipativo',
        ]);

        DB::table('map_item_types')->insert([
            'type' => 'Espacios Verdes',
        ]);
    }

    private function Cpcs()
    {
        DB::table('cpc')->insert([
            'name' => 'CPC Centro América',
        ]);

        DB::table('cpc')->insert([
            'name' => 'CPC Villa Libertador',
        ]);
    }

    private function Barrios()
    {
        DB::table('barrios')->insert([
            'name' => 'Cofico',
        ]);

        DB::table('barrios')->insert([
            'name' => 'Alta Córdoba',
        ]);
    }

    private function categories()
    {

        DB::table('categories')->insert([
            'category' => 'Transito',
        ]);

        DB::table('categories')->insert([
            'category' => 'Espacios Verdes',
        ]);
    }
}
