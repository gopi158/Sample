DELIMITER //
DROP PROCEDURE IF EXISTS userquery //
CREATE PROCEDURE userquery (IN email_id VARCHAR(128), IN titles VARCHAR(128), IN outlet_name VARCHAR(128),
							IN websites VARCHAR(128), IN f_name VARCHAR(128), IN l_name VARCHAR(128), IN phone_no VARCHAR(20), 
							IN topics VARCHAR(128), IN dead_line VARCHAR(200), IN interviewequ VARCHAR(2000))
BEGIN
        INSERT  INTO usersqueries
                ( fname
                , lname  
                , title
                , outletname
                , website              
                , email
                , phone
                , topic
                , deadline
                , intervieweq 
                )
                SELECT  f_name
                      , l_name
                      , titles
                      , outlet_name
                      , websites
                      , email_id
                      , phone_no
                      , topics
                      , dead_line
                      , interviewequ;
END //
DELIMITER //
