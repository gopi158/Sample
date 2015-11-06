//
//  TokenManager.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 3/4/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface TokenManager : NSObject
- (void)storeToken:(NSString *)authToken;
- (NSString *)recoverToken:(NSString *)authToken;
@end
