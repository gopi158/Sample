DELIMITER //
CREATE PROCEDURE followingupdates (IN updateby INT)
BEGIN
select * from fn_trackingnotifications where updateby= updateby;
END //
DELIMITER //
