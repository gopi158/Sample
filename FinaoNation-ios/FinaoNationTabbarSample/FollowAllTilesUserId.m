//
//  FollowAllTilesUserId.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 5/6/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FollowAllTilesUserId.h"

@implementation FollowAllTilesUserId

@synthesize FollowUsereListDic;

-(id)init
{
    
    return self;
}

-(void)FollowAllTilesUserId:(NSString*)followeduserId;
{
    [APPDELEGATE showHToastCenter:@"UnFollowing..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice FollowAllTilesUserId:(NSString*)followeduserId];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA FOLLOWING All tiles: %@ ",data);
#endif
    self.FollowUsereListDic = [[NSMutableArray alloc]init];
    //;
    if ([[data objectForKey:@"res"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
    }
    else
        if ([[data objectForKey:@"res"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FollowUsereListDic = [data objectForKey:@"res"];
        }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"FOLLOWUSERALLTILE" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at FOLLOWING All tiles : %ld",(long)statusCode);
#endif
    //;
}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    //NSLog(@"DATA array FOLLOWING All tiles: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end
@end