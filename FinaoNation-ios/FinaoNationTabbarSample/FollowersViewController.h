//
//  FollowersViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetFollowersList.h"
@interface FollowersViewController : UIViewController<UITableViewDelegate,UITableViewDataSource>{

    NSMutableArray* arrFollowers;
    UITableView* FollowersTableview;
    GetFollowersList* GetFollowers;
    BOOL NOFOLLOWERS;
}

@end
