<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="verstka.css">
</head>
<body>
<div class="parent" >
    <div class="lsidebar">
    </div>
    <div class="rsidebar">
    </div>
    <h1 class="zag1"> Бар </h1>
    <meta http-equiv="Refresh" content="30" /><!--  автообновление страницы для изменения жанра музыки -->
    <table class="table">
        <tr class="text1">
            <td>
                Жанры музыки
            </td>
        </tr>
<?php
require_once 'connection.php'; // подключение файла с настройками для входа в бд

$link = mysqli_connect($host, $user, $password, $database) // подключаемся к серверу
    or die ("Ошибка cвязи с базой данных" . mysqli_error($link)); // обработка ошибки

$queryM ="SELECT * FROM `type`"; // запрос в sql на получение всех типов музыки
$resultM = mysqli_query($link,$queryM) or die("Ошибка" . mysqli_error($link)); // отправка запроса и обработка ошибки
if($resultM) // условие, если сработал запрос
    {
        $rowsM = mysqli_num_rows($resultM); 
        for ($i = 0 ; $i < $rowsM ; ++$i) // прохождение всех строк в таблице
        { 
        	echo "<tr>";
        	echo "<td>";
            $rowM = mysqli_fetch_row($resultM) or die("Ошибка" . mysqli_error($link)); // получение данных из строк для вывода списка жанров музыки
            echo $rowM[0], ". ", $rowM[1];
            echo "</td>";
            echo "</tr>";

        }
        echo "</table>";
        $queryNowP = "SELECT `name` FROM `type` WHERE `id` = ".random_int(1, $rowsM)."";
        $zapros =  mysqli_query($link,$queryNowP) or die("Ошибка" . mysqli_error($link));
        if($zapros) // условие, если сработал запрос
    	{
    		$str = mysqli_fetch_row($zapros) or die("Ошибка" . mysqli_error($link));
    		echo "<b class= `zag1`> Сейчас играет: ".$str[0]."</b>";
    		echo "<br>";
    	}
    }
$queryP = "SELECT * FROM `gosti`"; // запрос в sql на получение всех гостей
$resultP = mysqli_query($link,$queryP) or die("Ошибка" . mysqli_error($link)); // отправка запроса и обработка ошибки
if($resultP) // условие, если сработал запрос
{
	?>
	<table class="table">
        <tr class="text1">
            <td>
                Посетители
            </td>
            <td>
                Любимые жанры
            </td>
            <td>
                Что сейчас делает
            </td>
        </tr>
    <?php
        $rowsP = mysqli_num_rows($resultP); 
        for ($i = 0 ; $i < $rowsP ; ++$i) // прохождение всех строк в таблице
        { 
        	echo "<td>";
            $rowP = mysqli_fetch_row($resultP) or die("Ошибка" . mysqli_error($link)); // получение данных из строк для вывода пользователей и их любимых жанров
            if (strpos($rowP[2], $str[0]) !== false) // определение действия (пить или танцевать)
            {
            	$deistvie = "Танцует";
            }
            else 
            {
            	$deistvie = "Пьёт";
            }
            echo "<tr>";
        	echo "<td>";
        	echo $rowP[1];
            echo "</td>";
            echo "<td>";
        	echo $rowP[2];
            echo "</td>";
            echo "<td>";
        	echo $deistvie;
            echo "</td>";
            echo "</tr>";
            // echo "</td>";
            // echo "<td>";
            // echo $rowP[2];
            // echo "<br>";
            // echo "</td>";
            // echo "</tr>";
        }
    }



mysqli_close($link);
?>
</div>
</body>
</html>