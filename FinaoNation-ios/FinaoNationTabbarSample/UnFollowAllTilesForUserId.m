//
//  UnFollowAllTilesForUserId.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "UnFollowAllTilesForUserId.h"

@implementation UnFollowAllTilesForUserId

@synthesize FollowUsereListDic;

-(id)init
{
    
    return self;
}

-(void)UnFollowAllTilesUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID{
    // Needs testing  with new API.Current API is failing
    [APPDELEGATE showHToastCenter:@"UnFollowing..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice UnFollowAllTilesForUserId:followeduserId];
}

-(void)UnFollowAllTilesForUserId:(NSString*)userId;
{
    [APPDELEGATE showHToastCenter:@"UnFollowing..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice UnFollowAllTilesForUserId:(NSString*)userId];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA UnFOLLOWING : %@ ",data);
#endif
    self.FollowUsereListDic = [[NSMutableArray alloc]init];
    [APPDELEGATE hideHUD];
    if ([[data objectForKey:@"res"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
    }
    else
        if ([[data objectForKey:@"res"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FollowUsereListDic = [data objectForKey:@"res"];
        }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"UNFOLLOWUSERWITHTILE" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at UnFollow : %ld",(long)statusCode);
#endif
    [APPDELEGATE hideHUD];
}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    //NSLog(@"DATA array: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end
@end