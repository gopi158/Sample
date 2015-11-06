//
//  GetSearchFollowingList.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetSearchFollowingList.h"

@implementation GetSearchFollowingList

@synthesize FollowingListDic;
-(id)init
{
    
    return self;
}

-(void)GetSearchFollowingListFromServer:(NSString*)SearchUSRID
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetSearchFollowingListFromServer:SearchUSRID];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
       //NSLog(@"DATA FOLLOWING : %@ ",data);
#endif
    //;
    
    self.FollowingListDic = [[NSMutableArray alloc]init];
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FollowingListDic = [data objectForKey:@"item"];
        }
    
    
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETSEARCHFOLLOWINGLIST" object:self];
    
    
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
