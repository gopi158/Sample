//
//  GetPostRecentPostinfo.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 04/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"
@interface GetPostRecentPostinfo : NSObject<WebServiceDelegate>
{
    NSMutableArray* FinaoListDic;
}

@property(nonatomic,retain)NSMutableArray* FinaoListDic;
-(void)GetPostInfo;
-(void)GetPostInfoForUserId:(NSString *) userID;
@end
