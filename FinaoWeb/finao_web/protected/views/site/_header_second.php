<?
    $current_page = $_GET["r"];
    $current_active = "";
    if($current_page == "site/aboutus")
    {
        $current_active = "aboutus";
    }
    else if($current_page == "site/in_the_news")
    {
        $current_active = "in_the_news";
    }   
    else if($current_page == "site/press_release")
    {
        $current_active = "press_release";
    }
    else if($current_page == "site/media_library")
    {
        $current_active = "media_library";
    }
    else if($current_page == "site/press_enquiries")
    {
        $current_active = "press_enquiries";
    }
    else if($current_page == "site/company_facts")
    {
        $current_active = "company_facts";
    }
    else if($current_page == "site/contact")
    {
        $current_active = "contact";
    }
?>

 <div class="about-header-top navbar-fixed-top" role="navigation">
        <div class="container " style="box-shadow: none!important; border: 0;">
            <div class="row">
                <div class="col-md-5 col-sm-5"></div>
                <div class="col-md-3 col-sm-2 splash-logo">
                    <a href="#">
                        <img class="img-responsive" alt="Image" src="content/images/logo-new.jpg"></a>
                </div>
                <div class="col-md-4 col-sm-5 font-14px" style="padding: 15px 0 0 0; text-align: right;">
                </div>
            </div>
        </div>
		
<div class="container container-nemu-second">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-lg-3 col-md-2 col-sm-1"></div>
            <div class="col-lg-2  col-md-2 col-sm-2 about-lg-menu">
                <div class="menu-text-fade">
                    <a href="index.php?r=site/aboutus"
                        <? echo ($current_active == "aboutus" ? "class='current'" : ""); ?>>ABOUT US
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <div class="menu-text-fade">
                    <a href="#popupBottom-media" role="button" data-toggle="modal-popover" data-placement="bottom"
                        <?
                            $media_class = "";
                            if($current_active == "in_the_news" ||$current_active == "press_release" || $current_active == "media_library" || $current_active == "press_enquiries")
                            {
                                $media_class = "current";
                            }
                            echo ("class=".$media_class);
                        ?>
                    >MEDIA CENTER</a>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="menu-text-fade">
                    <a href="index.php?r=site/company_facts"
                        <? echo ($current_active == "company_facts" ? "class='current'" : ""); ?>>COMPANY FACTS
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <div class="menu-text-fade">
                    <a href="index.php?r=site/contact" 
                        <? echo ($current_active == "contact" ? "class='current'" : ""); ?>>CONTACT US
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--media-->
<div id="popupBottom-media" style="margin-top: 20px; margin-left: 5px;" position="absolute" class="popover bottom" aria-hidden="true">
    <div class="arrow"></div>
    <div class="popover-content media-list">
        <ul>
            <li>
                <a href="index.php?r=site/in_the_news"
                    <? echo ($current_active == "in_the_news" ? "class='current'" : ""); ?>>IN THE NEWS
                </a>
            </li>
            <li>
                <a href="index.php?r=site/press_release"
                    <? echo ($current_active == "press_release" ? "class='current'" : ""); ?>>PRESS RELEASE
                </a>
            </li>
            <li>
                <a href="index.php?r=site/media_library"
                    <? echo ($current_active == "media_library" ? "class='current'" : ""); ?>>MEDIA LIBRARY
                </a>
            </li>
            <li>
                <a href="index.php?r=site/press_enquiries"
                    <? echo ($current_active == "press_enquiries" ? "class='current'" : ""); ?>>PRESS INQUIRIES
                </a>
            </li>
        </ul>
    </div>
</div> 