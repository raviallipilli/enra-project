<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
/**
 * @Use this reference if we dont need to refresh the database, 
 * but before we need to make sure products data exists in the database first 
 * so either comment out or remove setup function' 
 * Alternatively we can setup env.testing configuration and isolate the working database. 
 */
//use Illuminate\Foundation\Testing\DatabaseTransactions;


class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /*
     * If products data already existsthen remove this function or comment out
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create products in the product table
        Product::create(['code' => 'FR1', 'name' => 'Fruit tea', 'price' => 3.11]);
        Product::create(['code' => 'SR1', 'name' => 'Strawberries', 'price' => 5.00]);
        Product::create(['code' => 'CF1', 'name' => 'Coffee', 'price' => 11.23]);
    }

    public function testBasket1() // 1st Deliverable testcase - BOGOF
    {
        
        /*
         * Prices: FR1 (3.11), 
         *          SR1 (5.00), 
         *          FR1 (0.00), 
         *          FR1 (3.11), 
         *          CF1 (11.23)
         */
        $response = $this->postJson('/scan', ['codes' => ['FR1', 'SR1', 'FR1', 'FR1', 'CF1']]);
        $response->assertJson(['Total Price' => '£22.45']); // Expected Total: 22.45
    }

    public function testBasket2() // 2nd Deliverable testcase - only BOGOF
    {
        /*
         * Prices: FR1 (3.11), 
         *          FR1 (0.00)
         *  */
        $response = $this->postJson('/scan', ['codes' => ['FR1', 'FR1']]);
        $response->assertJson(['Total Price' => '£3.11']); // Expected Total: 3.11
    }

    public function testBasket3() // 3rd Deliverable testcase - BulkDiscount
    {
        
        /*
         * Prices: SR1 (5.00), 
         *          SR1 (5.00), 
         *          FR1 (3.11), 
         *          SR1 (4.50)
         */
        $response = $this->postJson('/scan', ['codes' => ['SR1', 'SR1', 'FR1', 'SR1']]);
        $response->assertJson(['Total Price' => '£16.61']); // Expected Total: 16.61
    }

    /**
     * Optional testcases - below are different scenarios
     */
    public function testComboOfBogofAndBulkDiscount() // Combining all the above 3 cases testcase
    {
        /*
         * Prices: FR1 (3.11), SR1 (5.00), FR1 (0.00), FR1 (3.11), CF1 (11.23), 
         *          FR1 (0.00), FR1 (3.11), SR1 (4.50), SR1 (4.50), FR1 (0.00), 
         *          SR1 (4.50)
         */
        $response = $this->postJson('/scan', ['codes' => ['FR1', 'SR1', 'FR1', 'FR1', 'CF1', 'FR1', 'FR1', 'SR1', 'SR1', 'FR1', 'SR1']]);
        $response->assertJson(['Total Price' => '£38.56']); // Expected Total: 38.56
    }

    public function testMultipleBogofAndBulkDiscounts() // Having multiple BOGOF and BulkDiscounts testcase
    {
        /*
         * Prices: FR1 (3.11), SR1 (5.00), FR1 (0.00), FR1 (3.11), CF1 (11.23), 
         *          FR1 (0.00), SR1 (4.50), FR1 (3.11), FR1 (0.00), CF1 (11.23), 
         *          SR1 (4.50), SR1 (4.50), FR1 (3.11), SR1 (4.50), SR1 (4.50), 
         *          SR1 (4.50), FR1 (0.00), SR1 (4.50)
         */
        $response = $this->postJson('/scan', ['codes' => [
            'FR1', 'SR1', 'FR1', 'FR1', 'CF1', 'FR1', 'SR1', 
            'FR1', 'FR1', 'CF1', 'SR1', 'SR1', 'FR1', 'SR1', 
            'SR1', 'SR1', 'FR1', 'SR1'
        ]]);
        $response->assertJson(['Total Price' => '£70.9']); // Expected Total: 70.9
    }

    public function testNoOffersOrDiscounts() // No offers or discounts testcase
    {
        /* Prices: FR1 (3.11), 
                    SR1 (5.00), 
                    SR1 (5.00), 
                    CF1 (11.23)
        */
        $response = $this->postJson('/scan', ['codes' => ['FR1', 'SR1', 'SR1', 'CF1']]);
        $response->assertJson(['Total Price' => '£24.34']); // Expected Total: 24.34
    }

    public function testSingleItemInTheBasket() // Single item testcase
    {
        /* Prices: CF1 (3.11)
        */
        $response = $this->postJson('/scan', ['codes' => ['CF1']]);
        $response->assertJson(['Total Price' => '£11.23']); // Expected Total: 11.23
    }

    public function testEmptyBasket() // Empty basket testcase
    {
        /* Prices: []
        */
        $response = $this->postJson('/scan', ['codes' => []]);
        $response->assertJson(['message' => "Basket is Empty."]); // Expected Response: Basket is Empty.
    }
}
