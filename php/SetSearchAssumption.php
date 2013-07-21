<?php
include_once('Assumption.php');
include_once('ApiConnecter.php');
include_once('Store.php');

// お店検索の中心機能を備えたクラス。中
class SetSearchAssumption {

	//検索条件を収納する配列。中
	private $assumptionArray=array();

	/*検索条件自体のパラメーター名。中
		MaxPrice・・・・平均金額の上限
		MinPrice・・・・平均金額の下限
		Plus◯◯・・・・・◯◯に入るパラメーターに数値を追加
		OpenTime・・・・営業時間
		Categoly_L_In・・・指定された大分類で検索
		Categoly_L_Out・・・指定された大分類を除外して検索
		Categoly_S_In・・・指定された少分類で検索
		Categoly_S_Out・・・指定された少分類を除外して検索
		FreeWord・・・指定されたフリーワードで検索
	*/
	const MaxPrice=1;
	const MinPrice=2;
	const PlusMaxPrice=3;
	const OpenTime=4;
	const Categoly_L_In=5;
	const Categoly_L_Out=6;
	const Categoly_S_In=7;
	const Categoly_S_Out=8;
	const FreeWord=9;

	private $searchState=null;
	private $searchLevel=null;
	private $apiConnecter=null;
	private $storeInfo=null;

	//リクエストおよびリターンパラメーター。保守性・拡張性向上のため定数とする。
	const BUDGET='budget';
	const CATEGOLY_L='categoly_l';
	const CATEGOLY_S='categoly_S';
	const OPEN_TIME='opentime';
	const FREE_WORD='fw';

	function __construct(){
		$this->searchLevel=1;
		$this->searchState=1;
		$this->apiConnecter=new GulnaviApiConnecter();
		$this->storeInfo=new Store();
	}

	//デバッグ用
	function returnPram(){
		return $this->apiConnecter->returnXml(1,1);
	}
	//ソートするためのコールバック関数




	//1つの情報から得られる検索条件を、検索条件のクラスを集めた配列に追加する。中
	function setSimpleAssumption($name,$value){

		switch($name){
			case 'sex':
				if($value==1){
					//男

				}elseif($value==2){
					//女
				}
				break;

			case 'position':
				//会社員。中
				if($value==1){
					$this->assumptionArray[]=new Assumption($this::MaxPrice,1,1,true,array(6000,1500),null);
				}elseif($value==2){
					//主夫・主婦。中
					$this->assumptionArray[]=new Assumption($this::MaxPrice,1,1,true,array(4000,2000),null);
				}elseif($value==3){
					//大学生。中
					$this->assumptionArray[]=new Assumption($this::MaxPrice,1,1,true,array(4000,1000),null);
				}elseif($value==4){
					//中学・高校生。中
					$this->assumptionArray[]=new Assumption($this::MaxPrice,2,1,true,array(3000,1000),null);
				}
				break;

			case 'age':
				if($value==1){
					//〜18
				}elseif($value==2){
					//19〜23歳
				}elseif($value==3){
					//24~29
					$this->assumptionArray[]=new Assumptoin($this::PlusMaxPrice,1,1,true,array(1000,500),null);
				}elseif($value==4){
					//30~34
					$this->assumptionArray[]=new Assumptoin($this::PlusMaxPrice,1,1,true,array(4000,99999),null);
				}elseif($value==5){
					//35~39
					$this->assumptionArray[]=new Assumptoin($this::PlusMaxPrice,1,1,true,array(99999,99999),null);
				}elseif($value==6){
					//40~
					$this->assumptionArray[]=new Assumptoin($this::PlusMaxPrice,1,1,true,array(99999,99999),null);
				}
				break;

			case 'purpose':
				if($value==1){
					//朝食
					$this->assumptionArray[]=new Assumption($this::OpenTime,1,1,true,array(7,10),null);
					$this->assumptionArray[]=new Assumption($this::Categoly_L_In,1,1,true,array(1000,11000,13000,14000,18000,20000),null);
				}elseif($value==2){
					//昼食
					$this->assumptionArray[]=new Assumption($this::OpenTime,1,1,true,array(10,14),null);
				}elseif($value==3){
					//夕食
					$this->assumptionArray[]=new Assumption($this::OpenTime,1,1,true,array(17,22),null);
				}elseif($value==4){
					//飲み会・パーティ
					$this->assumptionArray[]=new Assumption($this::OpenTime,1,1,true,array(17,23),null);
					$this->assumptionArray[]=new Assumption($this::Categoly_L_In,1,1,true,array(5000,7000,9000,10000,21000),null);
				}elseif($value==5){
					//合コン
					$this->assumptionArray[]=new Assumption($this::FreeWord,1,1,true,array('合コン'),null);
					$this->assumptionArray[]=new Assumption($this::MaxPrice,1,5,true,array(5000,5000),null);
				}elseif($value==6){
					//接待
				}elseif($value==7){
					//お茶
					$this->assumptionArray[]=new Assumption($this::Categoly_L_In,1,5,true,array(18000),null);
				}elseif($value==8){
					//記念日
					$this->assumptionArray[]=new Assumption($this::MaxPrice,1,5,true,array(99999,99999),null);
					$this->assumptionArray[]=new Assumption($this::MinPrice,1,5,true,array(8000,8000),null);
				}
				break;

			case 'member':
				# code...
				break;

			case 'who':
				if($value==1){
					//友達・同僚
				}elseif($value==2){
					//先輩
				}elseif($value==3){
					//恋人
				}elseif($value==4){
					//家族・子供
				}
				break;

			case 'where':
				if($value==1){
					//現在地周辺
				}elseif($value==2){
					//目的地周辺
				}
				break;
		}
	}

	//復数の条件から複合的に判断される情報を配列に追加する。中
	function setComplexAssumption(){
		$basicSort=function ($array1, $array2){

			$tmp=strcmp($array1->getLevel(), $array2->getLevel());

			if($tmp==0){
				$tmp=strcmp($array1->getPriority(), $array2->getPriority());
				if($tmp==0){
					$tmp=strcmp($array1->getName(), $array2->getName());
				}
			}

			return $tmp;

		};

		usort($this->assumptionArray, $basicSort);
	}

	function requestAssumptionFilter ($array1){
		if($array1->getLevel()==$this->searchLevel){
			if($array1->getName()==$this::FreeWord){
				return true;
			}
		}
		return false;
	}

	//検索を開始する。中
	function startSearch(){

		//xmlでの結果が10件以下になるまで検索レベルをあげて検索を繰り返す。
		//0件になったら一つ前のレベルに戻る。
		//前提として優先度を考慮した綺麗な綺麗な配列になっている。
		$requestArray=array();
		$requestLevel=$this->searchLevel;
		$requestAssumptionFilter=function ($array1) use($requestLevel){
			if($array1->getLevel()==$requestLevel){
				if($array1->getName()=='fw'){
					return true;
				}
			}
			return false;
		};

		while($this->searchLevel<4){
			$requestLevel=$this->searchLevel;
			$requestArray=array_filter($this->assumptionArray, $requestAssumptionFilter);

			foreach ($requestArray as $value) {
				$this->apiConnecter->addRequestUrl($this->judgeParam($value),$value->value);
			}

			if(($this->apiConnecter->countHit()<10) && ($this->apiConnecter->countHit()!=0)){

				$this->searchLevel=4;

			}elseif($this->apiConnecter->countHit()==0){

				if($this->apiConnecter->searchLevel!=1){

					$this->apiConnecter->searchLevel-=1;
					$this->apiConnecter->resetRequest();
					foreach ($requestArray as $value) {
						$apiConnecter->addRequestUrl(judgeParam($value),$value->value);
					}
					$this->apiConnecter->searchLevel=4;
				}else{
					//レベル１の検索でも結果が0件だった時の処理
				}
			}else{
				$this->searchLevel+=1;
			}
		}

		if($this->apiConnecter->countHit()==1){
			$pageNum=1;
			$storeNum=1;
		}else{
			//日付によって乱数を発生させたい。中
			if($this->apiConnecter->countHit() <= 10){
				$pageNum=1;
				$storeNum=mt_rand(0,$this->apiConnecter->countHit() - 1);
			}else{
				$pageNum=mt_rand(0, $this->apiConnecter->countPage() - 1);
				$storeNum=mt_rand(0,10);
			}
		}

		$this->setStore($pageNum,$storeNum);
		return $this->storeInfo;

	}

	//お店情報をインプットする。
	private function setStore($pageNum, $storeNum){

		$storeXml=$this->apiConnecter->returnXml(1,$pageNum);
		$this->storeInfo->setId($storeXml->rest[$storeNum]->id);
		$this->storeInfo->setName($storeXml->rest[$storeNum]->name);
		$this->storeInfo->setLatitude($storeXml->rest[$storeNum]->latitude);
		$this->storeInfo->setLongitude($storeXml->rest[$storeNum]->longitude);
		$this->storeInfo->setFwCategory($storeXml->rest[$storeNum]->fwCategory);
		$this->storeInfo->setUrlPc($storeXml->rest[$storeNum]->url_pc);
		$this->storeInfo->setUrlMobile($storeXml->rest[$storeNum]->url_mobile);
		$this->storeInfo->setImage1($storeXml->rest[$storeNum]->image_url->shop_image1);
		$this->storeInfo->setImage2($storeXml->rest[$storeNum]->image_url->shop_image2);
		$this->storeInfo->setQrCode($storeXml->rest[$storeNum]->qrcode);
		$this->storeInfo->setAdress($storeXml->rest[$storeNum]->adress);
		$this->storeInfo->setTel($storeXml->rest[$storeNum]->tel);
		$this->storeInfo->setFax($storeXml->rest[$storeNum]->fax);
		$this->storeInfo->setOpenTime($storeXml->rest[$storeNum]->opentime);
		$this->storeInfo->setHoliday($storeXml->rest[$storeNum]->holiday);
		$this->storeInfo->setStation($storeXml->rest[$storeNum]->access->station);
		$this->storeInfo->setPrL($storeXml->rest[$storeNum]->pr->pr_l);
		$this->storeInfo->setPrS($storeXml->rest[$storeNum]->pr->pr_s);
		$this->storeInfo->setArea($storeXml->rest[$storeNum]->code->areaname);
		$this->storeInfo->setPrefecture($storeXml->rest[$storeNum]->code->prefname);
		$this->storeInfo->setCategory($storeXml->rest[$storeNum]->category_name_l);
		$this->storeInfo->setBudget1($storeXml->rest[$storeNum]->budget);
		$this->storeInfo->setBudget2($storeXml->rest[$storeNum]->budget);
		$this->storeInfo->setEquipment($storeXml->rest[$storeNum]->equipment);

		return 0;
	}

	private function judgeParam($value){
		if($value->name==$this::FreeWord){
			return $this::FREE_WORD;
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