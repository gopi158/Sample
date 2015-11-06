<?
    //print_r (($user_notifications));
//    exit;
    include ("header.php");
    include ("footer.php");
    include ("configuration/configuration.php");
?>
 <div class="container">
    <div class="content-wrapper" style="margin-top: 23px;">
        <div class="content-wrapper">
            <div class="row"></div>
            <? echo $result; ?>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>