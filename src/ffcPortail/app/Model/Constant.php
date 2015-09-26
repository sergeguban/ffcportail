<?php
class Constant extends AppModel {



	public function getNewFfcId(){

		$result =$this->findByName('ffc_id');
		$ffcId = $result['Constant']['value'];
		$newFfcId = $ffcId +1;

		$sql = "update  `constants` set value = $newFfcId WHERE `name` = 'ffc_id'";
		$this->query($sql);
		return $ffcId;

	}
	
	
	public function getNewYearlyNumber(){

		$result =$this->findByName('yearly_number');
		$yearlyNumber = $result['Constant']['value'];
		$yearlyNumber = $yearlyNumber +1;

		$sql = "update  `constants` set value = $yearlyNumber WHERE `name` = 'yearly_number'";
		$this->query($sql);
		return $yearlyNumber;

	}

}
?>