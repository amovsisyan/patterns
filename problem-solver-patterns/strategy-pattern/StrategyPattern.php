<?php

abstract class CostStrategy
{
    abstract function cost(Lesson $lesson);

    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return ($lesson->getDuration() * 5);
    }

    function chargeType()
    {
        return " Почасовая оплат а ";
    }
}

class FixedCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return 30;
    }

    function chargeType()
    {
        return "Фиксированная ставка ";
    }
}

abstract class Lesson
{
    private $duration;
    private $costStrategy;

    function __construct($duration, CostStrategy $strategy)
    {
        $this->duration = $duration;
        $this->costStrategy = $strategy;
    }

    function cost()
    {
        return $this->costStrategy->cost($this);
    }

    function chargeType()
    {
        return $this->costStrategy->chargeType();
    }

    function getDuration()
    {
        return $this->duration;
    }
}

class Lecture extends Lesson
{
// Специфичные для Lecture реализации ...

}

class Seminar extends Lesson
{
// Специфичные для Seminar реализации ...
}


$lessons[] = new Seminar (4, new TimedCostStrategy());
$lessons[] = new Lecture (4, new FixedCostStrategy ());

foreach ($lessons as $lesson) {
    print"Плата за занятие { $ l e s son->cost ( ) ) . ";
    print"Тип оплаты : ( $ l e s son- >chargeType ( ) } \n ";
}