ALTER TABLE fn_users
ADD isemailverified BIT,
ADD emailverification VARCHAR(50) UNIQUE KEY;
