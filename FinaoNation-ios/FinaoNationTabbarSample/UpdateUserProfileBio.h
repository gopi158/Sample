//
//  UpdateUserProfileBio.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface UpdateUserProfileBio : NSObject<WebServiceDelegate>
{
    NSMutableDictionary* ListDic;
}

@property(nonatomic,retain)NSMutableDictionary* ListDic;
-(void)UpdateUserProfileBio:(NSString*)story;

@end
