//
//  SlideNoteViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SlideNoteViewController.h"
#import "SlideNoteBIOViewController.h"
#import "MenuCell.h"
#import "AppConstants.h"
#import "UIImageView+AFNetworking.h"
#import "TagnoteViewController.h"
#import "ProfileImageViewController.h"
#import "ProfileImageEditViewController.h"
#import "ProfileBGImageEditViewController.h"
//#import "MFSideMenuContainerViewController.h"

@interface SlideNoteViewController ()

@end

@implementation SlideNoteViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"My profile";
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
        path = [documentsDirectory stringByAppendingPathComponent: [NSString stringWithFormat: @"Blurredimage.png"]];
        self.view.backgroundColor = [UIColor colorWithPatternImage:[[UIImage alloc] initWithContentsOfFile:path]];
        
        UIImageView *tempImageView = [[UIImageView alloc]init];
        tempImageView.image = [[UIImage alloc] initWithContentsOfFile:path];
        [tempImageView setFrame:table.frame];
        
        table.backgroundView = tempImageView;
    }
    
}

-(void)viewWillDisappear:(BOOL)animated{
    
    [super viewWillDisappear:animated];
    
    self.tabBarController.tabBar.hidden = NO;
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
    [table reloadData];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self AddblurredimageBG];
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    self.navigationController.navigationBar.backgroundColor = [UIColor clearColor];
    arr = [NSArray arrayWithObjects:@"Name",@"Picture",@"Banner",@"Tagnote",@"Bio",@"", nil];
    
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


- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    MenuCell *cell = (MenuCell *)[tableView dequeueReusableCellWithIdentifier:@"MenuCell"];
    
    if(cell == nil)
        cell = [[MenuCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"aCell"];
    
	cell.selectionStyle = UITableViewCellSelectionStyleNone;
    
    
    UITextField* tf = nil ;
    
    if (indexPath.row == 0)
    {
        cell.textLabel.text = [arr objectAtIndex:indexPath.row];
        cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
        NSString* UsernameStr = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
        
        tf = UserNameTxtfld = [self makeTextField:UsernameStr placeholder:@"Username"];
        [cell addSubview:UserNameTxtfld];
        
        tf.frame = CGRectMake(70, 12, 220, 30);
        tf.enabled = YES;
        tf.font =  [UIFont fontWithName:@"HelveticaNeue-Light"  size:15.0f];
        
        tf.delegate = self ;
        return cell;
    }
    if (indexPath.row == 1) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        cell.textLabel.text = [arr objectAtIndex:indexPath.row];
        cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
        NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_image"]];
        
        [cell.imageView setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"chooseimg"]];
        
        return cell;
    }
    
    if (indexPath.row == 2) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        cell.textLabel.text = [arr objectAtIndex:indexPath.row];
        cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
        
        
        
        NSString* bgimageUrl = [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_bg_image"]];
        
        [cell.imageView setImageWithURL:[NSURL URLWithString:bgimageUrl] placeholderImage:[UIImage imageNamed:@"BannerPlaceholder"]];
        cell.imageView.frame = CGRectMake(80, 10, 220, 30);
        return cell;
    }
    
    if (indexPath.row == 3) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        cell.textLabel.text = [arr objectAtIndex:indexPath.row];
        cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
    }
    
    if (indexPath.row == 4) {
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        cell.textLabel.text = [arr objectAtIndex:indexPath.row];
        cell.textLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
        
        UILabel* cellLbl = [[UILabel alloc]initWithFrame:CGRectMake(80, 10, 220, 30)];
        cellLbl.font = [UIFont fontWithName:@"HelveticaNeue-Light"  size:18.0f];
        cellLbl.textColor = [UIColor colorWithRed:56.0f/255.0f green:84.0f/255.0f blue:135.0f/255.0f alpha:1.0f];
        cell.detailTextLabel.text = [USERDEFAULTS valueForKey:@"mystory"];
        return cell;
    }
    return cell;
}

-(UITextField*) makeTextField: (NSString*)text
                  placeholder: (NSString*)placeholder  {
	UITextField *tf = [[UITextField alloc] init];
	tf.placeholder = placeholder ;
	tf.text = text ;
	tf.autocorrectionType = UITextAutocorrectionTypeNo ;
	tf.autocapitalizationType = UITextAutocapitalizationTypeNone;
	tf.adjustsFontSizeToFitWidth = YES;
	tf.textColor = [UIColor colorWithRed:56.0f/255.0f green:84.0f/255.0f blue:135.0f/255.0f alpha:1.0f];
	return tf ;
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    return NO;
}
#pragma mark -
#pragma mark Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    
    if (indexPath.row == 0) {
        [APPDELEGATE showHToastCenter:@"Name not editable"];
    }
    if (indexPath.row == 1) {
        
        ProfileImageEditViewController *imageViewEditController=[[ProfileImageEditViewController alloc]initWithNibName:nil bundle:Nil];
        
        imageViewEditController.profileImageUrl =  [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_image"]];
        [self.navigationController pushViewController:imageViewEditController animated:YES];

    }
    if (indexPath.row == 2) { //BG image
        
        ProfileBGImageEditViewController *imageViewEditController=[[ProfileBGImageEditViewController alloc]initWithNibName:nil bundle:Nil];
        
        imageViewEditController.profileImageUrl =  [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_bg_image"]];
        [self.navigationController pushViewController:imageViewEditController animated:YES];     
    }
    if (indexPath.row == 3) {
        TagnoteViewController * tagnote = [[TagnoteViewController alloc]initWithNibName:@"TagnoteViewController" bundle:nil];
        [self.navigationController pushViewController:tagnote animated:YES];
    }
    
    if (indexPath.row == 4) {
        SlideNoteBIOViewController* BiOslide = [[SlideNoteBIOViewController alloc]initWithNibName:@"SlideNoteBIOViewController" bundle:nil];
        [self.navigationController pushViewController:BiOslide animated:YES];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
