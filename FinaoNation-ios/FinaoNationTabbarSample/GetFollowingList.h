//
//  GetFollowingList.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetFollowingList : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FollowingListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FollowingListDic;
-(void)GetFollowingListFromServer;

@end
