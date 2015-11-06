//
//  GetNumofList.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetNumofList.h"

@implementation GetNumofList

@synthesize ListDic;

-(id)init
{
    return self;
}

-(void)GetNumbers
{
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    //NSLog(@"[USERDEFAULTS valueForKey:@userid] : %@ ",[USERDEFAULTS valueForKey:@"userid"]);
    [webservice GetNumberList:[USERDEFAULTS valueForKey:@"userid"]];
    
}

-(void)GetNumbers:(NSString *)UserId
{
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    //NSLog(@"UserId : %@ ",UserId);
    [webservice GetNumberList:UserId];
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
#endif
    self.ListDic = [data objectForKey:@"item"];
     //NSLog(@"self.ListDic  : %@ ",self.ListDic );
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETLISTNUMBERS" object:self];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    [APPDELEGATE hideHUD];
}


#pragma mark WebDelegate end
@end
