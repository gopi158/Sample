//
//  TilesDetailViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 11/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"

@interface TilesDetailViewController : UIViewController<UITableViewDataSource,UITableViewDelegate,WebServiceDelegate>{

    UITableView* TileDetailTable;
    NSMutableArray* arrTileLIST;
    NSString* TileIDStr;
    NSString* PassesUsrid;
    NSString* WebStringExtra;
    NSString* Friendsname;
    NSString* FriendsImageURL;
    BOOL SelfUser;
}
@property(nonatomic,retain)NSString* Friendsname;
@property(nonatomic,retain)NSString* FriendsImageURL;
@property(nonatomic,assign)BOOL SelfUser;
@property(nonatomic,retain)NSString* WebStringExtra;
@property(nonatomic,retain)NSString* PassesUsrid;
@property(nonatomic,retain)NSString* TileIDStr;
@end
