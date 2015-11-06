<?php
/**
 CategoryList is a widget used to display a list of Categories
 */

class Interest extends CWidget
{
	public $interest;
	public function init()
 	{
   
   		$this->interest = Lookups::model()->findAllByAttributes(array('lookup_parentid'=>0,'lookup_type'=>'interests'));

 	}
	public function run()
	{
		$this->getSubInterets();
	}
	public function getSubInterests($lookup_parentid="")
	{
		
		echo '  <div class="act-pref-right">
                	<div class="blue-sub-headline">My Child'.'s Interests</div>
                    <div class="run-text">(We'.'ll send you updates when activities in your community that match your preferences enter our database)</div>
                    <div class="orange-sub-headline">Check to Choose Your Child Interests</div>';
					
				foreach($this->interest as $intrst)
				{					
					echo '<div id="content">
			<form autocomplete="off">
				<ul class="first acfb-holder" id="x">
					
					<input type="text" class="city acfb-input" />
				</ul>
				<br/>
				
			</form>
		</div>';
				}
		echo	'</div>';
	}
		
		
	
	
	

}
?>