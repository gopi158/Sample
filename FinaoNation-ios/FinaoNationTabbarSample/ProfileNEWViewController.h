//
//  ProfileNEWViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 27/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetNumofList.h"
#import "GetFinaoList.h"
#import "GetTiles.h"
#import "GetFollowingList.h"
#import "GetFollowersList.h"

@interface ProfileNEWViewController : UIViewController<UITableViewDataSource,UITableViewDelegate, UIImagePickerControllerDelegate,UIAlertViewDelegate,UIActionSheetDelegate,UIImagePickerControllerDelegate,UINavigationControllerDelegate>
{
    CGRect screenHeightBounds;
    
    NSDictionary* ListDic;
    UILabel* FinaoLbl,*TileLbl,*FollowingLbl,*FollowersLbl,*PostsLbl,*InspiredLbl;
    UILabel* ProfileName;
    UIButton* Inspiredbtn,*Postsbtn,*Followingbtn,*Followerssbtn,*Tilesbtn,*Finaobtn;
    UILabel* FinaoCountLbl,*TileCountLbl,*FollowingCountLbl,*FollowersCountLbl;

    UIImageView* Profileimgview,*Bannerimgview;
    UIButton* imgbtn;
    UITextView* txtview;
    UITableView* FinaoTable,* FollowingTable,* TilesTable,*FollowersTable;
    
    NSMutableArray* arrFINAOLIST,* arrTilesList,* arrFollowingList,* arrFollowersLIST;
    GetNumofList* Getnumlist;
    GetFinaoList* GetFinoasListProfile;
    GetTiles* GetTilesListProfile;
    GetFollowingList* GetFollowingListProfile;
    GetFollowersList* GetFollowersListProfile;
    BOOL NOTiles;
    BOOL UserisNew;
    BOOL TablesScrolledUP;
    BOOL NOFollowings;
    BOOL NOFOLLOWERS;
    NSString* imageUrl;
    BOOL FirStTime;//First time
    
    UIView* HeaderView;
    
}
@end
