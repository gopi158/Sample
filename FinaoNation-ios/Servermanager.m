
//
//  Servermanager.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 20/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "Servermanager.h"
#import "AppConstants.h"
#import "Reachability.h"
#import "SBJSON.h"
#import "ServiceCallsManager.h"

@implementation Servermanager
@synthesize delegate = _delegate;
BOOL serviceDataError = NO;
int requestID = 0;


-(void)loginBase64:(NSString *)base64str username:(NSString*)username password:(NSString*)MD5Password
{
    //NSLog(@"PWD : %@",MD5Password);
    //NSLog(@"username : %@",username);
    base64value = [NSString stringWithFormat:@"Basic %@",base64str];
    //NSLog(@"base64value : %@",base64value);
    NSString *reqUrl = [CALLMANAGER returnLoginURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    NSMutableData *postData = [self generateDataFromText:username  fieldName:@"username"];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",MD5Password] fieldName:@"password"]];
    [postData appendData:[self generateDataFromText:@"login" fieldName:@"json"]];
    requestID = 1;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)RegisterManual:(NSString *)FirstName Lastname:(NSString *)Lastname Email:(NSString*)Email PassWord:(NSString*)Password ProfileImage:(NSData*)ProfileImgData profileimagename:(NSString*)Profilename;
{
    NSString *reqUrl = [CALLMANAGER returnLoginURL];//[NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    
    if ([Profilename isEqualToString:@"NOIMAGE"]) {
        NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"1"] fieldName:@"type"];
        [postData appendData:[self generateDataFromText:FirstName fieldName:@"name"]];
        [postData appendData:[self generateDataFromText:FirstName fieldName:@"fname"]];
        [postData appendData:[self generateDataFromText:Lastname fieldName:@"lname"]];
        [postData appendData:[self generateDataFromText:Password fieldName:@"password"]];
        [postData appendData:[self generateDataFromText:Email fieldName:@"email"]];
        [postData appendData:[self generateDataFromText:@"registration" fieldName:@"json"]];
        requestID = 2;
        [self handleRequestForUrl:reqUrl withData:postData actionType:action];
    }
    else{
        NSMutableData *postData = [self generateImageDatafromImage:ProfileImgData fieldName:@"profilepic" FileName:Profilename];
        
        [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"1"] fieldName:@"type"]];
        [postData appendData:[self generateDataFromText:FirstName fieldName:@"name"]];
        [postData appendData:[self generateDataFromText:FirstName fieldName:@"fname"]];
        [postData appendData:[self generateDataFromText:Lastname fieldName:@"lname"]];
        [postData appendData:[self generateDataFromText:Password fieldName:@"password"]];
        [postData appendData:[self generateDataFromText:Email fieldName:@"email"]];
        [postData appendData:[self generateDataFromText:@"registration" fieldName:@"json"]];
        requestID = 23;
        [self handleRequestForUrl:reqUrl withData:postData actionType:action];
    }
    
}
-(void)RegisterFacebook:(NSString *)FirstName Lastname:(NSString *)Lastname Email:(NSString*)Email UID:(NSString*)Fid
{
    NSString *reqUrl = [CALLMANAGER returnLoginURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"2"] fieldName:@"type"];
    [postData appendData:[self generateDataFromText:FirstName fieldName:@"name"]];
    [postData appendData:[self generateDataFromText:Lastname fieldName:@""]];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",Fid] fieldName:@"facebookid"]];
    [postData appendData:[self generateDataFromText:Email fieldName:@"email"]];
    [postData appendData:[self generateDataFromText:@"registration" fieldName:@"json"]];
    //NSLog(@"URLFB:%@",reqUrl);
    requestID = 3;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
    
}


-(void)UpdateUserProfileBGImage:(NSString*)Profilename BGImageData:(NSData*)ProfileImgBGData
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:@"updateprofile" fieldName:@"json"];
    [self generateImageDatafromImage:ProfileImgBGData fieldName:@"profile_bg_image" FileName:Profilename];
    Loginbase64 = YES;
    requestID = 65;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)UpdateUserProfileImage:(NSData*)ProfileImgData
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:@"updateprofile" fieldName:@"json"];
    [self generateImageDatafromImage:ProfileImgData fieldName:@"profile_image" FileName:@"profile_image"];
    Loginbase64 = YES;
    requestID = 67;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)UpdateUserProfileBGImage:(NSData*)ProfileBGImgData
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:@"updateprofile" fieldName:@"json"];
    [self generateImageDatafromImage:ProfileBGImgData fieldName:@"profile_bg_image" FileName:@"profile_bg_image"];
    Loginbase64 = YES;
    requestID = 68;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)UpdateUserProfileName:(NSString*)name
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",name] fieldName:@"bio"];
    [postData appendData:[self generateDataFromText:@"updateprofile" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 63;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)UpdateUserProfileBio:(NSString*)story
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",story] fieldName:@"bio"];
    [postData appendData:[self generateDataFromText:@"updateprofile" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 62;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)UpdateUserProfileBGImage:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:@"updateprofile" fieldName:@"json"];
    [self generateImageDatafromImage:ProfileImgData fieldName:@"profile_bg_image" FileName:Profilename];
    Loginbase64 = YES;
    requestID = 61;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)UpdateUserProfile:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=updateprofile",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",name] fieldName:@"name"];
    [postData appendData:[self generateDataFromText:@"updateprofile" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",story]  fieldName:@"bio"]];
    [self generateImageDatafromImage:ProfileImgData fieldName:@"profile_image" FileName:Profilename];
    [self generateImageDatafromImage:ProfileImgData fieldName:@"profile_bg_image" FileName:Profilename];
    Loginbase64 = YES;
    requestID = 61;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetNumberList:(NSString*)UID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=getuser_finaocounts",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",UID] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"user_details" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 4;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)GetFinaoListFromServer:(NSString*)UID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=finao_list",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",UID] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"0" fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:@"finao_list" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 5;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)GetFollowingListFromServer:(NSString*)UID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followings&userid=%@",BASEURL,UID];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:@"followings" fieldName:@"json"];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",UID] fieldName:@"userid"]];
    requestID = 6;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)GetTilesListFromServer:(NSString*)UID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=mytiles&user_id=%@&iscomplete=0",BASEURL,UID];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",UID] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"mytiles" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:@"0" fieldName:@"iscomplete"]];
    Loginbase64 = YES;
    requestID = 7;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetNotificationsCount
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:@"getnotificationscount" fieldName:@"json"];
    Loginbase64 = YES;
    requestID = 51;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetNotifications
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:@"getnotifications" fieldName:@"json"];
    Loginbase64 = YES;
    requestID = 50;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)GetProfile_finaos:(NSString*)UID FinaoID:(NSString*)Finao_id
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",UID]  fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:Finao_id fieldName:@"finao_id"]];
    [postData appendData:[self generateDataFromText:@"public_posts" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 8;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetPPublicPostsForFinaoId:(NSString*)FinaoID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",FinaoID] fieldName:@"finao_id"];
    [postData appendData:[self generateDataFromText:@"public_posts" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 48;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetProfileTilesDetails:(NSString*)TileID UID:(NSString*)UID ExtraString:(NSString*)WebExtrastring
{
    //NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=listfinaos&tile_id=%@&user_id=%@%@",BASEURL,TileID,UID,WebExtrastring];
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:UID fieldName:@"user_id"];
    [postData appendData:[self generateDataFromText:@"listfinaos" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:TileID fieldName:@"tile_id"]];
    Loginbase64 = YES;
    requestID = 9;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}
-(void)GetFinaosForTile:(NSString*)TileID UID:(NSString*)UID ExtraString:(NSString*)WebExtrastring
{
    //NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=listfinaos&tile_id=%@&user_id=%@%@",BASEURL,TileID,UID,WebExtrastring];
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:UID fieldName:@"user_id"];
    [postData appendData:[self generateDataFromText:@"public_finao" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:TileID fieldName:@"tile_id"]];
    Loginbase64 = YES;
    requestID = 49;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetSearchList:(NSString*)SearchString{
    Loginbase64 = YES;
    NSString *reqUrl=[NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",SearchString] fieldName:@"username"];
    [postData appendData:[self generateDataFromText:@"searchusers" fieldName:@"json"]];
    requestID = 14;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetSearchFinaoListFromServer:(NSString*)SearchUsrID USERID:(NSString*)user_id
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=finao_list",BASEURL];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:user_id fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"1" fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:SearchUsrID fieldName:@"otherid"]];
    [postData appendData:[self generateDataFromText:@"finao_list" fieldName:@"json"]];
    requestID = 11;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetSearchTilesListFromServer:(NSString*)SearchUsrID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=usertiles&user_id=%@&ispublic=1",BASEURL,SearchUsrID];
    NSMutableData *postData = [self generateDataFromText:SearchUsrID fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"1" fieldName:@"ispublic"]];
    [postData appendData:[self generateDataFromText:SearchUsrID fieldName:@"user_id"]];
    [postData appendData:[self generateDataFromText:@"usertiles" fieldName:@"json"]];
    Loginbase64 = YES;
    NSString *action = @"POST";
    
    requestID = 12;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetSearchFollowingListFromServer:(NSString*)SearchUsrID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followings&userid=%@",BASEURL,SearchUsrID];
    NSMutableData *postData = [self generateDataFromText:SearchUsrID fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"followings" fieldName:@"json"]];
    Loginbase64 = YES;
    NSString *action = @"POST";
    requestID = 13;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)GetHomeListFromServer:(NSString*)usrID{
    
    Loginbase64 = YES;
    NSString *reqUrl=[NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"homepage_user" fieldName:@"json"]];
    requestID = 24;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)FollowUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followuser&tileid=%@",BASEURL,tileID];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",tileID] fieldName:@"tileid"];
     [postData appendData: [self generateDataFromText:[NSString stringWithFormat:@"%@",followeduserId] fieldName:@"followeduserid"]];

    [postData appendData:[self generateDataFromText:@"followuser" fieldName:@"json"]];
    
    requestID = 40;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetPublicTilesUserId:(NSString*)followeduserId
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=public_followedtile&userid=%@",BASEURL,followeduserId];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",followeduserId] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"public_followedtile" fieldName:@"json"]];
    requestID = 44;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}



-(void)FollowAllTilesUserId:(NSString*)followeduserId
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followall&id=%@",BASEURL,followeduserId];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",followeduserId] fieldName:@"id"];
    [postData appendData:[self generateDataFromText:@"followall" fieldName:@"json"]];
    requestID = 42;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)UnFollowUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followuser&tileid=%@",BASEURL,tileID];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",tileID] fieldName:@"tileid"];
    [postData appendData: [self generateDataFromText:[NSString stringWithFormat:@"%@",followeduserId] fieldName:@"followeduserid"]];
    
    [postData appendData:[self generateDataFromText:@"unfollow" fieldName:@"json"]];
    
    requestID = 43;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)UnFollowAllTilesForUserId:(NSString*)userId
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=unfollowalltiles&id=%@",BASEURL,userId];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",userId] fieldName:@"id"];
    [postData appendData:[self generateDataFromText:@"unfollowalltiles" fieldName:@"json"]];
    requestID = 41;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}



-(void)GetFollowersListFromServer:(NSString*)usrID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=followers&userid=%@",BASEURL,usrID];
    Loginbase64 = YES;
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:@"followers" fieldName:@"json"]];
    requestID = 25;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetDefaultTile:(NSString*)usrID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=usertiles&custom_user_id=%@&iscomplete=0",BASEURL,usrID];
    Loginbase64 = YES;
    NSString *action = @"POST";
    
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"custom_user_id"];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"user_id"]];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:@"usertiles" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:@"0" fieldName:@"iscomplete"]];
    requestID = 15;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)CreateFinao:(NSString*)usrID Public:(BOOL)Public FinaoText:(NSString*)FinaoTxt TileID:(NSString*)TileID TileName:(NSString*)TileName CaptionTxt:(NSString*)CaptionTxt
{
    Loginbase64 = YES;
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=createfiano",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"user_id"];
    [postData appendData:[self generateDataFromText:@"createfinao" fieldName:@"json"]];
    [postData appendData:[self generateDataFromText:FinaoTxt fieldName:@"finao_msg"]];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"updatedby"]];
    [postData appendData:[self generateDataFromText:@"38" fieldName:@"finao_status"]];
    [postData appendData:[self generateDataFromText:@"0" fieldName:@"completed"]];
    [postData appendData:[self generateDataFromText:TileID fieldName:@"tile_id"]];
    [postData appendData:[self generateDataFromText:TileName fieldName:@"tile_name"]];
    [postData appendData:[self generateDataFromText:@"CaptionTxt" fieldName:@"caption"]];
    
    if (Public) {
        [postData appendData:[self generateDataFromText:@"0" fieldName:@"finao_status_ispublic"]];
    }
    else{
        [postData appendData:[self generateDataFromText:@"1" fieldName:@"finao_status_ispublic"]];
    }
    requestID = 16;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)PostImageCreateFinao:(NSString*)usrID ImgData:(NSData*)ImgData ImgName:(NSString*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text
{
    
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=uploadimagesfinao",BASEURL];
    NSString *action = @"POST";
    
    NSMutableData *postData =    [self generateImageDatafromImage:ImgData fieldName:@"image1" FileName:ImgName];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:FinaoID fieldName:@"finaoid"]];
    [postData appendData:[self generateDataFromText:@"" fieldName:@"upload_text"]];
    [postData appendData:[self generateDataFromText:@"1" fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:@"" fieldName:@"captiondata"]];
    [postData appendData:[self generateDataFromText:@"createpost" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 17;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)PostImagesUpdateFinao:(NSString*)usrID ImgData:(NSMutableArray*)ImgData ImgName:(NSMutableArray*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text
{
    
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=uploadimagesfinao",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData =  [[NSMutableData alloc]init];
    for (int i = 0 ; i< [ImgName count]; i++)
    {
        NSString *trimmedString=[[ImgName objectAtIndex:i] substringFromIndex:[[ImgName objectAtIndex:i] length]-4];
        
        //for video
        NSString* fldname;
        
        if ([trimmedString isEqualToString:@".mp4"]) {
            
            fldname = [NSString stringWithFormat:@"video%d",i+1];
            [postData appendData:[self generateImageDatafromImage:[ImgData objectAtIndex:i] fieldName:fldname FileName:[ImgName objectAtIndex:i]]];
            
        }else if ([trimmedString isEqualToString:@".jpg"])
        {
            fldname = [NSString stringWithFormat:@"postimage%d",i+1];
            [postData appendData:[self generateImageDatafromImage:[ImgData objectAtIndex:i] fieldName:fldname FileName:[ImgName objectAtIndex:i]]];
        }
        //NSLog(@"fldname:%@",fldname);
    }
    
    [postData appendData:[self generateDataFromText:CaptionData fieldName:@"captiondata"]];
    [postData appendData:[self generateDataFromText:[NSString stringWithFormat:@"%@",usrID] fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:FinaoID fieldName:@"finao_id"]];
    [postData appendData:[self generateDataFromText:FinaoID fieldName:@"finaoid"]];
    [postData appendData:[self generateDataFromText:upload_text fieldName:@"upload_text"]];
    [postData appendData:[self generateDataFromText:upload_text fieldName:@"postdata"]];
    [postData appendData:[self generateDataFromText:@"1" fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:@"createpost" fieldName:@"json"]];
    Loginbase64 = YES;
    requestID = 18;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
    
    
    
}

-(void)ChangePublictoPrivate:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=changefinaostatus",BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    NSMutableData *postData = [self generateDataFromText:usrID fieldName:@"userid"];
    [postData appendData:[self generateDataFromText:Type fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:finaoid fieldName:@"finaoid"]];
    [postData appendData:[self generateDataFromText:finaoid fieldName:@"finao_id"]];
    [postData appendData:[self generateDataFromText:status fieldName:@"status"]];
    [postData appendData:[self generateDataFromText:@"changefinaostatus" fieldName:@"json"]];
    requestID = 19;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}
-(void)ChangeTrackInfo:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status isPublic:(NSString*)isPublic{
    Loginbase64 = YES;
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php?json=changefinaostatus",BASEURL];
    NSString *action = @"POST";
    NSMutableData *postData = [self generateDataFromText:finaoid fieldName:@"finaoid"];
    [postData appendData:[self generateDataFromText:Type fieldName:@"type"]];
    [postData appendData:[self generateDataFromText:usrID fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:isPublic fieldName:@"finao_status_ispublic"]];
    [postData appendData:[self generateDataFromText:status fieldName:@"status"]];
    [postData appendData:[self generateDataFromText:@"changefinaostatus" fieldName:@"json"]];
    requestID = 20;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
    
}

-(void)GetRecentPosts
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    requestID = 21;
    Loginbase64 = YES;
    //NSLog(@"userid : %@",[USERDEFAULTS objectForKey:@"userid"]);
    NSMutableData *postData = [self generateDataFromText:@"finaorecentposts"  fieldName:@"json"];
    [postData appendData:[self generateDataFromText:[USERDEFAULTS objectForKey:@"userid"] fieldName:@"userid"]];
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}
-(void)GetRecentPostsForUserId:(NSString *) userID
{
    Loginbase64 = YES;
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php",BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    NSMutableData *postData = [self generateDataFromText:@"finaorecentposts"  fieldName:@"json"];
    [postData appendData:[self generateDataFromText:userID fieldName:@"userid"]];
    requestID = 22;
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


-(void)DeletePost:(NSString*)FinaoID withID:(NSString*)UserPostID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    requestID = 80;
    NSMutableData *postData = [self generateDataFromText:FinaoID fieldName:@"finao_id"];
    [postData appendData:[self generateDataFromText:UserPostID fieldName:@"userpostid"]];
    [postData appendData:[self generateDataFromText:@"deletepost" fieldName:@"json"]];
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetInspiredForId:(NSString*)ID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    requestID = 26;
    NSMutableData *postData = [self generateDataFromText:ID fieldName:@"id"];
    [postData appendData:[self generateDataFromText:ID fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:@"getinspired" fieldName:@"json"]];
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetInspiredFromPost:(NSString*)ID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    requestID = 70;
    NSMutableData *postData = [self generateDataFromText:ID fieldName:@"userpostid"];
    [postData appendData:[self generateDataFromText:ID fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:@"getinspiredfrompost" fieldName:@"json"]];
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}

-(void)GetUnInspiredFromPost:(NSString*)ID
{
    NSString *reqUrl = [NSString stringWithFormat:@"%@api.php" ,BASEURL];
    NSString *action = @"POST";
    Loginbase64 = YES;
    requestID = 70;
    NSMutableData *postData = [self generateDataFromText:ID fieldName:@"userpostid"];
    [postData appendData:[self generateDataFromText:ID fieldName:@"userid"]];
    [postData appendData:[self generateDataFromText:@"getuninspiredfrompost" fieldName:@"json"]];
    [self handleRequestForUrl:reqUrl withData:postData actionType:action];
}


/**
 This method handles the Request URL and redirects to fetch the data from the server
 @param requesturl Request URL to fetch the data
 @param message Message to perform particular Action
 @param action Action to be performed to fetch the data
 */

- (void) handleRequestForUrl:(NSString *) requestURL withData:(NSMutableData *) postData actionType:(NSString *) action
{
    Reachability* reachability = [Reachability reachabilityForInternetConnection];
    [Reachability reachabilityWithHostName:@"www.apple.com"];    // set your host name here
    NetworkStatus remoteHostStatus = [reachability currentReachabilityStatus];
    
    if (remoteHostStatus == NotReachable)
    {
        UIAlertView *netAlert = [[UIAlertView alloc]initWithTitle:@"Internet Alert" message:@"intenet not found" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [netAlert show];
        [APPDELEGATE hideHUD];
    }
    else
    {
        
#ifdef DEBUG
        //NSLog(@"actionType  : %@",action);
        //NSLog(@"Request URL : %@",requestURL);
#endif
        NSURL *url = [NSURL URLWithString:requestURL];
        
        NSMutableURLRequest *req = [NSMutableURLRequest requestWithURL:url];
        req.timeoutInterval = 300.0;
        if(postData != nil)
        {
            if([action isEqualToString:@"POST"])
            {
                [req setHTTPMethod:@"POST"];
                
                [req setValue:[NSString stringWithFormat:@"%lu", (unsigned long)[postData length]] forHTTPHeaderField:@"Content-Length"];
                
                [req setValue:@"multipart/form-data; boundary=AaB03x" forHTTPHeaderField:@"Content-Type"];
                
                [req setHTTPBody: postData];
            }
            else
            {
                [req setHTTPBody:postData];
            }
        }
        
        [req setHTTPMethod:action];
        if (Loginbase64) {
#ifdef DEBUG
            //NSLog(@"Auth header= %@",[NSString stringWithFormat:@"Basic %@",[USERDEFAULTS objectForKey:@"base64str"]] );
#endif
            [req setValue:[NSString stringWithFormat:@"Basic %@",[USERDEFAULTS objectForKey:@"base64str"]] forHTTPHeaderField:@"Authorization"];
            Loginbase64 = NO;
        }
        aConnection = [[NSURLConnection alloc] initWithRequest:req delegate:self];
        
#ifdef DEBUG
        //NSLog(@"request headers %@",[req allHTTPHeaderFields]);
#endif
        
        if( aConnection)
        {
            webData = [NSMutableData data];
        }
        else
        {
            //NSLog(@"Connection Failed");
        }
    }
}

-(NSMutableData *)generateImageDatafromImage:(NSData *)FileData fieldName:(NSString *)fieldName FileName:(NSString*)Filename
{
    NSString *post = [NSString stringWithFormat:@"--AaB03x\r\nContent-Disposition: form-data; name=\"%@\"; filename=\"%@\"\r\n",fieldName, Filename];
    NSData *postHeaderData = [post dataUsingEncoding:NSUTF8StringEncoding];
    NSMutableData *postData = [[NSMutableData alloc] initWithLength:[postHeaderData length]];
    [postData setData:postHeaderData];
    NSData *uploadData = [NSData dataWithData:FileData];//[FileData dataUsingEncoding:NSUTF8StringEncoding];
    [postData appendData: [@"\r\n" dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES]];
    [postData appendData: uploadData];
    [postData appendData: [@"\r\n" dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES]];
    return postData;
    
}
-(NSMutableData *)generateDataFromText:(NSString *)dataText fieldName:(NSString *)fieldName
{
    NSString *post = [NSString stringWithFormat:@"--AaB03x\r\nContent-Disposition: form-data; name=\"%@\"\r\n\r\n", fieldName];
    // Get the post header int ASCII format:
    NSData *postHeaderData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
    // Generate the mutable data variable:
    NSMutableData *postData = [[NSMutableData alloc] initWithLength:[postHeaderData length]];
    [postData setData:postHeaderData];
    NSData *uploadData = [dataText dataUsingEncoding:NSUTF8StringEncoding allowLossyConversion:YES];
    // Add the text:
    [postData appendData: uploadData];
    // Add the closing boundry:
    [postData appendData: [@"\r\n" dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES]];
    // Return the post data:
    return postData;
}
-(void) cancelAllRequest{
    
    [aConnection cancel];
}
- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
#ifdef DEBUG
    //NSLog(@"Status code %ld",(long)[(NSHTTPURLResponse *) response statusCode]);
#endif
	[webData appendData:nil];
    NSInteger status = (NSInteger)[(NSHTTPURLResponse *) response statusCode];
    if(status== 200){
        serviceDataError = NO;
    }
    else
    {
        [APPDELEGATE showHToast:@"Service Temporarily Unavailable"];
        serviceDataError = YES;
        if([self.delegate respondsToSelector:@selector(webServiceFinishedWithcode:withMessage:)])
            [self.delegate webServiceFinishedWithcode:status withMessage:[self getErrorMessageForStatus:status]];
    }
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
#ifdef DEBUG
	//NSString *stringReply = (NSString *)[[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
	//NSLog(@"response is:  %@",stringReply);
#endif
	[webData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    webData = nil;
    [APPDELEGATE hideHUD];
    [APPDELEGATE showHToast:@"Connection Error"];
    //NSLog(@"error is =%@",error.description);
    
    UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"Finao" message:@"Could not connect to server." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert show];
    
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
	[UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
	NSString *response = [[NSString alloc] initWithData:webData encoding:NSUTF8StringEncoding];
    
    [self selectParserWithData:[response dataUsingEncoding:NSUTF8StringEncoding] RequestID:requestID];
    
    
    webData = nil;
}

-(NSString *)getErrorMessageForStatus:(NSInteger)status
{
    NSString *errorMsg = nil;
    switch (status) {
        case 400:
            errorMsg = @"Bad Request";
            break;
        case 401:
            errorMsg = @"Authorisation Failed";
            break;
        case 409:
            errorMsg = @"Conflict arised";
            break;
        default:
            errorMsg = @"Something went wrong with server";
            break;
    }
    return errorMsg;
}

- (void) selectParserWithData:(NSData *) data RequestID:(int) requestID
{
    if (data!=nil){
        
        NSMutableDictionary *respDict = (NSMutableDictionary *) [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingAllowFragments error:nil];
        //NSLog(@"respdict is =%@",respDict);
        if([self.delegate respondsToSelector:@selector(webServiceFinishWithDictionary:withError:)])
            [self.delegate webServiceFinishWithDictionary:respDict withError:nil];
    }
    else{
        
        if([self.delegate respondsToSelector:@selector(webServiceFinishWithDictionary:withError:)])
            [self.delegate webServiceFinishWithDictionary:nil withError:nil];
    }
}

@end
