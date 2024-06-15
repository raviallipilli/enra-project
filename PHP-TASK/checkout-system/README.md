### Supermarket Checkout System

--------------------------------------------------------------------------------------------------------------------------------------

## Author : Ravi Allipilli

--------------------------------------------------------------------------------------------------------------------------------------

### Overview
This project implements a supermarket checkout system with special pricing rules. The system allows you to scan items and calculate the total price with applied discounts.

--------------------------------------------------------------------------------------------------------------------------------------

### Available Products
Product code | Name         | Price
-----------------------------------------
FR1          | Fruit tea    |  £3.11
SR1          | Strawberries |  £5.00
CF1          | Coffee       | £11.23

--------------------------------------------------------------------------------------------------------------------------------------

### Pricing Rules
Buy-One-Get-One-Free (BOGOF): Buy one get one free offer for Fruit tea (FR1).
Bulk Discount (BD): If you buy 3 or more Strawberries (SR1), the price per unit drops to £4.50.

--------------------------------------------------------------------------------------------------------------------------------------

### Requirements
PHP 8
Composer
Laravel 11
MySQL (for testing purposes)

--------------------------------------------------------------------------------------------------------------------------------------

### Installation
1. Clone the repository:
   -- git clone <repository-url>
   -- cd <repository-directory> - the php project is two folders inside so we need to cd the folder checkout-system

2. Set up environment file:
   -- cp .env.example .env
   -- Generate application key:
   -- php artisan key:generate

4. Configure the database:
   == Open the .env file and set the DB_CONNECTION to mysql and configure the other DB settings accordingly.

5. Run migrations:
   -- php artisan migrate

6. Seed the database with initial products:
   -- php artisan db:seed

--------------------------------------------------------------------------------------------------------------------------------------

### Usage
   -- Endpoints
    Scan products:
        http - POST http://localhost/api/scan
    
    Request body:
        json
            {
                "codes": ["FR1", "SR1", "FR1", "FR1", "CF1"]
            }

--------------------------------------------------------------------------------------------------------------------------------------

### Project Workflow
    -- Scan multiple products in one request:
        POST http://localhost/api/scan 
            body
            {
                "codes": ["FR1", "SR1", "FR1", "FR1", "CF1"]
            }
            headers
            "Content-Type: application/json"
    
    -- Expected Response
        After sending the scan request, you will receive a response with the total price:

        json
            {
                "Total Price": "£22.45"
            }

--------------------------------------------------------------------------------------------------------------------------------------

### Running Tests
Run the feature tests:
   -- php artisan test
    *** Test Cases ***
        
        Basket: FR1, SR1, FR1, FR1, CF1
        Expected Total: £22.45
            - Prices in order of scanning: FR1 (£3.11), SR1 (£5.00), FR1 (£0.00), FR1 (£3.11), CF1 (£11.23)
        
        Basket: FR1, FR1
        Expected Total: £3.11
            - Prices in order of scanning: FR1 (£3.11), FR1 (£0.00)
        
        Basket: SR1, SR1, FR1, SR1
        Expected Total: £16.61
            - Prices in order of scanning: SR1 (£5.00), SR1 (£5.00), FR1 (£3.11), SR1 (£3.50)

        Additional Test Cases
            - Additional test case are included to cover robust functionality

        Also covers Pricing Rules
        Two tests that covers
            - BuyOneGetOneFree
            - BulkDiscount

--------------------------------------------------------------------------------------------------------------------------------------

### Code Overview
   *** Controllers ***
        CheckoutController:
            scan(Request $request): Scans products by their codes and returns the total price.
   *** Models ***
        Product: 
            Represents a product in the supermarket.
   *** Services ***
        Checkout: 
            Handles the scanning of products and the calculation of the total price. It applies the pricing rules to the scanned products.
   *** Pricing Rules ***
        PricingRules:
            getRules(): Returns the list of pricing rules to be applied.
            applyBOGOFRule(int $count, float $price): Applies the Buy-One-Get-One-Free rule for Fruit tea.
            applyBulkDiscountRule(int $count, float $price): Applies the Bulk Discount rule for Strawberries.
   *** Routes ***
        POST /scan: 
            Scans products and adds them to the cart, returning the total price.

--------------------------------------------------------------------------------------------------------------------------------------

### Testing
The tests are located in the tests/Feature directory and cover the primary functionalities of scanning items and calculating totals.

--------------------------------------------------------------------------------------------------------------------------------------

### Note

The PHPDocs doesn't support on Visual Studio Code IDE, so i recommend opening the project on PHPStorm, lot of dependencies are conflicting to setup on VS Code 

--------------------------------------------------------------------------------------------------------------------------------------

### Conclusion
This checkout system is flexible and allows for easy addition of new pricing rules as required. The project is well-documented and tested to ensure reliable functionality.

----------------------------------------------------END TASK--------------------------------------------------------------------------