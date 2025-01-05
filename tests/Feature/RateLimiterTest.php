<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RateLimiterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCanUploadFileWithinRateLimit()
    {
        for($i = 0; $i<5; $i++){
            $response = $this->postJson('/route-limiter/upload', [
                'file' => UploadedFile::fake()->image('test.jpg'),
            ]);

            $response->assertStatus(200)
                ->assertJson([
                    'pesan' => 'File berhasil di unggah !',
                ]);
        }
    }

    public function testExceedingRateLimitReturn429()
    {
        for($i = 0; $i<5; $i++){
            $response = $this->postJson('/route-limiter/upload', [
                'file' => UploadedFile::fake()->image('test.jpg'),
            ]);

            if($i<5) {

                $response->assertStatus(200)
                    ->assertJson([
                        'pesan' => 'File berhasil di unggah !',
                    ]);
            } else {
                $response->assertStatus(429);
            }
        }
    }
}
