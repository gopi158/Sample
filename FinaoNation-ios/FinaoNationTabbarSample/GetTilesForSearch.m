//
//  GetTilesForSearch.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "GetTilesForSearch.h"

@implementation GetTilesForSearch
@synthesize TilesListDic;
-(id)init
{
    
    return self;
}

-(void)GetSearchTilesListFromServer:(NSString*)SearchUsrID
{
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
//    [webservice GetSearchTilesListFromServer:SearchUsrID];
    [webservice GetSearchTilesListFromServer:SearchUsrID];
    
}


#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA TILES : %@ ",data);
#endif
    [APPDELEGATE hideHUD];
    
    //self.TilesListDic = [[NSMutableArray alloc]init];
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            self.TilesListDic = [data objectForKey:@"item"];
        }
    
    
    [[NSNotificationCenter defaultCenter] postNotificationName:@"GETSEARCHTILESLIST" object:self];
    
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];

}
-(void)webServiceFinishWithArray:(NSMutableArray *)data withError:(NSError *) error{
    
#ifdef DEBUG
    //NSLog(@"DATA array: %@ ",data);
#endif
    
}

#pragma mark WebDelegate end

@end
