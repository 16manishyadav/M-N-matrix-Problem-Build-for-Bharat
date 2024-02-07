use hms_db;
-- First table for merchant details
CREATE TABLE Merchant (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    product_delivered VARCHAR(255)
);

-- Second table for pincode and corresponding merchant ids
CREATE TABLE PincodeMerchant (
    pincode INT PRIMARY KEY,
    merchant_ids TEXT
);

-- Insert data into Merchant table
INSERT INTO Merchant (id, name, product_delivered) VALUES
(1, 'Merchant1', 'ProductA'),
(2, 'Merchant2', 'ProductB'),
(3, 'Merchant3', 'ProductC');

-- Insert data into PincodeMerchant table with sorting
INSERT INTO PincodeMerchant (pincode, merchant_ids) VALUES
(12345, '1,2,3'),  -- Example data
(56789, '2,1,3');  -- Example data



CREATE TABLE `tbl_employee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `emailid` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(50) NOT NULL COMMENT '1=Admin'
);

INSERT INTO `tbl_employee` (`id`, `first_name`, `last_name`, `username`, `emailid`, `password`, `role`) VALUES
(1, 'admin', '', 'admin', 'admin@hms.com', 'Admin@123', '1');



