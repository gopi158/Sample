<?php
     include ("configuration/configuration.php");
?>
<div class="modal fade bs-modal-sm3"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm1">
        <div class="modal-content">
            <div align="right" style="margin:-15px;">
                <button type="button" class="close close-opacity" data-dismiss="modal" aria-hidden="true">
                    <img src="<? echo $icon_path."icon-close.png"; ?>" class="img-responsive">
                </button>
            </div>
            <div class="modal-header">
                <div id="carousel-example-generic" class="carousel slide row finao-margin" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img alt="Post-image" src="content/images/cat_big.jpg">
                            <div class="carousel-caption">
                            </div>
                        </div>
                        <div class="item">
                            <img alt="" src="content/images/cat_big.jpg">
                            <div class="carousel-caption">
                            </div>
                        </div>
                        <div class="item">
                            <img alt="" src="content/images/cat_big.jpg">
                            <div class="carousel-caption">
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
                <div class="row">
                    <div class="finao-text col-md-8 col-xs-8">
                        <img alt="Icon-finao" src="<? echo $icon_path. "/icon-finao.png";?>"/>
                        I will become a cat photograper.
                    </div>
                    <div class="col-md-3 col-xs-3 text-fade finao-top-padding">
                        five minutes ago
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <p class="finao-title-text">Probably my new favorite picture. I love the snow!</p>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-4 finao-top-padding">
                        <a href="#" class="following-button status-button-ontrack">ON TRACK</a>
                    </div>
                    <div class="col-md-8 col-xs-8 text-right finao-top-padding">
                        <span class="finao-share-options"> 
                            <img alt="Icon-share" src="<? echo $icon_path. "/icon-share-options.png";?>"></span><span class="inspiring">Inspiring
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container" style="box-shadow: none!important; border: 0;">
        <div class="row">
            <div class="row">
                <div class="col-md-5 col-xs-4" style="padding-left: 0;">
                    <div class="header-left">
                        <a href="#" class="home-header">HOME</a>
                        <a href="#" class="profile-header">PROFILE</a>
                    </div>
                    <a href="#" data-toggle="modal" data-target=".bs-modal-sm3" style="color: #FFF;">
                        Profile photos
                    </a>
                </div>
                <div class="col-md-2 col-xs-2 splash-logo">
                    <a href="#">                        
                        <img alt="Logo" class="img-responsive" src="<? echo $icon_path."/logo-new.jpg"; ?>">
                    </a>
                </div>
                <div class="col-md-5 col-xs-6" style="padding-right: 0;">
                    <div class="header-right">
                        <a href="#">
                            <img alt="Icon-post" src="<? echo $icon_path."icon-post-finao.png"; ?>">
                        </a>
                        <a href="#">
                            <img alt="Icon-notofication" src="<? echo $icon_path."icon-notifications.png"; ?>">
                        </a>
                        <input class="imagesearch" type="image" src="content/images/icons/search.png">
                        <input type="search" class="search-box no-border" placeholder="Search">
                        <a href="#">
                            <img src="<? echo $icon_path."icon-settings.png"; ?>" alt="Icon-settings">
                        </a>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
