<?php
	//店名、値段、ジャンルなど主なお店情報を文字として格納するためのクラス。中
	class Store{
		// 変数名は食べログのリターンパラメーター名に準拠。中
		private $rcd=null;
		private $restaurantName=null;
		private $tabelogUrl=null;
		private $tabelogMobileUrl=null;
		private $totalScore=null;
		private $tasteScore=null;
		private $serviceScore=null;
		private $moodScore=null;
		private $situation=null;
		// 夜の上限価格。中
		private $dinnerPriceMax=null;
		// 夜の下限価格。中
		private $dinnerPriceMin=null;
		// 昼の上限価格。中
		private $lunchMax=null;
		// 昼の下限価格。中
		private $lunchPriceMin=null;
		private $category=null;
		private $station=null;
		private $address=null;
		private $tel=null;
		private $businessHours=null;
		private $holiday=null;
		private $latitude=null;
		private $longitude=null;

		// 以下getter/setter。中
		public function getRcd(){
			return $this->rcd;
		}
		public function setRcd($rcd){
			$this->rcd=$rcd;
		}

		public function getRestrauntName(){
			return $this->restaurantName;
		}
		public function setRestrauntName($restaurantName){
			$this->restaurantName=$restaurantName;
		}

		public function getTabelogUrl(){
			return $this->tabelogUrl;
		}
		public function setTabelogUrl($tabelogUrl){
			$this->tabelogUrl=$tabelogUrl;
		}

		public function getTabelogMobileUrl(){
			return $this->tabelogMobileUrl;
		}
		public function setTabelogMobileUrl($tabelogMobileUrl){
			$this->tabelogMobileUrl=$tabelogMobileUrl;
		}

		public function getTotalScore(){
			return $this->totalScore;
		}
		public function setTotalScore($totalScore){
			$this->totalScore=$totalScore;
		}

		public function getMoodScore(){
			return $this->moodScore;
		}
		public function setMoodScore($moodScore){
			$this->moodScore=$moodScore;
		}

		public function getTasteScore(){
			return $this->tasteScore;
		}
		public function setTasteScore($tasteScore){
			$this->tasteScore=$tasteScore;
		}

		public function getServiceScore(){
			return $this->serviceScore;
		}
		public function setServiceScore($serviceScore){
			$this->serviceScore=$serviceScore;
		}

		public function getDinnerPriceMax(){
			return $this->dinnerPriceMax;
		}
		public function setDinnerPriceMax($dinnerPriceMax){
			$this->dinnerPriceMax=$dinnerPriceMax;
		}

		public function getDinnerPriceMin(){
			return $this->dinnerPriceMin;
		}
		public function setDinnerPriceMin($dinnerPriceMin){
			$this->dinnerPriceMin=$dinnerPriceMin;
		}

		public function getLunchPriceMax(){
			return $this->lunchPriceMax;
		}
		public function setLunchPriceMax($lunchPriceMax){
			$this->lunchPriceMax=$lunchPriceMax;
		}

		public function getLunchPriceMin(){
			return $this->lunchPriceMin;
		}
		public function setLunchPriceMin($lunchPriceMin){
			$this->lunchPriceMin=$lunchPriceMin;
		}

		public function getCategory(){
			return $this->category;
		}
		public function setCategory($category){
			$this->category=$category;
		}

		public function getStation(){
			return $this->station;
		}
		public function setStation($station){
			$this->station=$station;
		}

		public function getAddress(){
			return $this->address;
		}
		public function setAddress($address){
			$this->adress=$adress;
		}

		public function getTel(){
			return $this->tel;
		}
		public function setTel($tel){
			$this->tel=$tel;
		}

		public function getBusinessHours(){
			return $this->businessHours;
		}
		public function setBusinessHours($businessHours){
			$this->businessHours=$businessHours;
		}

		public function getHoliday(){
			return $this->holiday;
		}
		public function setHoliday($holiday){
			$this->holiday=$holiday;
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
	}
?>