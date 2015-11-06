CREATE TABLE IF NOT EXISTS userfollowers
    (
      userfollowerid SERIAL
    , userid INT
    , followerid INT
    , tileid INT
    , isactive BIT
    , modification DATETIME
    , creation DATETIME
    , PRIMARY KEY (userfollowerid)
    )
