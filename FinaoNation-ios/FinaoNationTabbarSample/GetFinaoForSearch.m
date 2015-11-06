//
//  GetFinaoForSearch.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetFinaoForSearch.h"

@implementation GetFinaoForSearch
@synthesize FinaoListDic;
@synthesize PassesUsrid;
-(id)init
{
    
    return self;
}

-(void)GetSearchFinaoListFromServer:(NSString*)SearchUsrID
{
    self.FinaoListDic = [[NSMutableArray alloc]init];
    
    [APPDELEGATE showHToastCenter:@"Loading..."];
    
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetSearchFinaoListFromServer:SearchUsrID USERID:PassesUsrid];
    
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"SEARCH FINAO LIST : %@ ",data);
#endif
    //;
    
    
    //NSLog(@"%lu",(unsigned long)[self.FinaoListDic count]);
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.FinaoListDic = [data objectForKey:@"item"];
        }
    
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETSEARCHFINAOLIST" object:self];
    
    
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
