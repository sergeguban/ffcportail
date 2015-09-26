<?php
class CategoryCalculatorComponent  extends Component{


	private $categories = array(10 => "pupil",
	12 => "minime",
	14 => "cadet",
	16 => "aspirant",
	18 => "junior",
	34 => "senior",
	44 => "vétéran 1",
	54 => "vétéran 2",
	110 => "vétéran 3"
	);


	/**
	 *
	 * Return the competition category (pupille, minime, etc ...) compute from a birthdate for a specific year.
	 *
	 * birthdate as yyyy-mm-dd
	 * year as yyyy
	 *
	 *
	 *
	 * Enter description here ...
	 * @param $birthdate
	 * @param $year
	 */

	public function getCategoryFromBirthDate ($birthdate, $year)
	{
		$birthYear = strtok($birthdate, '-');
		$age = $year - $birthYear;
		return $this->findCategory($age);
	}

	 
	private function findCategory($age){

		foreach ( $this->categories as $key => $value) {
			if($age <= $key ){
				return $value;
			}
		}

	}

}

?>