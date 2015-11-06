//
//  MenuViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 06/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "MenuViewController.h"

@interface MenuViewController ()

@end

@implementation MenuViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
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
        self.view.backgroundColor = [UIColor colorWithPatternImage:[[UIImage alloc] initWithContentsOfFile:path]];
        
        UIImageView *tempImageView = [[UIImageView alloc]init];
        tempImageView.image = [[UIImage alloc] initWithContentsOfFile:path];
        [tempImageView setFrame:table.frame];
        
        table.backgroundView = tempImageView;
    }
    else{
        
        [USERDEFAULTS setBool:NO forKey:@"BlurredImage"];
    }
    
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
    
    self.tabBarController.tabBar.hidden = YES;
    [self.navigationController.navigationBar setBackgroundImage:[UIImage new]
                                                  forBarMetrics:UIBarMetricsDefault];
    self.navigationController.navigationBar.shadowImage = [UIImage new];
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = YES;
        
    }
    
}
-(void)DoneClicked{
    
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    
    [self AddblurredimageBG]; // add the blurred image from profile screen shot
    
    
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemDone target:self action:@selector(DoneClicked)];
    
    arr = [NSArray arrayWithObjects:@"My profile",@"Settings",@"Notifications",@"Shop", @"Video: About FINAO", @"Video: What is a FINAO", @"Logout", nil];
    
    if (isiPhone5) {
        table = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 600) style:UITableViewStylePlain];
    }else{
        table = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 500) style:UITableViewStylePlain];
    }
    table.delegate = self;
    table.dataSource = self;
    [self.view addSubview:table];
    
    table.backgroundColor = [UIColor clearColor];
    
    //Adding the image to the footer
    UIView *fView = [[UIView alloc] initWithFrame:CGRectMake(0, 10, 239, 200)];
    UIImageView* imageview = [[UIImageView alloc]initWithFrame:CGRectMake(90, 10, 120, 150)];
    imageview.image = [UIImage imageNamed:@"GetStartedImage-black"];
    [fView addSubview:imageview];
    table.tableFooterView = fView;
    
    
}

#pragma mark -
#pragma mark Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
    return 1;
}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    return [arr count];
}


- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 36.0f;
}

- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    
    UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
    
    cell.textLabel.text = [arr objectAtIndex:indexPath.row];
    
    if (indexPath.row != [arr count]-1) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    
    cell.selectionStyle= UITableViewCellSelectionStyleNone;
    cell.backgroundColor = [UIColor clearColor];
    return cell;
}

#pragma mark -
#pragma mark Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    
    if (indexPath.row == 0) {
        //profile page
        SlideNoteViewController* slide = [[SlideNoteViewController alloc]initWithNibName:@"SlideNoteViewController" bundle:nil];
        [self.navigationController pushViewController:slide animated:YES];
    }
    
    else if (indexPath.row == 1) {
        SettingsViewController *settings = [[SettingsViewController alloc]initWithNibName:@"SettingsViewController" bundle:nil];
        [self.navigationController pushViewController:settings animated:YES];
    }
    else if (indexPath.row == 2) {
        NotificationViewController *notif = [[NotificationViewController alloc]init];
        [self.navigationController pushViewController:notif animated:YES];
    }
    
    
    else if (indexPath.row == 3) {
        ShopViewController *shop = [[ShopViewController alloc]initWithNibName:@"ShopViewController" bundle:nil];
        [shop setTheURL:@"http://finaogear.com/"];
        [self.navigationController pushViewController:shop animated:YES];
    }
    
    else if (indexPath.row == 4) { // About FINAO
        APPViewController *appviewController = [[APPViewController alloc] initWithNibName:@"APPViewController" bundle:nil];
        NSURL *vidUrl = [NSURL URLWithString:@"http://503e51859492bd1db4c8-1c5fc9a4b7622394621a8967c79cf921.r53.cf2.rackcdn.com/FINAO_H264_1080P_HQ.mp4"];
        [appviewController setMovieURL:vidUrl];
        [self.navigationController pushViewController:appviewController animated:YES];
        
    }
    
    else   if (indexPath.row == 5) { // Whatt is a FINAO
        APPViewController *appviewController = [[APPViewController alloc] initWithNibName:@"APPViewController" bundle:nil];
        NSURL *vidUrl = [NSURL URLWithString:@"http://503e51859492bd1db4c8-1c5fc9a4b7622394621a8967c79cf921.r53.cf2.rackcdn.com/Whats_FINAO.mp4"];
        [appviewController setMovieURL:vidUrl];
        [self.navigationController pushViewController:appviewController animated:YES];
    }
    
    else  if (indexPath.row == 6) {
        
        UIAlertView* alert  = [[UIAlertView alloc]initWithTitle:@"FINAO" message:@"You really want to Logout." delegate:self cancelButtonTitle:@"No" otherButtonTitles:@"Yes", nil];
        [alert show];
    }
}
-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    
    if (buttonIndex == 1) {
        
        //NSLog(@"Loggedin:%@",[USERDEFAULTS valueForKey:@"Loggedin"]);
        LoginViewController* login = [[LoginViewController alloc]initWithNibName:@"LoginViewController" bundle:nil];
        [self presentViewController:login animated:YES completion:nil];
        
    }
    
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
