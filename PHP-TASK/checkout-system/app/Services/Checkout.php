<?php

namespace App\Services;

use App\Models\Product;

/**
 * Checkout service to handle scanning and calculating total price with pricing rules.
 */
class Checkout
{
    // Array of pricing rules
    protected $pricing_rules;
    // Array to store scanned items
    protected $items;

    /**
     * Constructor to initialize pricing rules.
     *
     * @param array $pricing_rules
     */
    public function __construct(array $pricing_rules)
    {
        // Initialize pricing rules
        $this->pricing_rules = $pricing_rules;
        // Initialize items array
        $this->items = [];
    }

    /**
     * Scan a product by its code.
     *
     * @param string $itemCode
     */
    public function scan(string $itemCode)
    {
        // Find the product by its code
        $product = Product::where('code', $itemCode)->first();
        // If the product exists, add it to the items array
        if ($product) {
            $this->items[] = $product;
        }
    }

    /**
     * Calculate the total price of the items in the basket.
     *
     * @return float
     */
    public function total(): float
    {
        $total = 0.0;
        $itemCounts = [];

        // Count the items by product code
        foreach ($this->items as $item) {
            // If the item code is not in the counts array, initialize it
            if (!isset($itemCounts[$item->code])) {
                $itemCounts[$item->code] = 0;
            }
            // Increment the count for the item code
            $itemCounts[$item->code]++;
        }

        // Apply pricing rules to calculate total price
        foreach ($itemCounts as $code => $count) {
            // Find the product by its code
            $product = Product::where('code', $code)->first();

            // If there is a pricing rule for this product code, apply it
            if (isset($this->pricing_rules[$code])) {
                // Calculate total using the pricing rule
                $total += call_user_func($this->pricing_rules[$code], $count, $product->price);
            } else {
                // If no pricing rule, calculate total price normally
                $total += $count * $product->price;
            }
        }

        // Return the total price rounded to 2 decimal places
        return round($total, 2);
    }
}
