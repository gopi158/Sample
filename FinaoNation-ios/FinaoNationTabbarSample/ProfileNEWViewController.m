//
//  ProfileNEWViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 27/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileNEWViewController.h"
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

@interface ProfileNEWViewController ()

@end

@implementation ProfileNEWViewController

dispatch_queue_t FollowingQueue_gcd;


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
//#pragma - mark Selecting Image from Camera and Library
//- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
//{
//    // Picking Image from Camera/ Library
//    [picker dismissViewControllerAnimated:YES completion:^{}];
//    UIImage *selectedImage = [info objectForKey:@"UIImagePickerControllerOriginalImage"];
//
//    if (!selectedImage)
//    {
//        return;
//    }
//
//    // Adjusting Image Orientation
//    NSData *data = UIImagePNGRepresentation(selectedImage);
//    UIImage *tmp = [UIImage imageWithData:data];
//    UIImage *fixed = [UIImage imageWithCGImage:tmp.CGImage
//                                         scale:selectedImage.scale
//                                   orientation:selectedImage.imageOrientation];
//    selectedImage = fixed;
//
//}
//
//- (void)doImagePickerForType:(UIImagePickerControllerSourceType)type {
//    UIImagePickerController* _imagePicker = [[UIImagePickerController alloc] init];
//    if (!_imagePicker) {
//        _imagePicker = [[UIImagePickerController alloc] init];
//        _imagePicker.mediaTypes = UIImagePickerControllerCameraCaptureModePhoto;
//        _imagePicker.allowsEditing = YES;
//        // TODO Cast to correct delegate type
//        //_imagePicker.delegate = self;
//    }
//    _imagePicker.sourceType = type;
//    [self presentViewController:_imagePicker animated:YES completion:nil];
//}


-(void)SettingsClicked{
    
    //TODO move this code to the right place
    /*
     UIStoryboard *sb = [UIStoryboard storyboardWithName:@"MainStoryboard_iPhone" bundle:nil];
     UIViewController *vc = [sb instantiateInitialViewController];
     vc.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
     [self presentViewController:vc animated:YES completion:NULL];
     */
    // camera
    //[self doImagePickerForType:UIImagePickerControllerSourceTypeCamera];
    
    /* library
     UIImagePickerControllerSourceType type =
     UIImagePickerControllerSourceTypePhotoLibrary;
     BOOL ok = [UIImagePickerController isSourceTypeAvailable:type];
     if (!ok) {
     //NSLog(@"alas");
     return;
     }
     UIImagePickerController* picker = [UIImagePickerController new];
     picker.sourceType = type;
     picker.mediaTypes =
     [UIImagePickerController availableMediaTypesForSourceType:type];
     picker.delegate = self;
     [self presentViewController:picker animated:YES completion:nil]; // iPhone
     */
    // Generate a QR bar code from a url
    QREncodeViewController * qrEncodeViewController = [[QREncodeViewController alloc] initWithNibName:@"QREncodeViewController" bundle:nil];
    qrEncodeViewController.encodeURL = @"http://www.finaonation.com";
    [self.navigationController pushViewController:qrEncodeViewController animated:YES];
    /* Scan a QR code
     FinaoQRScanViewController* qrViewController = [[FinaoQRScanViewController alloc]init];
     [self.navigationController pushViewController:qrViewController animated:YES];
     */
    
    /*
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
     */
}

-(void)ImgBtnClicked{
    
    //NSLog(@"UPdate IMAGE BTN CLICKED");
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Update Photo from"
                                                             delegate:self cancelButtonTitle:nil destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Take Photo With Camera", @"Select Photo From Library", @"Cancel", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex == 0)
    {
        [self takeNewPhotoFromCamera];
    }
    else if (buttonIndex == 1)
    {
        [self choosePhotoFromExistingImages];
    }
    
    else if (buttonIndex == 2)
    {
        //NSLog(@"cancel");
    }
}

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    
	[picker dismissViewControllerAnimated:YES completion:nil];
    
    Profileimgview.image = [info objectForKey:@"UIImagePickerControllerOriginalImage"];
    
    
}
- (void)takeNewPhotoFromCamera
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypeCamera])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypeCamera;
        controller.allowsEditing = NO;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypeCamera];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }else{
        
        UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO" message:@"Camera not available" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alert show];
    }
}
-(void)choosePhotoFromExistingImages
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypePhotoLibrary])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        controller.allowsEditing = NO;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypePhotoLibrary];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }
}



- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    screenHeightBounds = [[UIScreen mainScreen] bounds];
    
    // Do any additional setup after loading the view from its nib.
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        
        self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Scan QR" style:UIBarButtonItemStylePlain target:self action:@selector(SettingsClicked)];
        
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
    
    //For setting the Profile image
    
    HeaderView = [[UIView alloc]initWithFrame:CGRectMake(-1, -1, 322, 294)];
    HeaderView.layer.borderWidth = 1.0f;
    HeaderView.layer.borderColor = [UIColor lightGrayColor].CGColor;
    HeaderView.backgroundColor = [UIColor whiteColor];
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
    
    
    imgbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    imgbtn.frame = CGRectMake(10, 120, 107, 107);
    [imgbtn addTarget:self action:@selector(ImgBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:imgbtn];
    
    //NSString* NameString = [NSString stringWithFormat:@"%@ %@",[USERDEFAULTS valueForKey:@"name"]];
    //NSLog(@"%@",NameString);
    ProfileName = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    ProfileName.frame = CGRectMake(132,160,150,21);
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
   // ProfileName.text = NameString;
    ProfileName.adjustsFontSizeToFitWidth = YES;
    ProfileName.backgroundColor = [UIColor clearColor];
    ProfileName.textColor = [UIColor orangeColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    ProfileName.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:ProfileName];
    
    FinaoLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FinaoLbl.frame = CGRectMake(19,232,31,14);
    FinaoLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FinaoLbl.text = @"FINAOs";
    FinaoLbl.adjustsFontSizeToFitWidth = YES;
    FinaoLbl.backgroundColor = [UIColor clearColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FinaoLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FinaoLbl];
    
    
    TileLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    TileLbl.frame = CGRectMake(85,232,31,14);
    TileLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    TileLbl.text = @"TILES";
    TileLbl.adjustsFontSizeToFitWidth = YES;
    TileLbl.backgroundColor = [UIColor clearColor];
    TileLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    TileLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:TileLbl];
    
    
    FollowersLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowersLbl.frame = CGRectMake(152,232,52,14);
    FollowersLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowersLbl.text = @"FOLLOWERS";
    FollowersLbl.adjustsFontSizeToFitWidth = YES;
    FollowersLbl.backgroundColor = [UIColor clearColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowersLbl];
    
    FollowingLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowingLbl.frame = CGRectMake(245,232,52,14);
    FollowingLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowingLbl.text = @"FOLLOWING";
    FollowingLbl.adjustsFontSizeToFitWidth = YES;
    FollowingLbl.backgroundColor = [UIColor clearColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowingLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowingLbl];
    
    PostsLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    PostsLbl.frame = CGRectMake(19,275,135,21);
    PostsLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    PostsLbl.text = @"POSTS";
    PostsLbl.adjustsFontSizeToFitWidth = YES;
    PostsLbl.backgroundColor = [UIColor clearColor];
    PostsLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    PostsLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:PostsLbl];
    
    InspiredLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    InspiredLbl.frame = CGRectMake(175,275,135,21);
    InspiredLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    InspiredLbl.text = @"INSPIRED";
    InspiredLbl.adjustsFontSizeToFitWidth = YES;
    InspiredLbl.backgroundColor = [UIColor clearColor];
    InspiredLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    InspiredLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:InspiredLbl];
    
    
    FinaoCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FinaoCountLbl.frame = CGRectMake(22,248,31,20);
    FinaoCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    //    FinaoCountLbl.text = @"66";
    FinaoCountLbl.adjustsFontSizeToFitWidth = YES;
    FinaoCountLbl.backgroundColor = [UIColor clearColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FinaoCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FinaoCountLbl];
    
    TileCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    TileCountLbl.frame = CGRectMake(89,247,28,20);
    TileCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    //    TileCountLbl.text = @"6";
    TileCountLbl.adjustsFontSizeToFitWidth = YES;
    TileCountLbl.backgroundColor = [UIColor clearColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    TileCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:TileCountLbl];
    
    FollowingCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowingCountLbl.frame = CGRectMake(153,247,52,20);
    FollowingCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    //    FollowingCountLbl.text = @"2000";
    FollowingCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowingCountLbl.backgroundColor = [UIColor clearColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowingCountLbl];
    
    FollowersCountLbl = [[UILabel alloc]init];//WithFrame:CGRectMake(15, 95, 20, 15)];
    FollowersCountLbl.frame = CGRectMake(249,247,52,20);
    FollowersCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    //    FollowersCountLbl.text = @"2000";
    FollowersCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowersCountLbl.backgroundColor = [UIColor clearColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];//[UIFont fontWithName:@"HelveticaNeue-Light" size:12];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowersCountLbl];
    
    
    Finaobtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Finaobtn.frame = CGRectMake(19, 231, 31, 35);
    [Finaobtn addTarget:self action:@selector(FinaoBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Finaobtn];
    
    Finaobtn.selected = YES;
    
    Tilesbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Tilesbtn.frame = CGRectMake(85, 231, 31, 35);
    [Tilesbtn addTarget:self action:@selector(TilesbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Tilesbtn];
    
    Followerssbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followerssbtn.frame = CGRectMake(152, 231, 29, 35);
    [Followerssbtn addTarget:self action:@selector(FollowersbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followerssbtn];
    
    Followingbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followingbtn.frame = CGRectMake(248, 231, 29, 35);
    [Followingbtn addTarget:self action:@selector(FollowingbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followingbtn];
    
    Postsbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Postsbtn.frame = CGRectMake(19,275,135,21);
    [Postsbtn addTarget:self action:@selector(PostsbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Postsbtn];
    
    Inspiredbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Inspiredbtn.frame = CGRectMake(175,275,135,21);
    [Inspiredbtn addTarget:self action:@selector(InspiredbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Inspiredbtn];
    
    
    //    FinaoCountLbl.textColor = [UIColor blueColor];
    //    FinaoLbl.textColor = [UIColor blueColor];
    
    txtview = [[UITextView alloc]init ];//WithFrame:CGRectMake(90, 30, 210, 50)];
    txtview.frame = CGRectMake(137, 203, 175, 46);
    txtview.backgroundColor = [UIColor clearColor];
    txtview.text = [USERDEFAULTS valueForKey:@"mystory"];
    txtview.textColor = [UIColor lightGrayColor];
    txtview.editable = NO;
    [HeaderView addSubview:txtview];
    
    [HeaderView bringSubviewToFront:txtview];
}
-(void)PostsbtnClicked{
    
}

-(void)InspiredbtnClicked{
    
}

-(void)LoadHEADERVIEW{
    
}

-(void)LoadOthers:(NSNotification *) notification
{
    //ListDic = Getnumlist.ListDic;
    
    //NSLog(@"LIST DIC :%@",[ListDic objectForKey:@"totalfinaos"]);
    
    
    //    [NSNotificationCenter defaultCenter]re
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETLISTNUMBERS" object:nil];
    
    imageUrl = [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_image"]];
    //    //NSLog(@"imageUrl:%@",imageUrl);
    [Profileimgview setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"profile"]];
    
    FinaoCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfinaos"] ];
    TileCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totaltiles"]];
    FollowingCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfollowings"]];
    FollowersCountLbl.text = [NSString stringWithFormat:@"%@",[ListDic objectForKey:@"totalfollowers"]];
    
    [self LoadHEADERVIEW];
    [self GetFinaoList];
    
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
    //NSLog(@"arrFINAOLIST:%@",arrFINAOLIST);
    
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
    
    
    FinaoTable.hidden = NO;
    TilesTable.hidden = YES;
    FollowingTable.hidden = YES;
    FollowersTable.hidden = YES;
    
    FollowingQueue_gcd = dispatch_queue_create("com.Finao.Tileslist", NULL);
    dispatch_async(FollowingQueue_gcd, ^{ [self getTilesList]; } );
}

-(void)getTilesList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetTilesListProfile = [[GetTiles alloc]init];
        [GetTilesListProfile GetTilesListFromServer];
        
    } );
}

-(void)GotTiLesListinDictionary:(NSNotification *) notification
{
    
    arrTilesList = [[NSMutableArray alloc]init];
    
    //NSLog(@"arrTilesList:%@",arrTilesList);
    arrTilesList = GetTilesListProfile.TilesListDic;
    //NSLog(@"arrFollowingList:%@",arrTilesList);
    
    if ([arrTilesList count] == 0) {
        [arrTilesList addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOTiles = TRUE;
    }
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETTILESLIST" object:nil];
    FollowingQueue_gcd = dispatch_queue_create("com.Finao.Followerslist", NULL);
    dispatch_async(FollowingQueue_gcd, ^{ [self getFollowersList]; } );
}
-(void)getFollowersList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetFollowersListProfile = [[GetFollowersList alloc]init];
        [GetFollowersListProfile GetFollowersListFromServer];
        
    } );
}


-(void)GotFollowersListinDictionary:(NSNotification *) notification
{
    
    arrFollowersLIST = [[NSMutableArray alloc]init];
    
    //NSLog(@"arrFollowersLIST:%@",arrTilesList);
    arrFollowersLIST = GetFollowersListProfile.FollowersListDic;
    //    //NSLog(@"arrFollowingList:%@",arrTilesList);
    
    if (![arrFollowersLIST count]) {
        [arrFollowersLIST addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFOLLOWERS = TRUE;
    }
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFOLLOWERSLIST" object:nil];
    dispatch_async(FollowingQueue_gcd, ^{ [self getFollowingList]; } );
    
}
-(void)getFollowingList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetFollowingListProfile = [[GetFollowingList alloc]init];
        [GetFollowingListProfile GetFollowingListFromServer];
        
    } );
}

-(void)GotFollowingListinDictionary:(NSNotification *) notification
{
    
    arrFollowingList = [[NSMutableArray alloc]init];
    
    //    //NSLog(@"arrFollowingList:%@",arrFollowingList);
    arrFollowingList = GetFollowingListProfile.FollowingListDic;
    //    //NSLog(@"arrFollowingList:%@",arrFollowingList);
    
    if (![arrFollowingList count]) {
        [arrFollowingList addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFollowings = TRUE;
    }
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFOLLOWINGLIST" object:nil];
    
    
    
    //MADHU BLURRED IMAGE FOR THE SCREEN AND STORE IN NSDOCUMENTARY FILE
    
    UIGraphicsBeginImageContext(self.view.bounds.size);
    [self.view.layer renderInContext:UIGraphicsGetCurrentContext()];
    UIImage *screenshotImage = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    //    NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    //    NSString *documentsPath = [paths objectAtIndex:0]; //Get the docs directory
    UIImage *screenshotImageeffect =[screenshotImage applyLightEffect];
    //    NSString *filePath = [documentsPath stringByAppendingPathComponent:@"Blurredimage.png"]; //Add the file name
    NSData *pngData = UIImagePNGRepresentation(screenshotImageeffect);
    
    //    NSData *imageData = [NSData dataWithContentsOfURL:myImageURL];
    NSString *imagePath = [[NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0] stringByAppendingPathComponent:@"/Blurredimage.png"];
    //    [imageData writeToFile:imagePath atomically:YES];
    
    
    [pngData writeToFile:imagePath atomically:YES]; //Write the file
    
    
    
    //ADD BLURRED IMAGE TO THE NSDOCUMENTARY FINISHED
    
    //    UIImageWriteToSavedPhotosAlbum(screenshotImage, nil, nil, nil);
}
-(void)CreateFinaoClicked{
    
    CreateFinaoViewController* CreateFinao = [[CreateFinaoViewController alloc]initWithNibName:@"CreateFinaoViewController" bundle:nil];
    [self.navigationController pushViewController:CreateFinao animated:YES];
    
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
    
    //    UIView* headerView = [[UIView alloc]initWithFrame:CGRectMake(0, 10, 320, 40)];
    //    headerView.backgroundColor = [UIColor lightGrayColor];
    //    UILabel* headerLbl = [[UILabel alloc]initWithFrame:CGRectMake(80, 10, 160, 20)];
    //    headerLbl.text = @"Create a new FINAO";
    //    headerLbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15];
    //    headerLbl.backgroundColor = [UIColor clearColor];
    //    [headerView addSubview:headerLbl];
    //
    //
    //    UIButton* headerbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    //    headerbtn.frame = CGRectMake(0, 10, 320, 40);
    //    [headerbtn addTarget:self action:@selector(CreateFinaoClicked) forControlEvents:UIControlEventTouchUpInside];
    //    [headerView addSubview:headerbtn];
    //
    //    FinaoTable.tableHeaderView = headerView;
    //    [FinaoTable setContentOffset:CGPointMake (0, headerView.frame.size.height)];
    
    FinaoTable.tableFooterView = [[UIView alloc]init];
    FinaoTable.hidden = NO;
    if (FirStTime) {
        FirStTime = NO;
        if (TablesScrolledUP) {
            
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 144, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 144, 320, 210);
            }
            HeaderView.frame = CGRectMake(-1, -121, 322, 264);
            [self.view bringSubviewToFront:HeaderView];
        }
        else{
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 264, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 264, 320, 108);
            }
            HeaderView.frame = CGRectMake(-1, -1, 322, 294);
            [self.view bringSubviewToFront:HeaderView];
            
        }
    }
    else{
        FirStTime = YES;
        if (TablesScrolledUP) {
            //            FinaoTable.frame = CGRectMake(0, 50, 320, 330);
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 144, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 144, 320, 210);
            }
            HeaderView.frame = CGRectMake(-1, -121, 322, 264);
            [self.view bringSubviewToFront:HeaderView];
            
        }
        else{
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 264, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 264, 320, 108);
            }
            HeaderView.frame = CGRectMake(-1, -1, 322, 294);
            [self.view bringSubviewToFront:HeaderView];
            
        }
        //        [FinaoTable reloadData];
    }
}

-(void)getCount{
    
    Finaobtn.selected = YES;
    
    if (Finaobtn.selected) {
        FinaoLbl.textColor = [UIColor blueColor];
        FinaoCountLbl.textColor = [UIColor blueColor];
        
        TileLbl.textColor = [UIColor lightGrayColor];
        TileCountLbl.textColor = [UIColor lightGrayColor];
        
        FollowersLbl.textColor = [UIColor lightGrayColor];
        FollowersCountLbl.textColor = [UIColor lightGrayColor];
        
        FollowingLbl.textColor = [UIColor lightGrayColor];
        FollowingCountLbl.textColor = [UIColor lightGrayColor];
    }
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Getnumlist = [[GetNumofList alloc]init];
        [Getnumlist GetNumbers];
    });
}
-(void)TilesbtnClicked
{
    FirStTime = YES;
    //    Followingbtn.selected = YES;
    if (Finaobtn.selected) {
        Finaobtn.selected = NO;
    }
    
    if (Followingbtn.selected) {
        Followingbtn.selected = NO;
    }
    if (Followerssbtn.selected) {
        Followerssbtn.selected = NO;
    }
    
    Tilesbtn.selected = YES;
    
    TileCountLbl.textColor = [UIColor blueColor];
    TileLbl.textColor = [UIColor blueColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];
    //    Finaobtn.backgroundColor = [UIColor whiteColor];
    [self LoadTilesTable];
    
    FinaoTable.hidden = YES;
    TilesTable.hidden = NO;
    FollowingTable.hidden = YES;
    FollowersTable.hidden = YES;
    //    [TilesTable reloadData];
}
-(void)LoadTilesTable{
    
    if (isiPhone5) {
        TilesTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 300) style:UITableViewStylePlain];
    }
    else{
        TilesTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 108) style:UITableViewStylePlain];
    }
    //    TilesTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 30) style:UITableViewStylePlain];
    TilesTable.delegate = self;
    TilesTable.dataSource = self;
    [self.view addSubview:TilesTable];
    UIView* headerViewTile = [[UIView alloc]initWithFrame:CGRectMake(0, 10, 320, 40)];
    headerViewTile.backgroundColor = [UIColor lightGrayColor];
    UILabel* headerLblTile = [[UILabel alloc]initWithFrame:CGRectMake(80, 10, 160, 20)];
    headerLblTile.text = @"Create a new Tile.";
    headerLblTile.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15];
    headerLblTile.backgroundColor = [UIColor clearColor];
    [headerViewTile addSubview:headerLblTile];
    [TilesTable setContentOffset:CGPointMake (0, headerViewTile.frame.size.height)];
    TilesTable.tableHeaderView = headerViewTile;
    TilesTable.tableFooterView = [[UIView alloc]init];
    
    //    TilesTable.tableHeaderView.hidden = YES;
    if (TablesScrolledUP) {
        
        /*
         if (isiPhone5) {
         FinaoTable.frame = CGRectMake(0, 144, 320, 300);
         }
         else{
         FinaoTable.frame = CGRectMake(0, 144, 320, 210);
         }
         */
        
        if (isiPhone5) {
            TilesTable.frame = CGRectMake(0, 144, 320, 300);
        }
        else{
            TilesTable.frame = CGRectMake(0, 144, 320, 210);
        }
        //        TilesTable.frame = CGRectMake(0, 50, 320, 330);
        HeaderView.frame = CGRectMake(-1, -121, 322, 264);
    }
    else{
        HeaderView.frame = CGRectMake(-1, -1, 322, 294);
        if (isiPhone5) {
            FinaoTable.frame = CGRectMake(0, 264, 320, 300);
        }
        else{
            FinaoTable.frame = CGRectMake(0, 264, 320, 108);
        }
    }
}

-(void)FinaoBtnClicked
{
    if (Followingbtn.selected) {
        Followingbtn.selected = NO;
    }
    
    if (Tilesbtn.selected) {
        Tilesbtn.selected = NO;
    }
    
    if (Followerssbtn.selected) {
        Followerssbtn.selected = NO;
    }
    Finaobtn.selected = YES;
    FinaoCountLbl.textColor = [UIColor blueColor];
    FinaoLbl.textColor = [UIColor blueColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];
    TileLbl.textColor = [UIColor lightGrayColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];
    //    Finaobtn.backgroundColor = [UIColor whiteColor];
    
    [self LoadFinaoTables];
    
    FinaoTable.hidden = NO;
    TilesTable.hidden = YES;
    FollowingTable.hidden = YES;
    FollowersTable.hidden = YES;
    
}
-(void)FollowingbtnClicked
{
    FirStTime = YES;
    
    if (Finaobtn.selected) {
        Finaobtn.selected = NO;
    }
    if (Tilesbtn.selected) {
        Tilesbtn.selected = NO;
    }
    if (Followerssbtn.selected) {
        Followerssbtn.selected = NO;
    }
    
    Followingbtn.selected = YES;
    FinaoCountLbl.textColor = [UIColor lightGrayColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];
    TileLbl.textColor = [UIColor lightGrayColor];
    FollowingCountLbl.textColor = [UIColor blueColor];
    FollowingLbl.textColor = [UIColor blueColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];
    
    //    Finaobtn.backgroundColor = [UIColor whiteColor];
    
    if (isiPhone5) {
        FollowingTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 300) style:UITableViewStylePlain];
    }
    else{
        FollowingTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 108) style:UITableViewStylePlain];
    }
    
    FollowingTable.delegate = self;
    FollowingTable.dataSource = self;
    [self.view addSubview:FollowingTable];
    
    FollowingTable.tableFooterView = [[UIView alloc]init];
    FinaoTable.hidden = YES;
    
    if (TablesScrolledUP) {
        //        FollowingTable.frame = CGRectMake(0, 50, 320, 330);
        HeaderView.frame = CGRectMake(-1, -121, 322, 264);
        if (isiPhone5) {
            FollowingTable.frame = CGRectMake(0, 144, 320, 300);
        }
        else{
            FollowingTable.frame = CGRectMake(0, 144, 320, 210);
        }
    }
    else{
        HeaderView.frame = CGRectMake(-1, -1, 322, 294);
        if (isiPhone5) {
            FollowingTable.frame = CGRectMake(0, 264, 320, 300);
        }
        else{
            FollowingTable.frame = CGRectMake(0, 264, 320, 108);
        }
    }
    //    [FollowingTable reloadData];
    
    FinaoTable.hidden = YES;
    TilesTable.hidden = YES;
    FollowingTable.hidden = NO;
    FollowersTable.hidden = YES;
}

-(void)FollowersbtnClicked
{
    FirStTime = YES;
    
    Followerssbtn.selected = YES;
    if (Finaobtn.selected) {
        Finaobtn.selected = NO;
    }
    if (Tilesbtn.selected) {
        Tilesbtn.selected = NO;
    }
    if (Followingbtn.selected) {
        Followingbtn.selected = NO;
    }
    FollowersLbl.textColor = [UIColor blueColor];
    FollowersCountLbl.textColor = [UIColor blueColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];
    TileLbl.textColor = [UIColor lightGrayColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];
    //    Finoasbtn.backgroundColor = [UIColor whiteColor];
    
    if (isiPhone5) {
        FollowersTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 300) style:UITableViewStylePlain];
    }
    else{
        FollowersTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 264, 320, 108) style:UITableViewStylePlain];
    }
    FollowersTable.delegate = self;
    FollowersTable.dataSource = self;
    [self.view addSubview:FollowersTable];
    
    FollowersTable.tableFooterView = [[UIView alloc]init];
    
    
    
    
    if (TablesScrolledUP) {
        
        HeaderView.frame = CGRectMake(-1, -121, 322, 264);
        if (isiPhone5) {
            FollowersTable.frame = CGRectMake(0, 144, 320, 300);
        }
        else{
            FollowersTable.frame = CGRectMake(0, 144, 320, 210);
        }
    }
    else{
        HeaderView.frame = CGRectMake(-1, -1, 322, 294);
        if (isiPhone5) {
            FollowersTable.frame = CGRectMake(0, 264, 320, 300);
        }
        else{
            FollowersTable.frame = CGRectMake(0, 264, 320, 108);
        }
    }
    //    [FollowingTable reloadData];
    FinaoTable.hidden = YES;
    TilesTable.hidden = YES;
    FollowingTable.hidden = YES;
    FollowersTable.hidden = NO;
}
-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    
    if (buttonIndex == 0) {
        [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
    }
    else
        if(buttonIndex ==1)
        {
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
            
            [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
            
        }
    
    
}
-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    //FOR GETTING GETLISTNUMBERS
    
    
    if (![USERDEFAULTS valueForKey:@"FirstTimeShare"])
    {
        UIAlertView* ShareAlert = [[UIAlertView alloc]initWithTitle:@"Finao" message:@"Share Finao" delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"OK", nil];
        [ShareAlert show];
    }
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(LoadOthers:)
                                                 name:@"GETLISTNUMBERS"
                                               object:nil];
    
    //FOR GETTING FINAO LIST
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotFinaoListinDictionary:)
                                                 name:@"GETFINAOLIST"
                                               object:nil];
    //FOR TILES LIST
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotTiLesListinDictionary:)
                                                 name:@"GETTILESLIST"
                                               object:nil];
    
    //FOR FOLLOWING LIST
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotFollowingListinDictionary:)
                                                 name:@"GETFOLLOWINGLIST"
                                               object:nil];
    
    //FOR FOLLOWERS LIST
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotFollowersListinDictionary:)
                                                 name:@"GETFOLLOWERSLIST"
                                               object:nil];
    
}

-(void)viewDidAppear:(BOOL)animated
{
    
    FirStTime = NO;
    Finaobtn.selected = YES;
    Tilesbtn.selected = NO;
    Followingbtn.selected = NO;
    Followerssbtn.selected = NO;
    TablesScrolledUP = NO;
    
    [super viewDidAppear:animated];
    
    [self getCount];
}

-(void)viewDidDisappear:(BOOL)animated
{
    [super viewDidDisappear:animated];
    
}


- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    
    CGFloat sectionHeaderHeight = 40;
    if (scrollView.contentOffset.y<sectionHeaderHeight&&scrollView.contentOffset.y>0)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-scrollView.contentOffset.y, 0, 0, 0);
        TablesScrolledUP = NO;
        HeaderView.frame = CGRectMake(-1, -1, 322, 294);
        [self.view bringSubviewToFront:HeaderView];
        if (Finaobtn.selected) {
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 264, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 264, 320, 108);
            }
        }
        if (Tilesbtn.selected) {
            
            if (isiPhone5) {
                TilesTable.frame = CGRectMake(0, 264, 320, 300);
            }else{
                TilesTable.frame = CGRectMake(0, 264, 320, 108);
            }
        }
        if (Followerssbtn.selected) {
            if (isiPhone5) {
                FollowersTable.frame = CGRectMake(0, 264, 320, 300);
            }else{
                FollowersTable.frame = CGRectMake(0, 264, 320, 108);
            }
        }
        
        if (Followingbtn.selected) {
            
            if (isiPhone5) {
                FollowingTable.frame = CGRectMake(0, 264, 320, 300);
            }else{
                FollowingTable.frame = CGRectMake(0, 264, 320, 108);
            }
        }
        
    } else if (scrollView.contentOffset.y>sectionHeaderHeight)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-sectionHeaderHeight, 0, 0, 0);
        TablesScrolledUP = YES;
        
        HeaderView.frame = CGRectMake(-1, -121, 322, 264);
        if (Finaobtn.selected) {
            
            if (isiPhone5) {
                FinaoTable.frame = CGRectMake(0, 144, 320, 300);
            }
            else{
                FinaoTable.frame = CGRectMake(0, 144, 320, 220);
            }
        }
        if (Tilesbtn.selected) {
            
            if (isiPhone5) {
                TilesTable.frame = CGRectMake(0, 144, 320, 300);                }else{
                    TilesTable.frame = CGRectMake(0, 144, 320, 220);
                }
            //                [TilesTable reloadData];
            
        }
        
        if (Followerssbtn.selected) {
            if (isiPhone5) {
                FollowersTable.frame = CGRectMake(0, 144, 320, 300);
            }else{
                FollowersTable.frame = CGRectMake(0, 144, 320, 220);
            }
        }
        
        if (Followingbtn.selected) {
            
            if (isiPhone5) {
                FollowingTable.frame = CGRectMake(0, 144, 320, 300);
            }else{
                FollowingTable.frame = CGRectMake(0, 144, 320, 220);
            }
        }
    }
    
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    if (tableView == FinaoTable) {
        return [arrFINAOLIST count];
        
    }else if (tableView == TilesTable){
        return [arrTilesList count];
    }
    else if (tableView == FollowingTable){
        return [arrFollowingList count];
    }else{
        return [arrFollowersLIST count];
    }
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == FinaoTable) {
        
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
            cell.textLabel.text = [tempDict objectForKey:@"finao_title"]; //finao_msg
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        
        return cell;
    }else if (tableView == TilesTable){
        
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        
        if (NOTiles) {
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrTilesList objectAtIndex:indexPath.row];
        }
        else{
            cell.textLabel.textColor = [UIColor lightGrayColor];
            NSDictionary *tempDict = [arrTilesList objectAtIndex:indexPath.row];
            cell.textLabel.text = [tempDict objectForKey:@"tile_name"];
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        
        return cell;
        
    }
    else if(tableView == FollowingTable){
        
        if (NOFollowings)
        {
            UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
            
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrFollowingList objectAtIndex:indexPath.row];
            
            cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
            return cell;
        }
        else
        {
            FinaoFollowingCell *cell = (FinaoFollowingCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
            
            
            if(cell == nil)
                cell = [[FinaoFollowingCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoFollowingCell"];
            
            cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
            
            NSDictionary *tempDict = [arrFollowingList objectAtIndex:indexPath.row];
            
            cell.FollowingName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"name"]];
            
            
            NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            
            
            NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString: imageUrl1]];
            __weak FinaoFollowingCell *weakCell = cell;
            
            [cell.FollowingImage setImageWithURLRequest: urlRequest
                                       placeholderImage: [UIImage imageNamed:@"No_Image@2x"]
                                                success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {
                                                    
                                                    
                                                    NSInteger status = (NSInteger)[(NSHTTPURLResponse *) response statusCode];
                                                    
                                                    if(status== 200)
                                                        //NSLog(@"Following status :%ld",(long)status);
                                                    
                                                    
                                                    __strong FinaoFollowingCell *strongCell = weakCell;
                                                    strongCell.FollowingImage.image = image;
                                                    [strongCell.activityIndicatorView stopAnimating];
                                                    [strongCell.activityIndicatorView setHidden:YES];
                                                    
                                                }
                                                failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                    
                                                    //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                    
                                                    __strong FinaoFollowingCell *strongCell = weakCell;
                                                    [strongCell.FollowingImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                                                }
             
             ];
            
            [cell.activityIndicatorView setHidden:YES];
            [cell.activityIndicatorView stopAnimating];
            
            cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
            
            return cell;
        }
    }else//For Followers List
        
        if (tableView == FollowersTable) {
            
            if (NOFOLLOWERS) {
                
                
                UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
                
                cell.textLabel.textColor = [UIColor lightGrayColor];
                //NSLog(@"arrFollowersLIST:%@",arrFollowersLIST);
                cell.textLabel.text = [arrFollowersLIST objectAtIndex:indexPath.row];
                cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
                
                return cell;
            }
            else{
                
                FinaoFollowersCell *cell = (FinaoFollowersCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
                
                
                
                if(cell == nil)
                    cell = [[FinaoFollowersCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoFollowersCell"];
                
                NSDictionary *tempDict = [arrFollowersLIST objectAtIndex:indexPath.row];
                
                cell.FollowersName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"name"]] ;
                
                cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
                
                NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"h",[tempDict objectForKey:@"image"]];
                
                if ([tempDict objectForKey:@"image"] == nil) {
                    [cell.FollowersImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                }
                else{
                    NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString: imageUrl1]];
                    __weak FinaoFollowersCell *weakCell = cell;
                    
                    [cell.FollowersImage setImageWithURLRequest: urlRequest
                                               placeholderImage: [UIImage imageNamed:@"No_Image@2x"]
                                                        success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {
                                                            
                                                            NSInteger status = (NSInteger)[(NSHTTPURLResponse *) response statusCode];
                                                            
                                                            if(status== 200)
                                                                //NSLog(@"Following status :%ld at index:%ld",(long)status,(long)indexPath.row);
                                                            
                                                            __strong FinaoFollowersCell *strongCell = weakCell;
                                                            strongCell.FollowersImage.image = image;
                                                            [strongCell.activityIndicatorView stopAnimating];
                                                            [strongCell.activityIndicatorView setHidden:YES];
                                                            
                                                        }
                                                        failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                            
                                                            //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                            
                                                            __strong FinaoFollowersCell *strongCell = weakCell;
                                                            [strongCell.FollowersImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                                                            [strongCell.activityIndicatorView stopAnimating];
                                                            [strongCell.activityIndicatorView setHidden:YES];
                                                        }
                     
                     ];
                    [cell.activityIndicatorView setHidden:YES];
                    [cell.activityIndicatorView stopAnimating];
                }
                cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
                
                
                return cell;
                
            }
        }
        else{
            UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
            
            cell.textLabel.minimumScaleFactor = 8.0f;
            cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
            
            return cell;
        }
    
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == FinaoTable){
        return 60.0f;
    }
    else
        if (tableView == TilesTable){
            return 60.0f;
        }
        else{
            return 60.0f;
        }
}
-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == FinaoTable){
        
        NSDictionary *tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
        
        ProfileDetailViewController* profileDetail = [[ProfileDetailViewController alloc]initWithNibName:@"ProfileDetailViewController" bundle:nil];
        [self.navigationController pushViewController:profileDetail animated:YES];
        //NSLog(@"finao_title:%@",[tempDict objectForKey:@"finao_title"]);
        profileDetail.finao_id = [tempDict objectForKey:@"finao_id"];
        profileDetail.Finao_title = [tempDict objectForKey:@"finao_title"]; //finao_msg
        
        if ([[tempDict objectForKey:@"tracking_status"] integerValue] == 1) {
            profileDetail.isPublicstr = @"Public";
        }else{
            profileDetail.isPublicstr = @"Private";
        }
        profileDetail.SelfUser = YES;
        profileDetail.Finao_status = [tempDict objectForKey:@"finao_status"];
    }
    else
        if(tableView == TilesTable){
            
            //NSLog(@"arrTilesList:%@",arrTilesList);
            
            NSDictionary *tempDict = [arrTilesList objectAtIndex:indexPath.row];
            
            //NSLog(@"Temp:%@",[tempDict objectForKey:@"tile_id"]);
            
            TilesDetailViewController* tileDetail = [[TilesDetailViewController alloc]initWithNibName:@"TilesDetailViewController" bundle:nil];
            [self.navigationController pushViewController:tileDetail animated:YES];
            tileDetail.TileIDStr = [tempDict objectForKey:@"tile_id"];
            tileDetail.PassesUsrid = [USERDEFAULTS valueForKey:@"userid"];
            tileDetail.FriendsImageURL = imageUrl;
            tileDetail.SelfUser = YES;
        }
        else if(tableView == FollowingTable){
            
            NSDictionary *tempDict = [arrFollowingList objectAtIndex:indexPath.row];
            
            //NSLog(@"temp DICT : %@",tempDict);
            
            
            SearchORFollowingDetailViewController* searchDetails = [[SearchORFollowingDetailViewController alloc]initWithNibName:@"SearchORFollowingDetailViewController" bundle:nil];
            [self.navigationController pushViewController:searchDetails animated:YES];
            
            searchDetails.Firstname = [tempDict objectForKey:@"name"];
            searchDetails.Lastname = [tempDict objectForKey:@""];
            searchDetails.StoryText = [tempDict objectForKey:@"mystory"];
            NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            searchDetails.imageUrlStr = imageUrl1;
            
            searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
            searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
            searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
            searchDetails.SearchusrID = [tempDict objectForKey:@"userid"];
            searchDetails.PassesUsrid = [USERDEFAULTS valueForKey:@"userid"];
        }
    
        else{
            
            NSDictionary *tempDict = [arrFollowersLIST objectAtIndex:indexPath.row];
            
            //NSLog(@"temp DICT : %@",tempDict);
            
            
            SearchORFollowingDetailViewController* searchDetails = [[SearchORFollowingDetailViewController alloc]initWithNibName:@"SearchORFollowingDetailViewController" bundle:nil];
            [self.navigationController pushViewController:searchDetails animated:YES];
            
            searchDetails.Firstname = [tempDict objectForKey:@"name"];
            searchDetails.Lastname = [tempDict objectForKey:@""];
            searchDetails.StoryText = [tempDict objectForKey:@"mystory"];
            NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            searchDetails.imageUrlStr = imageUrl1;
            
            searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
            searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
            searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
            searchDetails.SearchusrID = [tempDict objectForKey:@"userid"];
            
        }
    [tableView deselectRowAtIndexPath:indexPath animated:NO];
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
