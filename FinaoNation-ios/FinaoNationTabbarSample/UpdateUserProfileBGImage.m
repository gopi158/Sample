//
//  UpdateUserProfileBGImage.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//


#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"
#import "UpdateUserProfileBGImage.h"

@implementation UpdateUserProfileBGImage


@synthesize ListDic;

-(id)init
{
    
    return self;
}

-(void)UpdateUserProfileBGImage:(NSData*)image
{
    [APPDELEGATE showHToastCenter:@"Updating Image..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice UpdateUserProfileBGImage:image];
    
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    //[APPDELEGATE hideHUD];
    
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
#endif
    
    
    if ([data  isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([data  isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
        }else
            if ([data  isKindOfClass:[NSDictionary class]]){
                
                //NSLog(@"DIC TYPE");
                self.ListDic = data;
                [[NSNotificationCenter defaultCenter] postNotificationName:@"PROFILEUPDATEBGIMAGESUCCESSFULL" object:self];;
            }
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at PostFinaoUpdate : %ld",(long)statusCode);
#endif
    
    //[APPDELEGATE hideHUD];
    
}


#pragma mark WebDelegate end

@end
