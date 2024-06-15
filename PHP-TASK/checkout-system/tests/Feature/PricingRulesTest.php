<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\PricingRules\PricingRules;

class PricingRulesTest extends TestCase
{
    public function testApplyBogofRule()
    {
        // Test cases for Buy-One-Get-One-Free rule
        // Function applyBOGOFRule requires number of items count and the price of the product 
        $this->assertEquals(3.11, PricingRules::applyBOGOFRule(1, 3.11)); // 1 item, no discount
        $this->assertEquals(3.11, PricingRules::applyBOGOFRule(2, 3.11)); // 2 items, 1 free
        $this->assertEquals(6.22, PricingRules::applyBOGOFRule(3, 3.11)); // 3 items, 1 free
        $this->assertEquals(6.22, PricingRules::applyBOGOFRule(4, 3.11)); // 4 items, 2 free
    }

    public function testApplyBulkDiscountRule()
    {
        // Test cases for bulk discount rule
        // Function applyBulkDiscountRule requires number of items count and the price of the product 
        $this->assertEquals(5.00, PricingRules::applyBulkDiscountRule(1, 5.00)); // 1 item, no discount
        $this->assertEquals(10.00, PricingRules::applyBulkDiscountRule(2, 5.00)); // 2 items, no discount
        $this->assertEquals(13.50, PricingRules::applyBulkDiscountRule(3, 5.00)); // 3 items, discount applied
        $this->assertEquals(18.00, PricingRules::applyBulkDiscountRule(4, 5.00)); // 4 items, discount applied
    }
}
