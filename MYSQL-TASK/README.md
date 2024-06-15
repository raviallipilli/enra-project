# Loan Application System Database

## Description
This project involves designing a MySQL database schema to handle loan applications by customers or brokers acting on behalf of customers. The schema tracks customers, brokers, loan products, and applications, including a detailed history of application status changes.

## Schema
The database schema consists of the following tables:
- **customers**: Stores customer information.
- **addresses**: Stores the address history of customers.
- **brokers**: Stores broker information.
- **products**: Stores loan product information.
- **applications**: Stores loan application information.
- **application_statuses**: Tracks status changes of applications.

## Triggers
A trigger is used to calculate the `monthly_payment` field in the `applications` table based on the `loan_amount` and the `interest_rate` of the selected product before any insert or update operation.

## Files
- `schema.sql`: Contains the database schema with table definitions and triggers.
- `seed.sql`: Contains sample data to populate the database.
- `queries.sql`: Contains SQL queries to answer specific business questions.

## SQL Queries
1. **Number of Applications per Broker**:
    ```sql
    SELECT b.name AS broker_name, COUNT(a.id) AS application_count
    FROM applications a
    LEFT JOIN brokers b ON a.broker_id = b.id
    GROUP BY b.name;
    ```

2. **List of Applications and Their Status Transitions, Per Broker**:
    ```sql
    SELECT b.name AS broker_name, a.id AS application_id, s.status, s.created_at AS status_change_date
    FROM applications a
    LEFT JOIN brokers b ON a.broker_id = b.id
    JOIN application_statuses s ON a.id = s.application_id
    ORDER BY b.name, a.id, s.created_at;
    ```

3. **Customers with Incomplete Address History**:
    ```sql
    SELECT c.id, c.full_name, c.email, COUNT(a.id) AS address_count
    FROM customers c
    LEFT JOIN addresses a ON c.id = a.customer_id
    WHERE (SELECT DATEDIFF(MAX(a.to_date), MIN(a.from_date)) FROM addresses a WHERE a.customer_id = c.id) < 1825
    GROUP BY c.id, c.full_name, c.email;
    ```

## Setup
1. Create the database and tables:
    ```sql
    source schema.sql;
    ```

2. Insert sample data:
    ```sql
    source seed.sql;
    ```

3. Run the queries:
    ```sql
    source queries.sql;
    ```

## Explanation
- The `monthly_payment` calculation is handled by a trigger in the `applications` table.
- Sample data provides initial entries for customers, brokers, products, applications, and their statuses.
- The provided queries address common reporting needs for the loan application system.

## Sample data source
- Data is created using Mockaroo 

