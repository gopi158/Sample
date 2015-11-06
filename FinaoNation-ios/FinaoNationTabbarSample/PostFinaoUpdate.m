//
//  PostFinaoUpdate.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "PostFinaoUpdate.h"

@implementation PostFinaoUpdate

@synthesize ListDic;

-(id)init
{
    
    return self;
}

-(void)PostImageForUpdateFinao:(NSString*)usrID ImgData:(NSMutableArray*)ImgData ImgName:(NSMutableArray*)ImgName Finaoid:(NSString*)FinaoID CaptionData:(NSMutableArray*)CaptionData upload_text:(NSString*)upload_text
{
    
    NSData *jsonData2 = [NSJSONSerialization dataWithJSONObject:CaptionData options:NSJSONWritingPrettyPrinted error:nil];
    NSString *jsonString = [[NSString alloc] initWithData:jsonData2 encoding:NSUTF8StringEncoding];
    NSLog(@"jsonData as string:\n%@", jsonString);
    [APPDELEGATE showHToastCenter:@"Updating..."];
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice PostImagesUpdateFinao:usrID ImgData:ImgData ImgName:ImgName Finaoid:FinaoID CaptionData:jsonString upload_text:upload_text];
    
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
    [[NSNotificationCenter defaultCenter] postNotificationName:@"POSTWASSUCCESSFULL" object:self];
    [[NSNotificationCenter defaultCenter] postNotificationName:@"REMOVEPOSTIMAGESPOSTSUBMITTED" object:self];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at PostFinaoUpdate : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];
    
}


#pragma mark WebDelegate end

@end
