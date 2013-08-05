<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 03.08.13
 * Time: 13:02
 * To change this template use File | Settings | File Templates.
 */


/* ������������ ������������� ��� ������� ��������� �� ����, �� ������������� ������������ �� ������������ ������
 *
 * ������ �������������
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

        //���������� ��� ����� ����� md5 �������
        self::$url = md5($url).".cache";

        //����������� ������ ���� ���������� $fullPath
        self::$fullPath = $path.self::$url;

            //��������� �� �������� �� �������� � ����
            self::$time = time() - @filemtime(self::$fullPath);

            //���� �� �������� �� ���������� �
            if(self::$time < $cacheTime){
                include(self::$fullPath);

                //����������� ���� � TRUE
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