<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 15.11.2016
 * Time: 13:10
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $routersPath = ROOT . '/config/routes.php';
        $this->routes = include($routersPath);
    }

    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI']);


        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern=> $path){
           if(preg_match("~$uriPattern~",$uri)){
               $segments = explode('/',$path);
              $comtrollerName = array_shift($segments).'Controller';
               $comtrollerName = ucfirst($comtrollerName);
               $actionName = 'action'.ucfirst(array_shift($segments));
              $controllerFile = ROOT."\\controlers\\".$comtrollerName.'.php';

               if(file_exists($controllerFile)){
                   include_once ($controllerFile);

                   $controllerObject = new  $comtrollerName;
                   $result = $controllerObject->$actionName();
               }

               if($result !=null){
                   break;
               }
           }
        }


    }
}
