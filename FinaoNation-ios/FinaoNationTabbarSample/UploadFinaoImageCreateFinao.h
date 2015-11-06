//
//  UploadFinaoImageCreateFinao.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 09/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface UploadFinaoImageCreateFinao : NSObject<WebServiceDelegate>
{
    NSDictionary* ListDic;
    
//    NSMutableData *ReceivedwebData;
//    NSURLConnection *URLConnection;
}

@property(nonatomic,retain)NSDictionary* ListDic;

-(void)PostImageForCreateFinao:(NSString*)usrID ImgData:(NSData*)ImgData ImgName:(NSString*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text;

@end

