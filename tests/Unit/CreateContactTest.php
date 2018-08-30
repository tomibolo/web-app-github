<?php

namespace Unit\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;

class CreateContactTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNewContactWithoutFields()
    {
        $response = $this->json('POST', 'api/contacts');
        $response
        ->assertStatus(200)
        ->assertJson([
            "The name field is required.",
            "The company field is required.",
            "The profile image field is required.",
            "The email field is required.",
            "The birthdate field is required.",
            "The phone number field is required.",
            "The address.address field is required."
       ]);
    }

    public function testNewContact()
    {
        $data = Factory(Contact::class)->make();
        $response = $this->json('POST', 'api/contacts', $data->toArray());
        $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                "name" => $data->name,
                "email" => $data->email,
                "phone_number" => $data->phone_number,
                "company" => $data->company,
                "birthdate" => $data->birthdate,
                "profile_image" => $data->profile_image,
                "address" =>[
                    "address" => $data->address['address'],
                    "state" => $data->address['state'],
                    "number" => $data->address['number'],
                    "city" => $data->address['city']
                ]
            ]
       ]);
    }
}
