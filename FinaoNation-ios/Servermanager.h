//
//  Servermanager.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 20/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>

@protocol WebServiceDelegate <NSObject>

@optional

-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error;
-(void)webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error;
-(void)webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *) message;

@end

@interface Servermanager : NSObject<UIAlertViewDelegate>{
    NSURLConnection *aConnection;
    NSMutableData *webData;
    id <WebServiceDelegate>  _delegate;
    BOOL Loginbase64;
    NSString* base64value;
    //    BOOL ImageORVideo;
}

@property (nonatomic,retain) id <WebServiceDelegate> delegate;


//other methods
-(void)loginBase64:(NSString *)base64str username:(NSString*)username password:(NSString*)MD5Password;
//-(void)loginManual:(NSString *)userId password:(NSString *)pwd type:(NSString*)Typeoflogin;

-(void)RegisterManual:(NSString *)FirstName Lastname:(NSString *)Lastname Email:(NSString*)Email PassWord:(NSString*)Password ProfileImage:(NSData*)ProfileImgData profileimagename:(NSString*)Profilename;
-(void)RegisterFacebook:(NSString *)FirstName Lastname:(NSString *)Lastname Email:(NSString*)Email UID:(NSString*)Fid ;
-(void)GetNumberList:(NSString*)UID;
-(void)GetFinaoListFromServer:(NSString*)UID;
-(void)GetFollowingListFromServer:(NSString*)UID;
-(void)GetTilesListFromServer:(NSString*)UID ;
-(void)GetProfile_finaos:(NSString*)UID FinaoID:(NSString*)Finao_id;
-(void)GetSearchList:(NSString*)SearchString;
-(void)GetSearchFinaoListFromServer:(NSString*)SearchUsrID USERID:(NSString*)user_id;
-(void)GetSearchTilesListFromServer:(NSString*)SearchusrID;
-(void)GetSearchFollowingListFromServer:(NSString*)SearchusrID;
-(void)GetHomeListFromServer:(NSString*)usrID;
-(void)GetFollowersListFromServer:(NSString*)usrID;
-(void)GetProfileTilesDetails:(NSString*)TileID UID:(NSString*)UID ExtraString:(NSString*)WebExtrastring;
-(void)GetDefaultTile:(NSString*)usrID;
-(void)CreateFinao:(NSString*)usrID Public:(BOOL)Public FinaoText:(NSString*)FinaoTxt TileID:(NSString*)TileID TileName:(NSString*)TileName CaptionTxt:(NSString*)CaptionTxt;
-(void)PostImageCreateFinao:(NSString*)usrID ImgData:(NSData*)ImgData ImgName:(NSString*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text;
-(void)PostImagesUpdateFinao:(NSString*)usrID ImgData:(NSMutableArray*)ImgData ImgName:(NSMutableArray*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text;
-(void)ChangePublictoPrivate:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status;
-(void)ChangeTrackInfo:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status isPublic:(NSString*)isPublic;
-(void)GetRecentPosts;
-(void) cancelAllRequest;
-(void)GetInspiredForId:(NSString*)ID;
-(void)GetRecentPostsForUserId:(NSString *) userID;

-(void)FollowUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID;
-(void)UnFollowAllTilesForUserId:(NSString*)userId;
-(void)FollowAllTilesUserId:(NSString*)followeduserId;
-(void)GetPublicTilesUserId:(NSString*)followeduserId;
-(void)GetFinaosForTile:(NSString*)TileID UID:(NSString*)UID ExtraString:(NSString*)WebExtrastring;
-(void)GetPPublicPostsForFinaoId:(NSString*)FinaoID;
-(void)GetNotifications;
-(void)GetNotificationsCount;

-(void)UpdateUserProfileBGImage:(NSData*)ProfileBGImgData;
-(void)UpdateUserProfileImage:(NSData*)ProfileImgData;
-(void)UpdateUserProfileBGImage:(NSString*)Profilename BGImageData:(NSData*)ProfileImgBGData;
-(void)UpdateUserProfileBio:(NSString*)story;
-(void)UpdateUserProfileName:(NSString*)name;
-(void)UpdateUserProfile:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData;
-(void)GetInspiredFromPost:(NSString*)ID;
-(void)GetUnInspiredFromPost:(NSString*)ID;
-(void)DeletePost:(NSString*)FinaoID withID:(NSString*)UserPostID;
@end
