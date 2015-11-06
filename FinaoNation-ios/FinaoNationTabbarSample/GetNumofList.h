//
//  GetNumofList.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetNumofList : NSObject<WebServiceDelegate>
{
    NSArray* ListDic;

}
-(void)GetNumbers;
-(void)GetNumbers:(NSString *)UserId;
@property(nonatomic,retain)NSArray* ListDic;
@end
