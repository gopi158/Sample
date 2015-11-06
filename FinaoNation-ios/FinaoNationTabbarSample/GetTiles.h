//
//  GetTiles.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetTiles : NSObject<WebServiceDelegate>{
    
    NSMutableArray* TilesListDic;
    
}

@property(nonatomic,retain)NSMutableArray* TilesListDic;
-(void)GetTilesListFromServer;

@end


