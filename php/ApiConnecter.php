<?php
// APIアクセスの振る舞いを定義するインターフェイス。中
interface ApiConnecter{
	function addRequestUrl();
	function rmvRequestUrl();
	function connectApi();
}

// ぐるナビのAPIのコネクターとなるクラス。中
class gulnaviApiConnecter implements ApiConnecter{
	// ぐるナビのApeKey　中
	const apikey="";
	// ぐるナビのAPI問い合わせ用API。中
	const gulnaviUrl="http://api.gnavi.co.jp/ver1/RestSearchAPI/?";

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

	private $requestUrl=null;

	public function __construct(){


		$this->searchRange="medium";
		//$this->prefecture="tokyo";
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
}

// 食べログAPIのコネクターとなるクラス　中島
class tabelogApiConnecter implements ApiConnecter{

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
	public function addRequestUrl($addPram){
		return $this->requestUrl.'&'.$addPram;
	}
	// クエリ情報を消す。中
	public function rmvRequestUrl($rmvPram){

	}

	public function connect(){
		return file_get_contents($this->requestUrl);
	}

}

?>