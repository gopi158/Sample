//
//  TermsViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 21/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TermsViewController.h"
#import "AppConstants.h"

@interface TermsViewController ()

@end

@implementation TermsViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        self.title  = @"Terms";
        

        
        UIImage *image = [UIImage imageNamed:@"logoheader.png"];
        self.navigationItem.titleView = [[UIImageView alloc] initWithImage:image];
        
    }
    return self;
}

-(void)AddblurredimageBG
{
    
    NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    NSString *documentsDirectory = [paths objectAtIndex:0];
    NSString *path = [documentsDirectory stringByAppendingPathComponent:@"Blurredimage.png"];
    
    if ([[NSFileManager defaultManager] fileExistsAtPath: path])
    {
        path = [documentsDirectory stringByAppendingPathComponent: [NSString stringWithFormat: @"Blurredimage.png"]];
        self.view.backgroundColor = [UIColor colorWithPatternImage:[[UIImage alloc] initWithContentsOfFile:path]];
        
    }
    
}
- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [self AddblurredimageBG]; // add the blurred image from profile screen shot


    
    UIImage *image = [UIImage imageNamed:@"logoheader.png"];
    self.navigationItem.titleView = [[UIImageView alloc] initWithImage:image];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = YES;
        
    }
    
    if (isiPhone5) {
        ShopwebView = [[UIWebView alloc] initWithFrame:CGRectMake(0, 70, 320,500)];
    }else{
        ShopwebView = [[UIWebView alloc] initWithFrame:CGRectMake(0, 80, 320,400)];
    }
    
    ShopwebView.scalesPageToFit = YES;
    //    ShopwebView.s
    ShopwebView.delegate = self;
    ShopwebView.backgroundColor = [UIColor clearColor];
    
    [ShopwebView loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:@"http://finaonation.com/profile/terms"]]];
    
    activity = [[UIActivityIndicatorView alloc]initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
    activity.frame = CGRectMake(140, 140, 40, 40);
    //    activity.backgroundColor = [UIColor lightGrayColor];
    [self.view addSubview:activity];
    [activity startAnimating];
    
}
-(void)viewWillDisappear:(BOOL)animated{
    
    [super viewWillDisappear:animated];
    

    self.tabBarController.tabBar.hidden = NO;
    [self.navigationController.navigationBar setBackgroundImage:nil forBarMetrics:UIBarMetricsDefault];
    self.navigationController.navigationBar.shadowImage = nil;
    
    self.navigationController.navigationBar.translucent = NO;
}

-(void)viewWillAppear:(BOOL)animated{
    
    [super viewWillAppear:animated];
    
    [self.navigationController.navigationBar setBackgroundImage:[UIImage new]
                                                  forBarMetrics:UIBarMetricsDefault];
    self.navigationController.navigationBar.shadowImage = [UIImage new];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = YES;
        
    }
    
    self.tabBarController.tabBar.hidden = YES;
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
#pragma mark -
#pragma mark UIWebViewDelegate

- (void)webViewDidStartLoad:(UIWebView *)webView
{
    // starting the load, show the activity indicator in the status bar
    [UIApplication sharedApplication].networkActivityIndicatorVisible = YES;
    
    [self.view addSubview:ShopwebView];
    [self.view bringSubviewToFront:activity];
    
}

- (void)webViewDidFinishLoad:(UIWebView *)webView
{
    // finished loading, hide the activity indicator in the status bar
    [UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
    [activity stopAnimating];
}

- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    // load error, hide the activity indicator in the status bar
    [UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
    UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO" message:@"Could not connect to shop." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert show];
    // report the error inside the webview
    //    NSString* errorString = [NSString stringWithFormat:
    //                             @"<html><center><font size=+5 color='red'>An error occurred:<br>%@</font></center></html>",
    //                             error.localizedDescription];
    //    [ShopwebView loadHTMLString:errorString baseURL:nil];
}

@end
