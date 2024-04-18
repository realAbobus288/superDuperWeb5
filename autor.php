<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Авторизация</title>



    <table class="mainTable">
    <tr>
        <td >
        <form action='index.php'>
            <button type='submit' >На главную страницу</button>
        </form>
        </td>
        <td>
            Авторизация
        </td>
        <td>
        <form action='dost.php'>
            <button type='submit' >Заказать доставку</button>
        </form>
        </td>

        <td>
            Блок авторизации<br>
        <form action='autor.php'>
            <button type='submit' style="height:50px" >Авторизация</button>
        </form>
        </td>
    </tr>
   </table>
</head>

<body>

<?php
session_start();
if(isset($_POST['conf'])){
        if(empty($_POST['login']) || empty($_POST['password']) ){
            echo "Заполните все поля авторизации"."<br>";
        }else{
            include("Setup.php");
            $query = mysqli_query($mysqli, "SELECT * FROM klient WHERE Login = '$_POST[login]' AND Password = '$_POST[password]'");
            $result = mysqli_fetch_array($query);
            if($result['Code_client'] == NULL){
                echo "Ошибка в логине или пароле!"."<br>";
            }else{
                $_SESSION['userName'] = $result['Name'];
                $_SESSION['userID'] = $result['Code_client'];
                $_SESSION['login'] = $result['Login'];
                $_SESSION['password'] = $result['Password'];
                header("Location: index.php");
            }
        }
    }
    ?>

<table class="reg">
<tr>
        <td colspan="2">
            Авторизация
        </td>
    </tr>
    <tr>
        <td>
            Логин
        </td>
        <td>
            <form action='' method='POST'>
            <textarea cols=20 rows=1 name='login'><?php echo $_POST['login'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            Пароль
        </td>
        <td>
            <textarea cols=20 rows=1 name='password'><?php echo $_POST['password'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type='submit' name="conf" style="height:50px" >Подтвердить</button>
        </form>
        <form action='reg.php'>
            <button type='submit' style="height:50px" >Регистрация</button>
        </form>
        <form action='index.php'>
            <button type='submit' style="height:50px" >Отмена</button>
        </form>
        </td>

    </tr>
</table>

</body>

</html>