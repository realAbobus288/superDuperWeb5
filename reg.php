<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Регистрация</title>



    <table class="mainTable">
    <tr>
        <td >
        <form action='index.php'>
            <button type='submit' >На главную страницу</button>
        </form>
        </td>
        <td>
            Регистрация 
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

<!-- Регистрация -->
<?php
session_start();
    if(isset($_POST['conf'])){
        if(empty($_POST['login']) || empty($_POST['password']) || empty($_POST['name'])
        || empty($_POST['sern']) || empty($_POST['patr']) || empty($_POST['phone']) || empty($_POST['email'])){
            echo "Заполните все поля регистрации"."<br>";
        }else{
            include("Setup.php");
            $query = mysqli_query($mysqli, "SELECT COUNT(*) FROM klient WHERE Login = '$_POST[login]'");
            $result = mysqli_fetch_array($query);
            if($result[0]>0)echo "Пользователь уже зарегистрировался";
            if($result[0]==0)
            {
                $query = mysqli_query($mysqli, "
                
                INSERT INTO `klient` (`Code_client`, `Familiya`, `Login`, `Password`, `Phone`, `Email`, `Name`, `Otchestwo`) 
                VALUES (NULL, '$_POST[sern]', '$_POST[login]', '$_POST[password]', '$_POST[phone]', '$_POST[email]', '$_POST[name]', '$_POST[patr]');");

                $_SESSION['userName'] = $_POST['name'];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['login'] = $_POST['login'];

                $query = mysqli_query($mysqli, "SELECT Code_client FROM klient WHERE Login
                 = '$_POST[login]' AND Password = '$_POST[password]'");
                $result = mysqli_fetch_array($query);
                $_SESSION['userID'] = $result['Code_client'];
                header("Location: index.php");
            }
            mysqli_close($mysqli);
        }
    }
?>
<!-- Регистрация -->

<table class = "reg">
<tr>
        <td colspan="2">
            Регистрация
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
        <td>
            Имя
        </td>
        <td>
            <form action='' method='POST'>
            <textarea cols=20 rows=1 name='name'><?php echo $_POST['name'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            Фамилия
        </td>
        <td>
            <textarea cols=20 rows=1 name='sern'><?php echo $_POST['sern'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            Отчество
        </td>
        <td>
            <form action='' method='POST'>
            <textarea cols=20 rows=1 name='patr'><?php echo $_POST['patr'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            Телефон
        </td>
        <td>
            <textarea cols=20 rows=1 name='phone'><?php echo $_POST['phone'] ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            Email
        </td>
        <td>
            <input type="e-mail" name="email" value=<?php echo $_POST['email'] ?>>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <button type='submit' name="conf" style="height:50px" >Подтвердить</button>
        </form>
        <form action='autor.php'>
            <button type='submit' style="height:50px" >Авторизация</button>
        </form>
        <form action='index.php'>
            <button type='submit' style="height:50px" >Отмена</button>
        </form>
        </td>

    </tr>
</table>

</body>

</html>