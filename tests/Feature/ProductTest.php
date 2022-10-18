<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

class ProductTest extends TestCase
{
    public function test_index()
    {
        $this->singIn();
        $response = $this->get('/product');
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $this->singIn();
        $response = $this->get('/product/1');
        $response->assertStatus(200);
    }

    private function singIn()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false]);
        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
