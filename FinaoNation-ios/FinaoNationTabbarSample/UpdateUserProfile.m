//
//  UpdateUserProfile.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "UpdateUserProfile.h"

@implementation UpdateUserProfile

@synthesize ListDic;

-(id)init
{
    
    return self;
}

-(void)UpdateUserProfile:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData;
{
    [APPDELEGATE showHToastCenter:@"Updating..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice UpdateUserProfile:(NSString*)Profilename Name:(NSString*)name Story:(NSString*)story  ProfileImage:(NSData*)ProfileImgData ProfileBGName:(NSString*)ProfileBgname  ProfileBGImage:(NSData*)ProfileBGImgData];
    
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    [APPDELEGATE hideHUD];
    
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
                [[NSNotificationCenter defaultCenter] postNotificationName:@"PROFILEUPDATEWASSUCCESSFULL" object:self];;
            }
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at PostFinaoUpdate : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];
    
}


#pragma mark WebDelegate end

@end
