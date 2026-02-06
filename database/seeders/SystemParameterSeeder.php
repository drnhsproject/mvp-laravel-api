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
                'key' => '1',
                'value' => 'Aktif',
                'ordering' => 1,
                'description' => 'Status aktif',
            ],
            [
                'groups' => 'status_active',
                'key' => '0',
                'value' => 'Tidak Aktif',
                'ordering' => 2,
                'description' => 'Status tidak aktif',
            ],

            // Method Group
            [
                'groups' => 'method',
                'key' => 'GET',
                'value' => 'GET',
                'ordering' => 1,
                'description' => 'HTTP GET Method',
            ],
            [
                'groups' => 'method',
                'key' => 'POST',
                'value' => 'POST',
                'ordering' => 2,
                'description' => 'HTTP POST Method',
            ],
            [
                'groups' => 'method',
                'key' => 'PUT',
                'value' => 'PUT',
                'ordering' => 3,
                'description' => 'HTTP PUT Method',
            ],
            [
                'groups' => 'method',
                'key' => 'DELETE',
                'value' => 'DELETE',
                'ordering' => 4,
                'description' => 'HTTP DELETE Method',
            ],
        ];

        foreach ($parameters as $parameter) {
            SystemParameter::updateOrCreate(
                ['groups' => $parameter['groups'], 'key' => $parameter['key']],
                $parameter
            );
        }
    }
}
