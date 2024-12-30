<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImplicitEnumBindingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testImplicitEnumBindingApple()
    {
        $response = $this->get("/implicit_enum_binding/apple");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan response sesuai dengan nilai enum
        $response->assertJson([
            'data' => [
            'category' => 'apple',
        ]
        ]);
    }


    public function testImplicitEnumBindingInova()
    {
        $response = $this->get("/implicit_enum_binding/Inova Venturer");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan response sesuai dengan nilai enum
        $response->assertJson([
            'data' => [
            'category' => 'Inova Venturer',
        ]
        ]);
    }
}
