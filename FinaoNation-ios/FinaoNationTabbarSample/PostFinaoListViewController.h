//
//  PostFinaoListViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"
#import "PostFinaoUpdate.h"
#import "PostViewController.h"

@interface PostFinaoListViewController : UIViewController<UITableViewDataSource,UITableViewDelegate,WebServiceDelegate>{
    
    NSMutableArray* arrFinaoList;
    UITableView* FinaosTable;
    NSIndexPath* lastIndexPath;
    BOOL isTablecellSelected;
    NSString* FinaoIDStr;
    
    PostFinaoUpdate* PostUpdate;
    //synthesis
    NSMutableArray* UpdateImages_names;
    NSMutableArray* UpdateImages_data;
    NSMutableArray* UpdateImages_caption;
    NSString* UploadUpdatedTxt;
}
@property(nonatomic,retain)NSMutableArray* UpdateImages_names;
@property(nonatomic,retain)NSMutableArray* UpdateImages_data;
@property(nonatomic,retain)NSMutableArray* UpdateImages_caption;
@property(nonatomic,retain)NSString* UploadUpdatedTxt;
@end
