//
//  ProfileViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 22/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetNumofList.h"
#import "GetFinaoList.h"

@interface ProfileViewController : UIViewController<UITableViewDataSource,UITableViewDelegate>
{
    UIView* HeaderView;
    
    UIImageView* Bannerimgview;
    UIImageView* Profileimgview;
    UILabel* FinaoCountLbl,*TileCountLbl,*FollowingCountLbl,*FollowersCountLbl;
    UILabel* FinaoLbl,*TileLbl,*FollowingLbl,*FollowersLbl,*PostsLbl,*InspiredLbl;
    UILabel* ProfileName;
    UIButton* Inspiredbtn,*Postsbtn,*Followingbtn,*Followerssbtn,*Tilesbtn,*Finaobtn;
    //
    GetNumofList* Getnumlist;
    NSDictionary* ListDic;
    NSString* imageUrl;
    GetFinaoList* GetFinoasListProfile;
    NSMutableArray* arrFINAOLIST;
    UITableView* FinaoTable;
    BOOL UserisNew;
}
@end
