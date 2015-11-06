//
//  CreateFinaoPost.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface CreateFinaoPost : NSObject<WebServiceDelegate>
{
    NSDictionary* ListDic;
    
}
-(void)GetFinaoID:(NSString*)usrID Public:(BOOL)Public FinaoText:(NSString*)FinaoTxt TileID:(NSString*)TileID TileName:(NSString*)TileName CaptionTxt:(NSString*)CaptionTxt;
@property(nonatomic,retain)NSDictionary* ListDic;
@end

