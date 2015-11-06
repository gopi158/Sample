DELIMITER //
DROP PROCEDURE IF EXISTS migration //
CREATE PROCEDURE migration ()
BEGIN


/*********************************************************************               
-----VARIABLE DECLARATION---------------SECTION START-----------------
**********************************************************************/

DECLARE return_value INT;
DECLARE VALUE INT;
DECLARE adminId INT;
DECLARE tileId_art INT;
DECLARE tileId_athletics INT;
DECLARE tileId_baseball INT;
DECLARE tileId_Basketball INT;			
DECLARE tileId_Business INT;
DECLARE tileId_Causes INT;
DECLARE tileId_Cooking INT;
DECLARE tileId_Education INT;
DECLARE tileId_Faith INT;
DECLARE tileId_Finance INT;
DECLARE tileId_Football INT;
DECLARE tileId_Health_Fitness INT;
DECLARE tileId_JustBeingMe INT;
DECLARE tileId_Music INT;
DECLARE tileId_Recreation INT;
DECLARE tileId_Relationships INT;
DECLARE tileId_Soccer INT;
DECLARE tileId_Travel INT;
DECLARE finaoStatus_onTrack INT;
DECLARE finaoStatus_ahead INT;
DECLARE finaoStatus_behind INT;
DECLARE uploadSourceType_tile INT;
DECLARE uploadSourceType_finao INT;
DECLARE uploadSourceType_journal INT;
DECLARE uploadSourceType_group INT;
DECLARE uploadType_image INT;
DECLARE uploadType_video INT;
DECLARE uploadType_text INT;
DECLARE uploadType_portalUser INT;
DECLARE uploadType_web INT;
DECLARE uploadType_mobile INT;
DECLARE usercount INT;
DECLARE counter INT;
DECLARE total INT;
DECLARE uniquserid INT; 
DECLARE f_name VARCHAR(255);
DECLARE l_name VARCHAR(255);

/*********************************************************************               
-----VARIABLE DECLARATION---------------SECTION END-------------------
**********************************************************************/

/*********************************************************************               
-----TEMPORARY TABLE DECLARATION---------------SECTION START----------
**********************************************************************/

DROP TABLE IF EXISTS userids ;
CREATE TEMPORARY TABLE userids (id SERIAL, user_id INT);

/*********************************************************************               
-----TEMPORARY TABLE DECLARATION---------------SECTION END------------
**********************************************************************/

/*********************************************************************               
----- Intializing Variables ------------SECTION START-----------------
**********************************************************************/

SET uploadType_mobile = 0;
SET uploadType_web = 0;
SET uploadType_portalUser = 0;
SET uploadType_text = 0;
SET uploadType_video = 0;
SET uploadType_image = 0;
SET uploadSourceType_group = 0;
SET uploadSourceType_journal = 0;
SET uploadSourceType_finao = 0;
SET uploadSourceType_tile = 0;
SET finaoStatus_behind = 0;
SET finaoStatus_ahead = 0;
SET finaoStatus_onTrack = 0;
SET adminId := 0;
SET tileId_art := 0;
SET tileId_athletics := 0;
SET tileId_baseball := 0;
SET tileId_Basketball := 0;			
SET tileId_Business := 0;
SET tileId_Causes := 0;
SET tileId_Cooking := 0;
SET tileId_Education := 0;
SET tileId_Faith := 0;
SET tileId_Finance := 0;
SET tileId_Fitness := 0;
SET tileId_Football := 0;
SET tileId_Health := 0;
SET tileId_JustBeingMe := 0;
SET tileId_Music := 0;
SET tileId_Recreation := 0;
SET tileId_Relationships := 0;
SET tileId_Soccer := 0;
SET tileId_Travel := 0;
SET return_value := 0;
SET VALUE := 1;

/*********************************************************************               
----- Intializing Variables ------------SECTION END-------------------
**********************************************************************/

/*********************************************************************               
----------------------- ALTER TABLE --- SECTION START-----------------
**********************************************************************/

ALTER TABLE fn_trackingnotifications
ADD COLUMN isread INT;

ALTER TABLE fn_lookups 
ADD column code INT;

ALTER TABLE fn_users
ADD isemailverified BIT,
ADD emailverification VARCHAR(50) UNIQUE KEY;

/*********************************************************************               
----------------------- ALTER TABLE --- SECTION END-------------------
**********************************************************************/

IF (VALUE = 1)
THEN 
START TRANSACTION;

/*********************************************************************               
----------- Make Old Seed Data InActive -----SECTION START------------
**********************************************************************/

SET SQL_SAFE_UPDATES := 0;
UPDATE fn_profanity_words SET  status = 0;
SET SQL_SAFE_UPDATES := 0;
UPDATE fn_tilesinfo SET  status = 0;
SET SQL_SAFE_UPDATES := 0;
UPDATE fn_lookups SET  lookup_status = 0;

/*********************************************************************               
----------- Make Old Seed Data InActive -----SECTION END--------------
**********************************************************************/


/*********************************************************************               
----------- Inserting New Seed Data  -----SECTION START---------------
**********************************************************************/

INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( '@$$', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( '3M TA3', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ahole', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'amcik', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'andskota', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'anus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'arschloch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'arse', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ash0le', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ash0les', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'asholes', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ass', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Ass Monkey', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Assface', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'assh0le', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'assh0lez', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'asshole', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'assholes', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'assholz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'assrammer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'asswipe', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ayir', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'azzhole', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'b!+ch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'b!tch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'b00bs', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'b17ch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'b1tch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bassterds', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bastard', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bastards', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bastardz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'basterds', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'basterdz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bi+ch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bi7ch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Biatch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bitch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bitches', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Blow Job', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'blowjob', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'boffing', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'boiolas', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'bollock', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'boobs', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'boonga', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'breasts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'buceta', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'butthead', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'butthole', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'butt-pirate', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'buttwipe', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'c0ck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'c0cks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'c0k', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cabron', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cameltoe', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Carpet Muncher', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cawk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cawks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cazzo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'chink', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'chraa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'chuj', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cipa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Clit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'clit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'clits', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cnts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cntz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cock', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cockhead', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cock-head', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cocks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'CockSucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cock-sucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'crap', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cum', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cunt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cunts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'cuntz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'd4mn', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dago', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'damn', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'daygo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dego', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dick', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dike', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dild0', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dild0s', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dildo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dildos', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dilld0', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dilld0s', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dirsa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dominatricks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dominatrics', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dominatrix', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dupa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dyke', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'dziwka', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'effen', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'effer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ejackulate', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ejakulate', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Ekrem', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Ekto', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'enculer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'enema', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'f u c k', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'f u c k e r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faen', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fag', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fag1t', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faget', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fagg1t', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faggit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faggot', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fagit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fags', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fagz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faig', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'faigs', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fanculo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fanny', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fart', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fatass', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fcuk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'feces', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'feg', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Felcher', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'ficken', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fitt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Flikker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'flipping the bird', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'foreskin', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fotze', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fu(', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fuck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fuckin', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fucking', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fucks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fudge Packer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fuk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fuk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fuken', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukin', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukkah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukken', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Fukkin', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'futkretzn', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'fux0r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'g00k', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gay', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gayboy', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gaygirl', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gays', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gayz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'God-damned', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'gook', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'guiena', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'guinea', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'h00r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'h0ar', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'h0r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'h0re', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'h4x0r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hell', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hells', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'helvete', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hoar', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hoer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'honkey', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Honkie', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'honkie', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Honky', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'honky', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hoor', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hoore', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hore', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Huevon', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'hui', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Injun', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jackoff', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jap', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'japs', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jerk-off', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jisim', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jism', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jiss', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jizm', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'jizz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kanker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kawk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kike', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'klootzak', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'knob', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'knobs', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'knobz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'knulle', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kraut', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kuk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kuksuger', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kunt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kunts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kuntz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Kurac', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kurwa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kusi', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'kyrpa', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'l3i+ch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'l3itch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'lesbian', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'lesbo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Lezzian', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Lipshits', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Lipshitz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mamhoon', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masochist', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masokist', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'massterbait', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masstrbait', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masstrbate', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masterbaiter', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masterbat', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masterbat3', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masterbate', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'masterbates', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'merd', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mibun', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mofo', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'monkleigh', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Motha Fucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Motha Fuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Motha Fukkah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Motha Fukker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mother Fucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mother Fukah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mother Fuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mother Fukkah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mother Fukker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mothereffer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'motherfucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mother-fucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mouliewop', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'muddereffer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'muie', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'mulkku', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'muschi', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mutha Fucker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mutha Fukah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mutha Fuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mutha Fukkah', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Mutha Fukker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'muthereffer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'n1gr', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nastt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nazi', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nazis', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nepesaurio', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nigga', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nigger', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nigur', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'niiger', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'niigr', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'nutsack', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orafis', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orgasim', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orgasm', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orgasum', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'oriface', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orifice', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orifiss', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'orospu', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'p0rn', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'packi', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'packie', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'packy', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'paki', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pakie', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'paky', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'paska', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pecker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'peeenus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'peeenusss', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'peenus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'peinus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pen1s', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'penas', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'penis', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'penis-breath', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'penus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'penuus', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'perse', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'phart', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Phuc', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'phuck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Phuk', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Phuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Phukker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'picka', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pierdol', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pillu', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pimmel', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pimpis', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'piss', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pizda', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'polac', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'polack', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'polak', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Poonani', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'poontsee', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'poop', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'porn', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pr0n', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pr1c', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pr1ck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pr1k', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'preteen', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pula', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pule', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pusse', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pussee', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'pussy', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'puta', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'puto', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'puuke', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'puuker', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'qahbeh', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'queef', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'queer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'queers', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'queerz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'qweers', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'qweerz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'qweir', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'raghead', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'rautenberg', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'recktum', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'rectum', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'retard', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 's.o.b.', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sadist', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'scank', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'schaffer', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'scheiss', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'schlampe', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'schlong', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'schmuck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'screw', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'screwing', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'scrotum', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'semen', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sex', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sexy', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh!+', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh!t', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh1t', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh1ter', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh1ts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh1tter', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sh1tz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sharmuta', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sharmute', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shem', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shemale', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shi+', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shipal', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shits', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shitter', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shitty', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shity', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shitz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'shiz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shyt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shyte', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shytty', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Shyty', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skanck', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skank', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skankee', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skankey', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skanks', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Skanky', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'skrib', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'slut', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'sluts', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'Slutty', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'slutz', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'smut', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'son-of-a-bitch', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'teets', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'teez', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'testical', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'testicle', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'tit', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'tits', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'titt', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'towelhead', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'turd', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'va1jina', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vag1na', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vagiina', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vagina', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vaj1na', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vajina', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vullva', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'vulva', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'w00se', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'w0p', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'wank', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'wh00r', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'wh0re', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'whoar', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'whore', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'xrated', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'xxx', 1 );
INSERT  INTO fn_profanity_words ( badword, status ) VALUES  ( 'zipperhead', 1 );

--------------------------------------------------
-- START - Seed Data for "fn_lookups" table
--------------------------------------------------

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Art', 'tiles', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Athletics', 'tiles', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Baseball', 'tiles', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Basketball', 'tiles', 4, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Business', 'tiles', 5, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Causes', 'tiles', 6, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Cooking', 'tiles', 7, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Education', 'tiles', 8, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Faith', 'tiles', 9, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Finance', 'tiles', 10, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Football', 'tiles', 11, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Health + Fitness', 'tiles', 12, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Just Being Me', 'tiles', 13, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Music', 'tiles', 14, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Recreation', 'tiles', 15, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Relationships', 'tiles', 16, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Soccer', 'tiles', 17, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Travel', 'tiles', 18, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Male', 'gender', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Female', 'gender', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Image', 'uploadType', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Video', 'uploadType', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Text', 'uploadType', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Added FINAO', 'nofitication', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Updated FINAO', 'nofitication', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Changed FINAO status', 'nofitication', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Uploaded Image for FINAO', 'nofitication', 4, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Uploaded Video for FINAO', 'nofitication', 5, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Moved tile', 'nofitication', 6, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Added Journal', 'nofitication', 7, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Updated Journal', 'nofitication', 8, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Uploaded Image for Journal', 'nofitication', 9, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Uploaded Video for Journal', 'nofitication', 10, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Created a post', 'nofitication', 11, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Shared a post', 'nofitication', 12, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('started following you.', 'nofitication', 13, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('was inspired by your post.', 'nofitication', 14, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('On Track', 'finaoStatus', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Ahead', 'finaoStatus', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Behind', 'finaoStatus', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Complete', 'finaoStatus', 4, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('tile', 'uploadSourceType', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('finao', 'uploadSourceType', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('journal', 'uploadSourceType', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('group', 'uploadSourceType', 4, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Portal User', 'userType', 1, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Web', 'userType', 2, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Mobile', 'userType', 3, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());
INSERT INTO fn_lookups ( `lookup_name`, `lookup_type`, `code`, `lookup_status`, `lookup_parentid`, `createdate`, `updateddate`) VALUES ('Admin', 'userType', 4, 1, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP());

--------------------------------------------------
-- END - Seed Data for "fn_lookups" table
--------------------------------------------------

SELECT lookup_id from fn_lookups where lookup_type='userData' and lookup_name='Admin' and lookup_status=1 INTO adminId;

IF (adminId > 0)
THEN

	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Art' and lookup_status=1 INTO tileId_art;
	
	IF (tileId_art > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_art, 'Art', 'art.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Athletics' and lookup_status=1 INTO tileId_athletics;
	
	IF (tileId_athletics > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_athletics, 'Athletics', 'athletics.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Baseball' and lookup_status=1 INTO tileId_baseball;
	
	IF (tileId_baseball > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_baseball, 'Baseball', 'baseball.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;

	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Basketball' and lookup_status=1 INTO tileId_Basketball;
	
	IF (tileId_Basketball > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Basketball, 'Basketball', 'basketball.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());

	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Business' and lookup_status=1 INTO tileId_Business;
	
	IF (tileId_Business > 0)
	THEN
	INSERT INTO fn_tilesinfo VALUES (tileId_Business, 'Business', 'business.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());	
	END IF;	
	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Causes' and lookup_status=1 INTO tileId_Causes;
	
	IF (tileId_Causes > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Causes, 'Causes', 'causes.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Cooking' and lookup_status=1 INTO tileId_Cooking;
	
	IF (tileId_Cooking > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Cooking, 'Cooking', 'cooking.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Education' and lookup_status=1 INTO tileId_Education;
	
	IF (tileId_Education > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Education, 'Education', 'education.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Faith' and lookup_status=1 INTO tileId_Faith;
	
	IF (tileId_Faith > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Faith, 'Faith', 'faith.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Finance' and lookup_status=1 INTO tileId_Finance;
	
	IF (tileId_Finance > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Finance, 'Finance', 'finance.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Football' and lookup_status=1 INTO tileId_Football;
	
	IF (tileId_Football > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Football, 'Football', 'football.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;	
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Health + Fitness' and lookup_status=1 INTO tileId_Health_Fitness;
	
	IF (tileId_Health_Fitness > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Health_Fitness, 'Health + Fitness', 'healthandfitness.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Just Being Me' and lookup_status=1 INTO tileId_JustBeingMe;
	
	IF (tileId_JustBeingMe > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_JustBeingMe, 'Just Being Me', 'justbeingme.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Music' and lookup_status=1 INTO tileId_Music;
	
	IF (tileId_Music > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Music, 'Music', 'music.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
	SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Recreation' and lookup_status=1 INTO tileId_Recreation;
	
	IF (tileId_Recreation > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Recreation, 'Recreation', 'recreation.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Relationships' and lookup_status=1 INTO tileId_Relationships;
	
	IF (tileId_Relationships > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Relationships, 'Relationships', 'relationships.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Soccer' and lookup_status=1 INTO tileId_Soccer;
	
	IF (tileId_Soccer > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Soccer, 'Soccer', 'soccer.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());
	END IF;
	
		SELECT lookup_id from fn_lookups where lookup_type='tiles' and lookup_name='Travel' and lookup_status=1 INTO tileId_Travel;
	
	IF (tileId_Travel > 0)
	THEN
		INSERT INTO fn_tilesinfo (tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate) VALUES (tileId_Travel, 'Travel', 'travel.png', null, 0, 1, adminId, UTC_TIMESTAMP(), adminId, UTC_TIMESTAMP());

	END IF;

END IF;

/*********************************************************************               
----------- Inserting New Seed Data  -----SECTION END-----------------
**********************************************************************/


/*********************************************************************               
----------- Update Finao Status  -----SECTION START-------------------
**********************************************************************/

SELECT lookup_id from fn_lookups where lookup_type='finaoStatus' and lookup_name='On Track' and lookup_status=1 INTO finaoStatus_onTrack;

IF (finaoStatus_onTrack > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_user_finao SET finao_status = finaoStatus_onTrack where finao_status = 38;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='finaoStatus' and lookup_name='Ahead' and lookup_status=1 INTO finaoStatus_ahead;

IF (finaoStatus_ahead > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_user_finao SET finao_status = finaoStatus_ahead where finao_status = 39;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='finaoStatus' and lookup_name='Behind' and lookup_status=1 INTO finaoStatus_behind;

IF (finaoStatus_behind > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_user_finao SET finao_status = finaoStatus_behind where finao_status = 40;
END IF;

/*********************************************************************               
----------- Update Finao Status  -----SECTION END---------------------
**********************************************************************/


/*********************************************************************               
----------- Update Upload Source Type -----SECTION START--------------
**********************************************************************/

 SELECT lookup_id from fn_lookups where lookup_type='uploadsourcetype' and lookup_name='tile' and lookup_status=1 INTO uploadSourceType_tile;

IF (uploadSourceType_tile > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	update fn_uploaddetails set upload_sourcetype = uploadSourceType_tile where upload_sourcetype = 36;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='uploadsourcetype' and lookup_name='finao' and lookup_status=1 INTO uploadSourceType_finao;

IF (uploadSourceType_finao > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	update fn_uploaddetails set upload_sourcetype = uploadSourceType_finao where upload_sourcetype = 37;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='uploadsourcetype' and lookup_name='journal' and lookup_status=1 INTO uploadSourceType_journal;

IF (uploadSourceType_journal > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	update fn_uploaddetails set upload_sourcetype = uploadSourceType_journal where upload_sourcetype = 46;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='uploadsourcetype' and lookup_name='group' and lookup_status=1 INTO uploadSourceType_group;

IF (uploadSourceType_group > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	update fn_group_announcement set uploadsourcetype = uploadSourceType_group where uploadsourcetype = 61;
	SET SQL_SAFE_UPDATES = 0;
	update fn_uploaddetails set upload_sourcetype = uploadSourceType_group where upload_sourcetype = 61;
END IF;

/*********************************************************************               
----------- Update Upload Source Type -----SECTION END----------------
**********************************************************************/


/*********************************************************************               
----------- Update Image Url --------------SECTION START--------------
**********************************************************************/

SET SQL_SAFE_UPDATES = 0;
UPDATE  fn_uploaddetails
SET     uploadfile_path = 'http://d308e36ea233053a9f02-0f07724bd58006a3956ebdf5cd07aa55.r21.cf2.rackcdn.com/';

/*********************************************************************               
----------- Update Image Url --------------SECTION END----------------
**********************************************************************/


/*********************************************************************               
----------- Update Upload Type --------------SECTION END--------------
**********************************************************************/

SELECT lookup_id from fn_lookups where lookup_type='uploadType' and lookup_name='Image' and lookup_status=1 INTO uploadType_image;

IF (uploadType_image > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_uploaddetails SET uploadtype = uploadType_image WHERE uploadtype = 34;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='uploadType' and lookup_name='Video' and lookup_status=1 INTO uploadType_video;

IF (uploadType_video > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_uploaddetails SET uploadtype = uploadType_video WHERE uploadtype = 35;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='uploadType' and lookup_name='Text' and lookup_status=1 INTO uploadType_text;

IF (uploadType_text > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_uploaddetails SET uploadtype = uploadType_text WHERE uploadtype = 62;
END IF;

/*********************************************************************               
----------- Update Upload Type --------------SECTION END--------------
**********************************************************************/


/*********************************************************************               
----------- Update User Type --------------SECTION START--------------
**********************************************************************/

SELECT lookup_id from fn_lookups where lookup_type='usertype' and lookup_name='Portal User' and lookup_status=1 INTO uploadType_portalUser;

IF (uploadType_portalUser > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_users SET usertypeid = uploadType_portalUser WHERE usertypeid = 1 or usertypeid = null;
END IF;

SELECT lookup_id from fn_lookups where lookup_type='usertype' and lookup_name='Web' and lookup_status=1 INTO uploadType_web;

IF (uploadType_web > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_users SET usertypeid = uploadType_web WHERE usertypeid = 63;
END IF;


SELECT lookup_id from fn_lookups where lookup_type='usertype' and lookup_name='Mobile' and lookup_status=1 INTO uploadType_mobile;

IF (uploadType_mobile > 0)
THEN
	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_users SET usertypeid = uploadType_mobile WHERE usertypeid = 64;
END IF;

/*********************************************************************               
----------- Update User Type --------------SECTION END----------------
**********************************************************************/


/*********************************************************************               
----------- Update username in fn_users-------SECTION START-----------
**********************************************************************/

	SET SQL_SAFE_UPDATES = 0;
	UPDATE fn_users 
	SET uname = ' ';
	
	
	INSERT INTO userids (user_id)
	SELECT userid FROM fn_users;
 
	SELECT COUNT(id) FROM userids INTO usercount;
	SET counter := 1;
WHILE (counter <= usercount) 
	DO
	SELECT user_id FROM userids WHERE id = counter INTO uniquserid;
	SELECT fname FROM fn_users WHERE userid = uniquserid INTO f_name;
	SELECT lname FROM fn_users WHERE userid = uniquserid INTO l_name;

	SELECT COUNT(userid) FROM fn_users WHERE uname LIKE CONCAT_WS('.', f_name, l_name, '%') INTO total;
	SET total := total + 1;
  
	UPDATE fn_users SET uname = CONCAT_WS('.',f_name, l_name, total) WHERE userid = uniquserid;
  
	SET counter := counter + 1;
 END WHILE;


/*********************************************************************               
----------- Update username in fn_users-------SECTION END-------------
**********************************************************************/


/*********************************************************************               
------ Update Old tiles details with new-------SECTION START----------
**********************************************************************/

SET SQL_SAFE_UPDATES = 0;
UPDATE fn_user_finao_tile ftile 
INNER JOIN  fn_tilesinfo tile ON (tile.tilename = ftile.tile_name)
SET  
	ftile.tile_name = tile.tilename, 
	ftile.tile_id = tile.tile_id,  
	ftile.tile_profileImagurl = tile.tile_imageurl
WHERE tile.status = 1;

/*********************************************************************               
------ Update Old tiles details with new-------SECTION END------------
**********************************************************************/

SET return_value := 1;

END IF;

IF (return_value = 1)
	THEN 
		COMMIT;
	ELSE
		ROLLBACK;
END IF;

END //
DELIMITER //