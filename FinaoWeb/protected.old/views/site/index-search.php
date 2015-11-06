<div class="search-area">
                	<div class="search-schools-headline">Search Schools</div>
                    <!--<div class="search-box-padding"><input type="text" class="textbox" value="School or City and State" onclick="value=''" onblur="if (!value)value='School or Activity Name or City and State'" /></div>-->
					 <div class="invisible-box">
					 
					 <div style="position:relative;">
					 	<!--<input type="text" id="txtsearchstate" class="inv-state-box" value="State" onclick="value=''" onblur="if (!value)value='State'" onkeyup="lookup(this.value,'suggestions-state','autoSuggestionsList-state','state');" />-->
						
						<?php echo $form->textField($modelsearch,'state',array('id'=>'txtsearchstate', 'onblur'=>"if (!value)value='State'", 'class'=>'inv-state-box', 'onkeyup'=>'lookup(this.value,\'suggestions-state\',\'autoSuggestionsList-state\',\'state\');','value'=>"State", 'onclick'=>"if ((value == 'State')) value=''"  )); ?>	
						
						<div class="suggestionsBox" id="suggestions-state" style="display: none; width:80px;">
							<div class="suggestionList" id="autoSuggestionsList-state">
								&nbsp;
							</div>
						</div>
					 </div>
					 
					 <div>
					 	<!--<input type="text" id="txtsearchcity" class="inv-text-box" value="City" onclick="value=''" onblur="if (!value)value='City'" onkeyup="lookup(this.value,'suggestions-city','autoSuggestionsList-city','city');" />-->
	 
	              <?php echo $form->textField($modelsearch,'city',array('id'=>'txtsearchcity', 'onblur'=>"if (!value)value='City'", 'class'=>'inv-text-box', 'onkeyup'=>"lookup(this.value,'suggestions-city','autoSuggestionsList-city','city');",'value'=>"City", 'onclick'=>"if ((value == 'City')) value=''"  )); ?>
						
						<div class="suggestionsBox" id="suggestions-city" style="display: none; width:130px; position:absolute; left:85px;">
							<div class="suggestionList" id="autoSuggestionsList-city">
								&nbsp;
							</div>
						</div>
					 </div>
                        
                    <div>	
                        <!--<input type="text" id="txtsearchschool" class="inv-text-box1" value="School" onclick="value=''" onblur="if (!value)value='School'" onkeyup="lookup(this.value,'suggestions-school','autoSuggestionsList-school','school');" />-->
						
						<?php echo $form->textField($modelsearch,'schoolname',array('id'=>'txtsearchschool', 'onblur'=>"if (!value)value='School'", 'class'=>'inv-text-box1', 'onkeyup'=>"lookup(this.value,'suggestions-school','autoSuggestionsList-school','school');",'value'=>"School", 'onclick'=>"if ((value == 'School')) value=''"  )); ?>
						
						<div class="suggestionsBox" id="suggestions-school" style="display: none; position:absolute; left:180px; width:250px;">
							<div class="suggestionList" id="autoSuggestionsList-school">
								&nbsp;
							</div>
						</div>					
						
					</div>	
                    </div>
					
					
					
                    <div class="search-fields">
                    	<div class="search-fields-left" style="position:relative;">
                        	<!--<input type="text" class="textbox-med" value="ZIP Code" onclick="value=''" onblur="if (!value)value='ZIP Code'" />-->
							<?php echo $form->textField($modelsearch,'zipcode',array('id'=>'txtsearchzipcode', 'onblur'=>"if (!value)value='ZIP Code'", 'class'=>'textbox-med', 'onkeyup'=>"lookup(this.value,'suggestions-zipcode','autoSuggestionsList-zipcode','zipcode');",'value'=>"ZIP Code", 'onclick'=>"if ((value == 'ZIP Code')) value=''" ,"style"=>"float:none!important; position:relative;" )); ?>
							<div class="suggestionsBox" id="suggestions-zipcode" style="display: none; position:absolute; left:0px; top:30px; width:162px;">
							<div class="suggestionList" id="autoSuggestionsList-zipcode">
								&nbsp;
							</div>
						</div>	
                        </div>
                        <div class="search-fields-right">
							<div id="firstBox">
                               <!--<select name="country_id" id="country_id2" tabindex="1">
                                    <option>Grade Level</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                    <option>USA</option>
                                </select>-->
								<?php echo $form->dropDownList($modelsearch,'schoolgrade',CHtml::listData($modelSchoolGrade, 
                'school_grade', 'school_grade_name'), array('empty'=>'Grade Level','id'=>'country_id2')); ?>
                             </div>
                             
                         </div>
                    </div> 
                    <div class="search-fields">
                    	<div class="search-fields-left">
                        	<div id="firstBox">
                                <!-- <select name="country_id" id="country_id1" tabindex="1">
                                    <option>School Type</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                    <option>USA</option>
                                </select> -->
							<?php echo $form->dropDownList($modelsearch,'schooltype',CHtml::listData($modelSchoolType, 
                'school_type', 'school_type_name'), array('empty'=>'School Type','id'=>'country_id1')); ?>
								
                            </div>
                        </div>
                        <div class="search-fields-right">
                        	 <div id="firstBox" style="display:none;">
                                <select name="country_id" id="country_id0" tabindex="1">
                                    <option>Distance From</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                    <option>USA</option>
                                    <option>Canada</option>
                                </select>
                             </div>
                        </div>
                    </div>
                    <div class="search-button"><input type="submit" id="search-submit" class="orange-button" value="SEARCH"  onclick=" if(checkValidate('search') == 'false') return false; " disabled="disabled" /></div><!-- (checkValidate() == 'false') ? return false : return true ; -->
                    <div class="group-img"><img src="<?php echo Yii::app()->baseUrl ;?>/images/group-img.png" width="368" height="53" /></div>
                </div>