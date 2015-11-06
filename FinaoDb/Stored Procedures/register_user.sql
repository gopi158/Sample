DELIMITER //

CREATE PROCEDURE register_user (IN type BIT, IN emailid VARCHAR(128), IN password VARCHAR(128), IN fname VARCHAR(100),IN lname VARCHAR(100), IN facebookid VARCHAR(150), IN profile_pic BIT)

    BEGIN
    
        DECLARE usersid INT;
        DECLARE socialnetworkid INT;
        
        IF ( type = 1 ) 
        
            THEN
            
                SELECT userid
                FROM    fn_users NOLOCK
                WHERE   email = emailid limit 1 INTO usersid;
                
                IF ( usersid = 0 ) 
                
                    THEN
                    
                        INSERT  INTO fn_users
                                ( password
                                , email
                                , fname
                                , lname
                                , usertypeid
                                , status
                                , createtime
                                , mageid
                                )
                        VALUES  ( password
                                , emailid
                                , fname
                                , lname
                                , 64
                                , 1
                                , NOW()
                                , mageid
                                );                            
                    END IF;
                    
                IF ( profile_pic = 0 ) 
                
                   THEN
                        INSERT  INTO fn_user_profile
                                ( user_id
                                , profile_image
                                , createdby
                                , createddate
                                , updatedby
                                , updateddate
                                , temp_profile_image
                                )
                        VALUES  ( insert_id
                                , uploadfile_name
                                , insert_id
                                , NOW()
                                , insert_id
                                , NOW()
                                , uploadfile_name
                                );
                   ELSE 
                    
                        INSERT  INTO fn_user_profile
                                ( user_id
                                , createdby
                                , createddate
                                , updatedby
                                , updateddate
                                )
                        VALUES  ( insert_id
                                , insert_id
                                , NOW()
                                , insert_id
                                , NOW()
                                );
                   END IF;
            
        ELSE 
            
		SELECT  userid
                FROM    fn_users NOLOCK
                WHERE   email = emailid LIMIT 1 INTO usersid;

		SELECT  socialnetworkid
                FROM    fn_users NOLOCK
                WHERE   email = emailid LIMIT 1 INTO socialnetworkid; 
                
                IF ( userid > 0 ) 
                
                    THEN

                        IF ( socialnetworkid = NULL ) 
                        
                            THEN
                                UPDATE  fn_users
                                SET     socialnetwork = 'facebook'
                                      , socialnetworkid = facebookid
                                WHERE   userid = usersid LIMIT 1;
                           
                            ELSE 
                            
                                SELECT 'USER_LOGGED_IN'; 

                        END IF;
                    
                    ELSE 
                    
                        INSERT  INTO fn_users
                                ( email
                                , fname
                                , lname
                                , usertypeid
                                , status
                                , createtime
                                , mageid
                                , socialnetwork
                                , socialnetworkid
                                )
                        VALUES  ( emailid
                                , fname
                                , lname
                                , 64
                                , 1
                                , NOW()
                                , mageid
                                , 'facebook'
                                , facebookid
                                );
                                
                        INSERT  INTO fn_user_profile
                                ( user_id
                                , createdby
                                , createddate
                                , updatedby
                                , updateddate
                                )
                        VALUES  ( insert_id
                                , insert_id
                                , NOW()
                                , insert_id
                                , NOW()
                                );
                    END IF;
            END IF;

IF EXISTS (SELECT  email
FROM   fn_users NOLOCK WHERE email = email_id)
THEN 
INSERT  INTO fn_users
            ( isemailverified
            , emailverification
            )
    VALUES  ( 'O'
            , GUID
            );
      ELSE
      SELECT 'Registration was not sucessful';
END IF;
SELECT isemailverified, emailverification FROM fn_users NOLOCK WHERE email = email_id;
    END //
DELIMITER //
