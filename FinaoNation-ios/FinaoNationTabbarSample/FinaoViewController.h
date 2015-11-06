//
//  FinaoViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetFinaoList.h"
#import "GetFinaoForSearch.h"

@interface FinaoViewController : UIViewController<UITableViewDataSource,UITableViewDelegate>{

    NSMutableArray* arrFinao;
    UITableView* FinaoTableview;
    BOOL UserisNew;
    
    GetFinaoList* GetFinoaList;
    GetFinaoForSearch* GetFinoasListProfile;//  = [[GetFinaoForSearch alloc]init];

    NSString* Userid;
    BOOL SelfUser;
}
@property(nonatomic,readwrite)BOOL SelfUser;
@property(nonatomic,retain)NSString* Userid;
@property(nonatomic,retain)NSString* imageurl;
@property(nonatomic,retain)NSString* FriendusrName;

@end
