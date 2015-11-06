//
//  GetInspiredFromPost.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 04/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetInspiredFromPost.h"

@implementation GetInspiredFromPost

@synthesize InspiredListDic;

-(id)init
{
    
    return self;
}

-(void)GetInspiredFromPost
{
    [APPDELEGATE showHToastCenter:@"Inspired..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetInspiredFromPost:@""];
    
}


-(void)GetInspiredFromPost:(NSString *) ID
{
    [APPDELEGATE showHToastCenter:@"Inspired..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetInspiredFromPost:ID];
    
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
            self.InspiredListDic = [data objectForKey:@"item"];
            
            //NSLog(@"InspiredListDic:%@",self.InspiredListDic);
        }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETINSPIREDFROMPOST" object:self];
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

