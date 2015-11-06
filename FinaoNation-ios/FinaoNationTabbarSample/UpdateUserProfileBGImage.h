//
//  UpdateUserProfileImage.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//


#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"


@interface UpdateUserProfileBGImage : NSObject<WebServiceDelegate>
{
    NSDictionary* ListDic;
    
}

@property(nonatomic,retain)NSDictionary* ListDic;

-(void)UpdateUserProfileBGImage:(NSData*)image;

@end
