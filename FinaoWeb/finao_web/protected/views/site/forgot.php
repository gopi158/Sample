<style>
    body
    {
        background-image: url('content/images/blur-background.jpg');
    }
</style>
<script>
    //j = jQuery.noConflict();
//    function forgot_password()
//    {
//       ajaxCall = function(a){
//            j.ajax({
                // The url must be appropriate for your configuration;
                // this works with the default config of 1.1.11
//                url: 'index.php?r=site/forgot_password',
//                type: "POST",
//                data: {ajaxData: a},  
//                error: function(xhr,tStatus,e){
//                    if(!xhr){
//                        alert(" We have an error ");
//                        alert(tStatus+"   "+e.message);
//                    }else{
//                        alert("else: "+e.message); // the great unknown
//                    }
//                    },
//                success: function(resp){
//                    nextThingToDo(resp);  // deal with data returned
//                    }
//                });
//        };
        //j.post("index.php?r=site/forgot_password&email="+ j("#email").val(),function(data){
//            alert (data);
//        });    
    }
</script>
<? 
    include ("footer.php");
?>        
<div class="col-md-4"></div>
<div class="col-md-4 splash-logo" id="block" style="background-color: rgb(255, 255, 255); height: auto; margin-top: 50px; display: block;">
    <div align="right" style="margin-right: -15px; margin-top: -15px">
        <a href="#">
            <img alt="Icon-close" src="<? echo $icon_path."/icon-close.png"?>" class="img-responsive">            
        </a>
    </div>
    <div class="font-18px" align="left" style="margin-top: -15px;">
        <a href="#" style="color: #e56424;">FORGOT YOUR PASSWORD?</a>
    </div>
    <br />
    <div class="row font-14px" style="text-aline: center; padding-left: 80px; padding-right: 80px;">
        <span>Enter your email and you'll receive an email to reset your password.</span>
    </div>
    <form method="post" action="index.php?r=site/forgot_password">
    <div class="row" style="padding-top: 20px; margin-bottom: 10px">
        <div class="col-md-2"></div>
        <div style="padding-left: 20px; padding-right: 30px;">
            <input class="txtbox txtbox-error col-md-9" placeholder="email" id="email" name="email" style="text-align: center" type="text" />
        </div>
    </div>
    <input type="submit" value="Submit" class=>
    </form>
</div>
<?
    include_once("alert_modal.php");
?>