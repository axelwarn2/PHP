<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <select name="city">
            <option selected disabled>Выберите город</option>
            <option value="Москва">Москва</option>
            <option value="Екатеринбург">Екатеринбург</option>
            <option value="Новосибирск">Новосибирск</option>
            <option value="Санкт-Петербург">Санкт-Петербург</option>
        </select>
        <select name="price">
            <option selected disabled>Выберите стоимость билета</option>
            <option value="1-2000">1-2000</option>
            <option value="2000-4000">2000-4000</option>
            <option value="4000-6000">4000-6000</option>
            <option value="6000-8000">6000-8000</option>
        </select>
        <button type="submit" name="button">Применить</button>
    </form>

    <?php
        $connect = mysqli_connect('localhost', 'root', '', 'ekz');
        $result = mysqli_query($connect, "SELECT * FROM primer");
        echo "<table border>";
        echo "<tr><th>Кассир</th><th>Город</th><th>Стоимость билета</th></tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
        }
        echo "</table>";
    ?>
    <?php
        function myFunc($result, $srCenUs, $count){
            echo "<table border>";
            echo "<tr><th>Кассир</th><th>Город</th><th>Стоимость билета</th></tr>";
            while($row = mysqli_fetch_array($result)){
                $srCenUs += (int)$row[3];
                $count++;
                echo "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
            }
            if($count == 0){
                echo "<tr><td colspan = 3>Ничего нет</td></tr>";
                echo "</table>";
            }else{
                echo "</table>";
                $srCenUs = $srCenUs / $count;
                echo round($srCenUs);
            }
        }

        if(isset($_POST['button'])){
            if(isset($_POST['city']) && !isset($_POST['price'])){
                $value = $_POST['city'];
                $result = mysqli_query($connect, "SELECT * FROM primer WHERE Город = '$value'");

                myFunc($result, $srCenUs, $count);
            }
            if(!isset($_POST['city']) && isset($_POST['price'])){
                $valueArr = explode('-', $_POST['price']);
                $result = mysqli_query($connect, "SELECT * FROM primer WHERE `Стоимость билета` > '$valueArr[0]' AND `Стоимость билета` < '$valueArr[1]'");
            
                myFunc($result, $srCenUs, $count);
            }
            if(isset($_POST['city']) && isset($_POST['price'])){
                $valueArr = explode('-', $_POST['price']);
                $value = $_POST['city'];
                $result = mysqli_query($connect, "SELECT * FROM primer WHERE `Стоимость билета` > '$valueArr[0]' AND `Стоимость билета` < '$valueArr[1]' AND Город = '$value' ORDER BY Кассир ASC");
           
                myFunc($result, $srCenUs, $count);
            }
        }
    ?>
</body>
</html>