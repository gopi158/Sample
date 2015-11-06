//
//  GetFinaoForSearch.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface GetFinaoForSearch : NSObject<WebServiceDelegate>{
    
    NSMutableArray* FinaoListDic;
    NSString* PassesUsrid;
}
@property(nonatomic,retain)NSString* PassesUsrid;
@property(nonatomic,retain)NSMutableArray* FinaoListDic;
-(void)GetSearchFinaoListFromServer:(NSString*)SearchUsrID;

@end
