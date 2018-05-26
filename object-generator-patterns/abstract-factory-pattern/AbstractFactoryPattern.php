<?php
//В зависимости от своих потребностей вы можете купить деревянную дверь в одном магазине, стальную — в другом, пластиковую — в третьем.
// Для монтажа вам понадобятся разные специалисты: деревянной двери нужен плотник, стальной — сварщик, пластиковой — спец по ПВХ-профилям.

interface Door
{
    public function getDescription();
}

class WoodenDoor implements Door
{
    public function getDescription()
    {
        echo 'I am a wooden door';
    }
}

class IronDoor implements Door
{
    public function getDescription()
    {
        echo 'I am an iron door';
    }
}


interface DoorFittingExpert
{
    public function getDescription();
}

class Welder implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit iron doors';
    }
}

class Carpenter implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit wooden doors';
    }
}


/*
    VERSION ONE FOR ABSTRACT FACTORY
*/
interface DoorFactory
{
    public function makeDoor(): Door;

    public function makeFittingExpert(): DoorFittingExpert;
}

// Фабрика деревянных дверей возвращает плотника и деревянную дверь
class WoodenDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new WoodenDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Carpenter();
    }
}

// Фабрика стальных дверей возвращает стальную дверь и сварщика
class IronDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new IronDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Welder();
    }
}


$woodenFactory = new WoodenDoorFactory();

$door = $woodenFactory->makeDoor();
$expert = $woodenFactory->makeFittingExpert();

$door->getDescription();  // Output: Я деревянная дверь
$expert->getDescription(); // Output: Я могу устанавливать только деревянные двери

// Same for Iron Factory
$ironFactory = new IronDoorFactory();

$door = $ironFactory->makeDoor();
$expert = $ironFactory->makeFittingExpert();

$door->getDescription();  // Output: Я стальная дверь
$expert->getDescription(); // Output: Я могу устанавливать только стальные двери


/*
    VERSION TWO FOR ABSTRACT FACTORY WITH PROTOTYPE
*/
class DoorFactorySecond
{
    private $door;
    private $doorFittingExpert;

    function __construct(Door $door, DoorFittingExpert $doorFittingExpert)
    {
        $this->door = $door;
        $this->doorFittingExpert = $doorFittingExpert;
    }

    public function makeDoor(): Door
    {
        return clone $this->door;
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return clone $this->doorFittingExpert;
    }
}

$woodenFactory = new DoorFactorySecond(new WoodenDoor(), new Carpenter());

$door = $woodenFactory->makeDoor();
$expert = $woodenFactory->makeFittingExpert();

$door->getDescription();  // Output: Я деревянная дверь
$expert->getDescription(); // Output: Я могу устанавливать только деревянные двери

// Same for Iron Factory
$ironFactory = new DoorFactorySecond(new IronDoor(), new Welder());

$door = $ironFactory->makeDoor();
$expert = $ironFactory->makeFittingExpert();

$door->getDescription();  // Output: Я стальная дверь
$expert->getDescription(); // Output: Я могу устанавливать только стальные двери