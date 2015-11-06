<script>
    function show_alert(message)
    {   
        $("#alert").html(message);
        $('#alert_modal').modal('show');
    }

    function closealertbox()
    {
        $("#alert").html("");
        $('#alert_modal').modal('hide');
    }
</script>
<div class="modal fade" id="alert_modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="margin-top:50%;">
            <div align="right" style="margin: -15px;">
                <button type="button" class="close close-opacity no-border" onclick="closealertbox()" data-dismiss="modal" aria-hidden="true">
                    <img src="<? echo $icon_path."icon-close.png"; ?>" class="img-responsive"/>
                </button>
            </div>               
            <div class="modal-body">
                <p class="p-title font-23px font-black margin-top-20px text-align-center">
                    <span id="alert">
                    </span>                    
                </p>               
            </div>
        </div>
    </div>
</div>