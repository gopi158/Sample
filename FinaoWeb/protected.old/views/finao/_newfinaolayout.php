 
<div class="tiles-container<?php if(empty($groupid)):else:?>-group<?php endif; ?>">
                <div class="create-finao-wrapper">
                	
                  <?php if(empty($groupid)){?> 
                  
                    <div class="create-finao-wrapper-left">
                    	
                         <div align="left" class="vpb_main_wrapper">
                
                <div id="vasPhoto_uploads_Status" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:black; line-height:25px;"></div>
                <center>
                  
                <span class="uploadeFileWrapper">
				
				<div id="noimage">
					<img src="<?php echo $this->cdnurl;?>/images/no-imageforfinao.jpg" width="420" height="275"  />
					 </div>
					</span>
                    <br clear="all">
                    <div style="width:420px; float:left; margin-top:5px;">
                    	<div style="font-size: 12px;line-height: 25px;float: left; text-align: center;" id="vasPhoto_uploads_Status">
                            <span class="uploadeFileWrapper"><input class="txtbox left" type="text" name="caption" id="caption" value="" placeholder="Enter Caption" onblur="if(this.placeholder =='')this.placeholder ='Enter Caption';" onfocus="if(this.placeholder=='Enter Caption')this.placeholder ='';" style="width:277px;" maxlength="60"></span>
                        </div>
                        <div style="float:left;">
                            <form id="vasPLUS_Programming_Blog_Form" method="post" enctype="multipart/form-data" action="javascript:void(0);" autocomplete="off">
                                
                                
                                
                                
                               
                                <div style="float:left; font-size:12px; width:120px;" align="left">
                                    <div style=" background: url('<?php  echo Yii::app()->baseUrl; ?>/javascript/ajaximage/images/addfile.png') no-repeat scroll 0 -2px #F57B20;border: 1px solid #CCCCCC;cursor: pointer;float: left;height: 24px;padding: 3px 0 0 10px;width: 110px;"><input type="file" name="vasPhoto_uploads" id="vasPhoto_uploads" style="opacity:0;-moz-opacity:0;filter:alpha(opacity:0);z-index:9999;width:110px;padding:5px; cursor:pointer;" value="Upload Image" />                                    
                                </div>
                                
                                
                                
                                
                                
                                <br clear="all">
                            </form>
						</div>                        
                    </div>
                </center>
                <br clear="all" />
                </div>
                         
                    </div>
                    
                	<div class="create-finao-wrapper-right">
 
                    
        <?php if($userid== Yii::app()->session['login']['id'] && $share != "share"){?>
	        	
				<?php if(!empty($groupid)){ $isgroup = $groupid;}else{ $isgroup = '';} ?>
				<?php if(!empty($tiles) && $tiles != "") {?>				
				 <div class="create-finao-wrapper-right">
				<?php $this->widget('finao',array('type'=>'tilefinao'
				                          ,'isgroup'=>$groupid
										,'Isprofile'=>($share == "share") ? "1" : "0" )); ?>
		         </div>
				 <?php }else
				 { ?>
				 <div class="create-finao-wrapper-right">
				<?php $this->widget('finao',array('type'=>'tilefinao'
				                        ,'isgroup'=>$groupid
										,'Isprofile'=>($share == "share") ? "1" : "0" )); ?>
		         </div>
				 
				<?php } ?>

				<?php }?>
                </div>
                
				  
				  <?php  }else{?> 
				  
				    <form name="userfinaotile" action="<?php echo Yii::app()->createUrl('finao/newtile'); ?>" method="post" enctype="multipart/form-data" >
                     <input type="hidden" name="groupid" value="<?php echo $groupid;?>" /> 
					   
                        <div class="create-finao-wrapper-left">
                    	
                  
                         <div align="left" class="vpb_main_wrapper">
                
                <div id="vasPhoto_uploads_Status" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:black; line-height:25px;"></div>
                
                  
                <span class="uploadeFileWrapper">
				
				<div id="noimage">
					<img id="hideimage" src="<?php echo $this->cdnurl;?>/images/no-imageforfinao.jpg" width="420" height="275"  />
                    <img id="test" src="" width="420" height="275" style="display:none;"  />
					 </div>
					
                </span>
                    <br clear="all">
                    <div style="width:420px; float:left; margin-top:5px;">
                    	<div style="font-size: 12px;line-height: 25px;float: left; text-align: center;" id="vasPhoto_uploads_Status">
                            <span class="uploadeFileWrapper">
                            <input class="txtbox left" type="text" name="caption" id="caption" value="" placeholder="Enter Caption" onblur="if(this.placeholder =='')this.placeholder ='Enter Caption';" onfocus="if(this.placeholder=='Enter Caption')this.placeholder ='';" style="width:277px;" maxlength="60">
                            </span>
                        </div>
                        <div style="float:left;">
                            
                                
                                
                                
                                
                               
                                <div style="float:left; font-size:12px; width:120px;" align="left">
                                    <div style=" background: url('<?php  echo Yii::app()->baseUrl; ?>/javascript/ajaximage/images/addfile.png') no-repeat scroll 0 -2px #F57B20;border: 1px solid #CCCCCC;cursor: pointer;float: left;height: 24px;padding: 3px 0 0 10px;width: 110px;">
                                    <input onchange="readURL(this,this.value);" type="file" name="file" id="file" style="opacity:0;-moz-opacity:0;filter:alpha(opacity:0);z-index:9999;width:110px;padding:5px; cursor:pointer;" value="Upload Image" />                                    
                                </div>
                                
                                
                                
                                
                                
                                <br clear="all">
                          
						</div>                        
                    </div>
               
                <br clear="all" />
                </div>
                         
                    </div>
                    </div>
                    
                        <div class="create-finao-wrapper-right">
                        
                        <div class="padding-5pixels">
                        
                        <textarea name="finao_msg" onkeyup="change_va(event);" placeholder="My new FINAO: I will..." value="" style="width: 506px; resize: none; height: 60px;" id="finaomesg" maxlength="100" class="finaos-area"></textarea>
                        
                           
                        </div>
                        
                        <div class="padding-5pixels">
                        
                        <table width="313" height="88" border="0">
                        <tr>
                        <td><input type="radio" name="ispublic" value="1" id="ispublic_0" />
                        Make FINAO Public</td>
                        <td><input type="radio" checked="checked" name="ispublic" value="0" id="ispublic_1" />
                        Make FINAO Private</td>
                        </tr>
                        
                        </table>
                        <table width="180">
                        	<tr>
                        <td><label>
                        <input type="submit" name="Sumbit" id="Sumbit" class="orange-square" value="Submit" />
                        </label></td>
                        <td><label>
                        <input type="button" onclick="closefrommenu(0);" name="cancel" id="cancel" class="orange-square" value="Cancel" />
                        </label></td>
                        </tr>
                        </table>
                        </div>
                        
                        
                        </div>
                        
                        
                        
                          
                  </form>
				  
				  
				  <?php } ?>   
					
                
                
                </div>
</div>                
                           
				
					 
                    
                    
                    
                    
                    
                    
            
<script type="text/javascript">

$(document).ready(function(){
	$('#finaomesg').blur(function()
	{
		 
		var msg  = $(this).val()
		if(msg != "" && msg == "What's Your FINAO?"  )
		{
			
		}
	});
	
	});
</script>  

<script type="text/javascript">

$( document ).ready( function(){
	
	
	/**************************************************************
	* This script is brought to you by Vasplus Programming Blog
	* Website: www.vasplus.info
	* Email: info@vasplus.info
	****************************************************************/

	$('#vasPhoto_uploads').live('change', function() 
	{
	$('#noimage').hide();
	$("#vasPLUS_Programming_Blog_Form").vPB({
	url: '<?php echo Yii::app()->createUrl("/finao/finaopreupload"); ?>',
	beforeSubmit: function() 
	{
	 
	$("#vasPhoto_uploads_Status").show();
	$("#vasPhoto_uploads_Status").html('');
	$("#vasPhoto_uploads_Status").html('<div style="width:370px; height:135px; padding:120px 20px 10px 20px; text-align:center; border:5px solid #E2E2E2;  -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;"><img src="<?php  echo Yii::app()->baseUrl; ?>/images/bx_loader.gif" align="absmiddle" alt="Upload...." title="Upload...."/></div>');
	},
	success: function(response) 
	{
	 
	$("#vasPhoto_uploads_Status").hide().fadeIn('slow').html(response);
	}
	}).submit();
	});
	/**************************************************************
	* This script Ends
	****************************************************************/
	
	/*$(document).bind("contextmenu",function(e){
    return false;
	});*/
	fbfriednslist();
	<?php if(isset($getusertileid) && $getusertileid != ""){?>
	putseltile(<?php echo $getusertileid;?>);
	getdetailtile(<?php echo $userid;?>,<?php echo $tileid;?>)
	<?php }?>
	<?php if(isset($tileimageerror) && $tileimageerror =="Tileimageerror"){?>
		putseltile(<?php echo $getusertileid;?>);
	<?php if(!isset($newtile) && $newtile != "yes"){?>
	getdetailtile(<?php echo $userid;?>,<?php echo $tileid;?>)
	<?php }?>
	alert("Minimum of 440 x 320 pixels is a must!!");
	<?php }?>
});


  


 function gettileid(id,did)

{

 tileid = id;

 frndid = did;

 var url='<?php echo Yii::app()->createUrl("/tracking/saveTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , frndid : frndid},

   		function(data){

				$("#track").html(data);

		});

}
 

function submitfinao(userid,redirecttype,type)
{
	var finaomesg = document.getElementById('finaomesg').value;
	if(finaomesg == '')
	{
		$('#finaomesg').css({'border':'2px solid #F00'});
		$('#finaomesg').attr('placeholder','Enter your FINAO and select Tile to proceed') 
		return false;
	}
	var tileid = document.getElementById('tileid').value;
	var tilename = document.getElementById('tilename').value;
 
	var ispublic = document.getElementById("ispublic").checked;
	var filename =   $('#filename').attr('src');
	var caption  = document.getElementById('caption').value;
	var groupid =  document.getElementById('groupid').value;
	 
	if(tileid=='')
	{ 
		$('.finao-tile-container').css({'border':'2px solid #F00'});
		return false;
	}	

 
	if(tileid > 0 && tilename == "" )
		tileid = "";
	 
	if(finaomesg.length > 1 && tileid.length >= 1)
	{
		 
		var url='<?php echo Yii::app()->createUrl("/finao/addFinao"); ?>';
		$.post(url, { userid : userid , tileid : tileid , finaomesg : finaomesg , tilename : tilename , ispublic : ispublic,filename:filename,caption:caption,groupid:groupid},
	   		function(data){
				if(data)
				{   
				    //alert(data);
					refreshmenucount(userid);
					getfinaos(userid,data);
					//view_single_finao(userid,finaoid);
				}
	     });
	}
	else
	{
		//$("#mesg").html("Please enter mandatory fields");
		if(finaomesg.length < 1)
		{
			document.getElementById('finaomesg').className = "finaos-area-error";
		}
		if(tilename.length < 1)
		{
			document.getElementById('finaotiles').className = "tiles-div-error";
		}
	}
}



function cancelfinao(userid)
{
	getmessages();
}

 

         </script>




<script type="text/javascript">



function clickdiv(id,tilename)
{
	var checkboxid = id.split("-");
	if($("#tileid").length)
		$("#tileid").val(checkboxid[2]);
	if($("#tilename").length)
		$("#tilename").val(tilename);
		//$("#tilename").val(checkboxid[1]);
	//alert(id + tilename);
	 $(".holder-active").addClass("holder smooth").removeClass("holder-active");
	$("#"+id).addClass("holder-active");
	$('.finao-tile-container').css({'border':''});		
}
function removeclass()
{
	document.getElementById('finaomesg').className = "finaos-area";
}



$(document).ready(function(){ });

function showtileform(finaoid,userid,groupid,pagetype)
{
	//alert(pagetype);
	var finaomesg = document.getElementById('finaomesg').value;
	if(finaomesg == '')
	{
		$('#finaomesg').css({'border':'2px solid #F00'});
		$('#finaomesg').attr('value','Enter your FINAO to activate Tiles') 
		$("#addanotherfinao").show();
		return false;
	}
	
	$("#oldtiles").hide();
    var filename =   $('#filename').attr('src');
	 
	var url='<?php echo Yii::app()->createUrl("/finao/newTile"); ?>';
		$.post(url, { userid :  userid , finaoid : finaoid ,pagetype : pagetype ,filename:filename,groupid:groupid},
	   		function(data){
	   			//alert(data);
				if(data)
				{
					if(pagetype!="newtilepage")
					{
						$("#selecttile").hide();
						$("#newtile").show();
						$("#newtile").html(data);
					}
					else
					{
						//addnewtilefinao(userid);
						//submitfinao(userid,'addanotherfinao','tilefinao','newtilepage');
						$("#finaotiles").hide();
						$("#addanotherfinao").hide();
						$("#newusertile").show();
						$("#newusertile").html(data);

					}

					

				}

				

	     });

}

function cancelnewtile()
{
	$("#oldtiles").show();
	$("#newtile").hide();
	$("#newusertile").hide();
	$("#finaotiles").show();
	$("#selecttile").show();
	$("#createtile").show();
	$("#addanotherfinao").show();
}

function addnewtilefinao(userid,groupid)
{
	//alert('s');return false;
	var finaomesg = document.getElementById('finaomesg').value;
	var tileid = document.getElementById('tileid').value;
	if(finaomesg == '')
	{
		$('#finaomesg').css({'border':'2px solid #F00'});
		$('#finaomesg').attr('placeholder','Enter your FINAO and select Tile to proceed') 
		return false;
	}
	
	$('.grey-square').hide();
	$("#createtile").hide();
	showtileform(0,userid,groupid,'newtilepage');
	if($("#hdnfinaomessage").length)
		$("#hdnfinaomessage").val($("#finaomesg").val());
	 

}
function deletefj(type,userid,journalid,finaoid)
{
	if(type=="finao")
	{
		journalid = finaoid;
		msg = "Sure? All items linked to this FINAO (photos, videos, and journal entries) will be deleted."
	}
	else
	{
		msg = "Sure? All items linked to this Journal entry (photos and videos) will be deleted.";
	}	
	if(confirm(msg))
	{
		var url='<?php echo Yii::app()->createUrl("/finao/deletefj"); ?>';

			$.post(url, { userid :  userid , journalid : journalid ,type : type},

		   		function(data){

		   			//alert(data);

					if(data)

					{
						if(type=="journal")
						{
							getalljournals(finaoid,userid,0);
							//refreshwidget(userid);
						}
						if(type=="finao")
						{
							//alert(data);
							location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";
						}
					}

					

		     });
	}
}
function closeheroupdate()
{
	//alert('hi');
	hidealldivs();
	$("#allinfo").show();
	// window.scrollTo(0,document.body.scrollHeight);
	$('html, body').animate({scrollTop:$(document).height()}, 'slow');

}

function validatesubmit(fileid,errmsg,msg,ctlid,condition)
{
	if($("#"+fileid).val() == condition)
	{
		$("#"+errmsg).html(msg);
		if(ctlid != "")
		{	
			$("#"+ctlid).removeClass("txtbox-caption");
			$("#"+ctlid).addClass("txtbox-caption-error");
		}	
		return "1";
	}
	return "0";
}

function resetfile(errormsg,ctlid)
{
	$("#"+errormsg).html("");
	if(ctlid != "")
	{
		$("#"+ctlid).removeClass("txtbox-caption-error");
		$("#"+ctlid).addClass("txtbox-caption");
	}
}

function viewjournal(journalid,finaoid,userid,completed,pageid)
{
	var update = document.getElementById('isheroupdate');
	if(update != null && update.value != "")
		heroupdate = update.value;
	else
		heroupdate = "";
	var isshare = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/ViewJournal"); ?>';

 	$.post(url, { finaoid : finaoid, userid : userid, iscompleted : completed,isshare:isshare,pageid:pageid,heroupdate:heroupdate, journalid:journalid },
   		function(data){
			if(data)
			{
				if(iscompleted=="completed")
				{
					/*hidealldivs();
					$("#showcompletedfinaodiv-profile").show();
					$("#showcompletedfinaodiv-profile").html(data);
					$("#showcompletedfinaodiv-default").show();
					$("#showcompletedfinaodiv-default").html(data);
					$("#finaodiv").hide();
					$("#journaldiv").show();
					$("#journaldiv").hide();*/
				}
				else
				{
					hidealldivs();
					$("#finaodiv").hide();
					$("#journaldiv").show();
					$("#journaldiv").html(data);
				}
			}
    });	
}

function validateSubmitJournal(txtid)
{
	if($("#"+txtid).val() == "Enter your Journal")
	{
		$("#"+txtid).addClass("run-textarea-error").removeClass("run-textarea");
		//$("#"+txtid).addClass("left");
		return 'false';
	}
}

function hideshow(id,hideorshow)
	{
		if(hideorshow == 'hide')
			$("#"+id).hide();
		else
			$("#"+id).show();	
	}
function getalltiles(userid,share)
{
	/*var url='<?php echo Yii::app()->createUrl("/finao/getalltiles"); ?>';
	$.post(url, { userid : userid , share : share},

		function(data){

	  			//alert(data);

			if(data)

			{*/
				//hidealldivs();
				$("#menuhidediv").show();
				//$("#menuhidediv").html();

			/*}

		});*/

}
function putseltile(usertileid)
{
	//document.getElementById('usertileid').value = usertileid;
	if($("#usertileid").length)
		$("#usertileid").val(usertileid);
}

 
  
function getdetailtile(userid,tileid)
{
	//alert("hiii");
	var share = document.getElementById('isshare').value;
	//alert(share);
	var usertileid = document.getElementById('usertileid').value;
	var url='<?php echo Yii::app()->createUrl("/finao/getDetailTile"); ?>';
	$.post(url, { userid : userid , tileid : tileid, share : share, usertileid : usertileid},
	function(data){
	//alert(data);
	if(data)
	{
		$("#divdisplaydata").html("");
			$("#divdisplaydata").html(data);
			$("#divdisplaydata").show();
	}
	});
}
  
function closefrommenu(page)
{// alert(page);
	if(page=="main")
	{
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
	}
	else
	{
		$('#finaofeed').show();
		hidealldivs();
		clickvalue = $(".active-category").attr("rel");
		$("#allinfo").show();
		if(clickvalue == 'tiles')
		{
			selectetileid = $("#usertileid").val();
			if(selectetileid != "")
				getdetailtile(userid,selectetileid);
			else
				$(".active-category").trigger("click");	
		}
		else 
		{
			$(".active-category").trigger("click");
		}
	}
	 
}

 

function enablemenu(menuselected)
{
	$("#ultopmenu a").each(function(i){
		if($(this).attr('rel') == menuselected)
		{
			$(this).attr('class','active-category');
		}
	});	
}

$(".fixed-imagea-area").click(function () {
$('#vasPhoto_uploads').trigger('click');

});
</script>          
	                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                  
<script type="text/javascript">
function change_va(event)
{
	var url = '<?php echo Yii::app()->createUrl("finao/badWords"); ?>';
	if(event.keyCode == 32) 
	{
		var valu=$('#finaomesg').val();
		//alert(valu);
		var mySplitResult = valu.split(" ");
		//alert(mySplitResult[mySplitResult.length-1]); 
		var lastWord =  mySplitResult[mySplitResult.length-2];
//		alert(valu.length);
//		alert(valu.length-lastWord.length);
		
		$.post(url, { word : lastWord}, function (data){if(data=='yes'){
			if(valu.length-lastWord.length<=1){$('#finaomesg').val('');}
			else {// alert('f'); //var ss=valu.slice(0,lastword.length);
			$('#finaomesg').val($('#finaomesg').val().slice(0,valu.length-lastWord.length-2)); }
			$('#badword').html('Bad word');
		}});
		$('#badword').html('');	   
	}	
}

function readURL(input,value) 
{
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$('#hideimage').hide();


  
var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
if(!re.exec(value))
{
$('#test').hide();
$('#hideimage').show();	
alert("Invalid Extension");
}else
{
	

$('#test').show().attr('src', e.target.result);

}

}
reader.readAsDataURL(input.files[0]);
}
}                    
                    
         
</script> 