
<!-- Search in the ParentValet Starts here 29-01-2013--> 

		   		<?php $form=$this->beginWidget('CActiveForm', array(

					'id'=>'search-form',

						'enableAjaxValidation'=>false,

				)); 

				?>  

				<div class="invisible-box1">  

				<?php if(Yii::app()->user->hasFlash('NotFound')): ?>



					<div class="flash-success">

						<?php echo Yii::app()->user->getFlash('NotFound'); ?>

					</div>

				<?php endif; ?>    

					<div id="no-data" style="color:#FF0000"></div>

					<div style="position:relative;">

					<?php 

					if(isset($page) && $page != "")

					{

						echo $form->textField($searchpeople,'useremail',array('id'=>'searchemail', 'onblur'=>"if (!value)value='Search People'", 'class'=>'inv-state-box', 'autocomplete'=>'off', 'style'=>'float:left;margin-left:90px;', 'onkeyup'=>"lookupActivity(this.value,'suggestions-email','autoSuggestionsList-email','useremail',this.id);",'value'=>"Search People", 'onclick'=>"if ((value == 'Search People')) value=''"  ));

					}

					else

					{

						echo $form->textField($searchpeople,'useremail',array('id'=>'searchemail', 'onblur'=>"if (!value)value='Please enter name to search'", 'class'=>'textbox', 'autocomplete'=>'off', 'style'=>'width:40%; float:left', 'onkeyup'=>"lookupActivity(this.value,'suggestions-email','autoSuggestionsList-email','useremail',this.id);",'value'=>"Please enter name to search", 'onclick'=>"if ((value == 'Please enter name to search')) value=''"  ));

					}

					 ?>

					<input type="submit" id="search-submit" style="position: absolute; left: -9999px"   value="SEARCH"  onclick=" if(checkValidate('searchemail') == 'false') return false; " />

					 <div class="suggestionsBox" id="suggestions-email" style="display: none; position:absolute; top:25px; background:#f5f5f5; width:320px; border:solid 1px #d5d5d5; padding:10px;z-index:99; left:90px;">

						<div class="suggestionList" id="autoSuggestionsList-email" style="color:#343434;">&nbsp;</div>

					</div>

					</div>

					<div style="position:relative;">

					<?php 

					if(isset($page) && $page != "")

					{

						echo $form->textField($searchpeople,'usertile',array('id'=>'searchtile', 'onblur'=>"if (!value)value='Search Tile'", 'class'=>'inv-state-box', 'autocomplete'=>'off', 'style'=>'float:left;margin-left:90px;', 'onkeyup'=>"lookupActivity(this.value,'suggestions-tile','autoSuggestionsList-tile','usertile',this.id);",'value'=>"Search Tile", 'onclick'=>"if ((value == 'Search Tile')) value=''"  ));

					}

					?>

					<!--<input type="submit" id="search-submit" style="position: absolute; left: -9999px"   value="SEARCH"  onclick=" if(checkValidate('searchemail') == 'false') return false; " />-->

					 <div class="suggestionsBox" id="suggestions-tile" style="display: none; position:absolute; top:25px; background:#f5f5f5; width:320px; border:solid 1px #d5d5d5; padding:10px;z-index:99; left:90px;">

						<div class="suggestionList" id="autoSuggestionsList-tile" style="color:#343434;">&nbsp;</div>

					</div>

					</div>

					
					

				<div style="float:left; padding-top:3px;">

				<input type="hidden" id="logedemail" value="<?php echo Yii::app()->session['login']['email'];?>" />

				</div>

				</div>

			<!-- Search in the ParentValet Ends here-->



<!-- Added on 29-01-2013 for search functionality in entire parentvalet-->

<?php $this->endWidget(); ?>

