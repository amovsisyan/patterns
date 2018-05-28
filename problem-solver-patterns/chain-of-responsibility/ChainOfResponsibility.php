<?php

// Допустим, для вашего банковского счёта доступны три способа оплаты (A, B и C).
// Каждый подразумевает разные доступные суммы денег: A — 100 долларов, B — 300, C — 1000.
// Приоритетность способов при оплате: А, затем В, затем С. Вы пытаетесь купить что-то за 210 долларов.
// На основании «цепочки ответственности» система попытается оплатить способом А.
// Если денег хватает — то оплата проходит, а цепочка прерывается.
// Если денег не хватает — то система переходит к способу В, и т. д.

// Шаблон «Цепочка ответственности» позволяет создавать цепочки объектов.
// Запрос входит с одного конца цепочки и движется от объекта к объекту, пока не будет найден подходящий обработчик.

abstract class Account
{
    protected $successor;
    protected $balance;

    public function setNext(Account $account)
    {
        $this->successor = $account;
    }

    public function pay(float $amountToPay)
    {
        if ($this->canPay($amountToPay)) {
            echo sprintf('Paid %s using %s' . PHP_EOL, $amountToPay, get_called_class());
        } elseif ($this->successor) {
            echo sprintf('Cannot pay using %s. Proceeding ..' . PHP_EOL, get_called_class());
            $this->successor->pay($amountToPay);
        } else {
            throw new Exception('None of the accounts have enough balance');
        }
    }

    public function canPay($amount): bool
    {
        return $this->balance >= $amount;
    }
}

class Bank extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

class Paypal extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

class Bitcoin extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}


// Сделаем такую цепочку
//      $bank->$paypal->$bitcoin
//
// Приоритет у банка
//      Если банк не может оплатить, переходим к Paypal
//      Если Paypal не может, переходим к Bitcoin

$bank = new Bank(100);          // У банка баланс 100
$paypal = new Paypal(200);      // У Paypal баланс 200
$bitcoin = new Bitcoin(300);    // У Bitcoin баланс 300

$bank->setNext($paypal);
$paypal->setNext($bitcoin);

// Начнём с банка
$bank->pay(259);

// Выходной вид
// ==============
// Нельзя оплатить с помощью банка. Обрабатываю...
// Нельзя оплатить с помощью Paypal. Обрабатываю...
// Оплачено 259 с помощью Bitcoin!