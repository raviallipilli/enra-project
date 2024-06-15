<?php

namespace App\Services;

use App\Models\Product;

/**
 * Checkout service to handle scanning and calculating total price with pricing rules.
 */
class Checkout
{
    protected $pricing_rules;
    protected $items;

    /**
     * Constructor to initialize pricing rules.
     *
     * @param array $pricing_rules
     */
    public function __construct(array $pricing_rules)
    {
        $this->pricing_rules = $pricing_rules;
        $this->items = [];
    }

    /**
     * Scan a product by its code.
     *
     * @param string $itemCode
     */
    public function scan(string $itemCode)
    {
        $product = Product::where('code', $itemCode)->first();
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
            if (!isset($itemCounts[$item->code])) {
                $itemCounts[$item->code] = 0;
            }
            $itemCounts[$item->code]++;
        }

        // Apply pricing rules
        foreach ($itemCounts as $code => $count) {
            $product = Product::where('code', $code)->first();

            if (isset($this->pricing_rules[$code])) {
                $total += call_user_func($this->pricing_rules[$code], $count, $product->price);
            } else {
                $total += $count * $product->price;
            }
        }

        return round($total, 2);
    }
}
