-- Select the database for loan application if not already used as reference
USE `loan-application`;

-- Query to get the number of applications per broker
SELECT 
    brokers.name AS broker_name,
    COUNT(applications.id) AS application_count
FROM 
    applications
LEFT JOIN 
    brokers ON applications.broker_id = brokers.id
GROUP BY 
    brokers.name;

-- Query to get a list of applications and their status transitions, per broker
SELECT 
    brokers.name AS broker_name,
    applications.id AS application_id,
    applications.status AS current_status,
    application_statuses.status AS status_transition,
    application_statuses.created_at AS transition_time
FROM 
    applications
LEFT JOIN 
    brokers ON applications.broker_id = brokers.id
LEFT JOIN 
    application_statuses ON applications.id = application_statuses.application_id
ORDER BY 
    brokers.name, applications.id, application_statuses.created_at;

-- Query showing customers with incomplete address history (less than 5 years)
SELECT 
    customers.full_name,
    customers.email,
    COUNT(addresses.id) AS current_address_listed,
    5 - COUNT(addresses.id) AS missing_addresses_in_5_years
FROM 
    customers
LEFT JOIN 
    addresses ON customers.id = addresses.customer_id
GROUP BY 
    customers.id
HAVING 
    current_address_listed < 5;
