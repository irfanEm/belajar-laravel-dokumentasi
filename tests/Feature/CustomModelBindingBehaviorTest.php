<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomModelBindingBehaviorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCustomModelBindingBehavior()
    {
        $response = $this->get('/custome_model_binding_behavior/location/show/non-existent-slug');
        $response->assertRedirect(route('locations.index'));
    }
}
