-- Create database for loan application as loan_application
CREATE DATABASE IF NOT EXISTS `loan-application`;

-- Create customers table
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create addresses table
CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    from_date DATE NOT NULL,
    to_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Create brokers table
CREATE TABLE brokers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    company_address VARCHAR(255) NOT NULL,
    type ENUM('A', 'B', 'C', 'D') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    interest_rate DECIMAL(5, 2) NOT NULL,
    term INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create applications table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    broker_id INT,
    product_id INT NOT NULL,
    loan_amount DECIMAL(15, 2) NOT NULL,
    monthly_payment DECIMAL(15, 2) NOT NULL,
    status ENUM('NEW', 'PROCESSING', 'APPROVED', 'DECLINED', 'COMPLETED', 'CANCELLED') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (broker_id) REFERENCES brokers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create application_statuses table
CREATE TABLE application_statuses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    status ENUM('NEW', 'PROCESSING', 'APPROVED', 'DECLINED', 'COMPLETED', 'CANCELLED') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(id)
);

-- Create trigger to calculate monthly_payment before insert or update
DELIMITER //

CREATE TRIGGER calculate_monthly_payment_before_insert
BEFORE INSERT ON applications
FOR EACH ROW
BEGIN
    DECLARE interest_rate DECIMAL(5, 2);
    SELECT products.interest_rate INTO interest_rate FROM products WHERE products.id = NEW.product_id;
    SET NEW.monthly_payment = NEW.loan_amount * ((interest_rate/100) / 12);
END//

CREATE TRIGGER calculate_monthly_payment_before_update
BEFORE UPDATE ON applications
FOR EACH ROW
BEGIN
    DECLARE interest_rate DECIMAL(5, 2);
    SELECT products.interest_rate INTO interest_rate FROM products WHERE products.id = NEW.product_id;
    SET NEW.monthly_payment = NEW.loan_amount * ((interest_rate/100) / 12);
END//

DELIMITER ;

-- Adding indexes
CREATE INDEX idx_customer_email ON customers (email);
CREATE INDEX idx_broker_email ON brokers (email);
CREATE INDEX idx_application_customer_broker_product ON applications (customer_id, broker_id, product_id);
