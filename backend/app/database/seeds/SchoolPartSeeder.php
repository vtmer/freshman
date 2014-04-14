<?php

class SchoolPartSeeder extends Seeder{

    public function run()
    {
        DB::table('schoolpart')->delete();

        SchoolPart::create(array(
            'schoolpart' => '大学城'
        ));
        SchoolPart::create(array(
            'schoolpart' => '龙洞'
        ));
        SchoolPart::create(array(
            'schoolpart' => '东风路'
        ));
    }
}
