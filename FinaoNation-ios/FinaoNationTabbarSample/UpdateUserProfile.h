//
//  PostFinaoUpdate.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface UpdateUserProfile : NSObject<WebServiceDelegate>
{
    NSDictionary* ListDic;

}

@property(nonatomic,retain)NSDictionary* ListDic;

-(void)UpdateUserProfile:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData;
@end

