<?php

function nod($a, $b){
  while($a != 0 && $b != 0) {
    if($a > $b) {
      $a = $a % $b;
    } else {
      $b = $b % $a;
    }
  }

  return $a + $b;
}

function get_simple_float($numerator, $denominator) {
  $nod = nod($numerator, $denominator);
  $numerator /= $nod;
  $denominator /= $nod;
  return array($numerator, $denominator);
}

function get_float($number, $integer, $mantissa) {

  $numerator = $mantissa;
  preg_match('/^(\d+)$/', $mantissa, $params);
  $denominator = pow( 10, strlen($params[1]) );

  list($numerator, $denominator) = get_simple_float($numerator, $denominator);
  $mantissa = "$numerator/$denominator";

  return array($integer, $mantissa);
}

function main() {
  $lines = file('input.txt');

  echo "<h2>А.Дроби</h2>";

  foreach ($lines as $num) {
    echo "$num => ";

    if(!$num) {
      continue;
    }

    if( preg_match('/^\d+$/', $num) ) {
      echo $num . '<br>';
      continue;
    }

    preg_match('/^(\d+).(\d+)$/', $num, $params);

    if( isset($params[2]) && strlen($params[2]) > 10 ) {
      echo 'Мантисса длиннее 10. <br>';
      continue;
    }

    if( isset($params[1]) &&  isset($params[2]) ) {
      list($integer, $mantissa) = get_float($num, $params[1], $params[2]);
      if($integer == 0) {
        $integer = '';
      }
      echo "$integer $mantissa <br>";
    }

    if( isset($params[1]) && !isset($params[2]) ) {
      echo $params[1];
    }
  }
}

main();