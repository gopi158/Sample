//
//  DeletePost.h
//  FinaoNationTabbarSample
//
//  Created on 4/21/14.
//  Copyright (c) 2014. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Servermanager.h"
#import "AppConstants.h"

@interface DeletePost : NSObject<WebServiceDelegate>
{
    NSMutableArray* DeleteListDic;
}

@property(nonatomic,retain)NSMutableArray* DeleteListDic;
-(void)DeletePost:(NSString*)FinaoID withID:(NSString*)UserPostID;
@end

