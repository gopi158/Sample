<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=finaonationqa',
                'emulatePrepare' => true,
                'username' => 'application',
                'password' => '4*W^Nzpf@65O',
                'charset' => 'utf8',
                'tablePrefix' => 'fn_',
                'attributes'=>array(
                    PDO::MYSQL_ATTR_LOCAL_INFILE
                ),
            ),

            'db2'=>array(
                'class'=>'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=shopqa',
                'emulatePrepare' => true,
                'username' => 'application',
                'password' => '4*W^Nzpf@65O',
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
            'cdnUrl' => 'http://finaonationqa.com',
        ),
    )
);