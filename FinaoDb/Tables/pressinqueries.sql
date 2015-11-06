CREATE TABLE IF NOT EXISTS pressinqueries(
								fname VARCHAR( 128 ) NOT NULL,
								lname VARCHAR( 128 ) NOT NULL,
								email VARCHAR( 128 ) NOT NULL,
								title VARCHAR( 128 ) NOT NULL,
								outletname VARCHAR( 128 ) NOT NULL,
								website VARCHAR( 128 ) NOT NULL,
								phone VARCHAR( 20 ) NOT NULL,
								topic VARCHAR( 200 ) NOT NULL,
								deadline VARCHAR( 200 ) NOT NULL,
								rfi_inperson SMALLINT ,
								rfi_phone SMALLINT ,
								rfi_email SMALLINT 
								)