//
//  SearchDetailNewViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 13/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetPostRecentPostinfo.h"
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

@interface SearchDetailNewViewController : UIViewController
{
    UIView* HeaderView;
    UIButton* imgbtn;
    UITextView* txtview;
    
    NSArray* ListDic;
    UILabel* FinaoLbl,*TileLbl,*FollowingLbl,*FollowersLbl,*PostsLbl,*InspiredLbl;
    UILabel* ProfileName;
    UIButton* Inspiredbtn,*Postsbtn,*Followingbtn,*Followerssbtn,*Tilesbtn,*Finaobtn, *Followbtn;
    UILabel* FinaoCountLbl,*TileCountLbl,*FollowingCountLbl,*FollowersCountLbl;
    
    UIImageView* Profileimgview,*Bannerimgview;
    
    UITableView* PostTableview;
    UITableView* InspiredTableview;

    
    BOOL TablesScrolledUP;
    NSMutableArray* postarray;
    NSMutableArray* inspiredarray;
    NSMutableArray* Notificationarray;
    NSDictionary * pssedDict;
    BOOL UserisNew;
    GetPostRecentPostinfo* getpostinfo;
    GetInspiredinfo* getinspiredinfo;
    GetNumofList* Getnumlist;
    BOOL shareBtnBOOL;
}

@property(nonatomic,retain)NSDictionary* pssedDict;
@property(nonatomic,retain)NSString* PassesUsrid;
@property(nonatomic,retain)NSString* SearchusrID;
@property(nonatomic,retain)NSString* imageUrlStr;
@property(nonatomic,retain)NSString* BannerimageUrlStr;
@property(nonatomic,retain)NSString* StoryText;
@property(nonatomic,retain)NSString* NumofFinaos;
@property(nonatomic,retain)NSString* NumofTiles;
@property(nonatomic,retain)NSString* NumofFollowing;
@property(nonatomic,retain)NSString* Firstname;
@property(nonatomic,retain)NSString* Lastname;
@end
