<?php
    include ("header.php");
    include ("configuration/configuration.php");
?>
<div class="container white-background">
    <div class="content-wrapper " style="margin-top: 23px;">
        <div class="row">
            <div class="col-md-4 col-sm-4" >
                <div>
                    <div class="entered-finaos ">
                        <div class="entered-finaos">
                            <ul class="fade-text">
                                <li><a href="index.php?r=site/edit_profile">My Profile</a></li>
                                <li><a href="index.php?r=site/tagnotes" class="current">Tagnotes</a></li>
                                <li><a href="index.php?r=site/privacy">Privacy</a></li>
                                <li><a href="#">Notifications</a></li>
                                <li class="last"><a href="<? echo $global_shop_url; ?>">FINAO Shop</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 content-wrapper-right  default-height" style="border-left:1px solid #afafaf;">
                <?
                    if (is_array($tagnotes))
                    {?>
                        <form method="post" action="index.php?r=site/submit_tagnotes">
			   <?
                        foreach ($tagnotes as $tagnote)
                        {
                            ?>
                                <div class="row"><br/>
                                    <div class="col-md-3 col-sm-4 text-align-center" >
                                        <img alt="Tagnotes-image" src="<? echo $tagnote->product_image; ?>" style="width:150px;" />
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <p class="oswald-font font-20px"><? echo $tagnote->product_name; ?></p>
                                        <div class="color">
<input type="hidden" value="<? echo $tagnote->tagnote_id;?>" name="tagnote_id"/>
                                            <textarea class="form-control font-18px " name="message" rows="6" placeholder="Mitchell Weholt 425.239.8161 mitchell@finaonation.com"><? echo $tagnote->finao; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?   
                        }?>
                        <div class="row col-md-12 col-sm-12">
                            <input type="submit" class="button-save" value="SAVE"/> 
                        </div>
                        </form>
                     <?                        
                    }
                    else
                    {
                        ?>
                            <div class="row"><br/>
                                <div class="col-md-3 col-sm-4 text-align-center" >                                    
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <p class="oswald-font font-20px"><? echo $tagnotes; ?></p>                                    
                                </div>
                            </div>
                        <?                        
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>
