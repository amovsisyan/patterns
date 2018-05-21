<?php

class Preferences
{
    private $props = array();
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setProperty($key, $val)
    {

        $this->props[$key] = $val;
    }

    public function getProperty($key)
    {
        return $this->props[$key];
    }
}

$pref = Preferences::getinstance();
$pref->setProperty("name ", "Иван ");
unset($pref); //Удалимссылку
$pref2 = Preferences::getinstance();
// Убедимся, что ранее установленное значение сохранено
print $pref2->getProperty(" name ") . " \n ";
