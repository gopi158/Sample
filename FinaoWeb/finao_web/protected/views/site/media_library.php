<?
    include_once("header.php");
    include_once("configuration/configuration.php");
    include_once("header_second.php");
?>
<div class="container white-background">
    <div class="content-wrapper text-align-center container-fixed-height" style="margin-top: 40px">
        <div class="row col-lg-12 col-md-12 col-sm-12">
            <div class="row about-title left">MEDIA LIBRARY</div>
        </div>
        <div class="row col-lg-12 col-md-12 col-sm-12">
            <p class="text-align-left font-23px media-library-text">	
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>                       
        </div>
      <div class="row col-lg-12 col-md-12 col-sm-12">
        <div class="row left font-25px"><p class="about-title-small">BRAND ASSETS [Please Follow our <u><a href="#" class="font-black">Brands Guidlines</a></u>]</p></div>
      </div>

      <div class="row col-lg-12 col-md-12 col-sm-12 brand-assets-row" >
       <div class="col-lg-4 col-md-4 col-sm-4 top-margin-brand-aasets">
         <img class="img-responsive" alt="main-without-tag" src="<? echo $icon_path."main-without-tag.png"; ?>" align="absmiddle">
		 <br><span class="download left"><a href="#">Download as PDF</a></span>
       </div>
        <div class="col-lg-4 col-md-4 col-sm-4 top-margin-brand-aasets">
         <img class="img-responsive" alt="Main-without-tag-bw" src="<? echo $icon_path."main-without-tag-bw.png"; ?>" align="absmiddle">
         <br><span class="download left"><a href="#">Download as PDF</a></span>
		</div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-sm-push-1" >
        <img class="img-responsive" alt="Stacked" src="<? echo $icon_path."stacked.png"; ?>">
         <br><span class="download left"><a href="#">Download as PDF</a></span>
		</div>
      </div>
      
      <div class="row col-lg-12 col-md-12 col-sm-12">
       <div class="col-lg-4 col-md-4 col-sm-4 top-margin-brand-aasets">
         <img class="img-responsive" alt="main-with-tag" src="<? echo $icon_path."main-with-tag.png"; ?>">
		 <br><span class="download left "><a href="#">Download as PDF</a></span>
       </div>
        <div class="col-lg-4 col-md-4 col-sm-4 left top-margin-brand-aasets">
         <img class="img-responsive" alt="Main-with-tag-bw" src="<? echo $icon_path."main-with-tag-bw.png"; ?>">
		 <br><span class="download left"><a href="#">Download as PDF</a></span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-sm-push-1">
        <img class="img-responsive" alt="Stacked-BW" src="<? echo $icon_path."stacked-bw.png"; ?>">
		<br><span class="download left"><a href="#">Download as PDF</a></span>
        </div>
      </div>
	   <div class="row col-lg-12 col-md-12 col-sm-12 ">
        <p class="about-title-small left">TESTEMONIALS AND BIOS [PDF]</p>
      </div>
      
	  <div class="row col-lg-12 col-md-12 col-sm-12">        
		 <div class="col-lg-3 col-md-3 col-sm-1"></div>      
			<div class="col-lg-2 col-md-2 col-sm-3">
			<a href="#"><img class="img-responsive" alt="Student" src="<? echo $icon_path."student-testemonials.png"; ?>"></a>
			</div>
			 <div class="col-lg-2 col-md-2 col-sm-3">
				<a href="#"><img class="img-responsive" alt="Administrator" src="<? echo $icon_path."administrator-testemonials.png"; ?>"></a>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-3">
			<a href="#"> <img class="img-responsive" alt="Executive" src="<? echo $icon_path."executive-bios.png"; ?>"> </a>       
			</div>
        </div>	
    </div>
</div> 
<?
    include_once("alert_modal.php");
?> 