<?php
//テスト　中島
header("Content-Type: text/html; charset=UTF-8");
include('ApiConnecter.php');
include('Store.php');
?>
<html>
<head>
	<meta http-equiv="Content-Type content=text/html; charset=UTF-8">
	<title>テスト用フォーム</title>
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
<p>性別:<input type="radio" name="sex" value="male" checked>男
<input type="radio" name="sex" value="female">女</p>
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
<input type="radio" name="purpose" value="3">夕飯
<input type="radio" name="purpose" value="4">飲み会・パーティ
<input type="radio" name="purpose" value="5">合コン
<input type="radio" name="purpose" value="6">お茶
<input type="radio" name="purpose" value="7">記念日・特別な日
</p>
何人でいくか:<input type="text" name="member" value="" />人
</p>
誰と行くか:<input type="radio" name="who" value="1" checked>友達・同僚
<input type="radio" name="who" value="2">先輩
<input type="radio" name="who" value="3">24〜29歳
<input type="radio" name="who" value="4">30〜34歳
<input type="radio" name="who" value="5">35〜39歳
<input type="radio" name="who" value="6">40〜歳
</p>
<p>
どこに行くか:<input type="text" name="where" value="" >
</p>
<p><input type="submit" name="sendButton" value="送信" /></p>
</form>
<?php
	}else{
		$apiConnecter=new ApiConnecter();

		// echo $apiConnecter->connect();
		echo $apiConnecter->requestUrl;
	}
?>
</body>
</html>

