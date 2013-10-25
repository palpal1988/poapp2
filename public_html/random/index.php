<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Firest Lite</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href=""/>
    <link rel="stylesheet" href="common.css">
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
<body onload="initialize()">
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
    improve your experience.</p>
<![endif]-->

<div id="container">
    <div id="main">
        <div class="inner">
            <h1 class="logo"><a href="" title="トップ"><img src="img/logo.png" alt="Firest"></a></h1>
            <noscript>
                <p>JavaScriptが無効です。</p>
            </noscript>
            <form action="result/" method="POST" id="form1">
                <div class="searchForm">
                    <input type="text" id="searchBox" value="エリア・駅名" name="searchBox" class="focus">
                    <input type="button" value="GO!" name="searchButton" class="searchButton" onclick="codeAddress()">
                </div>
                <input type="hidden" name="ido" id="ido" value="">
                <input type="hidden" name="keido" id="keido" value="">

                <div id="map_canvas" style="width:500px; height:300px"></div>
            </form>
            <footer>
                <small>&copy; 2013</small>
            </footer>
        </div>
    </div>
    <!-- /#main -->
</div>
<!-- /#container -->

<script src="../js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

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

    //ジオコーディング
    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(35.697456, 139.702148);
        var opts = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map
            (document.getElementById("map_canvas"), opts);
    }

    function codeAddress() {
        var address = document.getElementById("searchBox").value;
        if (geocoder) {

            geocoder.geocode({ 'address': address, 'region': 'jp'},
                function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);

                        var bounds = new google.maps.LatLngBounds();
                        for (var r in results) {
                            if (results[r].geometry) {
                                var latlng = results[r].geometry.location;
                                bounds.extend(latlng);
                                new google.maps.Marker({
                                    position: latlng, map: map
                                });

                                $("#ido").val(latlng.lat());
                                $("#keido").val(latlng.lng());
                                $("form").submit();
                            }
                        }
                        //map.fitBounds(bounds);
                    }
                });
        }
    }
</script>
<script src="common.js"></script>
</body>
</html>
