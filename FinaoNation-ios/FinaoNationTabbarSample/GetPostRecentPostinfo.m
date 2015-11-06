//
//  GetPostRecentPostinfo.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 04/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetPostRecentPostinfo.h"

@implementation GetPostRecentPostinfo

@synthesize FinaoListDic;

-(id)init
{
    return self;
}

-(void)GetPostInfo
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetRecentPosts];
}


-(void)GetPostInfoForUserId:(NSString *) userID
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetRecentPostsForUserId:userID];
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    //;
    
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
#endif
    
    //;
    
    if ([[data objectForKey:@"list"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FinaoListDic = [data objectForKey:@"item"];
            
            //NSLog(@"FinaoListDic:%@",self.FinaoListDic);
        }
    
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETPOSTSINFO" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    //;
    
#ifdef DEBUG
    //NSLog(@"StatusCode : %ld",(long)statusCode);
#endif
    
}

#pragma mark WebDelegate end
@end
