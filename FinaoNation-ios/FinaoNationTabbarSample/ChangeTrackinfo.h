//
//  ChangeTrackinfo.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 28/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface ChangeTrackinfo : NSObject<WebServiceDelegate>
{
}
-(void)ChangeTrackInfo:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status  isPublic:(NSString*)isPublic;
@end
