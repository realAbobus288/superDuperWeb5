<!DOCTYPE html>widName
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Выбор пункта приема</title>
</head>

<body>

<?php
if(isset($_POST['conf'])){
    session_start();
    $str = explode(';', $_POST['conf']);
    $_SESSION['wid'] = $str[0];
    $_SESSION['widName'] = $str[1]." ".$str[2];

    header('Location: dost.php');
}
?>

<?php

?>


<table style="margin: 5% auto;
    width: 25%;
    height: 25%;">
        <tr>
            <td>
                Поиск по Адресу
            </td>
            <td>
            <form action='' method='POST'>
                <input type="text" name="adress" value=<?php $_POST['adress']?>>
            </td>
        </tr>
        <tr>
            <td>
                Поиск по Городу
            </td>
            <td>
                <input type="text" name="city" value=<?php $_POST['city']?>>
            </td>
        </tr>
        <tr>
            <td>
                <button type='submit' class='btn' name='poisk'>Найти!</button>
            </td>
            <td>
                <button type='submit' class='btn' name='sbros'>Сброс</button>
            </td>
        </tr>
    </table>

    <table style="margin: 0 auto;
    width: 50%;
    height: 50%;">
        <tr>
            <td>
                Адрес
            </td>
            <td>
                Город
            </td>
            <td>
            </td>
        </tr>
       <?php
        include ("Setup.php");
        $query = mysqli_query($mysqli, "SELECT * FROM view1");
        if(isset($_POST['poisk'])){
            if (!empty($_POST['adress'])) {
                $query = mysqli_query($mysqli, "SELECT * FROM `view1` WHERE `Adress` LIKE '%$_POST[adress]%'");
            }
            if (!empty($_POST['city'])) {
                $query = mysqli_query($mysqli, "SELECT * FROM `view1` WHERE `Name` LIKE '%$_POST[city]%'");
            }
        }
        if(isset($_POST['sbros'])){$query = mysqli_query($mysqli, "SELECT * FROM view1");}

        while ($result = mysqli_fetch_array($query)) {
            // $arr = array(
            //     0 => $result['Code_punkt'],
            //     1 => $result['Adress'],
            //     2 => $result['Name'],
            // );
            echo"<tr>
            <td>
            $result[Adress]
            </td>
            <td>
            $result[Name]
            </td>
            <td>
            <form action='' method='POST'>
                <button type='submit' name ='conf' value='$result[Code_punkt];$result[Adress];$result[Name]'>Выбрать</button>
            </form>
            </td>
            <tr>";
        }
       
       ?>
    </table>
    <form action='dost.php'>
        <button type='submit'>Вернуться</button>
    </form>
</body>

</html>