<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_product()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        // Create a category with a clear name
        $category = Category::factory()->create([
            'name' => 'Laptops',
        ]);

        // Product creation attempt by admin
        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/products', [
            'name' => 'MacBook Pro',
            'price' => 1199,
            'category_id' => $category->id,
        ]);

        // Assert product created successfully
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'MacBook Pro']);

        // Optional: Ensure it exists in the DB
        $this->assertDatabaseHas('products', [
            'name' => 'MacBook Pro',
            'price' => 1199,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function non_admin_cannot_create_product()
    {
        // Create a staff user (not admin)
        $staff = User::factory()->create([
            'is_admin' => false,
        ]);

        // Create a category
        $category = Category::factory()->create([
            'name' => 'Electronics',
        ]);

        // Attempt to create a product as staff
        $response = $this->actingAs($staff, 'sanctum')->postJson('/api/products', [
            'name' => 'Dell XPS',
            'price' => 2199,
            'category_id' => $category->id,
        ]);

        // Assert access is forbidden
        $response->assertStatus(403)
                 ->assertJsonFragment([
                     'error' => 'Nur Admins dürfen diese Aktion durchführen.',
                 ]);

        // Optional: Ensure it was NOT added to DB
        $this->assertDatabaseMissing('products', [
            'name' => 'Dell XPS',
        ]);
    }
}
