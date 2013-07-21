<?php
//検索条件自体の情報を保持するためのクラス。中
	class Assumption{
		//検索条件。ここでどのように検索するのか判断する。中
		private $name=null;
		//レベルと優先度。中
		private $level=null;
		private $priority=null;
		//他の条件と競合するか。中
		private $conflict=false;

		//リクエストとリータンどちらから検索するか。
		//検索の仕方がわかっていればいらないかも。中
		//private $requestCode=null;
		//private $returnCode=null;

		//検索パラメーター。中
		private $value=null;
		//何かで使うかも。中
		private $optionCode=null;

		function __construct($name,$level,$priority,$conflict,$value,$optionCode){
			$this->name=$name;
			$this->level=$level;
			$this->priority=$priority;
			$this->conflict=$conflict;
			//$this->requestCode=$requestCode;
			//$this->returnCode=$returnCode;
			$this->value=$value;
			$this->optionCode=$optionCode;
		}

		function getName(){
			return $this->name;
		}

		function getLevel(){
			return $this->level;
		}

		function getPriority(){
			return $this->priority;
		}
	}
?>