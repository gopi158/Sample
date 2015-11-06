<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=finaonation_local',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => 'fn_',
                'attributes'=>array(
                    PDO::MYSQL_ATTR_LOCAL_INFILE
                ),
            ),

            'db2'=>array(
                'class'=>'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=shop_local',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => 'customer_',
                'attributes'=>array(
                    PDO::MYSQL_ATTR_LOCAL_INFILE
                ),
            ),
        ),
    ),

    array(
        'params'=>array(
            'cdnUrl' => 'http://finao.local', 
        ),
    )
);