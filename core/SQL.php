<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 28.07.13
 * Time: 23:11
 * To change this template use File | Settings | File Templates.
 */

//�������
SQL::connectDB();

class SQL {

    static $msconn;

    static function connectDB(){

    self::$msconn = mysql_connect(DBHOST,DBUSER,DBPASS) or die ('�� ������� ����������� � MySQL �������: '.mysql_error(self::$msconn));
    mysql_select_db(DB,self::$msconn) or die ('�� ������� ������� ���� ������: '.mysql_error(self::$msconn));
    mysql_query("SET NAMES 'cp1251'") or die ('�� ������� ���������� ���������: '.mysql_error(self::$msconn));
    }

    //������� SQL �������
    static function query($query){
        $result = array();
        $temp = mysql_query($query,self::$msconn);
        if($temp === false)
            throw new Exception("������ � SQL ������� <strong>'$query'</strong> : ".mysql_error(self::$msconn));
        while($row = mysql_fetch_assoc($temp))
            $result[] = $row;
        mysql_free_result($temp);
        return $result;
    }

    //������� ������� ������� ����������
    static function first($query) {
        $result = array();
        $temp = mysql_query($query, self::$msconn);
        if($temp === false)
            throw new Exception("������ � SQL-������� <strong>'$query'</strong> : " . mysql_error(self::$msconn));
        if($row = mysql_fetch_assoc($temp)) {
            mysql_free_result($temp);
            return $row;
        }
        else
            return null;
    }

    //������� ��� ������� UPDATE,INSERT,DELETE ���������� ���������� ��������� �����
    static function exec($query){
        $temp = mysql_query($query,self::$msconn);
        if($temp === false)
            throw new Exception("������ � SQL ������� <strong>'$query'</strong> : ".mysql_error(self::$msconn));
        return mysql_affected_rows(self::$msconn);
    }

}