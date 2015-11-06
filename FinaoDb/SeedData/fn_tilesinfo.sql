-------------------------------
-- Seed Data for fn_tilesinfo
-------------------------------
DECLARE @adminId INT;
SET @adminId = 0;
set @adminId = (select lookup_id from fn_lookups where lookup_type='userData' and lookup_name='Admin' and lookup_status=1);

IF (@adminId > 0)
THEN
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
END