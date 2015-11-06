//
//  GetUnInspiredFromPost.h
//  FinaoNationTabbarSample
//
//  Created on 4/21/14.
//  Copyright (c) 2014. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetUnInspiredFromPost : NSObject<WebServiceDelegate>
{
    NSMutableArray* InspiredListDic;
}

@property(nonatomic,retain)NSMutableArray* InspiredListDic;
-(void)GetUnInspiredFromPost;
-(void)GetUnInspiredFromPost:(NSString *)ID;
@end

