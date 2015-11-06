//
//  GetFollowingList.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetFollowingList.h"

@implementation GetFollowingList
@synthesize FollowingListDic;
-(id)init
{
    
    return self;
}

-(void)GetFollowingListFromServer
{
    [APPDELEGATE showHToastCenter:@"Loading..."];

    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetFollowingListFromServer:[USERDEFAULTS valueForKey:@"userid"]];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA FOLLOWING : %@ ",data);
#endif
    //;
    self.FollowingListDic = [[NSMutableArray alloc]init];
    if ([[data objectForKey:@"res"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
    }
    else
    if ([[data objectForKey:@"res"] isKindOfClass:[NSArray class]]) {
        //NSLog(@"NSARRAY TYPE");
        self.FollowingListDic = [data objectForKey:@"res"];
    }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETFOLLOWINGLIST" object:self];
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
