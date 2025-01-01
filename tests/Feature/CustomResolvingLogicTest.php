<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomResolvingLogicTest extends TestCase
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

    public function testCustomResolvingMethodWithBindMethodStatus200()
    {
        $item = Item::factory()->create();

        $response = $this->get("/custom_resolve_logic/{$item->name}");
        // pastikan response mengembalikan status 200
        $response->assertStatus(200);
        // pastikan response mengembalikan json yang sesuai
        $response->assertJson([
            'data' => [
                'item' => [
                    'name' => $item->name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                ]
            ],
        ]);
    }

    public function testCustomResolvingMethodWithResolveRouteBindingMethodStatus200()
    {
        $item = Item::factory()->create();

        $response = $this->get("/custom_resolve_logic/{$item->name}");
        // pastikan response mengembalikan status 200
        $response->assertStatus(200);
        // pastikan response mengembalikan json yang sesuai
        $response->assertJson([
            'data' => [
                'item' => [
                    'name' => $item->name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                ]
            ],
        ]);
    }

    public function testCustomResolvingMethodWithResolveRouteBindingMethodStatus404()
    {
        $item = Item::factory()->create();

        $response = $this->get("/custom_resolve_logic/nf-item");
        // pastikan response mengembalikan status 200
        $response->assertStatus(404);
        // pastikan response mengembalikan json yang sesuai
        $response->assertSee('404');
    }

    public function testCRMWithResolveChildRouteBindingMethod()
    {
        $item = Item::factory()->create();
        $itemDetail = ItemDetail::factory()->create();

        $response = $this->get("/custome_resolve_logic/item/{$item->id}/detail/{$itemDetail->id}");

        // pastikan response mengembalikan status 200
        $response->assertStatus(200);
        // pastikan response mengembalikan json yang sesuai
        $response->assertJson([
            'data' => [
                'item' => [
                    'name' => $item->name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'detail' => $itemDetail->id,
                ]
            ]
        ]);
    }
}

