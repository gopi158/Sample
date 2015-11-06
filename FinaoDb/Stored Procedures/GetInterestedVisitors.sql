DELIMITER //
DROP PROCEDURE IF EXISTS GetInterestedVisitors //
CREATE PROCEDURE `GetInterestedVisitors`(
      IN DateFrom DATE
    , IN DateTo DATE 
    )
BEGIN
    
	DECLARE mindate DATE;
	
    SELECT  MIN(date)
    FROM splash_details INTO mindate;


	IF (DateFrom = 0 OR DateFrom = NULL ) AND (DateTo != 0 OR DateTo != NULL )
	THEN
        SELECT  email
              , phone_num
              , ip
              , date
        FROM    splash_details NOLOCK
        WHERE   date BETWEEN mindate AND DateTo;
	ELSEIF (DateTo = 0 OR DateTo = NULL ) AND (DateFrom != 0 OR DateFrom != NULL )
	THEN
        SELECT  email
              , phone_num
              , ip
              , date
        FROM    splash_details NOLOCK
        WHERE   date BETWEEN DateFrom AND UTC_TIMESTAMP( );
	ELSEIF (DateFrom = 0 OR DateTo = 0) OR (DateFrom = NULL OR DateTo = NULL)
	THEN 
        SELECT  email
              , phone_num
              , ip
              , date
        FROM    splash_details NOLOCK ;
	ELSEIF  (DateFrom != 0 OR DateFrom != NULL ) AND (DateTo != 0 OR DateTo != NULL )
	THEN
        SELECT  email
              , phone_num
              , ip
              , date
        FROM    splash_details NOLOCK
        WHERE   date BETWEEN DateFrom AND DateTo;
	END IF;

	END //
DELIMITER //
