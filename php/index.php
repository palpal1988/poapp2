<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('SetSearchAssumption.php');
include_once('Store.php');
?>
<html>
<head>
	<meta http-equiv="Content-Type content=text/html; charset=UTF-8">
	<title>テスト用フォーム</title>
	<script type="text/javascript">
if (navigator.geolocation) {
   navigator.geolocation.getCurrentPosition(function(position) {
   s = position.coords.latitude+","+position.coords.longitude;
    alert(s);
 });
} else {
  alert("I'm sorry, but geolocation services are not supported by your browser.");
}
</script>
</head>
<body>
<?php
	if (!isset($_POST['do']))
	{
?>
<p>テスト用フォーム</p>
<form action="<?php echo basename(__FILE__) ?>" method="post"
enctype="application/x-www-form-urlencoded">
<input type="hidden" name="do" value="send" />
<p>性別:<input type="radio" name="sex" value="1" checked>男
<input type="radio" name="sex" value="2">女</p>
<p>職業:<input type="radio" name="position" value="1" checked>会社員
<input type="radio" name="position" value="2">主夫・主婦
<input type="radio" name="position" value="3">大学生
<input type="radio" name="position" value="4">高校・中学生
<input type="radio" name="position" value="5">フリーター
</p>
<p>年齢:<input type="radio" name="age" value="1" checked>15〜18歳
<input type="radio" name="age" value="1">19〜23歳
<input type="radio" name="age" value="2">24〜29歳
<input type="radio" name="age" value="3">30〜34歳
<input type="radio" name="age" value="4">35〜39歳
<input type="radio" name="age" value="5">40〜歳
</p>
<p>目的:<input type="radio" name="purpose" value="1" checked>朝食
<input type="radio" name="purpose" value="2">昼食
<input type="radio" name="purpose" value="3">夕食
<input type="radio" name="purpose" value="4">飲み会・パーティ
<input type="radio" name="purpose" value="5">合コン
<input type="radio" name="purpose" value="6">接待
<input type="radio" name="purpose" value="7">お茶
<input type="radio" name="purpose" value="8">記念日
</p>
何人でいくか:<input type="text" name="member" value="" />人
</p>
誰と行くか:<input type="radio" name="who" value="1" checked>友達・同僚
<input type="radio" name="who" value="2">先輩
<input type="radio" name="who" value="3">恋人
<input type="radio" name="who" value="4">家族
</p>
<p>
どこに行くか:<input type="text" name="where" value="" >
</p>
<p><input type="submit" name="sendButton" value="送信" /></p>
</form>
<?php
	}else{

		$setSearchAssumption=new SetSearchAssumption();

		$postArray=array(
			"sex"=>$_POST['sex'],
			"position"=>$_POST['position'],
			"age"=>$_POST['age'],
			"purpose"=>$_POST['purpose'],
			"member"=>$_POST['member'],
			"who"=>$_POST['who'],
			"where"=>$_POST['where']);

		foreach($postArray as $postName=>$value){
			$setSearchAssumption->setSimpleAssumption($postName,$value);
		}
		$setSearchAssumption->setComplexAssumption();
		$storeInfo=$setSearchAssumption->startSearch();
		//echo $setSearchAssumption->returnPram();

		echo $storeInfo->getId()."</br>";
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
?>
</body>
</html>

