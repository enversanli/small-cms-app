<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'title' => 'first',
                'text' => 'First'
            ],
            [
                'title' => 'second',
                'text' => 'Second'
            ]
        ];
        foreach ($types as $type){
            Type::updateOrInsert($type);
        }

    }
}
