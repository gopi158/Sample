//
//  FollowUserId.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 5/11/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FollowUserId.h"

@implementation FollowUserId

@synthesize FollowUsereListDic;

-(id)init
{
    
    return self;
}

-(void)FollowUserId:(NSString*)followeduserId withTileId:(NSString*)tileID;
{
    [APPDELEGATE showHToastCenter:@"Following..."];
    
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice FollowUserId:(NSString*)followeduserId  withTileId:(NSString*)tileID];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA FOLLOWING : %@ ",data);
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
    [[NSNotificationCenter defaultCenter] postNotificationName:@"FOLLOWUSERWITHTILE" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at Follow : %ld",(long)statusCode);
#endif
    //;
}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    //NSLog(@"DATA array: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end
@end
