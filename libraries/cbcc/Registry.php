<?php
/**
 * Created by PhpStorm.
 * User: huuthanh3108
 * Date: 9/30/13
 * Time: 3:18 PM
 */
class Registry
{
    private static $_instance;
    public static $_storage;
    protected function __construct(){}
    public static function getInstance()
    {
        if (!isset (self::$_instance))
            self::$_instance = new self;
        return self::$_instance;
    }
    public function isRegistered($name){
        if (isset ($this->_storage[$name]))return true;
        return false;
    }
    // Xét giá trị thông qua magic call
    public function set($name, $value)
    {
        $this->_storage[$name] = $value;
    }
    // Lấy giá trị đã lưu thông qua magic call
    public function get($name)
    {
        if (isset ($this->_storage[$name]))
            return $this->_storage[$name];
        throw new Exception ('Không tìm thấy giá trị');
    }
    protected function __clone(){}
}