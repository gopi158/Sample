<?
   include ("header.php"); 
   include ("configuration/configuration.php");
   include ("footer.php");
?>
<style>
.save 
{
    background: none repeat scroll 0% 0% #1286DB;
    padding: 3px 5px;
    font-family: 'oswaldbook';
    color: #FFF;
    font-size: 15px;
    width: 80px;
}
</style>
<script>
    function submit_reset_form()
    {
        if($("#password").val() != "")
        {
            if($("#password").val() != $("#reenter_password").val())
            {
                show_alert("Passwords are not same.");
                return false;
            }
        }
        $.get("index.php?r=site/updatepassword", $("#passwordreset").serialize(),function(data){
           if(data != "")
           {
                $("#passwordreset").html("");    
                $("#passwordreset").html("<div class='col-md-7 col-xs-8 content-wrapper-right'>" + data + "</div>");
           }
        });        
    }
</script> 
<div class="container white-background"><br />
    <div class="content-wrapper" style="margin-top:40px;">
        <div class="row" style="margin:0 auto; padding:0 auto;">
            <form id="passwordreset">    
                <div class="col-md-7 col-xs-8 content-wrapper-right" style="padding-left: 40px;">
                    <div class="row">
                        <div class="col-md-4">
                            <input class="placeholder" placeholder="Enter password" style="width:300px;" type="password" id="password" name="profile_info[password]"/>
                        </div>
                    </div>
                    <div class="space-setting"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="password" class="placeholder" style="width:300px;" placeholder="Re-enter password" id="reenter_password" name="profile_info[reenter_password]"/>
                            <input type="hidden"  name="profile_info[activkey]" value="<? echo @$_GET['activkey']?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8" style="margin-top:5px;">
                    <input type="button" value="SAVE" class="save" style="margin-left: 20px;" onclick="submit_reset_form();"/>
                </div> 
            </form>
        </div>
    </div><br /><br />
</div> 
<?
    include_once("alert_modal.php");
?>