<?php

namespace Database\Seeders;

use App\Models\SystemParameter;
use Illuminate\Database\Seeder;

class SystemParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parameters = [
            // Gender Group
            [
                'groups' => 'gender',
                'key' => 'male',
                'value' => 'Laki-laki',
                'ordering' => 1,
                'description' => 'Jenis kelamin laki-laki',
            ],
            [
                'groups' => 'gender',
                'key' => 'female',
                'value' => 'Perempuan',
                'ordering' => 2,
                'description' => 'Jenis kelamin perempuan',
            ],

            // Status Active Group
            [
                'groups' => 'status_active',
                'key' => 'active',
                'value' => 'Aktif',
                'ordering' => 1,
                'description' => 'Status aktif',
            ],
            [
                'groups' => 'status_active',
                'key' => 'inactive',
                'value' => 'Tidak Aktif',
                'ordering' => 2,
                'description' => 'Status tidak aktif',
            ],
        ];

        foreach ($parameters as $parameter) {
            SystemParameter::create($parameter);
        }
    }
}
