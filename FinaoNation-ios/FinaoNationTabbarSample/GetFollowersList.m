//
//  GetFollowersList.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetFollowersList.h"

@implementation GetFollowersList
@synthesize FollowersListDic;
-(id)init
{
    return self;
}

-(void)GetFollowersListFromServer
{
    //[APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetFollowersListFromServer:[USERDEFAULTS valueForKey:@"userid"]];
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
        //NSLog(@"DATA FOLLOWERS : %@ ",data);
#endif
    //;
    if ([[data objectForKey:@"res"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
    }
    else
        if ([[data objectForKey:@"res"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FollowersListDic = [data objectForKey:@"res"];
        }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETFOLLOWERSLIST" object:self];
}


-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
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
