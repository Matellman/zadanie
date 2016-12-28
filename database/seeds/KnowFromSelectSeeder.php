<?php

use Illuminate\Database\Seeder;

class KnowFromSelectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('know_from_select')->insert([
            ['name' => 'prasa'],
            ['name' => 'telewizja'],
            ['name' => 'znajomi'],
            ['name' => 'inne'],
        ]);
    }
}
