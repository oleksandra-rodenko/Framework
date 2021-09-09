<?php


namespace Components;

use mysqli;

class Database

{
    protected string $baseDir;
    protected array $config;

    protected const HOST = 'host';
    protected const PORT = 'port';
    protected const SOCKET = 'socket';
    protected const USER = 'user';
    protected const PASSWORD = 'password';
    protected const DBNAME = 'dbname';

    protected string $host;
    protected string $port;
    protected string $socket;
    protected string $user;
    protected string $password;
    protected string $dbname;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        $this->getConfig();

        $this->host=$this->config[self::HOST];
        $this->port=$this->config[self::PORT];
        $this->socket=$this->config[self::SOCKET];
        $this->user=$this->config[self::USER];
        $this->password=$this->config[self::PASSWORD];
        $this->dbname=$this->config[self::DBNAME];
    }

    public function getConnection(): ?mysqli
    {
        $connection = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dbname,
            $this->port,
            $this->socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

        return $connection;
    }

    protected function getConfig()
    {
        $this->config = require $this->baseDir .'/Configs/database.php';
    }


}