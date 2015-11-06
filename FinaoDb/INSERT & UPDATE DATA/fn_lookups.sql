INSERT  INTO fn_lookups
        ( lookup_name
        , lookup_type
        , lookup_status
        , lookup_parentid
        , createdate
        , updateddate
        )
        SELECT  'Added a post'
              , 'notificationaction'
              , 1
              , 0
              , NOW()
              , NULL;

INSERT  INTO fn_lookups
        ( lookup_name
        , lookup_type
        , lookup_status
        , lookup_parentid
        , createdate
        , updateddate
        )
        SELECT  'Marked your post inappropriate'
              , 'notificationaction'
              , 1
              , 0
              , NOW()
              , NULL;

INSERT  INTO fn_lookups
        ( lookup_name
        , lookup_type
        , lookup_status
        , lookup_parentid
        , createdate
        , updateddate
        )
        SELECT  'Followed you'
              , 'notificationaction'
              , 1
              , 0
              , NOW()
              , NULL;

INSERT  INTO fn_lookups
        ( lookup_name
        , lookup_type
        , lookup_status
        , lookup_parentid
        , createdate
        , updateddate
        )
        SELECT  'Inspired by your post'
              , 'notificationaction'
              , 1
              , 0
              , NOW()
              , NULL;
