//
//  ChangeTrackinfo.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 28/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ChangeTrackinfo.h"

@implementation ChangeTrackinfo
-(id)init
{
    
    return self;
}

-(void)ChangeTrackInfo:(NSString*)usrID Type:(NSString*)Type finaoid:(NSString*)finaoid status:(NSString*)status  isPublic:(NSString*)isPublic{
    [APPDELEGATE showHToastCenter:@"Updating..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice ChangeTrackInfo:usrID Type:Type finaoid:finaoid status:status isPublic:isPublic];
}



#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{

#ifdef DEBUG
    NSLog(@"DATA : %@ ",data);
#endif
    [[NSNotificationCenter defaultCenter] postNotificationName:@"UPDATETRACKINFO" object:self];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode : %ld",(long)statusCode);
#endif

}


#pragma mark WebDelegate end
@end
