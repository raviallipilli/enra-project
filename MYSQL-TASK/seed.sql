-- Insert sample data into customers table
INSERT INTO customers (full_name, date_of_birth, email) VALUES
('John Doe', '1980-01-01', 'john.doe@example.com'),
('Jane Smith', '1990-02-15', 'jane.smith@example.com'),
('Alice Johnson', '1985-07-23', 'alice.johnson@example.com'),
('Bob Brown', '1975-11-03', 'bob.brown@example.com'),
('Charlie Davis', '1995-05-14', 'charlie.davis@example.com');

-- Insert sample data into addresses table
INSERT INTO addresses (customer_id, address, from_date, to_date) VALUES
(1, '123 Main St', '2019-01-01', '2020-01-01'),
(1, '456 Elm St', '2020-01-02', '2021-01-01'),
(1, '789 Oak St', '2021-01-02', '2022-01-01'),
(1, '101 Pine St', '2022-01-02', '2023-01-01'),
(1, '102 Maple St', '2023-01-02', '2024-01-01'),
(2, '202 Birch St', '2019-03-15', '2020-03-15'),
(2, '303 Cedar St', '2020-03-16', '2021-03-15'),
(2, '404 Spruce St', '2021-03-16', '2022-03-15'),
(2, '505 Fir St', '2022-03-16', '2023-03-15'),
(2, '606 Ash St', '2023-03-16', '2024-03-15'),
(3, '707 Poplar St', '2018-07-01', '2019-07-01'),
(3, '808 Alder St', '2019-07-02', '2020-07-01'),
(3, '909 Sequoia St', '2020-07-02', '2021-07-01'),
(3, '1010 Redwood St', '2021-07-02', '2022-07-01'),
(4, '1111 Cypress St', '2019-11-10', '2020-11-10'),
(4, '1212 Dogwood St', '2020-11-11', '2021-11-10');

-- Insert sample data into brokers table
INSERT INTO brokers (name, email, company_address, type) VALUES
('Broker A', 'brokerA@example.com', 'Company A Address', 'A'),
('Broker B', 'brokerB@example.com', 'Company B Address', 'B'),
('Broker C', 'brokerC@example.com', 'Company C Address', 'C'),
('Broker D', 'brokerD@example.com', 'Company D Address', 'D'),
('Broker E', 'brokerE@example.com', 'Company E Address', 'A');

-- Insert sample data into products table
INSERT INTO products (name, interest_rate, term) VALUES
('Product A', 5.00, 30),
('Product B', 3.50, 15),
('Product C', 4.25, 20),
('Product D', 6.00, 10),
('Product E', 2.75, 25);

-- Insert sample data into applications table
INSERT INTO applications (customer_id, broker_id, product_id, loan_amount, monthly_payment, status) VALUES
(1, 1, 1, 100000, 416.67, 'NEW'),        -- Product A: 100000 * (5.00 / 12) = 416.67
(2, 2, 2, 200000, 583.33, 'PROCESSING'), -- Product B: 200000 * (3.50 / 12) = 583.33
(3, 3, 3, 150000, 531.25, 'APPROVED'),-- Product C: 150000 * (4.25 / 12) = 531.25
(4, 3, 4, 250000, 1250.00, 'DECLINED'),  -- Product D: 250000 * (6.00 / 12) = 1250.00
(5, 3, 5, 300000, 687.50, 'COMPLETED'),-- Product E: 300000 * (2.75 / 12) = 687.50
(1, 1, 2, 120000, 350.00, 'CANCELLED'),  -- Product B: 120000 * (3.50 / 12) = 350.00
(2, 2, 1, 180000, 750.00, 'NEW'),        -- Product A: 180000 * (5.00 / 12) = 750.00
(3, 3, 2, 220000, 641.67, 'APPROVED'),-- Product B: 220000 * (3.50 / 12) = 641.67
(4, 4, 3, 140000, 495.83, 'PROCESSING'), -- Product C: 140000 * (4.25 / 12) = 495.83
(5, 3, 4, 260000, 1300.00, 'DECLINED');-- Product D: 260000 * (6.00 / 12) = 1300.00

-- Insert sample data into application_statuses table
INSERT INTO application_statuses (application_id, status) VALUES
(1, 'NEW'),
(2, 'PROCESSING'),
(3, 'NEW'),
(3, 'APPROVED'),
(4, 'NEW'),
(4, 'PROCESSING'),
(4, 'DECLINED'),
(5, 'NEW'),
(5, 'COMPLETED'),
(6, 'NEW'),
(6, 'CANCELLED'),
(7, 'NEW'),
(8, 'NEW'),
(8, 'APPROVED'),
(9, 'NEW'),
(9, 'PROCESSING'),
(10, 'NEW'),
(10, 'DECLINED');
