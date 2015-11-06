//
//  GetSearchFollowingList.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetSearchFollowingList : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FollowingListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FollowingListDic;
-(void)GetSearchFollowingListFromServer:(NSString*)SearchUSRID;

@end
