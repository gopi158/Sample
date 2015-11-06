//
//  GetTiles.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetTiles.h"

@implementation GetTiles
@synthesize TilesListDic;
-(id)init
{
    
    return self;
}

-(void)GetTilesListFromServer
{
    [APPDELEGATE showHToastCenter:@"Loading..."];

    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetTilesListFromServer:[USERDEFAULTS valueForKey:@"userid"]];
    
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA TILES : %@ ",data);
#endif
    //;
    
    self.TilesListDic = [[NSMutableArray alloc]initWithCapacity:0];
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
//        self.TilesListDic = [data objectForKey:@"item"];

    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.TilesListDic = [data objectForKey:@"item"];
        }
    
    
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETTILESLIST" object:self];
    
    
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
