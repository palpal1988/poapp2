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
                        <div class="address"><?php $storeInfo->getAdress() ?></div>
                        <div class="tel"><span>TEL</span><?php $storeInfo->getTel() ?></div>
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
                            <td><?php echo $storeInfo->getCategory() ?></td>
                        </tr>
                        <tr>
                            <th>交通手段</th>
                            <td>
                                JR　地下鉄　【池袋駅】から徒歩1分　駅直結西武池袋店内<br>
                                池袋駅から163m
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
                            <td><?php echo $storeInfo->getBudget1() ?></td>
                            <td><?php echo $storeInfo->getBudget2() ?></td>
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
hl=ja&amp;
q=%E3%80%92107-0062+%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%AF%E5%8C%BA%E5%8D%97%E9%9D%92%E5%B1%B12-11-16+METLIFE%E3%83%93%E3%83%AB&amp;
t=m&amp;
ie=UTF8&amp;
oe=UTF8&amp;
ll=35.732021,139.71242&amp;
sspn=47.10617,93.076172&amp;
z=14&amp;
source=s_q&amp;
geocode=&amp;
aq=&amp;
sll=35.732021,139.71242&amp;
brcurrent=3,0x60188b6298e9424f:0xa2b8c41f6740576f,0&amp;
hq=&amp;
hnear=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%AF%E5%8C%BA%E5%8D%97%E9%9D%92%E5%B1%B1%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%91%EF%BC%96+%EF%BC%AD%EF%BC%A5%EF%BC%B4%EF%BC%AC%EF%BC%A9%EF%BC%A6%EF%BC%A5%E9%9D%92%E5%B1%B1%E3%83%93%E3%83%AB%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0&amp;
spn=0.013945,0.039396&amp;
iwloc=A&amp;
output=embed&amp;
iwloc=B"
                            height="300" width="100%" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">
                        </iframe>
                        <small>
                            <a style="color: #0000ff; text-align: left;" href="https://maps.google.co.jp/maps?
f=q&amp;
source=embed&amp;
hl=ja&amp;
geocode=&amp;
q=%E3%80%92107-0062+%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%AF%E5%8C%BA%E5%8D%97%E9%9D%92%E5%B1%B12-11-16+METLIFE%E3%83%93%E3%83%AB&amp;
aq=&amp;
sll=34.728949,138.455511&amp;
sspn=47.10617,93.076172&amp;
brcurrent=3,0x60188b6298e9424f:0xa2b8c41f6740576f,0&amp;
ie=UTF8&amp;
hq=&amp;
hnear=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%AF%E5%8C%BA%E5%8D%97%E9%9D%92%E5%B1%B1%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%91%EF%BC%96+%EF%BC%AD%EF%BC%A5%EF%BC%B4%EF%BC%AC%EF%BC%A9%EF%BC%A6%EF%BC%A5%E9%9D%92%E5%B1%B1%E3%83%93%E3%83%AB%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0&amp;
t=m&amp;
ll=35.732021,139.71242&amp;
spn=0.013945,0.039396&amp;
z=14&amp;
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
