//
//  GetInspiredinfo.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 04/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetInspiredinfo.h"

@implementation GetInspiredinfo


@synthesize InspiredListDic;

-(id)init
{
    
    return self;
}

-(void)GetInspiredInfo
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetInspiredForId:@""];
    
}


-(void)GetInspiredForId:(NSString *) ID
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetInspiredForId:ID];
    
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
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETINSPIREDINFO" object:self];
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
