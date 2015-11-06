<?php 

class NetworkSearch extends CWidget

{

	public $IsSuperAdmin;

	public $homepage;

	public function run()

	{

		$searchpeople = new SearchForm;

		if(isset($this->homepage))

		{

			$page = "homepage";

		}

		else

		{

			$page = "";

		}

		// Ended here

		$this->render('_searchNetwork',array('searchpeople'=>$searchpeople,'page'=>$page));

	}

}

?>

