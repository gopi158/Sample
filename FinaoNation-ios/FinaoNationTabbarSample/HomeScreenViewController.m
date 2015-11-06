//
//  HomeScreenViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "HomeScreenViewController.h"
#import "AppConstants.h"
#import "SlideNoteViewController.h"
#import "HomeCell.h"
#import "UIImageView+AFNetworking.h"
#import "ProfileDetailViewController.h"
#import "SearchORFollowingDetailViewController.h"
#import "MenuViewController.h"
#import "MFSideMenu.h"
#import <Social/Social.h>
#import <Accounts/Accounts.h>
#import "SearchDetailNewViewController.h"
#import "ApplicationConstants.h"

@interface HomeScreenViewController ()

@end

@implementation HomeScreenViewController

dispatch_queue_t PostQueue_gcd;
NSString *shareString;
NSString* name;
UIImageView *shareImage;
NSDictionary *tempDict;
NSURL *shareUrl;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_NORMAL_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_NORMAL, NSFontAttributeName, nil]
                                                 forState:UIControlStateNormal];
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_SELECTED_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_SELECTED, NSFontAttributeName, nil]
                                                 forState:UIControlStateSelected];
        
        self.title = @"Home";
        
        self.tabBarItem.image = [UIImage imageNamed:@"home"];
        
    }
    return self;
}

-(void)SettingsClicked{
    
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    profilePhotosDictionary = [[NSMutableDictionary alloc]init];
    
    shareUrl = [NSURL URLWithString:@"http://www.finaonation.com"];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
    }
    
    else
        
    {
        self.navigationController.navigationBar.translucent = NO;
        self.tabBarController.tabBar.tintColor = [UIColor whiteColor];
        [[UITabBar appearance] setSelectedImageTintColor:[UIColor orangeColor]];
        [[UINavigationBar appearance] setBackgroundImage:[[UIImage alloc] init] forBarMetrics:UIBarMetricsDefault];
        UIButton *btn = [UIButton buttonWithType:UIButtonTypeCustom];
        [btn setFrame:CGRectMake(0.0f, 0.0f,70.0f, 30.0f)];
        [btn addTarget:self action:@selector(SettingsClicked) forControlEvents:UIControlEventTouchUpInside];
        btn.showsTouchWhenHighlighted = YES;
        [btn setImage:[UIImage imageNamed:@"Setting_Custombtn"] forState:UIControlStateNormal];
        UIBarButtonItem *Setting_btn = [[UIBarButtonItem alloc] initWithCustomView:btn];
        self.navigationItem.rightBarButtonItem = Setting_btn;
    }
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        [APPDELEGATE showHToastCenter:@"Loading..."];
    });
    
    [self GetHomepageDetails];
}

#pragma mark -
#pragma mark - UIBarButtonItems

- (void)viewDidLoad
{
    [super viewDidLoad];
    Home_table = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, self.view.frame.size.height-50) style:UITableViewStylePlain];
    Home_table.delegate = self;
    Home_table.dataSource = self;
    Home_table.tableFooterView = [[UIView alloc]init];
    [self.view addSubview:Home_table];
    
    [APPDELEGATE setCurrentNav:self.navigationController];
    arrHomeLIST = [[NSMutableArray alloc]init];
    
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithImage:[UIImage imageNamed:@"menu_orange"] style:UIBarButtonItemStylePlain target:self action:@selector(SideMenuButtonPressed)];
    
    
    PostQueue_gcd = dispatch_queue_create("com.Finao.Posts", NULL);
    dispatch_async(PostQueue_gcd, ^{ [self GetNotificationList]; } );
}
- (void)SideMenuButtonPressed {
    MenuViewController* menu = [[MenuViewController alloc]initWithNibName:@"MenuViewController" bundle:nil];
    [self.navigationController pushViewController:menu animated:YES];
}

-(void)GetHomepageDetails{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Servermanager* webservice = [[Servermanager alloc]init];
        webservice.delegate = self;
        [webservice GetHomeListFromServer:[USERDEFAULTS valueForKey:@"userid"] ];
    });
}

#pragma mark WEBservice delegate
-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error{
    //;
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        ////NSLog(@"NSSTRING TYPE");
    }
    else {
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            arrHomeLIST = [data objectForKey:@"item"];
            [self removeSelfPostsFromData];
        }
        else
            [APPDELEGATE showHToast:@"No Items Found."];
    }
    if ([arrHomeLIST count]== 0) {
        [arrHomeLIST addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNotFollowing = YES;
    }
    [Home_table reloadData];
}
-(void)removeSelfPostsFromData
{
    NSMutableArray* newDataArray = [[NSMutableArray alloc] init];
    for (NSDictionary *object in arrHomeLIST) {
        if( [[object valueForKey:@"updateby"] integerValue] != [[USERDEFAULTS valueForKey:@"userid"] integerValue]){
            [newDataArray addObject:object];
        }
    }
    arrHomeLIST = newDataArray;
}
-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    //;
}
#pragma mark -----
#pragma mark Tableview Start

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (UserisNotFollowing) {
        return 60.0f;
    }
    NSDictionary *tempDict = [arrHomeLIST objectAtIndex:indexPath.row];
    ////NSLog(@"tempDict =%@",tempDict);
    ////NSLog(@"count= %lu",(unsigned long)[[tempDict objectForKey:@"image_urls"] count]);
    if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
        return 420.0f;
    }
    return 124.0f;
}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    
    return [arrHomeLIST count];
    
}
-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    /*
     NSDictionary *tempDict = [arrHomeLIST objectAtIndex:indexPath.row];
     SearchDetailNewViewController* searchDetails = [[SearchDetailNewViewController alloc]initWithNibName:@"SearchDetailNewViewController" bundle:nil];
     
     searchDetails.Firstname = [tempDict objectForKey:@"profilename"];
     searchDetails.Lastname = @"";
     searchDetails.StoryText = [tempDict objectForKey:@"story"];
     NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"profile_image"]];
     searchDetails.imageUrlStr = imageUrl1;
     
     searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
     searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
     searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
     searchDetails.SearchusrID = [tempDict objectForKey:@"updateby"];
     [self.navigationController pushViewController:searchDetails animated:YES];
     */
}

-(void)spamBtnClicked:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [arrHomeLIST objectAtIndex:index];
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share",@"Follow this Tile", @"Flag as Inappropriate", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}
-(BOOL)isTwitterInstalled {
    if([SLComposeViewController isAvailableForServiceType:SLServiceTypeTwitter])
        return YES;
    else
        return NO;
}
-(BOOL)isFBInstalled {
    if([SLComposeViewController isAvailableForServiceType:SLServiceTypeFacebook])
        return YES;
    else
        return NO;
}
-(void)ShareAction{
    if(![self isTwitterInstalled]){
        UIAlertView *alertView =
        [[UIAlertView alloc]
         initWithTitle:@"Sorry" message:@"You can't share via Twitter yet, make sure your phone has a Twitter app installed and you have at least one Twitter account setup in your settings" delegate:nil
         cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alertView show];
    }
    if(![self isFBInstalled]){
        UIAlertView *alertView =
        [[UIAlertView alloc]
         initWithTitle:@"Sorry" message:@"You can't share via Facebook yet, make sure your phone has a Facebook app installed and you have at least one Facebook account setup in your settings" delegate:nil
         cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alertView show];
    }
    NSArray *activityItems = [NSArray arrayWithObjects:shareString, shareImage.image, shareUrl, nil];
    UIActivityViewController *activityViewController = [[UIActivityViewController alloc] initWithActivityItems:activityItems applicationActivities:nil];
    activityViewController.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
    if (NSFoundationVersionNumber > NSFoundationVersionNumber_iOS_6_1) {
        activityViewController.excludedActivityTypes = @[UIActivityTypePrint, UIActivityTypeCopyToPasteboard,UIActivityTypeAssignToContact, UIActivityTypeSaveToCameraRoll, UIActivityTypePostToWeibo, UIActivityTypeAddToReadingList, UIActivityTypeAirDrop];
        
    }
    [self presentViewController:activityViewController animated:YES completion:nil];
}
- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex == 0)
    {
        [self ShareAction];
        //            [self takeNewPhotoFromCamera];
    }
    else if (buttonIndex == 1)
    {
        //            [self choosePhotoFromExistingImages];
    }
    else if (buttonIndex == 2)
    {
        
    }
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return NO;
}

- (void)willPresentActionSheet:(UIActionSheet *)actionSheet
{
    for (UIView *subview in actionSheet.subviews) {
        if ([subview isKindOfClass:[UIButton class]]) {
            UIButton *button = (UIButton *)subview;
            [button setTitleColor:[UIColor lightGrayColor] forState:UIControlStateNormal];
            if ([button.titleLabel.text isEqualToString:@"Cancel"] ) {
                [button setTitleColor:[UIColor blueColor] forState:UIControlStateNormal];
            }
        }
    }
}

- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *tableIdentifier=@"HomeCell";
    tempDict = [arrHomeLIST objectAtIndex:indexPath.row];
    if (UserisNotFollowing)
    {
        UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
        cell.textLabel.textColor = [UIColor lightGrayColor];
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        cell.textLabel.text = [arrHomeLIST objectAtIndex:indexPath.row];
        return cell;
    }
    else
    {
        HomeCell *cell = (HomeCell *)[tableView dequeueReusableCellWithIdentifier:tableIdentifier];
        if (cell == nil) {
            cell = [[HomeCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:tableIdentifier];
            cell.backgroundColor = [UIColor whiteColor];
        }
        [cell ChangeFramesHomecell];
        
        [cell.shareBtn addTarget:self action:@selector(spamBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        cell.shareBtn.tag = indexPath.row;
        NSDictionary *tempDict2 = tempDict;
        dispatch_async(PostQueue_gcd, ^ {
           // NSLog(@"[tempDict2 objectForKey:@profile_image]=%@",[tempDict2 objectForKey:@"profile_image"]);
            UIImage *image = [UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict2 objectForKey:@"profile_image"]]]]];
            dispatch_async(dispatch_get_main_queue(), ^ {
                [cell.ProfileImage  setImage:image forState:UIControlStateNormal];
            });
        });
        
        cell.ProfileImage.tag = indexPath.row;
        [cell.ProfileImage addTarget:self action:@selector(profileClicked:) forControlEvents:UIControlEventTouchUpInside];
        
        cell.ProfileImage.frame = CGRectMake(10, 3, 40, 40);
        
        cell.ProfileName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
        
        cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Finao_msg2.text = @"";
        }
        cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
        
        cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
        
        ////NSLog(@"finnao id for table colummis =%@",[tempDict objectForKey:@"finao_id"]);
        cell.inspireStatus.tag =  indexPath.row;
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
            [cell.inspireStatus setTitle:@"Inspiring" forState:UIControlStateNormal];
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.titleLabel.textColor = [UIColor whiteColor];
            [cell.inspireStatus setTitleColor:[UIColor whiteColor] forState:UIControlStateNormal];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
            cell.inspireStatus.titleLabel.text = @"Inspired";
            [cell.inspireStatus setTitle:@"Inspired" forState:UIControlStateNormal];
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            [cell.inspireStatus setTitleColor:[UIColor whiteColor] forState:UIControlStateNormal];
            cell.inspireStatus.titleLabel.textColor = [UIColor greenColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        [cell.inspireStatus addTarget:self
                               action:@selector(inspireStatusClicked:)
                     forControlEvents: UIControlEventTouchUpInside];
        if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
            || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
               || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            };
        }
        
        NSDictionary * imageArrayDict = [tempDict objectForKey:@"image_urls"];
        if ([imageArrayDict count] > 0) {
            if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
                cell.Images_arr = [tempDict objectForKey:@"image_urls"];
            }
            cell.Finao_detail_table.hidden = NO;
            [cell.Finao_detail_table reloadData];
            [cell.activityIndicatorView stopAnimating];
            [cell.activityIndicatorView setHidden:YES];
            cell.Upload_text.frame = CGRectMake(22, 40, 230, 35);
            cell.ProfileName.frame = CGRectMake(52, 10, 160, 27);
            cell.Finao_msg2.frame = CGRectMake(9, 370, 270, 30);
        }
        else{ // no image, image hidden
            cell.Images_arr = nil;
            cell.Finao_detail_table.hidden = YES;
            cell.Upload_text.frame = CGRectMake(22, 40, 230, 35);
            cell.Finao_msg2.frame = CGRectMake(9, 72, 270, 30);
            cell.ProfileName.frame = CGRectMake(52, 10, 160, 27);
        }
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
        cell.playbtn.hidden = YES;
        if ([[tempDict objectForKey:@"image_urls"] count] == 0) {
            [cell ChangeFrameShare];
        }
        [cell.activityIndicatorView stopAnimating];
        [cell.activityIndicatorView setHidden:YES];
        return cell;
    }
}


-(void)profileClicked:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [arrHomeLIST objectAtIndex:index];
    SearchDetailNewViewController* searchDetails = [[SearchDetailNewViewController alloc]initWithNibName:@"SearchDetailNewViewController" bundle:nil];
    
    searchDetails.Firstname = [tempDict objectForKey:@"profilename"];
    searchDetails.Lastname = @"";
    searchDetails.StoryText = [tempDict objectForKey:@"story"];
    NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"profile_image"]];
    searchDetails.imageUrlStr = imageUrl1;
    
    searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
    searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
    searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
    searchDetails.SearchusrID = [tempDict objectForKey:@"updateby"];
    [self.navigationController pushViewController:searchDetails animated:YES];
}

-(void)inspireStatusClicked:(id) sender
{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [arrHomeLIST objectAtIndex:index];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotNotificationinfo:)
                                                 name:@"GETNOTIFICATIONSINFO"
                                               object:nil];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotInspiredFromPost:)
                                                 name:@"GETINSPIREDFROMPOST"
                                               object:nil];
    if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) { //Inspiring
        
        dispatch_async(dispatch_get_main_queue(), ^ {
            getInspiredFromPost = [[GetInspiredFromPost alloc]init];
            [getInspiredFromPost GetInspiredFromPost:[tempDict objectForKey:@"updateby"]];
        });
        
    }
    else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) { //Inspired
        
        dispatch_async(dispatch_get_main_queue(), ^ {
            getUnInspiredFromPost = [[GetUnInspiredFromPost alloc]init];
            [getUnInspiredFromPost GetUnInspiredFromPost:[tempDict objectForKey:@"updateby"]];
        });
        
    }
}

-(void)LaunchActivity{
    NotificationViewController *notif = [[NotificationViewController alloc]init];
    [self.navigationController pushViewController:notif animated:YES];
}

-(void)scrollViewDidEndDecelerating:(UIScrollView *)scrollView{
    //[self downloadImagesForTableRow];
}

-(void)downloadImagesForTableRow{
    
}

-(void)loadProfilePhotoInDictionary :(NSDictionary*)userDictionary{
    ////NSLog(@"loading image for user entyr = %@",userDictionary);
    
}

-(void)scrollViewDidEndDragging:(UIScrollView *)scrollView willDecelerate:(BOOL)decelerate{
    
    ////NSLog(@"scrollViewDidEndDragging");
    
    if (!decelerate) {
        
        [self downloadImagesForTableRow];
        
    }
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETINSPIREDFROMPOST" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

#pragma martk Notification

-(void)GetNotificationList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        getNotificationInfo = [[GetNotificationInfo alloc]init];
        [getNotificationInfo GetNotifications];
        
    } );
    
}

-(void)GotInspiredFromPost:(NSNotification*)notify{
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETINSPIREDFROMPOST" object:nil];
    [self GetHomepageDetails];
    
}
-(void)GotNotificationinfo:(NSNotification*)notify{
    dispatch_after(dispatch_time(DISPATCH_TIME_NOW, 5 * NSEC_PER_SEC), dispatch_get_main_queue(), ^{
        //[APPDELEGATE hideHUD];
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];
        NSMutableArray *notifarray = getNotificationInfo.FinaoListDic;
        if ([notifarray count] == 0) {
            [notifarray addObject:@"No Items Found."];
            [APPDELEGATE showHToast:@"No Notifications Found."];
        }
        else{
            NSString *message = [NSString stringWithFormat:@"Click to see %lu %@",(unsigned long)[notifarray count],@"Notifications."];
            [APPDELEGATE showHToast:message WithDelegate:self];
            
            [UIApplication sharedApplication].applicationIconBadgeNumber = 0;
            NSDate *currentDate = [NSDate date];
            NSDate *targetDate = [currentDate dateByAddingTimeInterval:5];
            UILocalNotification *localNotification = [[UILocalNotification alloc] init];
            localNotification.fireDate = targetDate;
            localNotification.timeZone = [NSTimeZone defaultTimeZone];
            localNotification.alertBody = message;
            localNotification.alertAction = @"See Notifications";
            localNotification.soundName = UILocalNotificationDefaultSoundName;
            localNotification.applicationIconBadgeNumber = [notifarray count];
            [[UIApplication sharedApplication] scheduleLocalNotification:localNotification];
        }
    });
}

@end
