<?php      
    //print_r($public_tiles_view);exit;                           
    include("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php");
?>
<div class="container white-background">
    <div class="content-wrapper">
        <? include_once ("public_profile_details.php");?>
        <div class="row" style=" margin-left: -80px; margin-top:15px;!important">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <? include_once ("public_left_menu.php"); ?>                 
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
            <?
                if(is_array($public_tiles_view))
                {
                    foreach ($public_tiles_view as $public_tile)
                    {
                        if ($public_tile->type == 1)
                        {
                            ?> 
                                <div class="col-lg-4 col-md-5 col-sm-7">
                                    <ul class="nav  navbar-left img-responsive-tiles">
                                        <li id="fat-menu" class="dropdown">
                                            <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown" onclick="show_finao_msg_public(<? echo $public_tile->tile_id; ?>,<? echo $public_profile_details->userid; ?>); return false;">
                                                <div class="view view-sixth" >
                                                    <?
                                                        if(is_array($public_tile->image_urls))
                                                        {
                                                            foreach ($public_tile->image_urls as $image_urls)
                                                            {
                                                                foreach ($image_urls as $image_url)
                                                                {
                                                                    if($image_url != "")
                                                                    {
                                                                        
                                                                        ?>
                                                                            <img alt="Tile Image" src="<? echo ($image_url); ?>"  class="img-responsive" style="height: 180px; width: 180px;"/>
                                                                        <?
                                                                    }
                                                                }                                                                
                                                            }
                                                        }
                                                    ?>                                                    
                                                    <div class="mask">
                                                        <p class="info_travel">
                                                            <? echo $public_tile->tile_name; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <ul class="dropdown-menu  col-lg-12 col-md-12 col-sm-12" role="menu" aria-labelledby="drop3">
                                                <div class="row list">                                            
                                                    <ul id="finao<? echo $public_tile->tile_id; ?>">
                                                    </ul>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            <?   
                        }
                    }
                }
            ?>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>
