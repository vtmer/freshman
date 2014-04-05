<?php

class CatagorySeeder extends Seeder{

    public function run()
    {
        DB::table('catagory')->delete();

        Catagory::create(array(
            'catagory' => '新生知多D'
        ));
    }
}
