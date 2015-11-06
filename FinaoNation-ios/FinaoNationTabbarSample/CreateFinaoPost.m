//
//  CreateFinaoPost.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "CreateFinaoPost.h"

@implementation CreateFinaoPost
@synthesize ListDic;

-(id)init
{
    
    return self;
}

-(void)GetFinaoID:(NSString*)usrID Public:(BOOL)Public FinaoText:(NSString*)FinaoTxt TileID:(NSString*)TileID TileName:(NSString*)TileName CaptionTxt:(NSString*)CaptionTxt
{
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice CreateFinao:usrID Public:Public FinaoText:FinaoTxt TileID:TileID TileName:TileName CaptionTxt:CaptionTxt];
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    NSLog(@"DATA : %@ ",data);
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
            }
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETFINAOID" object:self];

}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif

}


#pragma mark WebDelegate end
@end
