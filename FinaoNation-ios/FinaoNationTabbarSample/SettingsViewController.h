//
//  SettingsViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 07/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SettingsCell.h"
#import "TermsViewController.h"
#import "NotificationSettingsViewController.h"

@interface SettingsViewController : UIViewController<UITableViewDelegate,UITableViewDataSource,UITextFieldDelegate>
{
    NSArray* arr;    
    UITableView* table;
}


@end
