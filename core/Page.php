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
    //������� ��������� �������� �� �������
    static function generate(){
        require_once (self::$template); //����������� ������� $template
    }
    //������� ��� ������ 404 ������
    static function error404(){
        self::$template = "/templates/template_404.php";
        self::generate();
        die();
    }
}