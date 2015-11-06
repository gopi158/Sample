//
//  GetNotificationsCount.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetNotificationsCount : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FinaoListDic;
    
}

@property(nonatomic,retain)NSMutableArray* FinaoListDic;
-(void)GetNotificationsCount;

@end
