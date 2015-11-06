//
//  ViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 1/15/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface QRWebViewController : UIViewController <UIWebViewDelegate>

@property(nonatomic, strong) NSString *urlAddress;
@property (nonatomic, strong) UIWebView *webView;
@property (nonatomic, strong) NSURL *URL;

@end
