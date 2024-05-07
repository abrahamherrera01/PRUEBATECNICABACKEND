<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            Address::create([
                'contact_id' => $contact->id,
                'address' => $this->generateAddress(),
            ]);

            Address::create([
                'contact_id' => $contact->id,
                'address' => $this->generateAddress(),
            ]);
        }
    }

    private function generateAddress()
    {
        // Lógica para generar direcciones aleatorias
        $streets = ['Main St', 'First Ave', 'Park Rd', 'Elm St', 'Maple Ave']; // Calles comunes
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix']; // Ciudades comunes
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ']; // Estados comunes
        $zip = mt_rand(10000, 99999); // Generar un código postal aleatorio de 5 dígitos

        $address = $streets[array_rand($streets)] . ', ' . $cities[array_rand($cities)] . ', ' . $states[array_rand($states)] . ' ' . $zip;

        return $address;
    }
}
