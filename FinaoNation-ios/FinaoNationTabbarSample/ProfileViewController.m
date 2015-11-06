//
//  ProfileViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 22/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileViewController.h"
#import "AppConstants.h"
#import "UIImageView+AFNetworking.h"
#import "UIImage+ImageEffects.h"
#import "FinaoFollowersCell.h"
#import "FinaoFollowingCell.h"
#import "ProfileDetailViewController.h"
#import "TilesDetailViewController.h"
#import "SearchORFollowingDetailViewController.h"
#import "CreateFinaoViewController.h"
#import <Social/Social.h>
#import <Accounts/Accounts.h>
#import "FinaoQRScanViewController.h"
#import "FDViewController.h"
#import "QREncodeViewController.h"

@interface ProfileViewController ()

@end

@implementation ProfileViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_NORMAL_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_NORMAL, NSFontAttributeName, nil]
                                                 forState:UIControlStateNormal];
        
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_SELECTED_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_SELECTED, NSFontAttributeName, nil]
                                                 forState:UIControlStateSelected];
        self.title = @"Profile";
        
        UIImage *image = [UIImage imageNamed:@"logoheader.png"];
        self.navigationItem.titleView = [[UIImageView alloc] initWithImage:image];
        //        self.navigationItem.
        self.tabBarItem.image = [UIImage imageNamed:@"profile"];
        

    }
    return self;
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

-(void)SettingsClicked{

    
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
    
    NSString *shareString = @"Sharing my FINAO.";
    UIImage *shareImage = [UIImage imageNamed:@"sharing.png"];
    NSURL *shareUrl = [NSURL URLWithString:@"http://www.finaonation.com"];
    
    NSArray *activityItems = [NSArray arrayWithObjects:shareString, shareImage, shareUrl, nil];
    UIActivityViewController *activityViewController = [[UIActivityViewController alloc] initWithActivityItems:activityItems applicationActivities:nil];
    activityViewController.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
    if (NSFoundationVersionNumber > NSFoundationVersionNumber_iOS_6_1) {
        activityViewController.excludedActivityTypes = @[UIActivityTypePrint, UIActivityTypeCopyToPasteboard,UIActivityTypeAssignToContact, UIActivityTypeSaveToCameraRoll, UIActivityTypePostToWeibo, UIActivityTypeAddToReadingList, UIActivityTypeAirDrop];
        
    }
    [self presentViewController:activityViewController animated:YES completion:nil];

}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    // Do any additional setup after loading the view from its nib.
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        
        self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Settings" style:UIBarButtonItemStylePlain target:self action:@selector(SettingsClicked)];
        
        self.navigationController.navigationBar.translucent = NO;
        //        self.navigationController.navigationBar.tintColor = [UIColor whiteColor];
        
    }
    else //if ([[[UIDevice currentDevice]systemVersion] floatValue] <= 6.1 )
    {
        
        
        self.navigationController.navigationBar.translucent = NO;
        [[UITabBar appearance] setSelectedImageTintColor:[UIColor orangeColor]];
        
        [[UITabBar appearance] setBackgroundColor:[UIColor lightGrayColor]];
        self.tabBarController.tabBar.tintColor = [UIColor whiteColor];
        
        [[UINavigationBar appearance] setBackgroundImage:[[UIImage alloc] init] forBarMetrics:UIBarMetricsDefault];
        [[UINavigationBar appearance] setBackgroundColor:[UIColor whiteColor]];
        
        UIButton *btn = [UIButton buttonWithType:UIButtonTypeCustom];
        [btn setFrame:CGRectMake(0.0f, 10.0f,70.0f, 30.0f)];
        [btn addTarget:self action:@selector(SettingsClicked) forControlEvents:UIControlEventTouchUpInside];
        btn.showsTouchWhenHighlighted = YES;
        [btn setImage:[UIImage imageNamed:@"Setting_Custombtn"] forState:UIControlStateNormal];
        UIBarButtonItem *Setting_btn = [[UIBarButtonItem alloc] initWithCustomView:btn];
        self.navigationItem.rightBarButtonItem = Setting_btn;
        
    }
    
    
    //NSLog(@"%@",[NSString stringWithFormat:@"%@%@",@"h",[USERDEFAULTS valueForKey:@"profile_image"]]);
    
    HeaderView = [[UIView alloc]initWithFrame:CGRectMake(-1, -1, 322, 264)];
    HeaderView.layer.borderWidth = 1.0f;
    HeaderView.layer.borderColor = [UIColor lightGrayColor].CGColor;
    [self.view addSubview:HeaderView];
    
    
    Bannerimgview = [[UIImageView alloc]init ];//WithFrame:CGRectMake(10, 10, 70, 70)];
    Bannerimgview.frame = CGRectMake(0, 0, 322, 140);
    Bannerimgview.layer.borderColor = [UIColor grayColor].CGColor;
    Bannerimgview.layer.borderWidth = 1.0f;
    //    Profileimgview.image = [UIImage imageNamed:@"profile"];
    [HeaderView addSubview:Bannerimgview];
    
    //Profile Image view
    Profileimgview = [[UIImageView alloc]init ];//WithFrame:CGRectMake(10, 10, 70, 70)];
    Profileimgview.frame = CGRectMake(10, 120, 107, 107);
    Profileimgview.layer.borderColor = [UIColor grayColor].CGColor;
    Profileimgview.layer.borderWidth = 1.0f;
    //    Profileimgview.image = [UIImage imageNamed:@"profile"];
    [HeaderView addSubview:Profileimgview];

    
    NSString* NameString = [NSString stringWithFormat:@"%@ %@",[USERDEFAULTS valueForKey:@"name"],[USERDEFAULTS valueForKey:@""]];
    //NSLog(@"%@",NameString);
    ProfileName = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    ProfileName.frame = CGRectMake(132,160,150,21);
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    ProfileName.text = NameString;
    ProfileName.adjustsFontSizeToFitWidth = YES;
    ProfileName.backgroundColor = [UIColor clearColor];
    ProfileName.textColor = [UIColor orangeColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    ProfileName.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:ProfileName];
    
    FinaoLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FinaoLbl.frame = CGRectMake(123,188,31,14);
    FinaoLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FinaoLbl.text = @"FINAOs";
    FinaoLbl.adjustsFontSizeToFitWidth = YES;
    FinaoLbl.backgroundColor = [UIColor clearColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FinaoLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FinaoLbl];
    
    
    TileLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    TileLbl.frame = CGRectMake(163,188,31,14);
    TileLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    TileLbl.text = @"TILES";
    TileLbl.adjustsFontSizeToFitWidth = YES;
    TileLbl.backgroundColor = [UIColor clearColor];
    TileLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    TileLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:TileLbl];
    

    FollowersLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowersLbl.frame = CGRectMake(201,188,52,14);
    FollowersLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowersLbl.text = @"FOLLOWERS";
    FollowersLbl.adjustsFontSizeToFitWidth = YES;
    FollowersLbl.backgroundColor = [UIColor clearColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowersLbl];
    
    FollowingLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowingLbl.frame = CGRectMake(261,188,52,14);
    FollowingLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowingLbl.text = @"FOLLOWING";
    FollowingLbl.adjustsFontSizeToFitWidth = YES;
    FollowingLbl.backgroundColor = [UIColor clearColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowingLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowingLbl];
    
    PostsLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    PostsLbl.frame = CGRectMake(52,235,135,21);
    PostsLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    PostsLbl.text = @"POSTS";
    PostsLbl.adjustsFontSizeToFitWidth = YES;
    PostsLbl.backgroundColor = [UIColor clearColor];
    PostsLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    PostsLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:PostsLbl];
    
    InspiredLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    InspiredLbl.frame = CGRectMake(165,235,135,21);
    InspiredLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    InspiredLbl.text = @"INSPIRED";
    InspiredLbl.adjustsFontSizeToFitWidth = YES;
    InspiredLbl.backgroundColor = [UIColor clearColor];
    InspiredLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    InspiredLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:InspiredLbl];
    
    
    FinaoCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FinaoCountLbl.frame = CGRectMake(124,200,31,20);
    FinaoCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
//    FinaoCountLbl.text = @"66";
    FinaoCountLbl.adjustsFontSizeToFitWidth = YES;
    FinaoCountLbl.backgroundColor = [UIColor clearColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FinaoCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FinaoCountLbl];

    TileCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    TileCountLbl.frame = CGRectMake(163,200,28,20);
    TileCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
//    TileCountLbl.text = @"6";
    TileCountLbl.adjustsFontSizeToFitWidth = YES;
    TileCountLbl.backgroundColor = [UIColor clearColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    TileCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:TileCountLbl];
    
    FollowersCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowersCountLbl.frame = CGRectMake(262,200,28,20);
    FollowersCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
//    FollowersCountLbl.text = @"2000";
    FollowersCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowersCountLbl.backgroundColor = [UIColor clearColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowersCountLbl];
    
    FollowingCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowingCountLbl.frame = CGRectMake(202,200,28,20);
    FollowingCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
//    FollowingCountLbl.text = @"2000";
    FollowingCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowingCountLbl.backgroundColor = [UIColor clearColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowingCountLbl];
    
    
    Finaobtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Finaobtn.frame = CGRectMake(123, 181, 31, 35);
    [Finaobtn addTarget:self action:@selector(FinaoBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Finaobtn];

    Tilesbtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Tilesbtn.frame = CGRectMake(163, 181, 29, 35);
    [Tilesbtn addTarget:self action:@selector(TilesbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Tilesbtn];
    
    Followerssbtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Followerssbtn.frame = CGRectMake(201, 181, 29, 35);
    [Followerssbtn addTarget:self action:@selector(FollowerssbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followerssbtn];
    
    Followingbtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Followingbtn.frame = CGRectMake(261, 181, 29, 35);
    [Followingbtn addTarget:self action:@selector(FollowingbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followingbtn];
    
    Postsbtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Postsbtn.frame = CGRectMake(52,235,135,21);
    [Postsbtn addTarget:self action:@selector(PostsbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Postsbtn];

    Inspiredbtn = [UIButton buttonWithType:UIButtonTypeSystem];
    Inspiredbtn.frame = CGRectMake(175,235,135,21);
    [Inspiredbtn addTarget:self action:@selector(InspiredbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Inspiredbtn];
    
    FinaoCountLbl.textColor = [UIColor blueColor];
    FinaoLbl.textColor = [UIColor blueColor];

}

-(void)PostsbtnClicked{
    //NSLog(@"PostsbtnClicked");
}

-(void)InspiredbtnClicked{
    //NSLog(@"InspiredbtnClicked");
}

-(void)FollowingbtnClicked{
    //NSLog(@"FollowingbtnClicked");
}

-(void)FollowerssbtnClicked{
    //NSLog(@"FollowerssbtnClicked");
}

-(void)TilesbtnClicked{
    //NSLog(@"TilesbtnClicked");
}
-(void)FinaoBtnClicked{

    //NSLog(@"FinaoBtnClicked ");
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(LoadOthers:)
                                                 name:@"GETLISTNUMBERS"
                                               object:nil];
    
}

-(void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    [self getCount];
}

//Getting the Finao counts
-(void)getCount{
    dispatch_async(dispatch_get_main_queue(), ^ {
        Getnumlist = [[GetNumofList alloc]init];
        [Getnumlist GetNumbers];
    });
}


-(void)LoadOthers:(NSNotification *) notification
{
    //ListDic = Getnumlist.ListDic;
    
    //NSLog(@"LIST DIC :%@",[ListDic objectForKey:@"totalfinaos"]);
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETLISTNUMBERS" object:nil];
    
    imageUrl = [NSString stringWithFormat:@"%@%@",@"h",[USERDEFAULTS valueForKey:@"profile_image"]];
    
    //NSLog(@"%@",[NSString stringWithFormat:@"%@%@",@"h",[USERDEFAULTS valueForKey:@"profile_image"]]);

    [Profileimgview setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"profile"]];
    
    FinaoCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfinaos"] ];
    TileCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totaltiles"]];
    FollowingCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfollowings"]];
    FollowersCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfollowers"]];

//    [self LoadHEADERVIEW];
    [self GetFinaoList];
    [APPDELEGATE hideHUD];
}

-(void)GetFinaoList{
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetFinoasListProfile  = [[GetFinaoList alloc]init];
        [GetFinoasListProfile GetFinaoListFromServer];
        
    } );
    
}

-(void)GotFinaoListinDictionary:(NSNotification *) notification
{
    
    arrFINAOLIST = [[NSMutableArray alloc]init];
    
    if ([GetFinoasListProfile.FinaoListDic count] == 0) {
        [arrFINAOLIST addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNew = TRUE;
    }
    else{
        NSArray *arr = GetFinoasListProfile.FinaoListDic;
        [arrFINAOLIST addObjectsFromArray:arr];
    }
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFINAOLIST" object:nil];
    [self LoadFinaoTables];
//
//    
//    FinaoTable.hidden = NO;
//    TilesTable.hidden = YES;
//    FollowingTable.hidden = YES;
//    FollowersTable.hidden = YES;
    
//    FollowingQueue_gcd = dispatch_queue_create("com.Finao.Tileslist", NULL);
//    dispatch_async(FollowingQueue_gcd, ^{ [self getTilesList]; } );
}

-(void)LoadFinaoTables{

    if (isiPhone5) {
        FinaoTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 300) style:UITableViewStylePlain];
    }
    else{
        FinaoTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 108) style:UITableViewStylePlain];
    }
    FinaoTable.delegate = self;
    FinaoTable.dataSource = self;
    [self.view addSubview:FinaoTable];
    
    UIView* headerView = [[UIView alloc]initWithFrame:CGRectMake(0, 10, 320, 40)];
    headerView.backgroundColor = [UIColor lightGrayColor];
    UILabel* headerLbl = [[UILabel alloc]initWithFrame:CGRectMake(80, 10, 160, 20)];
    headerLbl.text = @"Create a new FINAO";
    headerLbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15];
    headerLbl.backgroundColor = [UIColor clearColor];
    [headerView addSubview:headerLbl];
    
    
    UIButton* headerbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    headerbtn.frame = CGRectMake(0, 10, 320, 40);
//    [headerbtn addTarget:self action:@selector(CreateFinaoClicked) forControlEvents:UIControlEventTouchUpInside];
    [headerView addSubview:headerbtn];
    
    FinaoTable.tableHeaderView = headerView;
    [FinaoTable setContentOffset:CGPointMake (0, headerView.frame.size.height)];
    
    FinaoTable.tableFooterView = [[UIView alloc]init];
}

- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    
    CGFloat sectionHeaderHeight = 40;
    if (scrollView.contentOffset.y<sectionHeaderHeight&&scrollView.contentOffset.y>0)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-scrollView.contentOffset.y, 0, 0, 0);
        HeaderView.frame = CGRectMake(-1, -1, 322, 264);
//        [self.view bringSubviewToFront:HeaderView];
//        if (Finaobtn.selected) {
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 264, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 264, 320, 108);
            }
            [FinaoTable reloadData];
//        }
        
    } else if (scrollView.contentOffset.y>sectionHeaderHeight)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-sectionHeaderHeight, 0, 0, 0);
        
        HeaderView.frame = CGRectMake(-1, -121, 322, 264);
//        if (Finaobtn.selected) {
        
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 144, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 144, 320, 210);
            }
            [FinaoTable reloadData];
            
//        }

    }
    
}

#pragma mark UITABLEVIEW
-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    
        return [arrFINAOLIST count];
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
//    if (tableView == FinaoTable) {
    
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        
        if (UserisNew) {
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrFINAOLIST objectAtIndex:indexPath.row];
        }
        else{
            cell.textLabel.textColor = [UIColor lightGrayColor];
            NSDictionary *tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
            cell.textLabel.text = [tempDict objectForKey:@"finao_title"];
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        
        return cell;
    
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
        return 60.0f;
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
