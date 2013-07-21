<?php
	//店名、値段、ジャンルお店情報を文字として格納するためのクラス。中
	class Store{
		private $id=null;
		private $name=null;
		private $latitude=null;
		private $longitude=null;
		private $fwCategory=null;
		private $url_pc=null;
		private $url_mobile=null;
		private $image1=null;
		private $image2=null;
		private $qr_code=null;
		private $adress=null;
		private $tel=null;
		private $fax=null;
		private $opentime=null;
		private $holiday=null;
		private $station=null;
		private $pr_l=null;
		private $pr_s=null;
		private $area=null;
		private $prefecture=null;
		private $category=null;
		private $budget1=null;
		private $budget2=null;
		private $equipment=null;

		// 以下getter/setter。中
		public function getId(){
			return $this->id;
		}
		public function setId($id){
			$this->id=$id;
		}

		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name=$name;
		}

		public function getLatitude(){
			return $this->latitude;
		}
		public function setLatitude($latitude){
			$this->latitude=$latitude;
		}

		public function getLongitude(){
			return $this->longitude;
		}
		public function setLongitude($longitude){
			$this->longitude=$longitude;
		}

		public function getFwCategory(){
			return $this->fwCategory;
		}
		public function setFwCategory($fwCategory){
			$this->fwCategory=$fwCategory;
		}

		public function getUrlPc(){
			return $this->url_pc;
		}
		public function setUrlPc($url_pc){
			$this->url_pc=$url_pc;
		}

		public function getUrlMobile(){
			return $this->url_mobile;
		}
		public function setUrlMobile($url_mobile){
			$this->url_mobile=$url_mobile;
		}

		public function getImage1(){
			return $this->image1;
		}
		public function setImage1($image1){
			$this->image1=$image1;
		}

		public function getImage2(){
			return $this->image2;
		}
		public function setImage2($image2){
			$this->image2=$image2;
		}

		public function getQrCode(){
			return $this->qr_code;
		}
		public function setQrCode($qr_code){
			$this->qr_code=$qr_code;
		}

		public function getAdress(){
			return $this->adress;
		}
		public function setAdress($adress){
			$this->adress=$adress;
		}

		public function getTel(){
			return $this->tel;
		}
		public function setTel($tel){
			$this->tel=$tel;
		}

		public function getFax(){
			return $this->fax;
		}
		public function setFax($fax){
			$this->fax=$fax;
		}

		public function getOpenTime(){
			return $this->opentime;
		}
		public function setOpenTime($opentime){
			$this->opentime=$opentime;
		}

		public function getHoliday(){
			return $this->holiday;
		}
		public function setHoliday($holiday){
			$this->holiday=$holiday;
		}

		public function getStation(){
			return $this->station;
		}
		public function setStation($station){
			$this->station=$station;
		}

		public function getPrL(){
			return $this->pr_l;
		}
		public function setPrL($pr_l){
			$this->pr_l=$pr_l;
		}

		public function getPrS(){
			return $this->pr_s;
		}
		public function setPrS($pr_s){
			$this->pr_s=$pr_s;
		}

		public function getArea(){
			return $this->area;
		}
		public function setArea($area){
			$this->area=$area;
		}

		public function getPrefecture(){
			return $this->prefecture;
		}
		public function setPrefecture($prefecture){
			$this->prefecture=$prefecture;
		}
		public function getCategory(){
			return $this->category;
		}
		public function setCategory($category){
			$this->category=$category;
		}

		public function getBudget1(){
			return $this->budget1;
		}
		public function setBudget1($budget1){
			$this->budget1=$budget1;
		}

		public function getBudget2(){
			return $this->budget2;
		}
		public function setBudget2($budget2){
			$this->budget2=$budget2;
		}

		public function getEquipment(){
			return $this->equipment;
		}
		public function setEquipment($equipment){
			$this->equipment=$equipment;
		}
	}
?>