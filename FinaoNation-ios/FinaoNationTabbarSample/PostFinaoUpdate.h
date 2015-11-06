//
//  PostFinaoUpdate.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface PostFinaoUpdate : NSObject<WebServiceDelegate>
{
    NSDictionary* ListDic;
    
    //    NSMutableData *ReceivedwebData;
    //    NSURLConnection *URLConnection;
}

@property(nonatomic,retain)NSDictionary* ListDic;

-(void)PostImageForUpdateFinao:(NSString*)usrID ImgData:(NSMutableArray*)ImgData ImgName:(NSMutableArray*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSMutableArray*)CaptionData upload_text:(NSString*)upload_text;
@end