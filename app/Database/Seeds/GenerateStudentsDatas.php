<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class GenerateStudentsDatas extends Seeder
{
    public function run()
    {
        //
        for($i = 0; $i < 100; $i++){
            $data = $this->getStudentsData();
            $this->db->table('students')->insert($data);
        }

    }

    private function getStudentsData()
    {
        $fakerObject = Factory::create();
        $genders = ['male', 'female'];
        return[
            'name' => $fakerObject->name,
            'email' => $fakerObject->email,
            'gender' => $fakerObject->randomElement($genders),
            'phone_no' => $fakerObject->phoneNumber
        ];
    }
}
