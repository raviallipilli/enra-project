<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Checkout;
use App\PricingRules\PricingRules;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    protected $checkout;

    /**
     * CheckoutController constructor.
     * Initialize the Checkout service with pricing rules.
     */
    public function __construct()
    {
        // Initialize the Checkout service with the pricing rules
        $this->checkout = new Checkout(PricingRules::getRules());
    }

    /**
     * Scan products by their codes.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function scan(Request $request): JsonResponse
    {
        // Get the list of product codes from the request
        $codes = $request->input('codes', []);

        // Loop through each product code
        foreach ($codes as $code) {
            // Find the product in the database by its code
            $product = Product::where('code', $code)->first();

            // If the product is found, scan it
            if ($product) {
                $this->checkout->scan($product->code);
            } else {
                // If the product is not found, return a 404 error
                return response()->json(['message' => "Product with code $code not found."], 404);
            }
        }

        // Calculate the total price after scanning all products
        $total = $this->checkout->total();

        // Check if the basket is emoty
        if ($total === 0.00) {
            return response()->json(['message' => "Basket is Empty."]);
        } else {
            // Return the total price in the response
            return response()->json(['Total Price' => '£'.$total]);
        }
    }
}
