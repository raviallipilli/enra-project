<?php

namespace App\PricingRules;

/**
 * Pricing rules for the checkout system.
 */
class PricingRules
{
    /**
     * Get all pricing rules.
     *
     * @return array
     */
    public static function getRules(): array
    {
        // Return an array of pricing rules mapped to their respective method handlers
        return [
            'FR1' => [self::class, 'applyBOGOFRule'], // Rule for Buy-One-Get-One-Free (BOGOF) for Fruit tea
            'SR1' => [self::class, 'applyBulkDiscountRule'], // Rule for bulk discount for Strawberries
        ];
    }

    /**
     * Buy-One-Get-One-Free (BOGOF) rule for Fruit tea.
     *
     * @param int $count Number of items
     * @param float $price Price per item
     * @return float Total price after applying the BOGOF rule
     */
    public static function applyBOGOFRule(int $count, float $price): float
    {
        // Calculate the total price using the BOGOF rule
        // For every two items, one is free
        return ($count - floor($count / 2)) * $price;
    }

    /**
     * Bulk discount rule for Strawberries.
     *
     * @param int $count Number of items
     * @param float $price Price per item
     * @return float Total price after applying the bulk discount rule
     */
    public static function applyBulkDiscountRule(int $count, float $price): float
    {
        // If 3 or more items are bought, apply the bulk discount price, otherwise use the regular price
        return $count >= 3 ? $count * 4.50 : $count * $price;
    }
}
