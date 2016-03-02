<?php

class CDish {
  public $additives = array();

  public function __construct($name, $cost){
    $this->name = $name;
    $this->cost = $cost;
  }

  public function add(CAdditive $obj, $count) {
    if(array_key_exists($obj->name, $this->additives) ) {
      return false;
    } else {
      $this->additives[$obj->name] = array($obj, $count);
      return true;
    }
  }

  public function getCost() {
    $total_cost = 0;

    foreach ($this->additives as $additive) {
      $total_cost += $additive[0]->cost * $additive[1];
    }

    return $total_cost;
  }

  public function getName() {
    $recipe = $this->name . ' c ';
    foreach ($this->additives as $additive) {
      $recipe .= $additive[1] . ' ' .$additive[0]->name . ', ';
    }
    $recipe = rtrim($recipe, ', ');
    return $recipe;
  }
}

class CAdditive{
  public function __construct($name, $cost, $max){
    $this->name = $name;
    $this->cost = $cost;
    $this->max = $max;
  }
}

class COrder {
  public $dishes = array();

  public function __construct($name){
    $this->name = $name;
  }

  public function add(CDish $obj, $count) {
    if(array_key_exists($obj->name, $this->dishes) ) {
      return false;
    } else {
      $this->dishes[$obj->name] = array($obj, $count);
      return true;
    }

  }

  public function getCost() {
    $total_cost = 0;
    foreach ($this->dishes as $dishe) {
      $total_cost += ( $dishe[0]->cost * $dishe[1] ) + $dishe[0]->getCost();
    }
    return $total_cost;
  }

  public function getOrderText() {
    $name = $this->name . ' - ' . $this->getCost() . ' руб. <br>';
    foreach ($this->dishes as $dishe) {
      $name .= '- '. $dishe[1] . ' ' . $dishe[0]->getName() . ' <br>';
    }
    return $name;
  }
}

// создаем заказ
$order = new COrder('Мой первый заказ');

// создаем блюда
$borch = new CDish('борщ', 50);
$shashlik = new CDish('шашлык', 50);
$pure = new CDish('картофельное пюре', 25);

// создаем добавки
$smetana = new CAdditive('сметана', 3, 1);
$bread = new CAdditive('хлеб', 5, null);
$ketshup = new CAdditive('кетчуп', 3, 1);

// добавляем добавки в блюдо
$borch->add($smetana, 1);
$borch->add($bread, 2);

$shashlik->add($ketshup, 1);

$pure->add($ketshup, 2);
$pure->add($bread, 3);

// добавляем в заказ блюда
$order->add($borch, 1);
$order->add($shashlik, 2);
$order->add($pure, 2);

echo $order->getOrderText();