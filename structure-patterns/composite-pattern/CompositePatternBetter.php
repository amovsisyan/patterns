<?php

abstract class Unit
{
    function getComposite()
    {
        return null;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit
{
    protected $units = array();

    function getComposite()
    {
        return $this;
    }

    function removeUnit(Unit $unit)
    {
        $this->units = array_udiff(
            $this->units, array($unit),
            function ($а, $b) {
                return ($а === $b) ? 0 : 1;
            }
        );
    }

    function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }
}

class Army extends CompositeUnit
{
    function bombardStrength()
    {
        $ret = 0;
        foreach ($this->units as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

class Archer extends Unit
{
    function bombardStrength()
    {
        return 4;
    }
}

class LaserCannonUnit extends Unit
{
    function bombardStrength()
    {
        return 10;
    }
}


// Создадим армию
$main_army = new Army();
// Добавим пару боевых единиц
$main_army->addUnit(new Archer ());
$main_army->addUnit(new LaserCannonUnit ());
// Создадим еще одну армию
$sub_army = new Army ();
$sub_army->addUnit(new Archer ());
$sub_army->addUnit(new Archer ());
$sub_army->addUnit(new Archer ());
// Добавим вторую армию к первой
$main_army->addUnit($sub_army);
// Все вычисления выполняются за кулисами
$mainArmyBombardStrength = $main_army->bombardStrength();
print "Атакующая сила : { $mainArmyBombardStrength } \n";