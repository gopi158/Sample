//
//  TilesViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GetTiles.h"
#import "GetTilesForSearch.h"
@interface TilesViewController : UIViewController<UICollectionViewDataSource,UICollectionViewDelegateFlowLayout>
{
    UICollectionView *_collectionView;
    GetTiles* gettiles;
    GetTilesForSearch *GetTilesListProfile;
    NSMutableArray* arrTiles;
    BOOL NOTiles;
    NSString* Userid;
    BOOL SelfUser;
}
@property(nonatomic,readwrite)BOOL SelfUser;
@property(nonatomic,retain)NSString* Userid;
@property(nonatomic,retain)NSString* imageurl;
@property(nonatomic,retain)NSString* FriendusrName;

@end
