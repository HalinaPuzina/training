<?php

use Illuminate\Database\Seeder;
use App\Place;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<= 49; $i++){
            $place = new Place();
            $place->name = 'место ' . $i;
            if(($i>=1 && $i<=16) || ($i>=20 && $i<=23) || ($i>=27 && $i<=30) || ($i>=34 && $i<=49)){
                $place->class = 'far';
            }elseif ($i == 25){
                $place->name = 'ведущий';
                $place->class = 'coach';
            }else{
                $place->class = 'near';
            }
            $place->save();
        }
    }
}
