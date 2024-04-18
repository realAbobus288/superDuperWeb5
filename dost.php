<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Оформление доставки</title>

    <!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->
    <?php
    session_start();

    if (isset($_POST['exit'])) {
        $_SESSION['userID'] = NULL;
        $_SESSION['userName'] = NULL;
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
                Оформление доставки
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

<body>
    <!-- РАССЧЕТ ЦЕНЫ -->
    <?php
    function calculateDistance($latA, $lonA, $latB, $lonB)
    {
        $R = 6371;
        $phiA = $latA * M_PI / 180;
        $phiB = $latB * M_PI / 180;
        $lambdaA = $lonA * M_PI / 180;
        $lambdaB = $lonB * M_PI / 180;
        $d = acos(sin($phiA) * sin($phiB) + cos($phiA) * cos($phiB) * cos($lambdaA - $lambdaB));
        $L = $d * $R;
        return $L;
    }

    $priceForKM = 2;

    //echo $distance = calculateDistance(-34.806023, 128.065547, 45.853606, -162.810374);
    ?>
    <!-- РАССЧЕТ ЦЕНЫ -->


    <!-- СБРОС -->
    <?php
    if (isset($_POST['sbros'])) {
        $_SESSION['type'] = null;
        $_SESSION['gabar'] = null;
        $_SESSION['pri'] = null;
        $_SESSION['wid'] = null;
        $_SESSION['priName'] = null;
        $_SESSION['widName'] = null;
        
        
    }
    ?>
    <!-- СБРОС -->

    <!-- ВЫБОР ГАБАРИТА И ТИПА И КОММЕНТАРИЯ-->
    <?php
    if (isset($_POST['conf'])) {
        if (!empty($_POST['gabar'])) {
            $_SESSION['gabar'] = $_POST['gabar'];
        }
        if (!empty($_POST['type'])) {
            $_SESSION['type'] = $_POST['type'];
        }
        if (!empty($_POST['comm'])) {
            $_SESSION['comm'] = $_POST['comm'];
        }
    }
    ?>
    <!-- ВЫБОР ГАБАРИТА И ТИПА -->

    <!-- ВЫВОД ОБЩЕЙ ЦЕНЫ -->
    <?php
    $totalPrice;
    if ($_SESSION['type'] != null && $_SESSION['gabar'] != null && $_SESSION['pri'] != null && $_SESSION['wid'] != null) {
        include ("Setup.php");
        $query = mysqli_query($mysqli, "SELECT shirota, dolgota FROM punkt_dost WHERE Code_punkt = $_SESSION[pri]");
        $result = mysqli_fetch_array($query);
        $qr = mysqli_query($mysqli, "SELECT shirota, dolgota FROM punkt_dost WHERE Code_punkt = $_SESSION[wid]");
        $re = mysqli_fetch_array($qr);
       // echo $distance = calculateDistance($result[0], $result[1], $re[0], $re[1])."<br>";
        $distance = calculateDistance($result[0], $result[1], $re[0], $re[1]);
        $query = mysqli_query($mysqli, "SELECT nacenka FROM type WHERE Code_type = $_SESSION[type]");
        $nacT = mysqli_fetch_array($query);
        $query = mysqli_query($mysqli, "SELECT nacenka FROM gabarity WHERE Code_gab = $_SESSION[gabar]");
        $nacG = mysqli_fetch_array($query);
        $totalPrice =  ceil ($distance*$priceForKM*$nacT[0]*$nacG[0]) ;
        //echo $result[0]."<br>".$result[1]."<br>".$re[0]."<br>".$re[1]."<br>".$nacT[0]."<br>".$nacG[0];
    }
    ?>
    <!-- ВЫВОД ОБЩЕЙ ЦЕНЫ -->

    <!-- ОФРОМЛЕНИЕ -->
    <?php
    if (isset($_POST['oform'])) {
        if ($_SESSION['userID'] == null){
            echo "Вы должны быть авторизованы!"."<br>";
        }
        else{
            if ($_SESSION['type'] != null && $_SESSION['gabar'] != null && $_SESSION['pri'] != null && $_SESSION['wid'] != null){
                include ("Setup.php");
                $query = mysqli_query($mysqli, "INSERT INTO posilka 
                (Code_pos, Code_client, Code_type, Code_gab, Code_punkt_widachy, Comment, Data_of, Code_sost, 
                Cost_dost, Date_otpr, Date_polych, Code_punkt_priema) 
                VALUES(NULL, $_SESSION[userID], $_SESSION[type], $_SESSION[gabar], $_SESSION[wid], '$_SESSION[comm]', 
                NULL, NULL,  $totalPrice, NULL, NULL, $_SESSION[pri])");
                $_SESSION['type'] = null;
                $_SESSION['gabar'] = null;
                $_SESSION['pri'] = null;
                $_SESSION['wid'] = null;
                $_SESSION['priName'] = null;
                $_SESSION['widName'] = null;
                echo "Удача! Для окончательного оформления зайдите в личный кабинет!";
                //echo  mysqli_insert_id($mysqli);
                // $id = mysqli_insert_id($mysqli);
                // $query = mysqli_query($mysqli, "INSERT INTO korzina 
                // (code_user, code_posilka) 
                // VALUES($_SESSION[userID], $id)");

            }else{
                echo "Заполните все поля!"."<br>";
            }
        }
    }
    ?>
    <!-- ОФРОМЛЕНИЕ -->



    <table style="margin: 5% auto;
    width: 50%;
    height: 50%;">
            
        </tr>
        <tr>
            <td>
                Выберите пункт приема
            </td>
            <td>
                <!-- ПУНКТ ПРИЕМА -->
                <?php
                echo "Выбран пункт приема: " . $_SESSION['priName']."<br>";
                ?>
                <form action='punktPriema.php'>
                    <button type='submit'>Выбрать пункт</button>
                </form>
                <!-- ПУНКТ ПРИЕМА -->
            </td>
        </tr>

        <tr>
            <td>
                Выберите пункт выдачи
            </td>
            <td>

                <!-- ПУНКТ ВЫДАЧИ -->
                <?php
                echo "Выбран пункт выдачи: " . $_SESSION['widName']."<br>";
                ?>
                <form action='punktWid.php'>
                    <button type='submit'>Выбрать пункт</button>
                </form>
                <!-- ПУНКТ ВЫДАЧИ -->
            </td>
        </tr>
        <form action='' method='POST'>

        <tr>
                <td>
                    Выберите габариты посылки
                </td>
                <td>
                    <!-- ГАБАРИТЫ -->
                    <?php
                    echo "Выбранные габариты:" . $_SESSION['gabar'] . "<br>";
                    include ("Setup.php");

                    echo "
                <select name='gabar' size='1'>";
                    $query = mysqli_query($mysqli, "SELECT * FROM gabarity");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<option value = '$result[Code_gab]'";
                        if ($_SESSION['gabar'] == $result['Code_gab'])
                            echo " selected";
                        echo ">$result[name]</option>";
                    }
                    echo "</select>
                ";
                    ?>
                    <!-- ГАБАРИТЫ -->
                </td>
            </tr>

            <tr>
                <td>
                    Выберите тип посылки
                </td>
                <td>
                    <!-- onchange='window.location='dost.php?type='+this.value' -->
                    <!-- ТИПЫ -->
                    <?php
                    echo "Выбранный тип:" . $_SESSION['type'] . "<br>";

                    include ("Setup.php");

                    echo "
                <select name='type' size='1' >";
                    $query = mysqli_query($mysqli, "SELECT * FROM type");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<option value = '$result[Code_type]'";
                        if ($_SESSION['type'] == $result['Code_type'])
                            echo " selected";
                        echo ">$result[Type_name]</option>";
                    }
                    echo "</select>
                
                ";
                    ?>
                    <!-- ТИПЫ -->
                </td>
            </tr>

            <tr>
                <td>
                    Комментарий
                </td>
                <td>
                    <!-- КОММЕНТАРИЙ -->
                    <textarea cols=20 rows=1 name='comm'><?php echo $_POST['comm'] ?></textarea>
                    <!-- КОММЕНТАРИЙ -->
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type='submit' name='conf'>Подтвердить</button>
        </form>

        </td>
        <tr>
            <td>
                Итоговая цена(руб): <?php echo $totalPrice ?> <br>
                <form action='' method="POST">
                    <button type='submit' name="sbros">Сбросить</button>
                </form>
            </td>
            <td>
                <form action='' method="POST">
                    <button type='submit' name="oform">Заказать доставку</button>
                </form>
            </td>
        </tr>


    </table>
</body>

</html>