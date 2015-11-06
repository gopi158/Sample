//
//  GetNotificationInfo.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetNotificationInfo.h"

@implementation GetNotificationInfo

@synthesize FinaoListDic;
-(id)init
{
    
    return self;
}

-(void)GetNotifications
{
    self.FinaoListDic = [[NSMutableArray alloc]init];
    
    //[APPDELEGATE showHToastCenter:@"Getting Notifications..."];
    
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetNotifications];
    
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    ////NSLog(@"DATA Notifications LIST: %@ ",data);
#endif
    //;
    
    if ([[data objectForKey:@"list"] isKindOfClass:[NSString class]]) {
        ////NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            ////NSLog(@"NSARRAY TYPE");
            self.FinaoListDic = [data objectForKey:@"item"];
        }
    
    ////NSLog(@"%lu",(unsigned long)[self.FinaoListDic count]);
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETNOTIFICATIONSINFO" object:self];
    
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    ////NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    //;
}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    ////NSLog(@"DATA array: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end
@end
