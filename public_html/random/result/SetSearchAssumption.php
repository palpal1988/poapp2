<?php
include_once('Assumption.php');
include_once('ApiConnecter.php');
include_once('Store.php');

// お店検索の中心機能を備えたクラス。中
class SetSearchAssumption {

	//検索条件を収納する配列。中
	private $assumptionArray=array();

	/*検索条件自体のパラメーター名。中
		MaxDinnerPrice・・・・平均金額（夜）の上限（ぐるなびは基本的にこちらしか使わない。）
		MaxLunchPrice・・・・平均金額（昼）の上限
		MinDinnerPrice・・・・平均金額（夜）の下限
		MinLunchPrice・・・・平均金額（昼）の下限
		Plus◯◯・・・・・◯◯に入るパラメーターに数値を追加
		OpenStartTime・・・・営業開始時間
		OpenEndTime・・・・営業終了時間
		Categoly_L_In・・・指定された大分類で検索
		Categoly_L_Out・・・指定された大分類を除外して検索
		Categoly_S_In・・・指定された少分類で検索
		Categoly_S_Out・・・指定された少分類を除外して検索
		FreeWord・・・指定されたフリーワードで検索
	*/
	const PlusMaxDinnerPrice=1;
	const PlusMaxLunchPrice=2;
	const MaxDinnerPrice=3;
	const MaxLunchPrice=4;
	const MinDinnerPrice=5;
	const MinLunchPrice=6;
	const OpenStartTime=7;
	const OpenEndTime=8;
	const Categoly_L_In=9;
	const Categoly_L_Out=10;
	const Categoly_S_In=11;
	const Categoly_S_Out=12;
	const FreeWord=13;
	const Longitude=14;
	const Latitude=15;

	private $searchState=null;
	private $searchLevel=null;
	private $apiConnecter=null;
	private $storeInfo=null;

	//リクエストおよびリターンパラメーター。保守性・拡張性向上のため定数とする。
	const BUDGET='budget';
	const CATEGOLY_L='categoly_l';
	const CATEGOLY_S='categoly_S';
	const OPEN_TIME='opentime';
	const FREE_WORD='freeword';
	const LATITUDE='latitude';
	const LONGITUDE='longitude';

	function __construct(){
		$this->searchLevel=1;
		$this->searchState=1;
		$this->apiConnecter=new GulnaviApiConnecter();
		// $this->apiConnecter2=new GeocodingApiConnecter();
		$this->storeInfo=new Store();
	}

	//デバッグ用
	function returnPram(){
		return $this->apiConnecter->getXml(1,1);
	}
	//ソートするためのコールバック関数

	//検索を開始する。中
	function startSearch(){

		$requestArray=array();
		// $this->apiConnecter2->setGoal($_POST['where']);
		// $this->apiConnecter2->connectApi();
		// $this->apiConnecter->addRequestUrl($this::LONGITUDE,(String)$this->apiConnecter2->getLongitude());
		// $this->apiConnecter->addrequestUrl($this::LATITUDE,(String)$this->apiConnecter2->getLatitude());

		$this->apiConnecter->connectApi();
		$this->apiConnecter->setAllXml();

		if($this->apiConnecter->countHit()<=0){
			//0件の処理
		}else{
			do{
				$pageNum=mt_rand(0, $this->apiConnecter->countPage() - 1);
				$storeNum=mt_rand(0,10);
			}while(!isset($this->apiConnecter->requestXml[$pageNum]->rest[$storeNum]));
		}

		$this->setStore($pageNum,$storeNum);

		// echo $this->apiConnecter->getUrl(1);
		return $this->storeInfo;

	}

	//お店情報をインプットする。
	private function setStore($pageNum, $storeNum){

		$storeXml=$this->apiConnecter->getXml(1,$pageNum);
		$this->storeInfo->setId($storeXml->rest[$storeNum]->id);
		$this->storeInfo->setNamekana($storeXml->rest[$storeNum]->name_kana);
		$this->storeInfo->setName($storeXml->rest[$storeNum]->name);
		$this->storeInfo->setLatitude($storeXml->rest[$storeNum]->latitude);
		$this->storeInfo->setLongitude($storeXml->rest[$storeNum]->longitude);
		$this->storeInfo->setFwCategory($storeXml->rest[$storeNum]->fwCategory);
		$this->storeInfo->setUrlPc($storeXml->rest[$storeNum]->url);
		$this->storeInfo->setUrlMobile($storeXml->rest[$storeNum]->url_mobile);
		$this->storeInfo->setImage1($storeXml->rest[$storeNum]->image_url->shop_image1);
		$this->storeInfo->setImage2($storeXml->rest[$storeNum]->image_url->shop_image2);
		$this->storeInfo->setQrCode($storeXml->rest[$storeNum]->qrcode);
		$this->storeInfo->setAddress($storeXml->rest[$storeNum]->address);
		$this->storeInfo->setTel($storeXml->rest[$storeNum]->tel);
		$this->storeInfo->setFax($storeXml->rest[$storeNum]->fax);
		$this->storeInfo->setOpenTime($storeXml->rest[$storeNum]->opentime);
		$this->storeInfo->setHoliday($storeXml->rest[$storeNum]->holiday);

		$this->storeInfo->setLine($storeXml->rest[$storeNum]->access->line);
		$this->storeInfo->setStation($storeXml->rest[$storeNum]->access->station);
		$this->storeInfo->setStation_exit($storeXml->rest[$storeNum]->access->station_exit);
		$this->storeInfo->setWalk($storeXml->rest[$storeNum]->access->walk);
		$this->storeInfo->setNote($storeXml->rest[$storeNum]->access->note);

		$this->storeInfo->setPrL($storeXml->rest[$storeNum]->pr->pr_l);
		$this->storeInfo->setPrS($storeXml->rest[$storeNum]->pr->pr_s);
		$this->storeInfo->setArea($storeXml->rest[$storeNum]->code->areaname);
		$this->storeInfo->setPrefecture($storeXml->rest[$storeNum]->code->prefname);
		$this->storeInfo->setCategoryL($storeXml->rest[$storeNum]->code->category_name_l);
		$this->storeInfo->setCategoryS($storeXml->rest[$storeNum]->code->category_name_s);
		$this->storeInfo->setBudget1($storeXml->rest[$storeNum]->budget);
		$this->storeInfo->setBudget2($storeXml->rest[$storeNum]->budget);
		$this->storeInfo->setEquipment($storeXml->rest[$storeNum]->equipment);

		return 0;
	}

	private function judgeParam($value){
		if($value->getName()==$this::FreeWord){
			return $this::FREE_WORD;
		}elseif($value->getName()==$this::Latitude){
			return $this::LATITUDE;
		}elseif($value->getName()==$this::Longitude){
			return $this::LONGITUDE;
		}
		return -1;
	}

	//どちらが検索条件として優れいているか判断し、優先度が高いほうを返す。中
	private function comparePriority($assumption1, $assumption2){

	}
	//優先度を考慮して、かぶらない検索条件のうちから、指定された条件を返す。中
	private function returnRegularAssumption($number){

	}

	//優先度を考慮せず、登録された検索条件の数を返す。中
	function count(){

	}
	//優先度を考慮して、かぶらない検索条件がいくつあったかを数えて返す。中
	function regularCount(){

	}

}

?>