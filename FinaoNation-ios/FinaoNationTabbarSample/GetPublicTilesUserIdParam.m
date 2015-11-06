//
//  GetPublicTilesUserId.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetPublicTilesUserId.h"

@implementation GetPublicTilesUserId

@synthesize PublicTilesForUserId;

-(id)init
{
    
    return self;
}

-(void)GetPublicTilesUserId:(NSString*)followeduserId;
{
    [APPDELEGATE showHToastCenter:@"Refreshing..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetPublicTilesUserId:(NSString*)followeduserId];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA GetPublicTilesUserId: %@ ",data);
#endif
    self.PublicTilesForUserId = [[NSMutableArray alloc]init];
    //;
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.PublicTilesForUserId = [data objectForKey:@"item"];
        }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETPUBLICTILESUSERID" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode GetPublicTilesUserId : %ld",(long)statusCode);
#endif
    //;
}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    //NSLog(@"DATA array GetPublicTilesUserId: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end
@end
