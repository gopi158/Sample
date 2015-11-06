//
//  SearchDetailNewViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 13/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SearchDetailNewViewController.h"
#import "UIImageView+AFNetworking.h"
#import "FinaoViewController.h"
#import "TilesViewController.h"
#import "FollowingViewController.h"
#import "TilesListTableViewController.h"

@interface SearchDetailNewViewController ()
-(void)LoadOthers:(NSNotification *) notification;
@end

@implementation SearchDetailNewViewController

@synthesize imageUrlStr;
@synthesize StoryText;
@synthesize NumofFinaos;
@synthesize NumofTiles;
@synthesize NumofFollowing;
@synthesize Firstname;
@synthesize Lastname;
@synthesize SearchusrID;
@synthesize PassesUsrid;
@synthesize BannerimageUrlStr;
@synthesize pssedDict;

dispatch_queue_t PostQueue_gcd;
dispatch_queue_t NotificationQueue_gcd;
NSString *profileImageUrl;
NSDictionary *avatars;
NSString *shareString;
NSString* name;
UIImageView *shareImage;
NSDictionary *tempDict;
NSURL *shareUrl;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
    }
    else
    {
        self.navigationController.navigationBar.translucent = NO;
        [[UITabBar appearance] setSelectedImageTintColor:[UIColor orangeColor]];
        
        [[UITabBar appearance] setBackgroundColor:[UIColor lightGrayColor]];
        self.tabBarController.tabBar.tintColor = [UIColor whiteColor];
        
        [[UINavigationBar appearance] setBackgroundImage:[[UIImage alloc] init] forBarMetrics:UIBarMetricsDefault];
        [[UINavigationBar appearance] setBackgroundColor:[UIColor whiteColor]];
        
    }
}

-(void)notificationinfo:(NSNotification*)notify{
    
    
}

-(void)LoadOthers:(NSNotification *) notification
{
    ListDic = Getnumlist.ListDic;
    avatars = [ListDic objectAtIndex:0];
    
    ProfileName.text = [NSString stringWithFormat:@"%@ %@",[avatars objectForKey:@"fname"] ,[avatars objectForKey:@"lname"] ];
    if(Firstname == nil){
        Firstname = [NSString stringWithFormat:@"%@ %@",[avatars objectForKey:@"fname"] ,[avatars objectForKey:@"lname"] ];
        [PostTableview reloadData];
    }
    profileImageUrl=[NSString stringWithFormat:@"%@",[avatars objectForKey:@"profile_image"]];
    NSString* bgimageUrl = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"banner_image"]];
    
    [Profileimgview setImageWithURL:[NSURL URLWithString:profileImageUrl]];
    [Bannerimgview setImageWithURL:[NSURL URLWithString:bgimageUrl] placeholderImage:[UIImage imageNamed:@"BannerPlaceholder"]];
    
    FinaoCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfinaos"] ];
    TileCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totaltiles"]];
    FollowingCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfollowings"]];
    FollowersCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfollowers"]];
    txtview.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"mystory"]];
}
-(void)getPostsList{
    dispatch_async(dispatch_get_main_queue(), ^ {
        getpostinfo = [[GetPostRecentPostinfo alloc]init];
        [getpostinfo GetPostInfoForUserId:SearchusrID];
    } );
}

-(void)initOthers{
    HeaderView = [[UIView alloc]initWithFrame:CGRectMake(-1, -1, 322, 314)];
    HeaderView.layer.borderWidth = 1.0f;
    HeaderView.layer.borderColor = [UIColor lightGrayColor].CGColor;
    HeaderView.backgroundColor = [UIColor whiteColor];
    [self.view addSubview:HeaderView];
    
    Bannerimgview = [[UIImageView alloc]init ];
    Bannerimgview.frame = CGRectMake(0, 0, 322, 140);
    Bannerimgview.layer.borderColor = [UIColor grayColor].CGColor;
    Bannerimgview.layer.borderWidth = 1.0f;
    Bannerimgview.image = [UIImage imageNamed:@"BannerPlaceholder"];
    [HeaderView addSubview:Bannerimgview];
    
    Profileimgview = [[UIImageView alloc]init ];
    Profileimgview.frame = CGRectMake(5, 120, 70, 70);
    Profileimgview.layer.borderColor = [UIColor grayColor].CGColor;
    Profileimgview.layer.borderWidth = 1.0f;
    Profileimgview.image = [UIImage imageNamed:@"chooseimg"];
    [HeaderView addSubview:Profileimgview];
    
    
    imgbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    imgbtn.frame = CGRectMake(10, 120, 107, 107);
    [imgbtn addTarget:self action:@selector(ImgBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:imgbtn];
    ProfileName = [[UILabel alloc]init];
    ProfileName.frame = CGRectMake(80,140,240,15);
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    ProfileName.adjustsFontSizeToFitWidth = YES;
    ProfileName.backgroundColor = [UIColor clearColor];
    ProfileName.textColor = [UIColor orangeColor];
    ProfileName.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:ProfileName];
    
    FinaoLbl = [[UILabel alloc]init];
    FinaoLbl.frame = CGRectMake(19,252,31,14);
    FinaoLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FinaoLbl.text = @"FINAOs";
    FinaoLbl.adjustsFontSizeToFitWidth = YES;
    FinaoLbl.backgroundColor = [UIColor clearColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];
    FinaoLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FinaoLbl];
    
    
    TileLbl = [[UILabel alloc]init];
    TileLbl.frame = CGRectMake(85,252,31,14);
    TileLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    TileLbl.text = @"TILES";
    TileLbl.adjustsFontSizeToFitWidth = YES;
    TileLbl.backgroundColor = [UIColor clearColor];
    TileLbl.textColor = [UIColor lightGrayColor];
    TileLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:TileLbl];
    
    
    FollowersLbl = [[UILabel alloc]init];
    FollowersLbl.frame = CGRectMake(152,252,52,14);
    FollowersLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowersLbl.text = @"FOLLOWERS";
    FollowersLbl.adjustsFontSizeToFitWidth = YES;
    FollowersLbl.backgroundColor = [UIColor clearColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];
    FollowersLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowersLbl];
    
    FollowingLbl = [[UILabel alloc]init];
    FollowingLbl.frame = CGRectMake(245,252,52,14);
    FollowingLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowingLbl.text = @"FOLLOWING";
    FollowingLbl.adjustsFontSizeToFitWidth = YES;
    FollowingLbl.backgroundColor = [UIColor clearColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];
    FollowingLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowingLbl];
    
    PostsLbl = [[UILabel alloc]init];
    PostsLbl.frame = CGRectMake(50,289,135,21);
    PostsLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    PostsLbl.text = @"POSTS";
    PostsLbl.adjustsFontSizeToFitWidth = YES;
    PostsLbl.backgroundColor = [UIColor clearColor];
    PostsLbl.textColor = [UIColor lightGrayColor];
    PostsLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:PostsLbl];
    
    InspiredLbl = [[UILabel alloc]init];
    InspiredLbl.frame = CGRectMake(178,289,135,21);
    InspiredLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    InspiredLbl.text = @"INSPIRED";
    InspiredLbl.adjustsFontSizeToFitWidth = YES;
    InspiredLbl.backgroundColor = [UIColor clearColor];
    InspiredLbl.textColor = [UIColor lightGrayColor];
    InspiredLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:InspiredLbl];
    
    
    FinaoCountLbl = [[UILabel alloc]init];
    FinaoCountLbl.frame = CGRectMake(22,262,31,20);
    FinaoCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    FinaoCountLbl.adjustsFontSizeToFitWidth = YES;
    FinaoCountLbl.backgroundColor = [UIColor clearColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];
    FinaoCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FinaoCountLbl];
    
    TileCountLbl = [[UILabel alloc]init];
    TileCountLbl.frame = CGRectMake(89,262,28,20);
    TileCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    TileCountLbl.adjustsFontSizeToFitWidth = YES;
    TileCountLbl.backgroundColor = [UIColor clearColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];
    TileCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:TileCountLbl];
    
    FollowersCountLbl = [[UILabel alloc]init];
    FollowersCountLbl.frame = CGRectMake(168,262,52,20);
    FollowersCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    FollowersCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowersCountLbl.backgroundColor = [UIColor clearColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowersCountLbl];
    
    FollowingCountLbl = [[UILabel alloc]init];
    FollowingCountLbl.frame = CGRectMake(255,262,52,20);
    FollowingCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    
    FollowingCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowingCountLbl.backgroundColor = [UIColor clearColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];
    FollowingCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowingCountLbl];
    
    
    Followbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followbtn.frame = CGRectMake(80, 231, 67, 20);
    Followbtn.backgroundColor = [UIColor blueColor];
    [Followbtn setTitle:@"Follow" forState: UIControlStateNormal];
    [Followbtn addTarget:self action:@selector(FollowClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followbtn];
    
    Finaobtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Finaobtn.frame = CGRectMake(19, 262, 54, 35);
    [Finaobtn addTarget:self action:@selector(FinaoBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Finaobtn];
    Finaobtn.selected = YES;
    
    
    Tilesbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Tilesbtn.frame = CGRectMake(85, 262, 54, 35);
    [Tilesbtn addTarget:self action:@selector(TilesbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Tilesbtn];
    
    Followerssbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followerssbtn.frame = CGRectMake(152, 262, 80, 35);
    [Followerssbtn addTarget:self action:@selector(FollowersbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followerssbtn];
    
    Followingbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followingbtn.frame = CGRectMake(248, 262, 80, 35);
    [Followingbtn addTarget:self action:@selector(FollowingbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followingbtn];
    
    Postsbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Postsbtn.frame = CGRectMake(19,300,135,21);
    [Postsbtn addTarget:self action:@selector(PostsbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Postsbtn];
    
    Inspiredbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Inspiredbtn.frame = CGRectMake(175,300,135,21);
    [Inspiredbtn addTarget:self action:@selector(InspiredbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Inspiredbtn];
    
    
    txtview = [[UITextView alloc]init ];
    txtview.frame = CGRectMake(75, 148, 240, 82);
    txtview.backgroundColor = [UIColor clearColor];
    txtview.textColor = [UIColor blackColor];
    [txtview setFont:[UIFont systemFontOfSize:16]];
    txtview.editable = NO;
    [HeaderView addSubview:txtview];
    [HeaderView bringSubviewToFront:txtview];
    
    Postsbtn.selected = YES;
    if (Postsbtn.isSelected) {
        PostsLbl.textColor = [UIColor blueColor];
    }
    [self addPosttable];
    [ self addInspiredtable];
    PostTableview.hidden = NO;
    InspiredTableview.hidden = YES;
    
    shareUrl = [NSURL URLWithString:@"http://www.finaonation.com"];
}

-(void)FollowingbtnClicked{
    
    FollowingViewController* following = [[FollowingViewController alloc]initWithNibName:@"FollowingViewController" bundle:nil];
    [self.navigationController pushViewController:following animated:YES];
    following.SelfUser = NO;
    following.Userid = [NSString stringWithFormat:@"%@",SearchusrID];
    //NSLog(@"following.Userid:%@",following.Userid);
}

-(void)FollowersbtnClicked{
    
    FollowersViewController* Followers = [[FollowersViewController alloc]initWithNibName:@"FollowersViewController" bundle:nil];
    [self.navigationController pushViewController:Followers animated:YES];
}

-(void)TilesbtnClicked{
    
    TilesViewController *Tiles = [[TilesViewController alloc]initWithNibName:@"TilesViewController" bundle:nil];
    [self.navigationController pushViewController:Tiles animated:YES];
    Tiles.SelfUser = NO;
    Tiles.Userid = [NSString stringWithFormat:@"%@",SearchusrID];
    Tiles.imageurl = imageUrlStr;
    Tiles.FriendusrName = [NSString stringWithFormat:@"%@ %@",Firstname,Lastname];
}

-(void)shareBtnClicked:(id)sender
{
    shareBtnBOOL = YES;
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [postarray objectAtIndex:index];
    if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
        shareString = [tempDict objectForKey:@"finao_msg"];
    }
    else{
        shareString = @"";
    }
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];

    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:(id)self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
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

#pragma mark End Post

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

-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    
    if (buttonIndex == 0) {
        [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
    }
    else
        if(buttonIndex ==1)
        {
            [self ShareAction];
            [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
            
        }
}
-(void)ImgBtnClicked{
    
    shareBtnBOOL = NO;
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Update Photo from"
                                                             delegate:(id)self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Take Photo With Camera", @"Select Photo From Library", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}
- (void)willPresentActionSheet:(UIActionSheet *)actionSheet
{
    for (UIView *subview in actionSheet.subviews) {
        if ([subview isKindOfClass:[UIButton class]]) {
            UIButton *button = (UIButton *)subview;
            [button setTitleColor:[UIColor blueColor] forState:UIControlStateNormal];
            if ([button.titleLabel.text isEqualToString:@"Cancel"] ) {
                [button setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
            }
        }
    }
}
- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (shareBtnBOOL) {
        if (buttonIndex == 0)
        {
            [self ShareAction];
        }
        else if (buttonIndex == 1)
        {
        }
    }else{
        if (buttonIndex == 0)
        {
            [self takeNewPhotoFromCamera];
        }
        else if (buttonIndex == 1)
        {
            [self choosePhotoFromExistingImages];
        }
    }
}

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    
	[picker dismissViewControllerAnimated:YES completion:nil];
    
    Profileimgview.image = [info objectForKey:@"UIImagePickerControllerEditedImage"];
}
- (void)takeNewPhotoFromCamera
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypeCamera])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypeCamera;
        controller.allowsEditing = NO;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypeCamera];
        controller.delegate = (id)self;
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
        controller.delegate = (id)self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }
}

-(void)FinaoBtnClicked{
    FinaoViewController * finao = [[FinaoViewController alloc]initWithNibName:@"FinaoViewController" bundle:nil];
    [self.navigationController pushViewController:finao animated:YES];
    finao.SelfUser = NO;
    finao.Userid = [NSString stringWithFormat:@"%@",SearchusrID];
    finao.imageurl = imageUrlStr;
    finao.FriendusrName = [NSString stringWithFormat:@"%@ %@",Firstname,Lastname];
}


-(void)FollowClicked{
    TilesListTableViewController* following = [[TilesListTableViewController alloc]initWithNibName:nil bundle:nil];
    following.Userid = [NSString stringWithFormat:@"%@",SearchusrID];
    //NSLog(@"follow.Userid:%@",following.Userid);
    [self.navigationController pushViewController:following animated:YES];
}


-(void)PostsbtnClicked{
    //NSLog(@"PostsbtnClicked");
    dispatch_async(PostQueue_gcd, ^{ [self getPostsList]; } );
    PostsLbl.textColor = [UIColor blueColor];
    InspiredLbl.textColor = [UIColor grayColor];
    PostTableview.hidden = NO;
    InspiredTableview.hidden = YES;
}

-(void)InspiredbtnClicked{
    //NSLog(@"InspiredbtnClicked");
    dispatch_async(PostQueue_gcd, ^{ [self getInspiredList]; } );
    PostsLbl.textColor = [UIColor grayColor];
    InspiredLbl.textColor = [UIColor blueColor];
    PostTableview.hidden = YES;
    InspiredTableview.hidden = NO;
}

#pragma mark Post related

-(void)addPosttable{
    if (isiPhone5) {
        PostTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 312, 320, 180) style:UITableViewStylePlain];
    }
    else{
        PostTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 312, 320, 80) style:UITableViewStylePlain];
    }
    PostTableview.delegate = (id)self;
    PostTableview.dataSource = (id)self;
    [PostTableview setSeparatorStyle:UITableViewCellSeparatorStyleSingleLine];
    [PostTableview setSeparatorColor:[UIColor grayColor]];
    [self.view addSubview:PostTableview];
    PostTableview.tableFooterView = [[UIView alloc]init];
}

#pragma mark Post related
-(void)addInspiredtable{
    if (isiPhone5) {
        InspiredTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 312, 320, 180) style:UITableViewStylePlain];
    }
    else{
        InspiredTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 312, 320, 80) style:UITableViewStylePlain];
    }
    InspiredTableview.delegate = (id)self;
    InspiredTableview.dataSource = (id)self;
    [InspiredTableview setSeparatorStyle:UITableViewCellSeparatorStyleSingleLine];
    [InspiredTableview setSeparatorColor:[UIColor grayColor]];
    [self.view addSubview:InspiredTableview];
    InspiredTableview.tableFooterView = [[UIView alloc]init];
}

- (UITableViewCell* )handleInspiredTableCell:(NSIndexPath *)indexPath
{
    if (UserisNew) {
        
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        cell.textLabel.textColor = [UIColor lightGrayColor];
        cell.textLabel.text = [inspiredarray objectAtIndex:indexPath.row];
        return cell;
    }
    else{
        NSDictionary *tempDict = [inspiredarray objectAtIndex:indexPath.row];
        //NSLog(@"tempDict is =%@",tempDict);
        
        ProfileDetailTableCell* cell = [[ProfileDetailTableCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"ProfileDetailTableCell"];
        
        cell.postImageView.hidden = YES;
        
        NSString* imageUrl = [NSString stringWithFormat:@"%@", profileImageUrl];
        
        [cell.ProfileImage setImageWithURL:[NSURL URLWithString:imageUrl]];
        [cell.shareBtn addTarget:self action:@selector(spamBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        cell.shareBtn.tag = indexPath.row;
        
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
            cell.inspireStatus.text = @"Inspiring";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            
        }
        cell.shareBtn.hidden = YES;
        
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
            cell.inspireStatus.text = @"Inspired";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            
        }
        
        
        cell.finao_status.text = [tempDict objectForKey:@"finao_status"];
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
            cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Finao_msg2.text = @"";
            cell.Finao_msg.text = @"";
        }
        
        if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
            cell.Finao_detail_table.hidden = YES;
            
            cell.Upload_text.frame = CGRectMake(cell.Upload_text.frame.origin.x+10, 400, cell.frame.size.width-10, cell.Upload_text.frame.size.height);
            
            cell.Finao_Symbol.frame = CGRectMake(cell.Finao_Symbol.frame.origin.x +10, 400, cell.Finao_Symbol.frame.size.width, cell.Finao_Symbol.frame.size.height);
            
            cell.postImageView.hidden = NO;
            
            NSString *profileimageUrlFromResponse=[tempDict objectForKey:@"profile_image"];
            if(profileimageUrlFromResponse == nil)
                profileimageUrlFromResponse = profileImageUrl;
            cell.ProfileImage.image =[UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:profileimageUrlFromResponse]]];
            
            cell.shareBtn.frame = CGRectMake(cell.shareBtn.frame.origin.x, 400, cell.shareBtn.frame.size.width,cell.shareBtn.frame.size.height);
            cell.VideoImageview.hidden = YES;
        }
        
        
        cell.ProfileName.text = [NSString stringWithFormat:@"%@", ProfileName.text];
        //NSLog(@"temp = %@",tempDict);
        cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
        }
        else{
            cell.Upload_text.text = @"";
        }
        [cell ChangeFramesHomecell];
        if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
            cell.finao_status.frame = CGRectMake(16, 413, 50, 20);
            cell.inspireStatus.frame = CGRectMake(220, 413, 50, 20);
            cell.shareBtn.frame = CGRectMake(276, 413, 30, 20);
        }
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
            cell.Images_arr = [tempDict objectForKey:@"image_urls"];
        }
        if ([cell.Images_arr count] == 0) {
            [cell ChangeFrameShare];
        }
        cell.playbtn.hidden = YES; // force off
        cell.shareBtn.tag = indexPath.row;
        [cell.shareBtn addTarget:self action:@selector(shareBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
        
        cell.playbtn.hidden = YES;
        if ([[tempDict objectForKey:@"image_urls"] count] == 0) {
            [cell ChangeFrameShare];
        }
        if ([[tempDict objectForKey:@"status"] integerValue] == 38
            || [[tempDict objectForKey:@"status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"status"] integerValue] == 39
               || [[tempDict objectForKey:@"status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"status"] integerValue] == 40
                    || [[tempDict objectForKey:@"status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"status"] integerValue] == 41
                    || [[tempDict objectForKey:@"status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            }
        }
        
        return cell;
    }
}


- (void)adjustCellFrames:(NSDictionary *)tempDict cell:(ProfileDetailTableCell *)cell
{
    NSDictionary * imageArrayDict = [tempDict objectForKey:@"image_urls"];
    if ([imageArrayDict count] > 0) {
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
            cell.Images_arr = [tempDict objectForKey:@"image_urls"];
        }
        cell.Finao_detail_table.hidden = NO;
        cell.Upload_text.frame = CGRectMake(22, 40, 230, 35);
        cell.ProfileName.frame = CGRectMake(32, 10, 160, 27);
        cell.Finao_msg2.frame = CGRectMake(20, 370, 270, 30);
        cell.finao_status.frame = CGRectMake(235, 255, 50, 27);
    }
    else{ // no image, image hidden
        cell.Images_arr = nil;
        cell.Finao_detail_table.hidden = YES;
        [cell.activityIndicatorView stopAnimating];
        [cell.activityIndicatorView setHidden:YES];
        cell.Upload_text.frame = CGRectMake(22, 40, 230, 35);
        cell.Finao_msg2.frame = CGRectMake(20, 70, 270, 30);
        cell.ProfileName.frame = CGRectMake(32, 10, 160, 27);
    }
    [cell.activityIndicatorView stopAnimating];
    [cell.activityIndicatorView setHidden:YES];
}

- (UITableViewCell* )handlePostTableCell:(NSIndexPath *)indexPath
{
    if (UserisNew) {
        
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        cell.textLabel.textColor = [UIColor lightGrayColor];
        cell.textLabel.text = [postarray objectAtIndex:indexPath.row];
        return cell;
    }
    else{
        NSDictionary *tempDict = [postarray objectAtIndex:indexPath.row];
        //NSLog(@"tempDict is =%@",tempDict);
        
        ProfileDetailTableCell* cell = [[ProfileDetailTableCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"ProfileDetailTableCell"];
        
        cell.postImageView.hidden = YES;
        
        NSString* imageUrl = [[NSString stringWithFormat:@"%@",profileImageUrl]stringByReplacingOccurrencesOfString:@" " withString:@"%20"];
        [cell.ProfileImage setImageWithURL:[NSURL URLWithString:imageUrl]];
        
        //NSLog(@"tempDict is =%@",[tempDict objectForKey:@"finao_msg"]);
        //NSLog(@"tempDict is =%@",[tempDict objectForKey:@"upload_text"]);
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
            cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
        }
        else{
            cell.Finao_msg.text = @"";
        }
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Finao_msg2.text = @"";
        }
        
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
            cell.inspireStatus.text = @"Inspiring";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.textColor = [UIColor whiteColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
            cell.inspireStatus.text = @"Inspired";
            cell.inspireStatus.backgroundColor = [UIColor whiteColor];
            cell.inspireStatus.textColor = [UIColor redColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
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
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            }
        }
        cell.shareBtn.hidden = YES;
        if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
            
            cell.Finao_detail_table.hidden = YES;
            
            cell.Upload_text.frame = CGRectMake(cell.Upload_text.frame.origin.x+10, 400, cell.frame.size.width-10, cell.Upload_text.frame.size.height);
            
            cell.Finao_Symbol.frame = CGRectMake(cell.Finao_Symbol.frame.origin.x +10, 400, cell.Finao_Symbol.frame.size.width, cell.Finao_Symbol.frame.size.height);
            
            cell.postImageView.hidden = NO;
            
            NSString *postimageUrl=[[[tempDict objectForKey:@"image_urls"] objectAtIndex:0] objectForKey:@"image_url"];
            
            dispatch_async(PostQueue_gcd, ^{
                NSData * theData = [NSData dataWithContentsOfURL:[NSURL URLWithString:postimageUrl]];
                dispatch_async(dispatch_get_main_queue(), ^ {
                    cell.postImageView.image =[UIImage imageWithData:theData];
                });
            } );
            
            cell.shareBtn.frame = CGRectMake(cell.shareBtn.frame.origin.x, 400, cell.shareBtn.frame.size.width,cell.shareBtn.frame.size.height);
            cell.VideoImageview.hidden = YES;
        }
        
        //[self adjustCellFrames:tempDict cell:cell];
        
        cell.ProfileName.text = [NSString stringWithFormat:@"%@", Firstname];
        
        //NSLog(@"temp = %@",tempDict); 
        
        cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
        }
        else{
            cell.Upload_text.text = @"";
        }
        [cell ChangeFramesHomecell];
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
            cell.Images_arr = [tempDict objectForKey:@"image_urls"];
        }
        if ([cell.Images_arr count] == 0) {
            [cell ChangeFrameShare];
        }
        cell.playbtn.hidden = YES; // force off
        cell.shareBtn.tag = indexPath.row;
        [cell.shareBtn addTarget:self action:@selector(shareBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
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
            }
        }
        cell.inspireStatus.frame = CGRectMake( cell.inspireStatus.frame.origin.x+35, cell.inspireStatus.frame.origin.y, cell.inspireStatus.frame.size.width, cell.inspireStatus.frame.size.height);
        return cell;
    }
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (tableView == PostTableview){
        return [self handlePostTableCell:indexPath];
    }
    if (tableView == InspiredTableview){
        return [self handleInspiredTableCell:indexPath];
    }
    return nil;
}


-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    if (tableView == PostTableview){
        return [postarray count];
    }
    if (tableView == InspiredTableview){
        return [inspiredarray count];
    }
    return 0;
    
}



- (CGFloat)handleHeigthForInspiredTable:(NSIndexPath *)indexPath
{
    if (UserisNew) {
        return 40.0f;
    }
    else{
        //NSLog(@"indexPath.row is =%ld",(long)indexPath.row);
        NSDictionary *tempDict = [inspiredarray objectAtIndex:indexPath.row];
        //NSLog(@"dictionary is =%@",tempDict);
        CGFloat heightForPostImage = 0.0f;
        
        if ([[tempDict objectForKey:@"image_urls"]count] >0) {
            heightForPostImage=320.0f;
            return 117.0f + heightForPostImage;
        }
        else{
            return 117.0f + heightForPostImage;
        }
    }
}
- (CGFloat)handleHeigthForPostTable:(NSIndexPath *)indexPath
{
    if (UserisNew) {
        return 40.0f;
    }
    else{
        NSDictionary *tempDict = [postarray objectAtIndex:indexPath.row];
        
        //NSLog(@"dictionary is =%@",tempDict);
        
        CGFloat heightForPostImage = 0.0f;
        
        if ([[tempDict objectForKey:@"image_urls"]count] >0) {
            heightForPostImage=310.0f;
        }
        
        if ([[tempDict objectForKey:@"type"] integerValue] == 0) {
            return 117.0f + heightForPostImage;
        }
        else if ([[tempDict objectForKey:@"type"] integerValue] == 1) {
            if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSString class]]){
                return 117.0f + heightForPostImage ;
            }else{
                return 400.0f ;
            }
        }else if ([[tempDict objectForKey:@"type"] integerValue] == 2){
            return 300.0f;
        }else
            return 400.0f;
    }
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (tableView == PostTableview){
        return [self handleHeigthForPostTable:indexPath];
    }
    if (tableView == InspiredTableview){
        return [self handleHeigthForInspiredTable:indexPath];
    }
    return 0;
    
}
- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    
    CGFloat sectionHeaderHeight = 10;
    if (scrollView.contentOffset.y<sectionHeaderHeight&&scrollView.contentOffset.y>0)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-scrollView.contentOffset.y, 0, 0, 0);
        
        TablesScrolledUP = NO;
        
        [UIView animateWithDuration:0.5
                         animations:^{
                             HeaderView.frame = CGRectMake(-1, -1, 322, 314);
                             if (isiPhone5) {
                                 PostTableview.frame = CGRectMake(0, 292, 320, 180);
                                 InspiredTableview.frame = CGRectMake(0, 292, 320, 180);
                             }
                             else{
                                 PostTableview.frame = CGRectMake(0, 292, 320, 80);
                                 InspiredTableview.frame = CGRectMake(0, 292, 320, 80);
                             }
                         }
                         completion:^(BOOL finished){
                         }];
        
        
    }
    else if (scrollView.contentOffset.y>sectionHeaderHeight)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-sectionHeaderHeight, 0, 0, 0);
        
        TablesScrolledUP = YES;
        [UIView animateWithDuration:0.5
                         animations:^{
                             HeaderView.frame = CGRectMake(-1, -278, 322, 314);
                             if (isiPhone5) {
                                 PostTableview.frame = CGRectMake(0, 38, 320, 450);
                                 InspiredTableview.frame = CGRectMake(0, 38, 320, 450);
                             }
                             else{
                                 PostTableview.frame = CGRectMake(0, 38, 320, 350);
                                 InspiredTableview.frame = CGRectMake(0, 38, 320, 350);
                             }
                         }
                         completion:^(BOOL finished){
                         }];
    }
}

#pragma mark End Post

-(void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 )
    {
        self.navigationController.navigationBar.translucent = NO;
        [self.navigationController.view.layer setMasksToBounds:YES];
    }
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    
    TablesScrolledUP = NO;
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(LoadOthers:)
                                                 name:@"GETLISTNUMBERS"
                                               object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(PostInfo:)
                                                 name:@"GETPOSTSINFO"
                                               object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(InspiredInfo:)
                                                 name:@"GETINSPIREDINFO"
                                               object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(notificationinfo:)
                                                 name:@"GETNOTIFICATIONSINFO"
                                               object:nil];
    [self initOthers];
    
    PostQueue_gcd = dispatch_queue_create("com.Finao.Posts", NULL);
    dispatch_async(PostQueue_gcd, ^{ [self getPostsList]; } );
    dispatch_async(dispatch_get_main_queue(), ^ {
        Getnumlist = [[GetNumofList alloc]init];
        [Getnumlist GetNumbers:SearchusrID];
    });
    
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETPOSTSINFO" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETINSPIREDINFO" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETLISTNUMBERS" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];
}
-(void)getInspiredList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        getinspiredinfo = [[GetInspiredinfo alloc]init];
        [getinspiredinfo GetInspiredInfo];
        
    } );
}

-(void)InspiredInfo:(NSNotification*)notify{
    inspiredarray = getinspiredinfo.InspiredListDic;
    //inspiredarray = getpostinfo.FinaoListDic;
    if ([inspiredarray count] == 0) {
        [inspiredarray addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNew = TRUE;
    }
    
    
    PostTableview.hidden = YES;
    if (![USERDEFAULTS valueForKey:@"BlurredImage"])
    {
        [self performSelectorOnMainThread:@selector(takeScreenshotofProfileview) withObject:nil waitUntilDone:YES];
        [self takeScreenshotofProfileview];
    }
    InspiredTableview.hidden = NO;
    [InspiredTableview reloadData];
}

-(void)PostInfo:(NSNotification*)notify{
    
    postarray = getpostinfo.FinaoListDic;
    
    if ([postarray count] == 0) {
        [postarray addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNew = TRUE;
    }
    
    InspiredTableview.hidden = YES;
    if (![USERDEFAULTS valueForKey:@"BlurredImage"])
    {
        [self performSelectorOnMainThread:@selector(takeScreenshotofProfileview) withObject:nil waitUntilDone:YES];
        [self takeScreenshotofProfileview];
    }
    PostTableview.hidden = NO;
    [PostTableview reloadData];
}

-(void)takeScreenshotofProfileview{
    
    NSString *imagePath = [[NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0] stringByAppendingPathComponent:@"/Blurredimage.png"];
    UIGraphicsBeginImageContext(self.view.bounds.size);
    [self.view.layer renderInContext:UIGraphicsGetCurrentContext()];
    UIImage *screenshotImage = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    UIImage *screenshotImageeffect =[screenshotImage applyLightEffect];
    NSData *pngData = UIImageJPEGRepresentation(screenshotImageeffect,1);
    
    [pngData writeToFile:imagePath atomically:YES];
    
    [USERDEFAULTS setBool:YES forKey:@"BlurredImage"];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

#pragma ActionSheet
-(void)spamBtnClicked:(id)sender{
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:(id)self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share",@"Follow this Tile", @"Flag as Inappropriate", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}


@end
