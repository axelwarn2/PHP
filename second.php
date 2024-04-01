<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>***Экзамен</title>
    </head>

<style>
body {background-image: url('fon_02.gif');}
table {_float:left; margin:10px; padding:0; width:200px; border-collapse:collapse;}
td {border:1px dotted blue; margin:0;padding:10px;height:5px;min-width:20px;}
.header {font-family: Georgia; font-size: 2em; width:98%; text-align:center;}
.footer {clear: both;text-align:center;width:98%;
}

div {margin: 2px; text-align:left; padding: 5px; background-color: hsl(210,50%,50%);}
.menu {	font-family: Arial; width: 100%;
 padding: 0; margin: 0;
 list-style: none;
}

.menu > li {background-color: hsl(210,50%,50%); display: block; font-size: 16px; border: 0px solid;
 padding: 10px; margin: 10px;}

.menu{ text-decoration: none; color: white;
}

.first {font: 10pt Arial; font-style:italic;}
.second {font: 10pt Georgia;}
.third {font: 10pt Georgia; font-weight: bold; color: #800080;}
.leftcol {
    float: right; min-height: 200px; background-color: #ffffff;

}

.rightcol {
    float:left;
text-align:right; height: 100%;

    min-height: 300px; background-color: #ddd;

}

.pinline {display: block; width:30%;}
</style>

<body>
    <div class="header"><!--*****************Логотип и шапка********************-->
    Выгрузка из базы данных
    <?php
        $connect = mysqli_connect('localhost', 'root', '', 'EKZ');
        if(!$connect){
            die('Подключение к БД не получилось');
        }
        $result = mysqli_query($connect, "SELECT * FROM `ekz`");
    ?>
	</div>
    
    <div class="leftcol"><!--**************Основное содержание страницы************-->
    <table width="80%" class="pinline">
        <tr bgcolor="#dddddd">
            <td>Кассир
            <td>Пункт назначения
            <td>Цена
            <td>Количество
            <td>Дата
        </tr>
        <?php
            function printDateBase($result, $count){
                global $srCenUs;
                while($row = mysqli_fetch_array($result)){
                    $srCenUs += (int)$row[2];
                    $count++;
        ?>
                <tr bgcolor="#ffffff">
                    <td><?=$row[0]?></td>
                    <td><?=$row[1]?></td>
                    <td><?=$row[2]?></td>
                    <td><?=$row[3]?></td>
                    <td><?=$row[4]?></td>
                </tr>
                <?php
                }
                $srCenUs /= $count;
            }
            if(!isset($_POST['submit'])){
                printDateBase($result, $count);
            }
            ?>

            <?php
                function myFunc($result, $srCenUs, $count){
                    global $srCenUs;
                    while($row = mysqli_fetch_array($result)){
                        $srCenUs += (int)$row[2];
                        $count++;
            ?>
                    <tr bgcolor="#ffffff">
                        <td><?=$row[0]?></td>
                        <td><?=$row[1]?></td>
                        <td><?=$row[2]?></td>
                        <td><?=$row[3]?></td>
                        <td><?=$row[4]?></td>
                    </tr>
                <?php
                    }
                    $srCenUs /= $count;
                }
            ?>

            <?php
                if(isset($_POST['submit'])){
                    if(isset($_POST['city']) && !isset($_POST['data'])){
                        $city = $_POST['city'];
                        $result = mysqli_query($connect, "SELECT * FROM `ekz` WHERE `Пункт назначения` = '$city'");
                        myFunc($result, $srCenUs, $count);
                    }
                }
            ?>
    </table>
    
    <p class="first">
        Средняя цена билетов за указанный период: <b class="third"><?=round($srCenUs)?></b><br>
        Максимальная сумма продажи: <b class="third">X</b><br>
    </p>
    </div>
    
<div class="rightcol"><!--*******************Навигационное меню*******************-->
<form action="" method="POST">
    <ul class="menu">
        <li>Пункт назначения<br>
        <select name="city">
            <option selected disabled></option>
            <option value="Москва">Москва</option>
            <option value="Нижневартовск">Нижневартовск</option>
            <option value="Новосибирск">Новосибирск</option>
            <option value="Тюмень">Тюмень</option>
        </select>
        </li>


    	<li>Дата продажи<br>
        <select name="data">
        <option selected disabled></option>
            <option value="15-31января">15-31января</option>
            <option value="1февраля-1марта">1февраля-1марта</option>
            <option value="2-15марта">2-15марта</option>
		</select>
        </li>

        <li>
            <input type="submit" name="submit" value="Выгрузить данные">
        </li>
    </ul>
</form>
</div>

<div class="footer"><!--*******************Подвал*******************-->
&copy; Copyright 2018
</div>
</body>
</html>