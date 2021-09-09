<?php


namespace Components;


class Router
{
    protected string $baseDir;

    protected const CONTROLLERS = 'controllers';
    protected const CONTROLLER = 'controller';
    protected const ACTION = 'action';
    protected const WEB_SEPARATOR = '/';
    protected const DIR_SEPARATOR = '\\';

    protected string $url;
    protected string $controllerName;
    protected string $controllerMethod;
    protected array $webRoutes;
    protected array $appRoutes;
    protected array $actionParams;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        $this->getURL();
        $this->getConfigs();
    }

    public function run(): void
    {
        if ($this->match() == true) {
            $this->getControllerName();
            $this->getControllerMethod();
            if(class_exists($this->controllerName)){
                if (method_exists($this->controllerName, $this->controllerMethod)){
                    $controller = new $this->controllerName;
                    $controller->{$this->controllerMethod}();
                } else {
                    throw new \LogicException("Method [{$this->controllerMethod}] does not exist in [$this->controllerName]");
                }
            } else {
                throw new \LogicException("[$this->controllerName] does not exist");
            }
        } else {
            header('Location: /');
        }
    }

    protected function getURL(): void
    {
        $this->url = htmlspecialchars(trim($_SERVER['REQUEST_URI'], self::WEB_SEPARATOR));
    }

    protected function getConfigs(): void
    {
        $this->webRoutes = require $this->baseDir .'/Configs/Routes/web.php';
        $this->appRoutes = require $this->baseDir .'/Configs/Routes/app.php';
    }

    protected function match(): bool
    {
        foreach ($this->webRoutes as $route => $params)
        {
            $route = '#^' . $route . '$#';

            if (preg_match($route, parse_url($this->url, PHP_URL_PATH), $matches)) {
                $this->actionParams = $params;
                var_dump($this->webRoutes['']);
                return true;
            }
        }
        return false;
    }

    protected function getControllerName(): void
    {
        $this->controllerName = $this->appRoutes[self::CONTROLLERS]
                            . self::DIR_SEPARATOR
                            . $this->actionParams[self::CONTROLLER];
    }

    protected function getControllerMethod(): void
    {
        $this->controllerMethod = $this->actionParams[self::ACTION];
    }

}