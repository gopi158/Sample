<div style="float:left; width:390px;">
<p>Fields with * are required </p>
<input type="hidden" value="123" name="encrypted" id="encrypted" />
            <div class="element-input" ><label class="title">Email<span class="required">*</span></label><input id="ValidEmail"  onchange="return valid_email();" class="was email" type="text" name="input1" /><span style="color:#FF0000; display:none" id="ValidEmailerr">Enter Valid Email Id</span></div>

            <div class="element-input" ><label  class="title">Name<span class="required">*</span></label><input id="ValidName" class="was name" type="text" name="input" onchange="return strs()" /><span style="color:#FF0000; display:none" id="Validnamer">Enter Valid Name</span></div>

            <div class="element-input" ><label class="title">Phone</label><input onkeypress="return isNumberKey(event)" id="ValidPhone" type="text" name="input2"  class="phone" /></div>

            <div class="element-input" ><label class="title">Event Name<span class="required">*</span></label><input id="ValidEvent" class="was event" type="text" onchange="return valid_evntname();" name="input3" /><span style="color:#FF0000; display:none" id="ValidEventnamer">Enter Valid EventName</span></div>

            <div class="element-input" ><label class="title">Date Of Event<span class="required">*</span></label><input type="text" name="input4" class="was Date" id="Date" onmouseover="tot();" readonly="readonly" onchange="return valid_date();" onclick=""/><span style="color:#FF0000; display:none" id="ValidDate">Enter Valid Date</span></div>

            <div class="element-submit" style="padding-top:20px;"><input type="button" onclick="return book_validate();" value="Submit"/></div>

            </div>

            <div style="float:right;  width:390px;">

            <div class="element-input" ><label class="title">Location</label><input id="ValidLocation" type="text" name="input5" class="location" /></div>

            <div class="element-input" ><label class="title">School/College/University<span class="required">*</span></label><input onchange="return valid_school();" id="ValidSchool" type="text" name="input6" class="was school"/><span style="color:#FF0000; display:none" id="ValidSchooler">Enter Valid School</span></div>

            <div class="element-input" ><label class="title">Estimated Attendance</label><input type="text" id="ValidNumber" name="input7" class="attendance" onkeypress="return isNumberKey(event)" /></div>

            <div class="element-input" ><label class="title">Additional Notes<span class="required"></span></label><textarea  name="input8" cols="30" rows="5" class="additional" /></textarea></div>

            </div>