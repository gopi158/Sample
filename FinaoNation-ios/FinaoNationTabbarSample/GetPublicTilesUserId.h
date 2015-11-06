//
//  GetPublicTilesUserId.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"
#import "FollowAllTilesUserId.h"

@interface GetPublicTilesUserId : NSObject<WebServiceDelegate>{
    
    NSMutableArray* PublicTilesForUserId;
    
}

@property(nonatomic,retain)NSMutableArray* PublicTilesForUserId;
-(void)GetPublicTilesUserId:(NSString*)followeduserId;


@end

