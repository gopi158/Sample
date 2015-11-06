//
//  HomeScreenViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"
#import "AppConstants.h"
#import "ProfileDetailTableCell.h"
#import "GetInspiredFromPost.h"
#import "GetUnInspiredFromPost.h"


@interface HomeScreenViewController : UIViewController<UITableViewDataSource,UITableViewDelegate,WebServiceDelegate,UIActionSheetDelegate ,UIScrollViewDelegate>{
    NSMutableDictionary *profilePhotosDictionary;
    
    UITableView* Home_table;   
    NSMutableArray* arrHomeLIST;
    BOOL UserisNotFollowing;
    GetNotificationInfo *getNotificationInfo;
    GetInspiredFromPost *getInspiredFromPost;
    GetUnInspiredFromPost *getUnInspiredFromPost;
}
-(void)LaunchActivity;
@end
