<script type="text/javascript">
$(document).ready(function(){
	$("#txtsearchzipcode").keydown(keydownfun);
	$("#txtsearchzipcode").attr('maxlength','5');
	$("#txtsearchstate").attr('maxlength','2');
	
});	
</script>

<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'search-form',
						'enableAjaxValidation'=>false,
				)); ?>
				
				<?php echo $form->hiddenField($modelsearch,'pagenumber',array('value'=>$modelsearch->pagenumber));
					  echo $form->hiddenField($modelsearch,'datadisplay',array('value'=>$modelsearch->datadisplay,'id'=>'hdndatadisplay'));	 ?>
				<div class="refine-search">
          			
		            <div class="invisible-box" >
						<div style="float:left;">
		                <?php echo $form->textField($modelsearch,'state'
							,array('id'=>'txtsearchstate', 'onblur'=>"if (!value)value='State'"
									, 'class'=>'inv-state-box'
									, 'onkeyup'=>'lookup(this.value,\'suggestions-state\',\'autoSuggestionsList-state\',\'state\');'
									, 'value'=> ($modelsearch->state != "") ? $modelsearch->state : "State" 
									, 'onclick'=>"if ((value == 'State')) value=''"  
									)); ?>
						
						<div class="suggestionsBox" id="suggestions-state" style="display: none; width:80px;">
							<div class="suggestionList" id="autoSuggestionsList-state">
								&nbsp;
							</div>
						</div>
						</div>
						<div style="float:left;">
		                <?php echo $form->textField($modelsearch,'city',array('id'=>'txtsearchcity', 'onblur'=>"if (!value)value='City'", 'class'=>'inv-text-box', 'onkeyup'=>"lookup(this.value,'suggestions-city','autoSuggestionsList-city','city');",'value'=>($modelsearch->city != "") ? $modelsearch->city : "City" , 'onclick'=>"if ((value == 'City')) value=''"  )); ?>
						
						<div class="suggestionsBox" id="suggestions-city" style="display: none; width:130px; position:absolute; left:85px;">
							<div class="suggestionList" id="autoSuggestionsList-city">
								&nbsp;
							</div>
						</div>
						</div>
						<div style="float:left;">
		                <?php echo $form->textField($modelsearch,'schoolname',array('id'=>'txtsearchschool', 'onblur'=>"if (!value)value='School'", 'class'=>'inv-text-box1', 'onkeyup'=>"lookup(this.value,'suggestions-school','autoSuggestionsList-school','school');",'value'=>($modelsearch->schoolname != "") ? $modelsearch->schoolname : "School", 'onclick'=>"if ((value == 'School')) value=''"  )); ?>
						
						<div class="suggestionsBox" id="suggestions-school" style="display: none; position:absolute; left:180px; width:250px;">
							<div class="suggestionList" id="autoSuggestionsList-school">
								&nbsp;
							</div>
						</div>
						</div>
						
		            </div>
					<div style="float:left;">
		            <?php echo $form->textField($modelsearch,'zipcode',array('id'=>'txtsearchzipcode', 'onblur'=>"if (!value)value='ZIP Code'", 'class'=>'textbox-small', 'onkeyup'=>"lookup(this.value,'suggestions-zipcode','autoSuggestionsList-zipcode','zipcode');", 'onclick'=>"if ((value == 'ZIP Code')) value=''" , 'value'=>($modelsearch->zipcode != "") ? $modelsearch->zipcode : "ZIP Code" )); ?>
							<div class="suggestionsBox" id="suggestions-zipcode" style="display: none; position:absolute; left:180px; width:250px;">
							<div class="suggestionList" id="autoSuggestionsList-zipcode">
								&nbsp;
							</div>
						</div>
					</div>	
		            <!--<div id="sixthBox" style="float:left;display:none">
		               <select name="country_id" id="country_id1" tabindex="1">
		                    <option>Distance From</option>
		                </select>
		            </div>-->
		            <div id="sixthBox" style="float:left;">
					
		              <?php echo $form->dropDownList($modelsearch,'schooltype',CHtml::listData($modelSchoolType, 
                'school_type', 'school_type_name'), array('empty'=>'School Type','id'=>'dpschooltype','class'=>'dropdown-med')); ?>
		            
					</div>
		            <div id="sixthBox" style="float:left;">
					
		               <?php echo $form->dropDownList($modelsearch,'schoolgrade',CHtml::listData($modelSchoolGrade, 
                'pv_lookup_id', 'lookup_name'), array('empty'=>'Grade Level','id'=>'dpschoolgrade','class'=>'dropdown-med')); ?>
				
			
		            
		            </div>
					<input type="submit" id="search-submit" class="blue-button" value="SEARCH"  onclick=" if(checkValidate('search') == 'false') return false; " style="margin-top:3px;"/>
		          </div>
				
		<?php $this->endWidget(); ?>