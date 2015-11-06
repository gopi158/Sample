//
//  MenuViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 06/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SlideNoteViewController.h"
#import "AppConstants.h"
#import "SettingsViewController.h"
#import "LoginViewController.h"
#import "ShopViewController.h"
#import "APPViewController.h"
#import "NotificationViewController.h"

@interface MenuViewController : UIViewController<UITableViewDelegate,UITableViewDataSource,UIAlertViewDelegate>
{
    NSArray* arr;
    UITableView* table;
}

@end
