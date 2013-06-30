<?php
// 食べログAPIのコネクターとなるクラス　中島

class ApiConnecter{

// 食べログのApeKey　中島
	const apiKey="36806f7a238790b1529d4f641a2303e3c7fe3497";
// 食べログのAPI問い合わせ用API。中
	const tabelogUrl="http://api.tabelog.com/Ver2.1/RestaurantSearch/?";

//以下リクエストキー。食べログAPIのパラメータ名に準拠　中島
	private $latitude=null;
	private $longitude=null;
	//測地系はworldで固定。　中島
	private $datum="world";
	private $searchRange=null;
	private $prefecture=null;
	private $station=null;
	private $resultSet=null;
	private $sortOrder=null;
	private $pageNum=null;
	// 検索結果の測地系。同じくworldで固定　中島
	private $resultDatum="world";
	// リクエストurl。中
	public $requestUrl=null;

	public function __construct(){
		$this->searchRange="small";
		$this->prefecture="tokyo";
		// 最寄り駅はUTF-8でurlエンコードする必要がある。　中島
		$this->station=urlencode(mb_convert_encoding("銀座駅", 'UTF-8'));
		$this->sortOrder='reviewcount';
		$this->pageNum=1;

		$this->requestUrl=$this::tabelogUrl.
			'Key='.$this::apiKey.'&'.
			'SearchRange='.$this->searchRange.'&'.
			'Prefecture='.$this->prefecture.'&'.
			'Station='.$this->station.'&'.
			'SortOrder='.$this->sortOrder.'&'.
			'PageNum='.$this->pageNum;

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