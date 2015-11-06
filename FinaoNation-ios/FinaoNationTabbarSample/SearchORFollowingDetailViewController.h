//
//  SearchORFollowingDetailViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetFinaoForSearch.h"
#import "GetSearchFollowingList.h"
#import "GetTilesForSearch.h"

@interface SearchORFollowingDetailViewController : UIViewController<UITableViewDataSource,UITableViewDelegate>
{
    
    NSString* SearchusrID;
    NSString* imageUrlStr;
    NSString* StoryText;
    NSString* NumofFinaos;
    NSString* NumofTiles;
    NSString* NumofFollowing;
    NSString* Firstname;
    NSString* Lastname;
    
    UIButton* Finoasbtn,* Followingbtn,*Tilesbtn;
    UILabel* FinaoCountLbl,*TileCountLbl,*FollowingCountLbl;
    UITableView* FinaoTable,* FollowingTable,* TilesTable;
    
    NSMutableArray *arrFINAOLIST,* arrFollowingList,* arrTilesList;
    
    BOOL UserisNew;
    BOOL NOFollowings;
    BOOL NOTiles;
    
    NSString* PassesUsrid;
    
    GetFinaoForSearch* GetFinoasListProfile;
    GetSearchFollowingList* GetFollowingListProfile;
    GetTilesForSearch* GetTilesListProfile;
    
    NSData* ProfileimageData;
    UIView* HeaderView;
    BOOL TablesScrolledUP;
    BOOL FirStTime;
}
@property(nonatomic,retain)NSString* PassesUsrid;
@property(nonatomic,retain)NSString* SearchusrID;
@property(nonatomic,retain)NSString* imageUrlStr;
@property(nonatomic,retain)NSString* StoryText;
@property(nonatomic,retain)NSString* NumofFinaos;
@property(nonatomic,retain)NSString* NumofTiles;
@property(nonatomic,retain)NSString* NumofFollowing;
@property(nonatomic,retain)NSString* Firstname;
@property(nonatomic,retain)NSString* Lastname;

@end
