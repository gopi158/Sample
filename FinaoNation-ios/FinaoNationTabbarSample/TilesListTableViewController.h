//
//  TilesListTableViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 05/06/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetPublicTilesUserId.h"
#import "UnFollowAllTilesForUserId.h"
#import "FinaoTilesListCell.h"
#import "UIImageView+AFNetworking.h"
#import "SearchDetailNewViewController.h"

@interface TilesListTableViewController : UIViewController<UITableViewDelegate,UITableViewDataSource>{
    
    NSMutableArray* arrayTiles;
    UITableView* TilesListTableview;
    GetPublicTilesUserId* GetPublicTilesUserIdParam;
    BOOL NOFOLLOWERS;
    NSString* Userid;
}

@property(nonatomic, strong) NSString* Userid;

-(void)ReturnFollowAllTiles:(NSNotification *) notification;
@end
