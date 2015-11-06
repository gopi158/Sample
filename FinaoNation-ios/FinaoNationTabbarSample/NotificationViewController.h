//
//  NotificationViewController.h
//  FinaoNationTabbarSample
//
//  Created by FINAO NATION on 5/8/14.
//  Copyright (c) 2014 FINAO NATION. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>
#import "GetFollowingList.h"
#import "GetSearchFollowingList.h"
#import "FollowingViewController.h"
#import "FinaoFollowingCell.h"
#import "UIImageView+AFNetworking.h"
#import "SearchDetailNewViewController.h"
#import "GetNotificationInfo.h"
#import "NotificationTableVuewCell.h"

@interface NotificationViewController: UIViewController<UITableViewDelegate,UITableViewDataSource>
{
    
    NSMutableArray* arrNotifications;
    UITableView* NotificationTableview;
    BOOL NONotifications;
    
    NSString* Userid;
    BOOL SelfUser;

}
@property(nonatomic,readwrite)BOOL SelfUser;
@property(nonatomic,retain)NSString* Userid;

-(void)GetNotificationList;
@end
