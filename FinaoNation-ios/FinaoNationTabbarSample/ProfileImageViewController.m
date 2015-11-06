//
//  ProfileImageViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 08/04/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileImageViewController.h"

@interface ProfileImageViewController ()

@property (nonatomic ,strong)UIImageView *navigationBarLogoImage;

@end

@implementation ProfileImageViewController

@synthesize profileImageUrl = profileImageUrl_;
@synthesize profileImage = _profileImage;
@synthesize navigationBarLogoImage = navigationBarLogoImage_;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.view.backgroundColor = [UIColor whiteColor];
    _profileImage = [[UIImageView alloc]initWithFrame:CGRectMake(0, 0, [[UIScreen mainScreen]bounds].size.width,[[UIScreen mainScreen]bounds].size.height)];
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.navigationBarLogoImage = [[UIImageView alloc]initWithFrame:CGRectMake(150, 10 , 20, 30)];
    
    self.navigationBarLogoImage.image = [UIImage imageNamed:@"logo_finao.png"];
    
    self.navigationBarLogoImage.tag  = 1;
    
    [self.navigationController.navigationBar addSubview:self.navigationBarLogoImage];
    
    self.navigationController.navigationBar.translucent = NO;
    
    _profileImage.image = [UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",self.profileImageUrl]]]];
    
    if([self respondsToSelector:@selector(edgesForExtendedLayout)])
        self.edgesForExtendedLayout = UIRectEdgeNone;
    
    [self.view addSubview:_profileImage];
}

-(void)viewWillDisappear:(BOOL)animated{
    [super viewWillDisappear:YES];
    self.navigationBarLogoImage = Nil;
    
    
    [[self.navigationController.navigationBar viewWithTag:1]removeFromSuperview];
    
    [self.navigationBarLogoImage removeFromSuperview];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];}

@end
