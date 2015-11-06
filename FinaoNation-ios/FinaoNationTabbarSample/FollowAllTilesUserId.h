//
//
//  FollowAllTilesUserId.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"
#import "FollowAllTilesUserId.h"

@interface FollowAllTilesUserId : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FollowUsereListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FollowUsereListDic;
-(void)FollowAllTilesUserId:(NSString*)followeduserId;


@end
