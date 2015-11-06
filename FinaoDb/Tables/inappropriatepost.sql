CREATE TABLE IF NOT EXISTS inappropriatepost
    (
      inappropriatepostid SERIAL
    , userpostid INT
    , flagginguserid INT
    , isactive BIT
    , modification DATETIME
    , creation DATETIME
    ,  PRIMARY KEY (inappropriatepostid)
    )
