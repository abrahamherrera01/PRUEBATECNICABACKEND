<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 5000; $i++) {
            Contact::create([
                'name' => $this->generateRandomName(),
                'lastname' => $this->generateRandomLastName(),
            ]);
        }
    }

    // Método para generar nombres aleatorios
    private function generateRandomName()
    {
        $names = ['John', 'Jane', 'Michael', 'Emily', 'Robert', 'Sarah', 'David', 'Emma', 'Christopher', 'Olivia'];
        return $names[array_rand($names)];
    }

    // Método para generar apellidos aleatorios
    private function generateRandomLastName()
    {
        $lastnames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor'];
        return $lastnames[array_rand($lastnames)];
    }
}
