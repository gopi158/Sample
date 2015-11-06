//
//  ShopViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 19/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ShopViewController : UIViewController<UIWebViewDelegate>
{
    UIWebView* ShopwebView;
    UIActivityIndicatorView* activity;
    NSString * theURL;
}
@property(nonatomic, strong) NSString * theURL;
@end
