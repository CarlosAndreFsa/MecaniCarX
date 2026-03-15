<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_brands_index(): void
    {
        $response = $this->get(route('brands.index'));

        $response->assertStatus(200);
    }
    public function test_brands_create(): void
    {
        $response = $this->get(route('brands.create'));

        $response->assertStatus(200);
    }
    public function test_brands_store(): void
    {        $response = $this->post(route('brands.store'), [
            'name' => 'Test Brand',
        ]);

        $response->assertStatus(302); // Assuming it redirects after storing
    }   
    public function test_brands_edit(): void
    {
        $response = $this->get(route('brands.edit', 1));

        $response->assertStatus(200);
    }
    public function test_brands_update(): void
    {
        $response = $this->put(route('brands.update', 1), [
            'name' => 'Updated Test Brand',
        ]);

        $response->assertStatus(302); // Assuming it redirects after updating
    }   
    
        
}
