<?php 

namespace dopler_core;

class Router
{
    protected static array $routes = array();
    protected static array $route = array();

    public static function add($regexp, $route = []): void
    {
        self::$routes[$regexp] = $route;
    }
    public static function getRoutes(): array
    {
        return self::$routes;
    }
    public static function getRoute(): array
    {
        return self::$route;
    }
    public static function dispatch($url)
    {
        /** @var Controller $controllerObject */  
        if (self::matchRoute($url)){
            if (!empty(self::$route['lang'])) {
                App::$app->setProperty('lang', self::$route['lang']);
            }
            $controller = 'app\controllers\\' 
            . self::$route['admin_prefix']
            . self::$route['controller']
            . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $controllerObject->get_model();
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                    $controllerObject->getView();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден");
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }

        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }
    protected static function removeQueryString(string $url)
    {
        if ($url) {
            $params = explode("&", $url, 2);
            if (false === str_contains($params[0], '=')){
                return rtrim($params[0], '/');
            }
        }
        return '';
    }
    protected static function matchRoute($url): bool
    {
        $url = self::removeQueryString($url);
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#", $url, $matches)){

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;

                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true; 
            }
        }
        return false;
    }
    protected static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', (ucwords(str_replace('-', ' ', $name))));
    }
    protected static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }
}
?>