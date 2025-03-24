<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name'=>'Home',
            'devise'=> 'USD',
            'depense_id'=> '1'
        ]);
        Group::create([
            'name'=>'food',
            'devise'=> 'USD',
            'depense_id'=> '2'
        ]);
        Group::create([
            'name'=>'cloths',
            'devise'=> 'USD',
            'depense_id'=> '3'
        ]);
        Group::create([
            'name'=>'Sporte',
            'devise'=> 'USD',
            'depense_id'=> '4'

        ]);
        Group::create([
            'name'=>'Travle',
            'devise'=> 'USD',
            'depense_id'=> '5'
        ]);
        Group::create([
            'name'=>'Tascks',
            'devise'=> 'USD',
            'depense_id'=> '6'
        ]);
        
    }
}
