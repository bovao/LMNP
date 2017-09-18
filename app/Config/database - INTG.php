<?php

class DATABASE_CONFIG {

    public $default = array(
        'datasource' => 'Database/Sqlserver',
        'persistent' => false,
        'host' => '72139HPV114077\SQL', // or input your PC Name, or IP 127.0.0.1
        'port' => 1433,
        'login' => 'sa',
        'password' => 'Inelys69',
        'database' => 'Inelys-intg',
        'encoding' => PDO::SQLSRV_ENCODING_UTF8
    );
}
