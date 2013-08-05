<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 28.07.13
 * Time: 20:35
 * To change this template use File | Settings | File Templates.
 */

class Router {

    private static $routes = array();

    private function __construct() {}
    private function __clone() {}

    public static function route($pattern, $callback) {
        $pattern = '/' . str_replace('/', '\/', $pattern) . '/';
        self::$routes[$pattern] = $callback;
    }

    public static function execute() {
        $url = $_SERVER['REQUEST_URI'];
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if(strpos($url, $base) === 0) {
            $url = substr($url, strlen($base));
        }
        foreach (self::$routes as $pattern => $callback) {
            if(preg_match($pattern, $url)){
                preg_match_all($pattern, $url, $matches);
                array_shift($matches);
                $params = array();
                foreach($matches as $match){
                    if(array_key_exists(0, $match)){
                        $params[] = $match[0];
                    }
                }
                return call_user_func_array($callback, $params);
            }
        }
    }
}
?>