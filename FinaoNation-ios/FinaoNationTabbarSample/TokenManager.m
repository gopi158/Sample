//
//  TokenManager.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 3/4/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TokenManager.h"

@implementation TokenManager

- (void)storeToken:(NSString *)authToken{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setObject:authToken forKey:@"base64str"];
    [defaults synchronize];
}

- (NSString *)recoverToken:(NSString *)authToken{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    return [defaults objectForKey:@"base64str"];
}
@end
