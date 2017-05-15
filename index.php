<?php

/*
Задание №1
Найдите сумму произведений всех простых чисел, меньших 200, на их порядковые номера, считая, что первым простым числом является 2.
**/

function checkNum($num)
{
 $matches = [];
  foreach (range(2, $num) as $val) {
        $res = $num % $val;
        if ($res === 0)
            array_push($matches, $res);
    }
    return (count($matches) === 1) ? true : false;
}

function summSimpleNum($limit = 200)
{
    $a = [];
    for ($num = 2; $num <= $limit; $num++) {
        if (checkNum($num))
            array_push($a, $num);
    }
        $arrSumm = [];
        $summ = 0;
        
        foreach ($a as $key => $val) {
            $key++;
            array_push($arrSumm, $key * $val);
        }
        
        foreach ($arrSumm as $val) {
            $summ += $val;
        }
        return $summ;
}
$result = summSimpleNum(200);
echo $result .'<br>';


/*
Задание №2
 Напишите регулярное выражение, которое удаляло бы идущие подряд (через один или несколько пробелов) два и более одинаковых слов, причем так, чтобы не осталось пробелов. Считайте все слова состоящими из маленьких латинских букв.
**/
$text = "hello hello hello hello world world               world world";

function deleteDuplicatesWords($text)
{
    $text = preg_replace('/(\b[\pL0-9]++\b)(?=.*?\1)/', '', $text);
    $text = preg_replace('/\s{2,}/',' ',$text);
    $text = trim(html_entity_decode($text));
    return $text;
}

$words = deleteDuplicatesWords($text); 
echo $words.'<br>';
var_dump($words);


/*
Задание №3
 В прикрепленном файле база данных, в которой есть три таблицы: пользователи, проектов и "отношение пользователей к проектам". Отношение пользователя к проекту может быть с разными ролями: дизайнер, лид, тестировщик и тд. Один и тот же пользователь может иметь несколько ролей в рамках одного проекта. Напишите запрос, который покажет список всех пользователей и напротив каждого напишет через запятую список всех проектов, в которых он участвует.

**/

$host = 'localhost';
$database = 'ticher';
$user = 'root';
$password = '';

$db = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

$query ='SELECT * FROM users a INNER JOIN user_project_rel b ON b.user_id = a.id INNER JOIN projects c ON c.id = b.project_id';

 $result = mysqli_query($db, $query) or die("Ошибка " . mysqli_error($db)); 

mysqli_close($db); 
 $arr = [];

foreach ($result as $res) {
  $arr[] = $res; 
 }
 
$users = [];

 foreach ($arr as $ar) {
  if(in_array($ar['login'], $users) === false) {
   array_push($users, $ar['login']);
  }
 }

 $poct = [];

  for( $i = 0; $i < count($users); $i++)
  {
   foreach($arr as $ar){
    if ($users[$i] == $ar['login']) {
     $poct[$users[$i]][] = $ar['link']."(".$ar['role'].")";
   }  
 }
}
 
 
$table = '<table border="1">';
 
 foreach ($poct as $key => $value) {
  $table .= "<tr><td style = 'text-align:center'>$key</td>";
  $table .= "<td style = 'text-align:center'>";
  
  foreach ($value as $val) {
  $table .= $val.', ';
  }
  
  $table .= "</td>";
  $table .= "<tr>";
}


$table .= '</table>';

echo $table;
 
