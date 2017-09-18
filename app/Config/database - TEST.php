<?php

class DATABASE_CONFIG {

    public $default = array(
        'datasource' => 'Database/Sqlserver',
        'persistent' => false,
        'host' => '127.0.0.1', // or input your PC Name, or IP 127.0.0.1
        'port' => 1433,
        'login' => 'sa',
        'password' => 'Gepic69',
        'database' => 'Inelys',
        'encoding' => PDO::SQLSRV_ENCODING_UTF8
    );
}
