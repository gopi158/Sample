//
//  ServiceCallsManager.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 24/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ServiceCallsManager.h"
#import "AppConstants.h"

static ServiceCallsManager *sharedMyManager = nil;


@implementation ServiceCallsManager
+ (id)sharedManager
{
	@synchronized(self)
    {
//		if(sharedMyManager == nil)
//        {
//            sharedMyManager = nil;
//			sharedMyManager = [[super allocWithZone:NULL] init];
//        }
        if (nil != sharedMyManager) {
            return sharedMyManager;
        }
        
        static dispatch_once_t pred;        // Lock
        dispatch_once(&pred, ^{             // This code is called at most once per app
            sharedMyManager = [[super allocWithZone:NULL] init];
        });
    }
	return sharedMyManager;
}
- (id)init {
    if (self = [super init]) {
    NSString* plistPath = [[NSBundle mainBundle] pathForResource:@"ServerCallsmanagerURL" ofType:@"plist"];
    _configuration  = [[NSDictionary alloc]initWithContentsOfFile:plistPath];
    }
    return self;
}


+ (id)allocWithZone:(NSZone *)zone {
	return [self sharedManager];
}

-(NSString*)returnLoginURL{

    return [NSString stringWithFormat:@"%@api.php",BASEURL];
}

-(NSString*)GetBaseURLFromPlist{
    
    NSString *returnString = [self.configuration valueForKey:@"BaseUrl"];
    //    returnString = [returnString stringByAppendingString:[self.configuration valueForKey:@"LoginEndPoint"]];
    //    returnString = [returnString stringByAppendingString:[self.configuration valueForKey:@"LoginParameters"]];
    return returnString;
}

-(NSString*)LoginURLFromPlist{

    NSString *returnString = [self.configuration valueForKey:@"BaseUrl"];
//    returnString = [returnString stringByAppendingString:[self.configuration valueForKey:@"LoginEndPoint"]];
//    returnString = [returnString stringByAppendingString:[self.configuration valueForKey:@"LoginParameters"]];
    return returnString;
}

@end
