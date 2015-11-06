//
//  ProfileV1ViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetPostRecentPostinfo.h"
#import "GetInspiredinfo.h"
#import "GetNumofList.h"
#import "AppConstants.h"
#import "FinaoViewController.h"
#import "TilesViewController.h"
#import "FollowersViewController.h"
#import "FollowingViewController.h"
#import "ProfileDetailTableCell.h"
#import "UIImageView+AFNetworking.h"
#import "MenuViewController.h"
#import <Social/Social.h>
#import <Accounts/Accounts.h>
#import "UIImage+ImageEffects.h"
#import "AppDelegate.h"
#import "GetNotificationInfo.h"
#import "ProfileDetailViewController.h"
#import "DeletePost.h"


@interface ProfileV1ViewController : UIViewController<
 UIImagePickerControllerDelegate,UIAlertViewDelegate,UIActionSheetDelegate,UIImagePickerControllerDelegate,UINavigationControllerDelegate,UIGestureRecognizerDelegate,UITableViewDataSource,UITableViewDelegate>
{
    CGRect screenHeightBounds;
    
    UIView* HeaderView;
    UIButton* imgbtn;
    UITextView* txtview;

    NSArray* ListDic;
    UILabel* FinaoLbl,*TileLbl,*FollowingLbl,*FollowersLbl,*PostsLbl,*InspiredLbl;
    UILabel* ProfileName;
    UIButton* Inspiredbtn,*Postsbtn,*Followingbtn,*Followerssbtn,*Tilesbtn,*Finaobtn;
    UILabel* FinaoCountLbl,*TileCountLbl,*FollowingCountLbl,*FollowersCountLbl;
    
    UIImageView* Profileimgview,*Bannerimgview;
    
    
    UITableView* PostTableview;
    UITableView* InspiredTableview;
    
    ///
    
    NSMutableArray* postarray, *notifarray;
    NSMutableArray* inspiredarray;
    NSMutableArray* Notificationarray;
    
    BOOL UserisNew;
    BOOL TablesScrolledUP;

    GetPostRecentPostinfo* getpostinfo;
    GetInspiredinfo* getinspiredinfo;
    GetNumofList* Getnumlist;
    BOOL shareBtnBOOL;
    
    GetNotificationInfo *getNotificationInfo;
    DeletePost * deletePost;
    
}

@end
