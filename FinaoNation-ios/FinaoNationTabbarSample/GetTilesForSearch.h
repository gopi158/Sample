//
//  GetTilesForSearch.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetTilesForSearch : NSObject<WebServiceDelegate>{
    
    NSMutableArray* TilesListDic;
    
}

@property(nonatomic,retain)NSMutableArray* TilesListDic;
-(void)GetSearchTilesListFromServer:(NSString*)SearchUsrID;


@end
