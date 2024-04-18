<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Фирма доставки</title>

    <!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->
    <?php
    session_start();

    if (isset($_POST['exit'])) {
        $_SESSION['userID'] = NULL;
        $_SESSION['userName'] = NULL;
        header('Location: index.php');
    }
    ?>
    <!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->

    <table class="mainTable">
        <tr>
            <td>
                <form action='index.php'>
                    <button type='submit'>На главную страницу</button>
                </form>
            </td>
            <td>
                Главная страница
            </td>
            <td>
                <form action='dost.php'>
                    <button type='submit'>Заказать доставку</button>
                </form>
            </td>

            <td>
                Блок авторизации<br>
                <?php
                if ($_SESSION['userID'] != NULL) {
                    echo "Здравсвуйте " . $_SESSION['userName'] . "<br>";
                    ?>
                    <form action='' method='POST'>
                        <button type='submit' name='exit' class='btn'>Выйти</button>
                    </form>
                    <form action='userPage.php'>
                        <button type='submit' class='btn'>В личный кабинет</button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action='autor.php'>
                        <button type='submit' style="height:50px">Авторизация</button>
                    </form>
                <?php } ?>

            </td>
        </tr>
    </table>
</head>
<!-- UPDATE DATA -->
<?php
if (isset($_POST['update'])) {
    $_SESSION['userName'] = $_POST['name'];
    include ("Setup.php");
    $query = mysqli_query($mysqli, "UPDATE klient 
        SET Familiya = '$_POST[surn]', 
        Login = '$_POST[login]', 
        Password = '$_POST[pass]', 
        Phone= '$_POST[phone]',
         Email= '$_POST[email]', 
         Name = '$_POST[name]', 
         Otchestwo = '$_POST[patr]'
        WHERE Code_client = $_SESSION[userID]");
}
?>
<!-- UPDATE DATA -->

<!-- ОФОРМЛЕНИЕ -->
<?php
if (isset($_POST['oform'])) {
    $date = date('Y-m-d H:i:s');
    // echo "UPDATE posilka 
    // SET Data_of = '$date', 
    // Code_sost = 1
    // WHERE Code_pos = $_POST[oform]";
    include ("Setup.php");
    $query = mysqli_query($mysqli, "UPDATE posilka 
        SET Data_of = '$date', 
        Code_sost = 1
        WHERE Code_pos = $_POST[oform]");
}

if (isset($_POST['delete'])) {
    include ("Setup.php");
    $query = mysqli_query($mysqli, "DELETE FROM posilka WHERE Code_pos = $_POST[delete]");
}

if (isset($_POST['offAll'])) {
    $date = date('Y-m-d H:i:s');
    include ("Setup.php");
    $query = mysqli_query($mysqli, "UPDATE posilka 
    SET Data_of = '$date', 
    Code_sost = 1
    WHERE Code_client = $_SESSION[userID] AND Code_sost IS NULL");
}
if (isset($_POST['delAll'])) {
    include ("Setup.php");
    $query = mysqli_query($mysqli, "DELETE FROM posilka WHERE Code_client = $_SESSION[userID] AND Code_sost IS NULL");
}

$str = "Обратная связь!";
if (isset($_POST['mailB'])) {
    $name = $_SESSION['userName'];
    $text = $_POST['mailText'];
    if (mail('openServerTest@yandex.ru', $name, $text)) {
        $str = 'Письмо успешно отправлено';
    } else {
        $str = 'Ошибка';
    }
}

?>
<!-- ОФОРМЛЕНИЕ -->

<body>
    <table style="margin: 0 auto;
    width: 50%;
    height: 50%;">
        <tr>
            <td colspan="8">
                Личная информация
            </td>
        </tr>
        <tr>
            <td>
                Фамилия
            </td>
            <td>
                Имя
            </td>
            <td>
                Отчество
            </td>
            <td>
                Email
            </td>
            <td>
                Телефон
            </td>
            <td>
                Логин
            </td>
            <td>
                Пароль
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <?php
            include ("Setup.php");
            $query = mysqli_query($mysqli, "SELECT * FROM klient WHERE Code_client = $_SESSION[userID]");
            $result = mysqli_fetch_array($query);
            ?>
            <form action='' method='POST'>
                <td>
                    <input type="text" name="surn" value=<?php echo $result['Familiya'] ?>>
                </td>
                <td>
                    <input type="text" name="name" value=<?php echo $result['Name'] ?>>
                </td>
                <td>
                    <input type="text" name="patr" value=<?php echo $result['Otchestwo'] ?>>
                </td>
                <td>
                    <input type="e-mail" name="email" value=<?php echo $result['Email'] ?>>
                </td>
                <td>
                    <input type="text" name="phone" value=<?php echo $result['Phone'] ?>>
                </td>
                <td>
                    <input type="text" name="login" value=<?php echo $result['Login'] ?>>
                </td>
                <td>
                    <input type="text" name="pass" value=<?php echo $result['Password'] ?>>
                </td>
                <td>
                    <button type='submit' name="update">Обновить поля</button>
                </td>
            </form>
        </tr>
    </table>

    <table class='mail'>
        <form action='' method='POST'>
            <tr>
                <td>
                    <?php echo $str?>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea style="height: 90%; width: 90%" cols=20 rows=5 name='mailText'></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button type='submit' name="mailB">Написать нам!</button>
                </td>
            </tr>
        </form>
    </table>

    <table style="margin: 0 auto;
    width: 50%;
    height: 50%;">
        <tr>
            <td colspan="10">
                Доставки клиента
            </td>
        </tr>
        <tr>
            <td>
                Тип
            </td>
            <td>
                Габарит
            </td>
            <td>
                Адрес доставки
            </td>
            <td>
                Комментарий
            </td>
            <td>
                Дата оформления
            </td>
            <td>
                Состояние
            </td>
            <td>
                Цена доставки (руб)
            </td>
            <td>
                Дата отправления
            </td>
            <td>
                Дата получения
            </td>
            <td>
                <form action='' method='POST'>
                    <button type='submit' name="offAll">Оформить все</button>
                    <button type='submit' name="delAll">Удалить все</button>
                </form>
            </td>
        </tr>
        <tr>
            <?php
            include ("Setup.php");
            $query = mysqli_query($mysqli, "SELECT * FROM posilkaview WHERE Code_client = $_SESSION[userID]");

            while ($result = mysqli_fetch_array($query)) {
                $dateOf = date("d.m.Y H:i:s", strtotime($result['Data_of']));
                echo "
                <tr>
                <td>
                $result[Type_name]
                </td>
                <td>
                $result[gabName]
                </td>
                <td>
                $result[adrDost]
                </td>
                <td>
                $result[Comment]
                </td>
                <td>
                $dateOf
                </td>
                <td>
                $result[sostName]
                </td>
                <td>
                $result[Cost_dost]
                </td>
                <td>
                $result[Date_otpr]
                </td>
                <td>
                $result[Date_polych]
                </td>
                <td>
                ";
                if ($result['Data_of'] == null) {
                    echo "
                <form action='' method='POST'>
                    <button type='submit' name='oform' value = $result[Code_pos]>Оформить</button>
                </form>
                <form action='' method='POST'>
                    <button type='submit' name='delete' value = $result[Code_pos]>Удалить</button>
                </form>
                ";
                } else {
                    echo "Уже оформлено!";
                }
                echo "
                </td></tr>
                ";

            }


            ?>
    </table>
</body>

</html>