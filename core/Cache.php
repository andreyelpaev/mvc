<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 03.08.13
 * Time: 13:02
 * To change this template use File | Settings | File Templates.
 */


/* Использовать исключительно при больших нагрузках на сайт, не рекомендуется использовать на динамических данных
 *
 * Пример использования
 *
 * Cache::generate($_SERVER['REQUEST_URI'],3600,rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/cache/");
 *
 * if(!$done){
 *  Cache::start();
 *  echo Page::leftmenu();
 *  Cache::getCache();
 *  Cache::clear()
 *  Cache::writeCache();
 *  }
 *
 *
 */

class Cache {

    static $content = "";
    static $url = "";
    static $time;
    static $fullPath;
    static $done = false;

    static function generate($url,$cacheTime,$path){

        //Генерируем имя файла через md5 функцию
        self::$url = md5($url).".cache";

        //Присваиваем полный путь переменной $fullPath
        self::$fullPath = $path.self::$url;

            //Проверяем не устарела ли страница в кеше
            self::$time = time() - @filemtime(self::$fullPath);

            //Если не устарела то подключаем её
            if(self::$time < $cacheTime){
                include(self::$fullPath);

                //Переключаем флаг в TRUE
                self::$done = true;
            }
    }

    static function writeCache(){
        echo self::$content;
        $fp = @fopen(self::$fullPath,"w");
        @fwrite($fp,self::$content);
        @fclose($fp);
    }

    static function start(){
        ob_start();
    }

    static function clear(){
        ob_end_clean();
    }

    static function getCache(){
        self::$content = ob_get_contents();
        return self::$content;
    }

}