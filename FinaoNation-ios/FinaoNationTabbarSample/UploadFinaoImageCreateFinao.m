//
//  UploadFinaoImageCreateFinao.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 09/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "UploadFinaoImageCreateFinao.h"

@implementation UploadFinaoImageCreateFinao

@synthesize ListDic;
-(id)init
{
    
    return self;
}

-(void)PostImageForCreateFinao:(NSString*)usrID ImgData:(NSData*)ImgData ImgName:(NSString*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSString*)CaptionData upload_text:(NSString*)upload_text;
{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice PostImageCreateFinao:usrID ImgData:ImgData ImgName:ImgName Finaoid:FinaoID CaptionData:CaptionData upload_text:upload_text];
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    [APPDELEGATE hideHUD];
    
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
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
    [[NSNotificationCenter defaultCenter] postNotificationName:@"POSTIMAGETOSERVERDONE" object:self];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    
    //    [APPDELEGATE hideHUD];
    
}


#pragma mark WebDelegate end

@end
