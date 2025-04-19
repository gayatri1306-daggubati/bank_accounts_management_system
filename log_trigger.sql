-- Create transaction_logs table to maintain logs
CREATE TABLE transaction_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    account_id INT,
    type VARCHAR(20),
    amount DECIMAL(10, 2),
    transaction_date DATE,
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action VARCHAR(20)
);

-- Trigger to log transactions into transaction_logs table
DELIMITER //

CREATE TRIGGER after_transaction_insert
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
    DECLARE action_type VARCHAR(20);

    -- Check the type of transaction (Deposit, Withdrawal, Transfer)
    IF NEW.type = 'Deposit' THEN
        SET action_type = 'Deposit';
    ELSEIF NEW.type = 'Withdrawal' THEN
        SET action_type = 'Withdrawal';
    ELSEIF NEW.type = 'Transfer' THEN
        SET action_type = 'Transfer';
    END IF;

    -- Insert a record into transaction_logs with details of the transaction
    INSERT INTO transaction_logs (transaction_id, account_id, type, amount, transaction_date, action)
    VALUES (NEW.transaction_id, NEW.account_id, NEW.type, NEW.amount, NEW.transaction_date, action_type);
END //

DELIMITER ;
