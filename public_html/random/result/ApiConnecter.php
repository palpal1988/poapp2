<?php
include_once('SetSearchAssumption.php');
// APIへのアクセスの振る舞いを定義するインターフェイス。中
interface ApiConnecter{
	//与えられたパラメーターをリクエストURLにセットする。中
	function addRequestUrl($pram, $value);
	//与えれたパラメーターをリクエストURLから削除する。中
	function rmvRequestUrl($rmvPram);
	//xmlファイルを取得する。中
	function connectApi();
	//何件ヒットしているか数えて数値を返す。中
	function countHit();
	function countPage();
	//リクエストコードの配列を初期化する。
	function resetRequest();
	function defaultRequest();
	//リクエストURL自体を返す。中
	function getUrl($categoly);
	function getXml($categoly, $pageNum=1);
	function setAllXml();

	//第３引数$judgeが真の場合はXmlから要素を削除する。falseの場合は検索結果の数だけ削除する。
	function rmvXmlElements($name, $value, $judge);
	//XMLをXTML形式の一覧にして返す。中
	function getXmlString($categoly);
}

// class GeocodingApiConnecter{

// 	private $goal;
// 	private $latitude;
// 	private $longitude;

// 	public function __construct(){

// 	}

// 	public function setGoal($where){
// 		$this->goal=$where;
// 	}

// 	public function connectApi(){
// 		$requestUrl='http://www.geocoding.jp/api/?v=1.1&q='.$this->goal;
// 		$requestXml=simplexml_load_string(file_get_contents($requestUrl));
// 		$this->latitude=$requestXml->coordinate[0]->lat;
// 		$this->longitude=$requestXml->coordinate[0]->lng;
// 		echo $this->latitude."<br>".$this->longitude."<br>";
// 	}

// 	public function getLongitude(){
// 		return $this->longitude;
// 	}

// 	public function getLatitude(){
// 		return $this->latitude;
// 	}
// }

// ぐるナビのAPIのコネクターとなるクラス。中
class GulnaviApiConnecter implements ApiConnecter{

	private $debug=true;

	// ぐるナビのApeKey　中
	const apiKey="8d48e51493827bf2e374dcbb2098c853";

	// ぐるナビのAPI問い合わせ用API。中
	const gulnaviUrl="http://api.gnavi.co.jp/ver1/RestSearchAPI/?";
	//エリアマスタAPI。中
	const areaRequestApi="http://api.gnavi.co.jp/ver1/AreaSearchAPI/?";
	//都道府県マスタAPI。中
	const prefRequestApi="http://api.gnavi.co.jp/ver1/PrefSearchAPI/?";
	//大業態マスタAPI。中
	const categoly1RequestApi="http://api.gnavi.co.jp/ver1/CategoryLargeSearchAPI/?";
	//小業態マスタAPI。中
	const categoly2RequestApi="http://api.gnavi.co.jp/ver1/CategorySmallSearchAPI/?";

	//これ一個で全部含むことができるかも。中
	private $requestArray=array();
	//以下リクエストパラメータ。ぐるナビAPIのパラメータ名に準拠　中
	//測地系はworldで固定。中
	const input_coordinates_mode=2;
	const coordinates_mode=2;
	private $id=null;
	//UTF-8でのURLエンコード必要。中
	private $name=null;
	//カタカナのみ。UTF-8でのURLエンコード必要。中
	private $name_kana=null;
	//ハイフン必要。中
	private $tel=null;
	//（都道府県＋市町村＋番地）の文字列をUTF-8でURLエンコードすること。中
	private $address=null;
	private $area=null;
	private $pref=null;
	private $category_l=null;
	private $category_s=null;
	private $equipment=null;
	private $latitude=null;
	private $longitude=null;
	private $range=null;
	private $sort=null;
	private $offset=null;
	private $hit_per_page=null;
	private $offset_page=null;
	//UTF-8でのURLエンコード必要。中
	private $freeword=null;
	private $freeword_condition=null;

	//それぞれのXMLを格納する変数。中
	//本番用
	public $requestXml=array();
	//コピーして消した数だけを出す。
	public $finalRequestXml=array();
	private $areaRequestXml=null;
	private $prefRequestXml=null;
	private $categoly1RequestXml=null;
	private $categoly2RequestXml=null;

	public $resultNum=null;
	public $finalResultNum=null;

	public function __construct(){

		/*$this->range=1;
		$this->latitude=35.671989;
		$this->longitude=139.763965;
		$this->hit_per_page=20;*/
		$this->defaultRequest();
		//$this->requestUrl=$this::gulnaviUrl.http_build_query($this->requestArray);

		/*
		$this->requestXml=simplexml_load_string(file_get_contents($this->requestUrl));
		$this->areaRequestXml=simplexml_load_string(file_get_contents($this::areaRequestApi.'keyid='.$this::apiKey));
		$this->prefRequestXml=simplexml_load_string(file_get_contents($this::prefRequestApi.'keyid='.$this::apiKey));
		$this->categoly1RequestXml=simplexml_load_string(file_get_contents($this::categoly1RequestApi.'keyid='.$this::apiKey));
		$this->categoly2RequestXml=simplexml_load_string(file_get_contents($this::categoly2RequestApi.'keyid='.$this::apiKey));
		*/

		//echo"{$this->categoly1RequestXml->category_l[0]->category_l_name}";
	}

	//クリエ情報を加えたリクエストURLを返す。中
	public function addRequestUrl($pram, $value){
		$this->requestArray=array_merge($this->requestArray, array($pram=>$value));
		//var_dump($this->requestArray);
		return 0;

	}

	public function rmvRequestUrl($rmvPram){

	}

	//検索結果のXMLをAPIを叩かなくても大丈夫なように配列に格納する。
	public function setAllXml(){
		//念のため配列を初期化
		$pageNum=$this->countPage();
		$this->requestXml=array();
		$this->finalResultNum=$this->resultNum;
		for($i=1; $i<=$pageNum; $i++){
			$this->addRequestUrl('offset_page', $i);
			$this->connectApi();
		}
	}

	//ApiをたたいてXmlファイルを収納する。中
	public function connectApi(){
		//一時的にphp.iniの設定を変更する。中
		$separator = ini_get('arg_separator.output');
		ini_set('arg_separator.output', '&');
		$this->requestUrl=$this::gulnaviUrl.http_build_query($this->requestArray);
		ini_set('arg_separator.output', $separator);
		$this->requestXml[]=simplexml_load_string(file_get_contents($this->requestUrl));

		//echo $this->requestUrl;
		return true;
	}

	//今何件検索結果のXMLがあるかを返す。
	public function countHit(){
		if(isset($this->requestXml[0])){
			$this->resultNum=$this->requestXml[0]->total_hit_count;
			return $this->resultNum;
		}else{
			return -1;
		}
	}

	//1ページ20件が限界なため、何ページのXMLがあるかを返す。
	public function countPage(){
		if(isset($this->requestXml[0])){
			if(($this->countHit() % $this->requestXml[0]->hit_per_page)==0){
				return floor($this->countHit() / $this->requestXml[0]->hit_per_page);
			}else{
				return floor($this->countHit() / $this->requestXml[0]->hit_per_page) + 1;
			}
		}else{
			return -1;
		}
	}

	//リクエスト情報をリセットする。
	public function resetRequest(){
		$this->requestArray=array();
		$this->defaultRequest();
	}

	//デフォルト地をセットする。
	public function defaultRequest(){
		$this->requestArray=array_merge($this->requestArray, array(
			'keyid'=>$this::apiKey,
			'range'=>1,
			'latitude'=>$_POST['latitude'],
			'longitude'=>$_POST['longitude'],
			'hit_per_page'=>20,
			'offset_page'=>1
			));

	}

	//指定されたXMLを消去する。$judgeがfalseの場合はXMLからは削除せずヒットした数だけを減らす。
	public function rmvXmlElements($name, $value, $judge){

		if($judge){
			$currentXml=&$this->finalRequestXml;
		}else{
			$currentXml=&$this->requestXml;
		}

		switch($name){
			case SetSearchAssumption::MaxDinnerPrice:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach ($currentXml[$i]->xpath('./rest') as $rest) {
						if(isset($rest->budget) && ($rest->budget > $value)){
							$this->finalResultNum-=1;
							unset($rest[0]);

						}
					}
				}
				break;

			case SetSearchAssumption::MinDinnerPrice:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach ($currentXml[$i]->xpath('./rest') as $rest) {
						if(isset($rest->budget) && $rest->budget < $value){
							$this->finalResultNum-=1;
							unset($rest[0]);

						}
					}
				}
				break;

			case SetSearchAssumption::OpenStartTime:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach ($currentXml[$i]->xpath('./rest') as $rest) {
						if(isset($rest->opentime)){
							$matchCount=preg_match_all("/([0-2][0-9]:[0-5][0-9])～([0-2][0-9]:[0-5][0-9])/", $rest->opentime, $matchStr,PREG_SET_ORDER);
							if($matchCount>0){
								for($j=0; $j<=$matchCount-1; $j++){
									if(strtotime($matchStr[$j][1])<=strtotime($value)){
										break;
									}elseif($j==$matchCount-1){
										$this->finalResultNum-=1;
										unset($rest[0]);
										break;

									}
								}
							}
						}
					}
				}
				break;

			case SetSearchAssumption::OpenEndTime:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach ($currentXml[$i]->xpath('./rest') as $rest) {
						if(isset($rest->opentime)){
							$matchCount=preg_match_all("/([0-2][0-9]:[0-5][0-9])～([0-2][0-9]:[0-5][0-9])/", $rest->opentime, $matchStr,PREG_SET_ORDER);
							if($matchCount>0){
								for($j=0; $j<=$matchCount-1; $j++){
									if(strtotime($matchStr[$j][2])>=strtotime($value)){
										break;
									}elseif($j==$matchCount-1){
										$this->finalResultNum-=1;
										unset($rest[0]);
										break;

									}
								}
							}
						}
					}
				}
				break;

			case SetSearchAssumption::Categoly_L_In:
				$categoly_L_Array=mb_split(',',$value);
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach($currentXml[$i]->xpath('./rest') as $rest){
						if(isset($rest->code->category_code_l)){
							for($j=0; $j<=count($categoly_L_Array)-1; $j++){
								if(strcmp($rest->code->category_code_l,$categoly_L_Array[$j])==0){
									break;
								}
								if($j==count($categoly_L_Array)-1){

									$this->finalResultNum-=1;
									unset($rest[0]);
									break;

								}
							}
						}
					}
				}
				break;

			case SetSearchAssumption::Categoly_L_Out:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach($currentXml[$i]->xpath('./rest') as $rest){
						if(isset($rest->code->category_code_l)){
							if(strcmp($rest->code->category_code_l, $value)==0){
								$this->finalResultNum-=1;
								unset($rest[0]);

							}
						}
					}
				}
				break;

			case SetSearchAssumption::Categoly_S_In:
				$categoly_S_Array=mb_split(',',$value);
					for($i=0; $i<=$this->countPage()-1; $i++){
						foreach($currentXml[$i]->xpath('./rest') as $rest){
							if(isset($rest->code->category_code_s)){
								for($j=0; $j<=count($categoly_S_Array)-1; $j++){
									if(strcmp($rest->code->category_code_s,$categoly_S_Array[$j])==0){
										break;
									}elseif($j==count($categoly_S_Array)-1){
										$this->finalResultNum-=1;

										unset($rest[0]);
										break;

									}
								}
							}
						}
					}
				break;

			case SetSearchAssumption::Categoly_S_Out:
				for($i=0; $i<=$this->countPage()-1; $i++){
					foreach($currentXml[$i]->xpath('./rest') as $rest){
						if(isset($rest->code->category_code_s)){
							if(strcmp($rest->code->category_code_s, $value)==0){
								$this->finalResultNum-=1;
								unset($rest[0]);

							}
						}
					}
				}
				break;
		}
	}

	public function getUrl($categoly){
		switch($categoly){
			case 1:
				return $this->requestUrl;
				break;
			case 2:
				return $this::areaRequestApi.'keyid='.$this::apiKey;
				break;
			case 3:
				return $this::prefRequestApi.'keyid='.$this::apiKey;
				break;
			case 4:
				return $this::categoly1RequestApi.'keyid='.$this::apiKey;
				break;
			case 5:
				return $this::categoly2RequestApi.'keyid='.$this::apiKey;
				break;
		}
	}

	public function getXml($categoly, $pageNum=1){
		switch($categoly){
			case 1:
				$this->addRequestUrl('offset_page',$pageNum);
				$this->connectApi();
				return simplexml_load_string(file_get_contents($this->requestUrl));
				break;
			case 2:
				return simplexml_load_string(file_get_contents($this::areaRequestApi.'keyid='.$this::apiKey));
				break;
			case 3:
				return simplexml_load_string(file_get_contents($this::prefRequestApi.'keyid='.$this::apiKey));
				break;
			case 4:
				return simplexml_load_string(file_get_contents($this::categoly1RequestApi.'keyid='.$this::apiKey));
				break;
			case 5:
				return simplexml_load_string(file_get_contents($this::categoly2RequestApi.'keyid='.$this::apiKey));
				break;
		}
	}

	public function getXmlString($categoly){
		switch($categoly){
			case 1:
				return file_get_contents($this->requestUrl);
				break;
			case 2:
				return file_get_contents($this::areaRequestApi.'keyid='.$this::apiKey);
				break;
			case 3:
				return file_get_contents($this::prefRequestApi.'keyid='.$this::apiKey);
				break;
			case 4:
				return file_get_contents($this::categoly1RequestApi.'keyid='.$this::apiKey);
				break;
			case 5:
				return file_get_contents($this::categoly2RequestApi.'keyid='.$this::apiKey);
				break;
		}
	}

}





// 食べログAPIのコネクターとなるクラス　中島
class TabelogApiConnecter implements ApiConnecter{

// 食べログのApeKey　中島
	const apiKey="36806f7a238790b1529d4f641a2303e3c7fe3497";
// 食べログのAPI問い合わせ用API。中
	const tabelogUrl="http://api.tabelog.com/Ver2.1/RestaurantSearch/?";

//以下リクエストパラメータ。食べログAPIのパラメータ名に準拠　中島
	private $latitude=null;
	private $longitude=null;
	//測地系はworldで固定。　中島
	private $datum="world";
	private $searchRange=null;
	private $prefecture=null;
	private $station=null;
/*
resultSetをsmallにするとこの下6つのパラメーターが表示されなくなる。中
<address>・・・住所
<tel>・・・電話番号
<businesshours>・・・営業時間
<holiday>・・・休日
<latitude>・・・緯度
<longitude>・・・経度
*/
	private $resultSet=null;
	private $sortOrder=null;
	//最大60pまで表示可能。1ページ20件。中
	private $pageNum=null;
	// 検索結果の測地系。同じくworldで固定　中島
	private $resultDatum="world";
	// リクエストurl。中
	public $requestUrl=null;

	public function __construct(){
		$this->searchRange="medium";
		$this->prefecture="tokyo";
		// 最寄り駅はUTF-8でurlエンコードする必要がある。　中島
		// $this->station=urlencode(mb_convert_encoding("銀座駅", 'UTF-8'));
		// 最寄り駅の指定だと半径何mという検索はできない。中
		$this->latitude=35.671989;
		$this->longitude=139.763965;
		$this->resultSet='small';
		$this->sortOrder='reviewcount';
		$this->pageNum=1;

		$this->requestUrl=$this::tabelogUrl.
			'SearchRange='.$this->searchRange.'&'.
			'Prefecture='.$this->prefecture.'&'.
			// 'Station='.$this->station.'&'.
			// 緯度、経度を指定しないと半径何m以内という検索の仕方が出来ない
			'Latitude='.$this->latitude.'&'.
			'Longitude='.$this->longitude.'&'.
			'ResultSet='.$this->resultSet.'&'.
			'SortOrder='.$this->sortOrder.'&'.
			'PageNum='.$this->pageNum.'&'.
			'Key='.$this::apiKey;

	}

	//クリエ情報を加えたリクエストURLを返す。中
	public function addRequestUrl($pram, $value){
		return $this->requestUrl.'&'.$addPram;
	}
	// クエリ情報を消す。中
	public function rmvRequestUrl($rmvPram){

	}

	public function connectApi(){
		return file_get_contents($requestUrl);
	}
	function countHit(){

	}

	function countPage(){

	}

	function resetRequest(){

	}
	function defaultRequest(){

	}

	function getUrl($categoly){

	}

	function getXml($categoly, $pageNum=1){

	}

	function setXml($category){

	}

	function setAllXml(){

	}

	function getXmlString($categoly){

	}

	function rmvXmlElements($name, $value, $judge){

	}
}

?>