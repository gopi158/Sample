CREATE TABLE IF NOT EXISTS inspiringpost
    (
      inspiringpostid SERIAL
    , userpostid INT
    , inspireduserid INT
    , isactive BIT
    , modification DATETIME
    , creation DATETIME
    , PRIMARY KEY (inspiringpostid)
    )
