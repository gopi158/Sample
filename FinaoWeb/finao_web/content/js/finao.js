function mark_inappropriate_post(userpostid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/mark_inappropriate_post&userpostid="+ userpostid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {   
                show_alert("Post is inappropriated.");
                $("#row"+ userpostid).remove();
            }
            else
            {
                show_alert(data);
            }
        });
    }
    
    function sharepost(userpostid,finaoid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/sharepost&userpostid="+ userpostid + "&finaoid="+ finaoid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                show_alert("Post is shared successfully.")
            }
            else
            {
                show_alert(data);   
            }
        });
    }
    
    function follow_travel_tile(followeduserid, tileid)
    {                                         
        $("#ajax_loader").show(); 
        $.get("index.php?r=site/followuser&followeduserid="+ followeduserid +"&tileid="+ tileid,function(data){
            $("#ajax_loader").hide();
            var result = $.parseJSON(data);
            if(result["return"] = "success")
            {
                show_alert("You are now following this tile.")
            }
            else
            {
                show_alert(result["return"]);   
            }            
        });
    }
    
    function loadPosts()
    {
    	$.ajax({
    		url: "index.php?r=site/homepostsmarkup",
    		}).done(function(data){
    			document.getElementById('postscontainer').innerHTML = data;
    		});
    }
    
    function getinspired_by_post(userpostid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/get_inspired_by_post&userpostid="+ userpostid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                show_alert("You are now inspired by this post.")
            }
            else if (data = "You are already inspired by this post!")
            {
                show_alert(data);
            }
        });
    }
    
    
    $(function(){
        $(".mycorousel").each(function(){
           $(this).find("div.item").last().addClass("active");  
        });
    });