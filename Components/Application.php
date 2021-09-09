<?php


namespace Components;

class Application
{
    protected string $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        $this->databaseConnection()->sessionStart()->routerInit();
    }

    public function databaseConnection(): Application
    {
        $db = new Database($this->baseDir);
        $db->getConnection();
        return $this;
    }

    public function sessionStart(): Application
    {
        $session = new Session();
        $session->sessionStart();
        return $this;
    }

    public function routerInit(): Application
    {
        $router = new Router($this->baseDir);
        $router->run();
        return $this;
    }

}