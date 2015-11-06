//
//  SettingsViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 07/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SettingsViewController.h"

@interface SettingsViewController ()

@end

@implementation SettingsViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Settings";
    }
    return self;
}
-(void)DoneClicked{
    
}

-(void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
    
}

-(void)AddblurredimageBG
{
    
    NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    NSString *documentsDirectory = [paths objectAtIndex:0];
    NSString *path = [documentsDirectory stringByAppendingPathComponent:@"Blurredimage.png"];
    
    if ([[NSFileManager defaultManager] fileExistsAtPath: path])
    {
        self.view.backgroundColor = [UIColor colorWithPatternImage:[[UIImage alloc] initWithContentsOfFile:path]];
    }
    UIImageView *tempImageView = [[UIImageView alloc]init];
    tempImageView.image = [[UIImage alloc] initWithContentsOfFile:path];
    [tempImageView setFrame:table.frame];
    
    table.backgroundView = tempImageView;
}

-(void)viewWillDisappear:(BOOL)animated{
    
    [super viewWillDisappear:animated];
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

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    
    [self AddblurredimageBG];
    
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    self.navigationController.navigationBar.backgroundColor = [UIColor clearColor];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemDone target:self action:@selector(DoneClicked)];
    
    arr = [NSArray arrayWithObjects:@"Notification Settings",@"Terms and Conditions",@"", nil];
    
    table = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 500) style:UITableViewStylePlain];
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
    // Return the number of sections.
    return 1;
}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    // Return the number of rows in the section.
    return [arr count];
}


// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    
	
    UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
    
    // Make cell unselectable
	cell.selectionStyle = UITableViewCellSelectionStyleNone;
    cell.backgroundColor = [UIColor clearColor];
    
    if (indexPath.row != [arr count]-1) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    
    cell.textLabel.text = [arr objectAtIndex:indexPath.row];
    cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
    
    return cell;
}


#pragma mark -
#pragma mark Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    
    if (indexPath.row == 0) {
        NotificationSettingsViewController* notifSettings = [[NotificationSettingsViewController alloc]initWithNibName:@"NotificationSettingsViewController" bundle:nil];
        [self.navigationController pushViewController:notifSettings animated:YES];
    }
    if (indexPath.row == 1) {
        TermsViewController* terms = [[TermsViewController alloc]initWithNibName:@"TermsViewController" bundle:nil];
        [self.navigationController pushViewController:terms animated:YES];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
