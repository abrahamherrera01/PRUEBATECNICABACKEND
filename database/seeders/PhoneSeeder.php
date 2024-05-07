<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;

class PhoneSeeder extends Seeder
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
            Phone::create([
                'contact_id' => $contact->id,
                'phone' => $this->generatePhoneNumber(),
            ]);
            Phone::create([
                'contact_id' => $contact->id,
                'phone' => $this->generatePhoneNumber(),
            ]);
        }
    }

    private function generatePhoneNumber()
    {
        // Lógica para generar números de teléfono aleatorios
        $prefixes = ['555', '666', '777', '888', '999']; // Prefijos comunes de números de teléfono
        $suffix = mt_rand(1000000, 9999999); // Generar un número aleatorio de 7 dígitos para el sufijo
        $phone = $prefixes[array_rand($prefixes)] . $suffix; // Combinar prefijo y sufijo

        return $phone;
    }
}
