<?php

//Верхняя граница поиска
define('N',1000000); // n - входные данные
define('SQRT_N',floor(sqrt(N)));

//Путь до файла с результатами
define('FILE_PATH', 'result.txt');

//Лимит времени в сек.
set_time_limit (90);

//Поиск простых чисел
$S = str_repeat("\1", N+1);

for ($i=2; $i<=SQRT_N; $i++) {
  if ($S[$i]==="\1") {
    for ($j=$i*$i; $j<=N; $j+=$i) {
      $S[$j]="\0";
    }
  }
}

//Выводим в браузер, что получилось
$data = "";

for ($i=2; $i<N; $i++) {
  if ($S[$i]==="\1") {
    $data .= $i . " ";
  }
}

file_put_contents(FILE_PATH, $data);

echo "<h2>С. Странная сортировка.</h2>";
echo '<a href="'. FILE_PATH .'">Посмотреть результат</a>';