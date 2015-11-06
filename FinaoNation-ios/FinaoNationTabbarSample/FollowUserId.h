//
//  FollowUserId.h
//  FinaoNationTabbarSample
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 5/11/15.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface FollowUserId : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FollowUsereListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FollowUsereListDic;
-(void)FollowUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID;


@end
