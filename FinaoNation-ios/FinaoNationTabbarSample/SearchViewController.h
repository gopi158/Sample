//
//  SearchViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"

@interface SearchViewController : UIViewController<UISearchBarDelegate,UITableViewDelegate,UITableViewDataSource,WebServiceDelegate,UIGestureRecognizerDelegate>
{
    UITableView* SearchTable;
    UISearchBar *sBar;
    
    NSMutableArray* SearchArrayList;
    
    NSString* SearchTxtStr;
    Servermanager* webservice;
    BOOL NOSEARCHITEMS;
}
@property (nonatomic, retain) NSString * url;
@end
