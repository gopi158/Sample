//
//  FollowingViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetFollowingList.h"
#import "GetSearchFollowingList.h"

@interface FollowingViewController : UIViewController<UITableViewDelegate,UITableViewDataSource>{
    
    NSMutableArray* arrFollowings;
    UITableView* FollowingTableview;
    GetFollowingList* GetFollowing;
    GetSearchFollowingList* GetFollowingListProfile;
    BOOL NOFollowings;
    
    NSString* Userid;
    BOOL SelfUser;
}
@property(nonatomic,readwrite)BOOL SelfUser;
@property(nonatomic,retain)NSString* Userid;

@end
