//
//  ServiceCallsManager.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 24/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface ServiceCallsManager : NSObject{

}
@property(nonatomic, strong) NSDictionary *configuration;
//Making server manager a singleton class
+ (id)sharedManager;
-(NSString*)GetBaseURLFromPlist;
-(NSString*)LoginURLFromPlist;
-(NSString*)returnLoginURL;//REMOVE THIS AFTER EVERYTHING IS COMPLETED
@end
