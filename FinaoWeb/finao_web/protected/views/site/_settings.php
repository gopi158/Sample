<?
    include ("footer.php");
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container" style="box-shadow: none!important; border: 0;">
        <div class="row">
            <div class="col-md-5 col-xs-4" style="padding-left: 0;">
                <div class="header-left">
                    <a href="#" class="home-header">HOME</a>
                    <a href="#" class="profile-header">PROFILE</a>
                </div>
            </div>
            <div class="col-md-2 col-xs-2 splash-logo">
                <a href="#">
                    <img class="img-responsive" alt="Logo" src="<? echo $icon_path."logo-new.jpg";?>">
                </a>
            </div>
            <div class="col-md-5 col-xs-6" style="padding-right: 0;">
                <div class="header-right">
                    <div class="dropdown">
                        <a href="#">
                            <img src="<? echo $icon_path."icon-post-finao.png"; ?>" alt="Icon-post"/>
                        </a>
                        <a href="#">
                            <img src="<? echo $icon_path."icon-notifications.png"; ?>" alt="Icon-notification">
                        </a>
                        <input type="search" class="search-box" placeholder="Search">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                                <img alt="Icon-settings" src="<? echo $icon_path."icon-settings.png"; ?>">
                        </a>
                        <ul class="dropdown-menu pull-right" style="margin-top: 20px" aria-labelledby="drop1">
                            <li>
                                <div align="left">
                                    <img src="<? echo $icon_path."icon-profile.png"; ?>" alt="Icon-profile" style="padding-left: 10px">
                                    <span style="padding-left: 10px;">Edit My Profile</span>
                                </div>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <div align="left">
                                    <img src="content/images/icons/icon-post-finao.png" style="padding-left: 10px"/>
                                    <span style="padding-left: 10px">Tagnotes</span>
                                </div>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <div align="left">
                                    <img alt="Video Icon" src="content/images/icons/icon-video.png" style="padding-left: 10px">
                                    <span style="padding-left: 10px">Privacy</span>
                                </div>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <div align="left">
                                    <img alt="Notifications Icon" src="content/images/icons/icon-notifications.png" style="padding-left: 10px"/>
                                    <span style="padding-left: 10px">Notifications</span>
                                </div>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <div align="left">
                                    <span style="padding-left: 10px">Log out</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>