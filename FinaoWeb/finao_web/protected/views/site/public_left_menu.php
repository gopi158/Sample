<?
    $current_page = $_GET["r"];
    $current_id = "";
    if($current_page == "site/public_finaos")
    {
        $current_id = "finaos";
    }
    else if($current_page == "site/public_tiles")
    {
        $current_id = "tiles";
    }   
    else if($current_page == "site/public_finao_posts")
    {
        $current_id = "posts";
    }
    else if($current_page == "site/public_inspired")
    {
        $current_id = "inspired";
    }
    else if($current_page == "site/public_followings")
    {
        $current_id = "followings";
    }
    else if($current_page == "site/public_profile")
    {
        $current_id = "posts";	//changed this to posts from finao because Finaos now shows different content
    }
    else if($current_page == "site/public_followers")
    {
        $current_id = "followers";
    }
?>
<div class="left-rounded-box white-background" style="padding: 8px 3px 8px 8px; ">
    <div class="entered-finaos">
        <ul>
            <a href="index.php?r=site/public_finaos&uname=<? echo $public_profile_details->uname; ?>">
                <li <? echo ($current_id == "finaos" ? "class='current'" : ""); ?>>
                    FINAOs
                </li>
            </a>
            <a href="index.php?r=site/public_tiles&uname=<? echo $public_profile_details->uname; ?>">       
                <li <? echo ($current_id == "tiles" ? "class='current'" : ""); ?>>
                    Tiles
                </li>
            </a>
            <a  href="index.php?r=site/public_finao_posts&uname=<? echo $public_profile_details->uname; ?>">       
                <li <? echo ($current_id == "posts" ? "class='current'" : ""); ?>>
                    Posts
                </li>
            </a>
            <a href="index.php?r=site/public_inspired&uname=<? echo $public_profile_details->uname; ?>">
                <li <? echo ($current_id == "inspired" ? "class='current'" : ""); ?>>
                    Inspired
                </li>
            </a>
            <a class="last" href="index.php?r=site/public_followings&uname=<? echo $public_profile_details->uname; ?>">
                <li <? echo ($current_id == "followings" ? "class='current last'" : ""); ?>>
                    Following
                </li>
            </a>
        </ul>
    </div>

  <!--
  <div class="profile-finaos" style="padding-top: 15px;">
    <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
  </div>-->
  <div class="row img-responsive" style="margin: 0px;"> 
    <?
        if($current_id == "followings")
        {
            if(is_array($followings))
            {
                $tile_id = 0;
                $tile_image = "";
                $tiles_arr = array();
                foreach($followings as $following)
                {
                    if(is_array($following->tile_ids))
                    {
                        foreach ($following->tile_ids as $key => $tile)
                        {                
                            if(!in_array($tiles_arr[$tile->tile_id],$tiles_arr))
                            {                                                               
                                $tiles_arr[$tile->tile_id] = array("tile_id"=>$tile->tile_id,"tile_name"=>$following->tile_names[$key]->tile_name);
                            }    
                        } 
                    }
                }
                
                function multid_sort($arr, $index) 
                {
                    $b = array();
                    $c = array();
                    foreach ($arr as $key => $value) {
                        $b[$key] = $value[$index];
                    }

                    asort($b);

                    foreach ($b as $key => $value) {
                        $c[] = $arr[$key];
                    }

                    return $c;
                }
                
                $tiles_arr = multid_sort($tiles_arr, 'tile_name');                                
            }
            ?>
                <div class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="label">
                        <select id="myowntiles" name="myowntiles" onchange="sortfollowerbytiles(this.value);">
                            <option value="0">All</option>
                            <?
                                foreach ($tiles_arr as $tile)
                                {
                                    ?>
                                        <option value="<? echo $tile["tile_id"]; ?>"><? echo $tile["tile_name"]; ?></option>
                                    <?
                                }
                            ?>
                        </select>
                    </div>
                </div>
            <?   
        }
    ?>
    <?
       // if(is_array($public_user_posts))
//        {
//            $j = 0;
//            foreach($public_user_posts as $public_user_post)
//            {
//                if($public_user_post->status == 1)
//                {
//                    $has_data = false;
//                    if(is_array($public_user_post->image_urls))
//                    {                                                        
//                        foreach($public_user_post->image_urls as $image_url)
//                        {                              
//                            if ($image_url->image_url != "")
//                            {
                               // ?>                                                                    
                                    
    <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog("-->
      <? //echo $public_user_post->uploaddetail_id; ?>
                                        
     <!-- <img class="left-photos" src=""
      <? //echo $image_path."blank.gif"?>" style="background-image: url('
      <? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                    
    </a>  -->
    <?
                            //    $has_data = true;
//                                ++ $j;
//                                break;
//                            }
//                        }                                                               
//                    }
//                    if(!$has_data)
//                    {
//                        if(is_array($public_user_post->videourls))
//                        {                                                        
//                            foreach($public_user_post->videourls as $videourls)
//                            {                              
//                                if ($image_url->image_url != "")
//                                {
                                    ?>                                                                    
                                        
   <!-- <a href="#" data-target="#" data-interval="false" onclick="openimagedialog("
      <? //echo $public_user_post->uploaddetail_id; ?>);">
                                            
      <img class="left-photos" src=""
      <? //echo $icon_path."nike.png"?>" style="background-image: url('
      <? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                        
    </a>  -->
    <?                            //
//                                    $has_data = true;
//                                    ++ $j;
//                                    break;
//                                }
//                            }                                                               
//                        }
//                    }                                                    
//                }
//                if($j == 3)
//                {
//                    break;
//                }
//            }
//        }
//        else
//        {
//            
//        }
    ?>
  
  </div>
</div>
<? include_once ("footer.php"); ?>
