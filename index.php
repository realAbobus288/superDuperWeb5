<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta neme="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="st.css">
    <title>Фирма доставки</title>
    <style>
        .pod{
            position: absolute;
            margin: 16% 9% ;
            width: 81%;
        }
    </style>

<!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->
<?php
session_start();

if (isset($_POST['exit'])){
    $_SESSION['userID'] = NULL;
    $_SESSION['userName'] = NULL;
}
include("check.php")
?>
<!-- ВЫХОД ИЗ АВТОРИЗАЦИИ -->

    <table class="mainTable">
    <tr>
        <td >
        <form action='index.php'>
            <button type='submit' >На главную страницу</button>
        </form>
        </td>
        <td>
            Главная страница    
        </td>
        <td>
        <form action='dost.php'>
            <button type='submit' >Заказать доставку</button>
        </form>
        </td>

        <td>
            Блок авторизации<br>
            <?php
                if ($_SESSION['userID'] != NULL) {
                    echo "Здравсвуйте " . $_SESSION['userName'] . "<br>";
                    ?>
                    <form action='' method='POST'>
                        <button type='submit' name='exit' class='btn' >Выйти</button>
                    </form>
                    <form action='userPage.php'>
                        <button type='submit' class='btn' >В личный кабинет</button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action='autor.php'>
                        <button type='submit' style="height:50px" >Авторизация</button>
                    </form>
                <?php } ?>
        
        </td>
    </tr>
   </table>
</head>

<body>

    <p>Фирма доставки, которую мы представляем, является одной из ведущих компаний в отрасли. <br>
    Мы специализируемся на доставке товаров клиентов с высоким уровнем надежности и оперативности. <br>
    Наша компания обладает обширной сетью складов и транспортных средств, что позволяет нам осуществлять <br>
    доставку по всей стране в кратчайшие сроки.<br><br>

    Мы гордимся своей профессиональной командой сотрудников, которые обладают высоким уровнем квалификации и <br>
опыта в области логистики и доставки. Наш персонал стремится к обеспечению высочайшего уровня обслуживания<br>
 для каждого клиента, учитывая их индивидуальные потребности и требования.<br><br>

 Мы также активно внедряем новейшие технологии и инновации в нашу работу, чтобы обеспечить <br>
эффективность и удобство наших услуг. Мы постоянно совершенствуем процессы доставки, чтобы гарантировать<br>
 быструю и безопасную передачу товаров клиентам.<br><br>

 Наша фирма доставки стремится к постоянному росту и развитию, чтобы оставаться лидером на рынке <br>
и удовлетворять потребности наших клиентов в самых лучших условиях. Мы готовы предложить широкий <br>
спектр услуг по доставке, а также индивидуальный подход к каждому клиенту, чтобы обеспечить им максимальное <br>
удовлетворение от сотрудничества с нами.<br><br>

<table class="pod">
    <tr>
        <td colspan="7">О нас</td>
    </tr>
    <tr>
        <td>
            Компания: Novikov inc.
        </td>
        <td>
            Email: novikov@gmail.com
        </td>
        <td>
            Адрес: Город Пушкина, дом Колотушкина
        </td>
        <td>
            Телефон: +8-925-321-45-65
        </td>
        <td>Посещений всего: <?php echo $vsego ?></td>
        <td>Посещений за день: <?php echo $segodny ?></td>
        <td>IP: <?php echo $ipkol ?></td>
    </tr>
</table>
</body>


</html>