<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 28.07.13
 * Time: 22:28
 * To change this template use File | Settings | File Templates.
 */

//������������� ����� ���������� ��� ������� __handleexception
set_exception_handler("__handleexception");

//������������� ����� ������ ��� ������� __handleerror
set_error_handler("__handleerror");

function __autoload($class) {

    file_exists($className = "core/{$class}.php") || die("����� '$class' �� ������! ");
    include($className);
}

function __handleexception($exception) {
    echo "<div>��������� ������.</div> <br>".$exception->getMessage();

}
function __handleerror($errno, $errstr, $errfile, $errline) {
    $er = error_reporting(0);
    error_reporting($er);
    if ($er)
        throw new Exception("$errstr ($errfile, $errline)");
}

//���������� �������
function print_array($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
?>