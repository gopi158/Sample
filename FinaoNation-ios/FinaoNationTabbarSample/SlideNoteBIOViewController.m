//
//  SlideNoteBIOViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SlideNoteBIOViewController.h"
#import "AppConstants.h"
#import "UpdateUserProfileBio.h"

@interface SlideNoteBIOViewController ()

@end

@implementation SlideNoteBIOViewController

UITextView* tv;
UpdateUserProfileBio * updateUserProfileBio;
NSMutableDictionary* ListDic;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Update Bio";
    }
    return self;
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    tv.text = [USERDEFAULTS valueForKey:@"mystory"];
    self.tabBarController.tabBar.hidden = YES;
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UpdateFinished:)
                                                 name:@"PROFILEBIOUPDATEWASSUCCESSFULL"
                                               object:nil];
}

-(void)UpdateFinished: (NSNotification *)notification 
{
    ListDic = updateUserProfileBio.ListDic;
    [USERDEFAULTS setValue:tv.text forKey:@"mystory"];
    [self.navigationController popViewControllerAnimated:YES];
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
    self.tabBarController.tabBar.hidden = YES;

    [self AddblurredimageBG];
    
    [self.navigationController.navigationBar setBackgroundImage:[UIImage new]
                                                  forBarMetrics:UIBarMetricsDefault];
    self.navigationController.navigationBar.shadowImage = [UIImage new];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = YES;
        
    }
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemDone target:self action:@selector(DoneClicked)];
    
    tv = [[UITextView alloc]initWithFrame:CGRectMake(10, 10, 300, 200) textContainer:nil];
    tv.delegate = self;
    tv.backgroundColor = [UIColor clearColor];
    tv.editable = YES;
    tv.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
    [self.view addSubview:tv];
    
    tv.text = [USERDEFAULTS valueForKey:@"mystory"];
    
    [tv becomeFirstResponder];
    

}
-(void)viewWillDisappear:(BOOL)animated{
    
    [super viewWillDisappear:animated];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"PROFILEBIOUPDATEWASSUCCESSFULL" object:nil];
}


-(void)DoneClicked{

    NSLog(@"DoneClicked");
    NSString* updatedBio = tv.text;
    [self UpdateUserProfileBio:updatedBio];
}

-(void)UpdateUserProfileBio:(NSString*)story
{
    [APPDELEGATE showHToastCenter:@"Updating..."];
    updateUserProfileBio = [[UpdateUserProfileBio alloc] init];
    [updateUserProfileBio UpdateUserProfileBio:story];
    
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
