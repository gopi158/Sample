//
//  UnFollowAllTilesForUserId.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface UnFollowAllTilesForUserId : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FollowUsereListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FollowUsereListDic;
-(void)UnFollowAllTilesUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID;
-(void)UnFollowAllTilesForUserId:(NSString*)userId;


@end
