<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('SetSearchAssumption.php');
include_once('Store.php');

function printStore($storeInfo){
    echo $storeInfo->getId()."</br>";
    echo $storeInfo->getNameKana()."</br>";
    echo $storeInfo->getName()."</br>";
    echo $storeInfo->getLatitude()."</br>";
    echo $storeInfo->getLongitude()."</br>";
    echo $storeInfo->getFwCategory()."</br>";
    echo $storeInfo->getUrlPc()."</br>";
    echo $storeInfo->getUrlMobile()."</br>";
    echo $storeInfo->getImage1()."</br>";
    echo $storeInfo->getImage2()."</br>";
    echo $storeInfo->getQrCode()."</br>";
    echo $storeInfo->getAdress()."</br>";
    echo $storeInfo->getTel()."</br>";
    echo $storeInfo->getFax()."</br>";
    echo $storeInfo->getOpenTime()."</br>";
    echo $storeInfo->getHoliday()."</br>";
    echo $storeInfo->getStation()."</br>";
    echo $storeInfo->getPrL()."</br>";
    echo $storeInfo->getPrS()."</br>";
    echo $storeInfo->getArea()."</br>";
    echo $storeInfo->getPrefecture()."</br>";
    echo $storeInfo->getCategory()."</br>";
    echo $storeInfo->getBudget1()."</br>";
    echo $storeInfo->getBudget2()."</br>";
    echo $storeInfo->getEquipment();
    }


    $setSearchAssumption=new SetSearchAssumption();
    $storeInfo=$setSearchAssumption->startSearch();

    echo $storeInfo->getLatitude();
    echo ",";
    echo $storeInfo->getLongitude();

?>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Firest Lite</title>
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, maximum-scale=1.0, minimum-scale=0.5,user-scalable=yes,initial-scale=1.0"/>
    <link rel="shortcut icon" href=""/>
    <link rel="stylesheet" href="../common.css">
    <noscript>
        <style type="text/css">
            .searchForm {
                display: none;
            }
        </style>
    </noscript>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
    <![endif]-->
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
    improve your experience.</p>
<![endif]-->

<div id="container">
    <div id="main">
        <div class="inner">
            <h1 class="logo"><a href="../" title="トップ"><img src="../img/logo.png" alt="Firest"></a></h1>

            <div class="info ">
                <div class="searchArea">検索条件：<?php echo $_POST['searchBox'] ?></div>
                <div id="header">
                    <div class="headerLeft">
                        <div class="kana"><?php echo $storeInfo->getNameKana() ?></div>
                        <h2><?php echo $storeInfo->getName() ?></h2>
                    </div>
                    <div class="headerRight">
                        <div class="address"><?php echo $storeInfo->getAddress() ?></div>
                        <div class="tel"><span>TEL</span><?php echo $storeInfo->getTel() ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="content">
                    <div class="picture">
                        <img
                            src=<?php echo "\"".$storeInfo->getImage1()."\"" ?>
                            height="150" alt="">
                        <img
                            src=<?php echo "\"".$storeInfo->getImage1()."\"" ?>
                            height="150" alt="">
                       <!--  <img
                            src="http://image1-1.tabelog.k-img.com/restaurant/images/Rvw/22000/150x150_square_22000502.jpg"
                            width="150" height="150" alt="">
                        <img
                            src="http://image1-2.tabelog.k-img.com/restaurant/images/Rvw/22000/150x150_square_22000512.jpg"
                            width="150" height="150" alt=""> -->
                    </div>
                    <table>
                        <tr>
                            <th>ジャンル</th>
                            <td><?php echo $storeInfo->getCategoryL() ?>　<?php echo $storeInfo->getCategoryS() ?></td>
                        </tr>
                        <tr>
                            <th>交通手段</th>
                            <td>
                                <?php echo $storeInfo->getLine() ?>
                                <?php echo $storeInfo->getStation() ?>
                                <?php echo $storeInfo->getStation_exit() ?>
                                <?php echo $storeInfo->getWalk() ?>
                            </td>
                        </tr>
                        <tr>
                            <th>営業時間</th>
                            <td>
                                <?php echo $storeInfo->getOpenTime() ?>
                            </td>
                        </tr>
                        <tr>
                            <th>定休日</th>
                            <td><?php echo $storeInfo->getHoliday() ?></td>
                        </tr>
                        <tr>
                            <th>平均予算</th>
                            <td><?php echo $storeInfo->getBudget1() ?>円<br></td>
                        </tr>
                        <tr>
                            <th>設備</th>
                            <td><?php echo $storeInfo->getEquipment() ?></td>
                        </tr>
                        <tr>
                            <th>ホームページ</th>
                            <td><a href=<?php echo "\"".$storeInfo->getUrlPc()."\"" ?>><?php echo $storeInfo->getUrlPc() ?></a></td>
                        </tr>
                    </table>
                    <div id="map">
                        <iframe
                            src="https://maps.google.co.jp/maps?
f=q&amp;
q=<?php echo $storeInfo->getLatitude() ?>,<?php echo $storeInfo->getLongitude() ?>&amp;
hl=ja&amp;
t=m&amp;
ie=UTF8&amp;
oe=UTF8&amp;
ll=<?php echo $storeInfo->getLatitude() ?>,<?php echo $storeInfo->getLongitude() ?>&amp;
z=16&amp;
source=s_q&amp;
iwloc=A&amp;
output=embed&amp;
iwloc=B"
                            height="300" width="100%" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">
                        </iframe>
                        <small>
                            <a style="color: #0000ff; text-align: left;" href="https://maps.google.co.jp/maps?
f=q&amp;
q=<?php echo $storeInfo->getLatitude() ?>,<?php echo $storeInfo->getLongitude() ?>&amp;
source=embed&amp;
hl=ja&amp;
ie=UTF8&amp;
t=m&amp;
ll=<?php echo $storeInfo->getLatitude() ?>,<?php echo $storeInfo->getLongitude() ?>&amp;
z=16&amp;
iwloc=A">大きな地図で見る</a>
                        </small>
                    </div>
                </div>
                <!-- /#content -->
            </div>
            <footer>
                <small>&copy; 2013</small>
            </footer>
        </div>
    </div>
    <!-- /#main -->
</div>
<!-- /#container -->

<script src="../../js/vendor/jquery-1.9.1.min.js"></script>
<script src="../heightLine.js"></script>
<script>
    var _gaq = [
        ['_setAccount', 'UA-XXXXX-X'],
        ['_trackPageview']
    ];
    (function (d, t) {
        var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
        g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g, s)
    }(document, 'script'));


</script>
</body>
</html>
