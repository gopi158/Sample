//
//  MakePrivtoPub.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 28/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "MakePrivtoPub.h"

@implementation MakePrivtoPub

-(id)init
{
    
    return self;
}

-(void)ChangePublictoPrivate:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status{
    [APPDELEGATE showHToastCenter:@"Updating..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice ChangePublictoPrivate:usrID Type:Type finaoid:finaoid status:status];
}



#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    [APPDELEGATE hideHUD];
    
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
#endif
    [[NSNotificationCenter defaultCenter] postNotificationName:@"CHANGEPRIVATETOPUBLIC" object:self];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode : %ld",(long)statusCode);
#endif
    
}


#pragma mark WebDelegate end
@end
