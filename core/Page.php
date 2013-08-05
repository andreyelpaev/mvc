<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 28.07.13
 * Time: 20:55
 * To change this template use File | Settings | File Templates.
 */

class Page {
    static $title = "";
    static $description = "";
    static $keywords = "";
    static $content = "";
    static $template = "";
    static $leftmenu = "";
    static $contentTitle = "";
    static $basket = "";
    //Функция генерации страницы по шаблону
    static function generate(){
        require_once (self::$template); //Подключение шаблона $template
    }
    //Функция для вывода 404 ошибки
    static function error404(){
        self::$template = "/templates/template_404.php";
        self::generate();
        die();
    }
}