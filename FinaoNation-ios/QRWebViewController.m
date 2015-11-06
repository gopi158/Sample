//
//  ViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 1/15/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "QRWebViewController.h"

@interface QRWebViewController ()

@end

@implementation QRWebViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.view = self.webView;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
  
    self.URL = [NSURL URLWithString:self.urlAddress];
    [self loadURL:self.URL];
}
- (void)loadURL:(NSURL *)pageURL {
    [self.webView loadRequest:[NSURLRequest requestWithURL:pageURL]];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Getters

- (UIWebView*)webView {
    if(!_webView) {
        _webView = [[UIWebView alloc] initWithFrame:[UIScreen mainScreen].bounds];
        _webView.delegate = self;
        _webView.scalesPageToFit = YES;
    }
    return _webView;
}


#pragma mark - UIWebViewDelegate

- (void)webViewDidStartLoad:(UIWebView *)webView {
    [[UIApplication sharedApplication] setNetworkActivityIndicatorVisible:YES];
}


- (void)webViewDidFinishLoad:(UIWebView *)webView {
    [[UIApplication sharedApplication] setNetworkActivityIndicatorVisible:NO];
    
    self.navigationItem.title = [webView stringByEvaluatingJavaScriptFromString:@"document.title"];
}

- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error {
    [[UIApplication sharedApplication] setNetworkActivityIndicatorVisible:NO];
}
@end
