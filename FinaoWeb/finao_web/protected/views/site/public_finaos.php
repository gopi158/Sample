<?php
    //print_r($public_user_posts);exit; 
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php");
?>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("public_profile_details.php");?>
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="col-lg-3 col-md-4 col-sm-5 left-menu-width">
                <? include_once ("public_left_menu.php"); ?>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
                
                <div class="left-rounded-box white-background" style="padding: 5px 5px 8px 5px;">
                    <div class="entered-finaos">
                        <div class="color-fff" style="padding:10px;">
                            <ul>
                                <? 
                                    if(is_array($finao_list))
                                    {
                                        foreach($finao_list as $finao)
                                        {
                                            ?>
                                                <li id="finaostatus<? echo $finao->finao_id; ?>">  
                                                    <div style="width: 66%;" class="left">
                                                        <a href="index.php?r=site/public_user_finao_posts&finao_id=<? echo $finao->finao_id; ?>&uname=<? echo $public_profile_details->uname; ?>" class="finao_names" style="word-wrap: normal;">
                                                            <? 
                                                                echo $finao->finao_msg; 
                                                            ?>                                                     
                                                        </a>
                                                    </div>
                                                    <?
                                                        echo ($finao->finao_status == 38 ? '<a href="javascript:void(0);" id="link'. $finao->finao_id .'" class="dropdown-toggle button-track right">ON TRACK</a>' : ($finao->finao_status == 40 ? '<a href="javascript:void(0);" id="link'. $finao->finao_id .'" class="dropdown-toggle button-behind right">BEHIND</a>' : '<a href="javascript:void(0);" id="link'. $finao->finao_id .'" class="dropdown-toggle right button-ahead">AHEAD</a>'));                                                
                                                    ?>
                                                    
                                                    <div style="clear: both;"></div>
                                                </li>
                                            <?
                                        }
                                    }
                                    
                                    if(is_string($finao_list))
                                    {
                                        ?>
                                            <li><? echo $finao_list; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
                <div class="clear-50px"></div>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>
