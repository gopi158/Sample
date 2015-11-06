//
//  LoginRegisterViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "LoginRegisterViewController.h"
#import "LoginViewController.h"
#import "RegisterViewController.h"
#import "TokenManager.h"

@interface LoginRegisterViewController ()

@end

@implementation LoginRegisterViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    self.navigationController.navigationBarHidden = YES;
}


- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view from its nib.
    
    UIImageView* imageview = [[UIImageView alloc]initWithFrame:CGRectMake(90, 100, 150, 200)];
    imageview.image = [UIImage imageNamed:@"GetStartedImage-black"];
    imageview.backgroundColor = [UIColor clearColor];
    [self.view addSubview:imageview];
    
    UIButton* Loginbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Loginbtn.frame = CGRectMake(75,350,194,40);
    [Loginbtn setTitle:@"Login" forState:UIControlStateNormal];
    [Loginbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
//    Loginbtn.backgroundColor = [UIColor orangeColor];
    Loginbtn.layer.borderWidth = 2.0f;
    Loginbtn.layer.borderColor = [UIColor orangeColor].CGColor;
    [Loginbtn addTarget:self action:@selector(Loginbtnclicked:) forControlEvents:UIControlEventTouchUpInside];
    Loginbtn.showsTouchWhenHighlighted = YES;
    [Loginbtn setHighlighted:NO];
    [self.view addSubview:Loginbtn];

    UIButton* Registrationbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Registrationbtn.frame = CGRectMake(75,400,194,40);
    [Registrationbtn setTitle:@"Register" forState:UIControlStateNormal];
    [Registrationbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
//    Registrationbtn.backgroundColor = [UIColor orangeColor];
    Registrationbtn.showsTouchWhenHighlighted = YES;
    Registrationbtn.layer.borderWidth = 2.0f;
    Registrationbtn.layer.borderColor = [UIColor orangeColor].CGColor;
    [Registrationbtn addTarget:self action:@selector(Registrationbtnclicked) forControlEvents:UIControlEventTouchUpInside];
    //Registrationbtn.layer.borderColor = [UIColor blackColor].CGColor;
    
    [self.view addSubview:Registrationbtn];
}
-(void)Registrationbtnclicked{

    RegisterViewController* reg = [[RegisterViewController alloc]initWithNibName:@"RegisterViewController" bundle:nil];
    [self.navigationController pushViewController:reg animated:YES];
}

-(void)Loginbtnclicked:(id)sender{
    
//    [sender setHighlighted:NO];
    LoginViewController* login = [[LoginViewController alloc]initWithNibName:@"LoginViewController" bundle:nil];
    [self.navigationController pushViewController:login animated:YES];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];}

@end
