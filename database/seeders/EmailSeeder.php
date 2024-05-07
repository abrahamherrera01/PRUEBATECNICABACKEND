<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Email;

class EmailSeeder extends Seeder
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
            Email::create([
                'contact_id' => $contact->id,
                'email' => $this->generateEmail($contact->name),
            ]);
            Email::create([
                'contact_id' => $contact->id,
                'email' => $this->generateEmail($contact->name),
            ]);
        }
    }

    private function generateEmail($name)
    {
        $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'example.com']; // Dominios de correo comunes
        $email = strtolower($name) . '@' . $domains[array_rand($domains)]; // Generar correo electrónico usando el nombre del contacto

        return $email;
    }
}
