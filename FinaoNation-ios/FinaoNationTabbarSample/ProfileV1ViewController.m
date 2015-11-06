//
//  ProfileV1ViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileV1ViewController.h"

@interface ProfileV1ViewController ()

@end

@implementation ProfileV1ViewController

dispatch_queue_t PostQueue_gcd;
dispatch_queue_t NotificationQueue_gcd;
NSString *profileImageUrl;
NSString *shareString;
NSString* name;
UIImageView *shareImage;
NSDictionary *tempDict;
NSURL *shareUrl;
static dispatch_once_t once;

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
        self.title = @"Profile";
        
        self.tabBarItem.image = [UIImage imageNamed:@"profile"];
        shareString = @"Sharing my FINAO.";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [APPDELEGATE setCurrentNav:self.navigationController];
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
    
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithImage:[UIImage imageNamed:@"menu_orange"] style:UIBarButtonItemStylePlain target:self action:@selector(SideMenuButtonPressed)];
    shareUrl = [NSURL URLWithString:@"http://www.finaonation.com"];
}

- (void)SideMenuButtonPressed {
    MenuViewController* menu = [[MenuViewController alloc]initWithNibName:@"MenuViewController" bundle:nil];
    [self.navigationController pushViewController:menu animated:YES];
}

-(void)initOthers{
    HeaderView = [[UIView alloc]initWithFrame:CGRectMake(-1, -1, 322, 294)];
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
    
    //Profile Image view
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
    
    NSString* NameString = [NSString stringWithFormat:@"%@ %@",[USERDEFAULTS valueForKey:@"name"],[USERDEFAULTS valueForKey:@""]];
    //NSLog(@"%@",NameString);
    ProfileName = [[UILabel alloc]init];
    ProfileName.frame = CGRectMake(132,155,150,21);
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    ProfileName.text = NameString;
    ProfileName.adjustsFontSizeToFitWidth = YES;
    ProfileName.backgroundColor = [UIColor clearColor];
    ProfileName.textColor = [UIColor blackColor];
    ProfileName.textAlignment = NSTextAlignmentLeft;
    //[HeaderView addSubview:ProfileName];
    
    FinaoLbl = [[UILabel alloc]init];
    FinaoLbl.frame = CGRectMake(19,232,31,14);
    FinaoLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FinaoLbl.text = @"FINAOs";
    FinaoLbl.adjustsFontSizeToFitWidth = YES;
    FinaoLbl.backgroundColor = [UIColor clearColor];
    FinaoLbl.textColor = [UIColor lightGrayColor];
    FinaoLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FinaoLbl];
    
    
    TileLbl = [[UILabel alloc]init];
    TileLbl.frame = CGRectMake(85,232,31,14);
    TileLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    TileLbl.text = @"TILES";
    TileLbl.adjustsFontSizeToFitWidth = YES;
    TileLbl.backgroundColor = [UIColor clearColor];
    TileLbl.textColor = [UIColor lightGrayColor];
    TileLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:TileLbl];
    
    
    FollowersLbl = [[UILabel alloc]init];
    FollowersLbl.frame = CGRectMake(152,232,52,14);
    FollowersLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowersLbl.text = @"FOLLOWERS";
    FollowersLbl.adjustsFontSizeToFitWidth = YES;
    FollowersLbl.backgroundColor = [UIColor clearColor];
    FollowersLbl.textColor = [UIColor lightGrayColor];
    FollowersLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowersLbl];
    
    FollowingLbl = [[UILabel alloc]init];
    FollowingLbl.frame = CGRectMake(245,232,52,14);
    FollowingLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:8];
    FollowingLbl.text = @"FOLLOWING";
    FollowingLbl.adjustsFontSizeToFitWidth = YES;
    FollowingLbl.backgroundColor = [UIColor clearColor];
    FollowingLbl.textColor = [UIColor lightGrayColor];
    FollowingLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:FollowingLbl];
    
    PostsLbl = [[UILabel alloc]init];
    PostsLbl.frame = CGRectMake(19,265,135,21);
    PostsLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    PostsLbl.text = @"POSTS";
    PostsLbl.adjustsFontSizeToFitWidth = YES;
    PostsLbl.backgroundColor = [UIColor clearColor];
    PostsLbl.textColor = [UIColor lightGrayColor];
    PostsLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:PostsLbl];
    
    InspiredLbl = [[UILabel alloc]init];
    InspiredLbl.frame = CGRectMake(175,265,135,21);
    InspiredLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:18];
    InspiredLbl.text = @"INSPIRED";
    InspiredLbl.adjustsFontSizeToFitWidth = YES;
    InspiredLbl.backgroundColor = [UIColor clearColor];
    InspiredLbl.textColor = [UIColor lightGrayColor];
    InspiredLbl.textAlignment = NSTextAlignmentLeft;
    [HeaderView addSubview:InspiredLbl];
    
    
    FinaoCountLbl = [[UILabel alloc]init];
    FinaoCountLbl.frame = CGRectMake(22,243,31,20);
    FinaoCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    
    FinaoCountLbl.adjustsFontSizeToFitWidth = YES;
    FinaoCountLbl.backgroundColor = [UIColor clearColor];
    FinaoCountLbl.textColor = [UIColor lightGrayColor];
    FinaoCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FinaoCountLbl];
    
    TileCountLbl = [[UILabel alloc]init];
    TileCountLbl.frame = CGRectMake(89,243,28,20);
    TileCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    
    TileCountLbl.adjustsFontSizeToFitWidth = YES;
    TileCountLbl.backgroundColor = [UIColor clearColor];
    TileCountLbl.textColor = [UIColor lightGrayColor];
    TileCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:TileCountLbl];
    
    FollowersCountLbl = [[UILabel alloc]init];
    FollowersCountLbl.frame = CGRectMake(168,243,52,20);
    FollowersCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    
    FollowersCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowersCountLbl.backgroundColor = [UIColor clearColor];
    FollowersCountLbl.textColor = [UIColor lightGrayColor];
    FollowersCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowersCountLbl];
    
    FollowingCountLbl = [[UILabel alloc]init];
    FollowingCountLbl.frame = CGRectMake(255,243,52,20);
    FollowingCountLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    
    FollowingCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowingCountLbl.backgroundColor = [UIColor clearColor];
    FollowingCountLbl.textColor = [UIColor lightGrayColor];
    FollowingCountLbl.textAlignment = NSTextAlignmentJustified;
    [HeaderView addSubview:FollowingCountLbl];
    
    
    Finaobtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Finaobtn.frame = CGRectMake(19, 231, 54, 35);
    [Finaobtn addTarget:self action:@selector(FinaoBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Finaobtn];
    Finaobtn.selected = YES;
    
    Tilesbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Tilesbtn.frame = CGRectMake(85, 231, 54, 35);
    [Tilesbtn addTarget:self action:@selector(TilesbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Tilesbtn];
    
    Followerssbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followerssbtn.frame = CGRectMake(152, 231, 80, 35);
    [Followerssbtn addTarget:self action:@selector(FollowersbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followerssbtn];
    
    Followingbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followingbtn.frame = CGRectMake(248, 231, 80, 35);
    [Followingbtn addTarget:self action:@selector(FollowingbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Followingbtn];
    
    Postsbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Postsbtn.frame = CGRectMake(19,258,135,35);
    [Postsbtn addTarget:self action:@selector(PostsbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Postsbtn];
    
    Inspiredbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Inspiredbtn.frame = CGRectMake(175,258,135,35);
    [Inspiredbtn addTarget:self action:@selector(InspiredbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Inspiredbtn];
    
    
    txtview = [[UITextView alloc]init ];
    txtview.frame = CGRectMake(75, 143, 245, 85);
    txtview.backgroundColor = [UIColor clearColor];
    txtview.text = [USERDEFAULTS valueForKey:@"mystory"];
    txtview.textColor = [UIColor blackColor];
    [txtview setFont:[UIFont systemFontOfSize:16]];
    txtview.editable = NO;
    [HeaderView addSubview:txtview];
    [HeaderView bringSubviewToFront:txtview];
    
    Postsbtn.selected = YES;
    if (Postsbtn.isSelected) {
        PostsLbl.textColor = [UIColor blueColor];
    }
    
    profileImageUrl=[NSString stringWithFormat:@"%@",[USERDEFAULTS objectForKey:@"profile_image"]];
    [Profileimgview setImageWithURL:[NSURL URLWithString:profileImageUrl]];
    NSString* bgimageUrl = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"profile_bg_image"]];
    
    [Bannerimgview setImageWithURL:[NSURL URLWithString:bgimageUrl] placeholderImage:[UIImage imageNamed:@"BannerPlaceholder"]];
    
    [self addPosttable];
    [ self addInspiredtable];
    PostTableview.hidden = NO;
    InspiredTableview.hidden = YES;
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
-(void)ImgBtnClicked{
    
    shareBtnBOOL = NO;
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Update Photo from"
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
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
    if (buttonIndex == 0)
    {
        [self ShareAction];
    }
    else if (buttonIndex == 1)
    {
        UIAlertView* DeleteAlert = [[UIAlertView alloc]initWithTitle:@"Finao" message:@"Delete Finao" delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"OK", nil];
        DeleteAlert.tag = 2;
        [DeleteAlert show];
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



-(void)FinaoBtnClicked{
    FinaoViewController* finao = [[FinaoViewController alloc]initWithNibName:@"FinaoViewController" bundle:nil];
    [self.navigationController pushViewController:finao animated:YES];
    finao.SelfUser = YES;
}

-(void)TilesbtnClicked{
    
    TilesViewController* Tiles = [[TilesViewController alloc]initWithNibName:@"TilesViewController" bundle:nil];
    [self.navigationController pushViewController:Tiles animated:YES];
    Tiles.SelfUser = YES;
    
}

-(void)FollowingbtnClicked{
    
    FollowingViewController* Following = [[FollowingViewController alloc]initWithNibName:@"FollowingViewController" bundle:nil];
    [self.navigationController pushViewController:Following animated:YES];
    Following.SelfUser = YES;
}

-(void)FollowersbtnClicked{
    
    FollowersViewController* Followers = [[FollowersViewController alloc]initWithNibName:@"FollowersViewController" bundle:nil];
    [self.navigationController pushViewController:Followers animated:YES];
}

-(void)PostsbtnClicked
{
    //NSLog(@"PostsbtnClicked");
    dispatch_async(PostQueue_gcd, ^{ [self getPostsList]; } );
    PostsLbl.textColor = [UIColor blueColor];
    InspiredLbl.textColor = [UIColor grayColor];
    PostTableview.hidden = NO;
    InspiredTableview.hidden = YES;
}

-(void)InspiredbtnClicked
{
    //NSLog(@"InspiredbtnClicked");
    dispatch_async(PostQueue_gcd, ^{ [self getInspiredList]; } );
    PostsLbl.textColor = [UIColor grayColor];
    InspiredLbl.textColor = [UIColor blueColor];
    PostTableview.hidden = YES;
    InspiredTableview.hidden = NO;
}

#pragma mark Post related
-(void)addPosttable
{
    if (isiPhone5) {
        PostTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 292, 320, 180) style:UITableViewStylePlain];
    }
    else{
        PostTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 292, 320, 80) style:UITableViewStylePlain];
    }
    PostTableview.delegate = (id)self;
    PostTableview.dataSource = (id)self;
    [PostTableview setSeparatorStyle:UITableViewCellSeparatorStyleSingleLine];
    [PostTableview setSeparatorColor:[UIColor grayColor]];
    PostTableview.tableFooterView = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 320, 30) ];
    [self.view addSubview:PostTableview];
}

#pragma mark Post related
-(void)addInspiredtable
{
    if (isiPhone5) {
        InspiredTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 292, 320, 180) style:UITableViewStylePlain];
    }
    else{
        InspiredTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 292, 320, 80) style:UITableViewStylePlain];
    }
    InspiredTableview.delegate = self;
    InspiredTableview.dataSource = self;
    [InspiredTableview setSeparatorStyle:UITableViewCellSeparatorStyleSingleLine];
    [InspiredTableview setSeparatorColor:[UIColor grayColor]];
    InspiredTableview.tableFooterView = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 320, 20) ];
    [self.view addSubview:InspiredTableview];
}

- (CGFloat)tableView:(UITableView *)tableView heightForHeaderInSection:(NSInteger)section
{
    return 20.0;
}

- (UITableViewCell* )handleInspiredTableCell:(NSIndexPath *)indexPath
{
    
    tempDict = [inspiredarray objectAtIndex:indexPath.row];
    //NSLog(@"tempDict is =%@",tempDict);
    
    ProfileDetailTableCell* cell = [[ProfileDetailTableCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"ProfileDetailTableCell"];
    
    cell.postImageView.hidden = YES;
    
    NSString* imageUrl = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"profile_image"]];
    
    [cell.ProfileImage setImageWithURL:[NSURL URLWithString:imageUrl]];
    [cell.shareBtn addTarget:self action:@selector(shareClickedInspired:) forControlEvents:UIControlEventTouchUpInside];
    cell.shareBtn.tag = indexPath.row;
    cell.shareBtn.hidden = YES;
    
    if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
        cell.inspireStatus.text = @"Inspiring";
        cell.inspireStatus.backgroundColor = [UIColor orangeColor];
        
    }
    if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
        cell.inspireStatus.text = @"Inspired";
        cell.inspireStatus.backgroundColor = [UIColor orangeColor];
        
    }
    cell.inspireStatus.hidden = YES;
    if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
        cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
    }
    else{
        cell.Finao_msg.text = @"";
    }
    cell.finao_status.text = [tempDict objectForKey:@"finao_status"];
    if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
        cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
    }
    else{
        cell.Finao_msg2.text = @"";
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
    
    
    cell.ProfileName.text = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
    
    //NSLog(@"temp = %@",tempDict);
    
    cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
    
    if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
        cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
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
    [cell.shareBtn addTarget:self action:@selector(shareClickedInspired:) forControlEvents:UIControlEventTouchUpInside];
    
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
    
    if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
        cell.finao_status.frame = CGRectMake( cell.finao_status.frame.origin.x, cell.finao_status.frame.origin.y + 15, cell.finao_status.frame.size.width, cell.finao_status.frame.size.height);
    }
    //cell.finao_status.frame = CGRectMake( cell.finao_status.frame.origin.x, cell.finao_status.frame.origin.y + 2, cell.finao_status.frame.size.width, cell.finao_status.frame.size.height);
    
    else{
        cell.finao_status.frame = CGRectMake( cell.finao_status.frame.origin.x, cell.finao_status.frame.origin.y + 22, cell.finao_status.frame.size.width, cell.finao_status.frame.size.height);
        cell.Finao_msg.hidden = YES;
        cell.Finao_detail_table.hidden = YES;
        cell.shareBtn.frame = CGRectMake( cell.shareBtn.frame.origin.x, cell.shareBtn.frame.origin.y + 22, cell.shareBtn.frame.size.width, cell.shareBtn.frame.size.height);
        //Finao_msg2
        cell.Finao_msg2.frame = CGRectMake( cell.Finao_msg2.frame.origin.x, cell.Finao_msg2.frame.origin.y + 12, cell.Finao_msg2.frame.size.width, cell.Finao_msg2.frame.size.height);
    }
    
    return cell;
}

- (UITableViewCell* )handlePostTableCell:(NSIndexPath *)indexPath
{
    tempDict = [postarray objectAtIndex:indexPath.row];
    //NSLog(@"tempDict is =%@",tempDict);
    ProfileDetailTableCell* cell = [[ProfileDetailTableCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"ProfileDetailTableCell"];
    cell.postImageView.hidden = YES;
    
    NSString* imageUrl = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"profile_image"]];
    
    [cell.ProfileImage setImageWithURL:[NSURL URLWithString:imageUrl]];
    
    cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
    if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
        cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
    }
    else{
        cell.Finao_msg2.text = @"";
    }
    if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
        
        cell.Finao_detail_table.hidden = YES;
        cell.Upload_text.frame = CGRectMake(cell.Upload_text.frame.origin.x+10, 400, cell.frame.size.width-10, cell.Upload_text.frame.size.height);
        
        cell.Finao_Symbol.frame = CGRectMake(cell.Finao_Symbol.frame.origin.x +10, 400, cell.Finao_Symbol.frame.size.width, cell.Finao_Symbol.frame.size.height);
        
        NSString *profileimageUrlFromResponse=[tempDict objectForKey:@"profile_image"];
        if(profileimageUrlFromResponse == nil)
            profileimageUrlFromResponse = profileImageUrl;
        cell.ProfileImage.image =[UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:profileimageUrlFromResponse]]];
        
        cell.shareBtn.frame = CGRectMake(cell.shareBtn.frame.origin.x, 400, cell.shareBtn.frame.size.width,cell.shareBtn.frame.size.height);
        cell.VideoImageview.hidden = YES;
    }
    else{
        cell.Finao_msg2.frame = CGRectMake(16, 62, 270, 30);
    }
    if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
        cell.inspireStatus.text = @"Inspiring";
        cell.inspireStatus.backgroundColor = [UIColor orangeColor];
        cell.inspireStatus.textColor = [UIColor whiteColor];
        cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
        
    }
    else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
        cell.inspireStatus.text = @"Inspired";
        cell.inspireStatus.backgroundColor = [UIColor orangeColor];
        cell.inspireStatus.backgroundColor = [UIColor whiteColor];
        cell.inspireStatus.textColor = [UIColor redColor];
        cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
        
    }
    cell.inspireStatus.hidden = YES;
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
    
    cell.ProfileName.text = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
    
    //NSLog(@"temp = %@",tempDict);
    
    cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
    
    if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
        cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
    }
    [cell ChangeFramesHomecell];
    if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
        cell.Images_arr = [tempDict objectForKey:@"image_urls"];
    }
    if ([cell.Images_arr count] == 0) {
        [cell ChangeFrameShare];
    }
    cell.playbtn.hidden = YES; // force off
    [cell.shareBtn addTarget:self action:@selector(shareClicked:) forControlEvents:UIControlEventTouchUpInside];
    cell.shareBtn.tag = indexPath.row;
    
    if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
        || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
        cell.finao_status.text = @"Ontrack";
        cell.finao_status.backgroundColor = [UIColor lightGrayColor];
        
    }
    else {
        if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
           || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
            cell.finao_status.text = @"Ahead";
            cell.finao_status.backgroundColor = [UIColor colorWithRed:50.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
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
    cell.shareBtn.frame = CGRectMake( cell.shareBtn.frame.origin.x-5, cell.shareBtn.frame.origin.y, cell.shareBtn.frame.size.width+5, cell.shareBtn.frame.size.height);
    if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
    }
    else{
        cell.finao_status.frame = CGRectMake( cell.finao_status.frame.origin.x, cell.finao_status.frame.origin.y + 22, cell.finao_status.frame.size.width, cell.finao_status.frame.size.height);
        cell.Finao_msg.hidden = YES;
        cell.Finao_detail_table.hidden = YES;
        cell.shareBtn.frame = CGRectMake( cell.shareBtn.frame.origin.x, cell.shareBtn.frame.origin.y + 22, cell.shareBtn.frame.size.width, cell.shareBtn.frame.size.height);
        //Finao_msg2
        cell.Finao_msg2.frame = CGRectMake( cell.Finao_msg2.frame.origin.x, cell.Finao_msg2.frame.origin.y + 12, cell.Finao_msg2.frame.size.width, cell.Finao_msg2.frame.size.height);
    }
    cell.selectionStyle = UITableViewCellSelectionStyleNone;
    return cell;
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


-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    if (tableView == PostTableview){
        return [postarray count];
    }
    else if (tableView == InspiredTableview){
        return [inspiredarray count];
    }
    return 0;
    
}

- (CGFloat)handleHeigthForInspiredTable:(NSIndexPath *)indexPath
{
    //NSLog(@"indexPath.row is =%ld",(long)indexPath.row);
    tempDict = [inspiredarray objectAtIndex:indexPath.row];
    //NSLog(@"dictionary is =%@",tempDict);
    CGFloat heightForPostImage = 0.0f;
    
    if ([[tempDict objectForKey:@"image_urls"]count] >0) {
        heightForPostImage=320.0f;
        return 137.0f + heightForPostImage;
    }
    else{
        return 137.0f + heightForPostImage;
    }
}

- (CGFloat)handleHeigthForPostTable:(NSIndexPath *)indexPath
{
    tempDict = [postarray objectAtIndex:indexPath.row];
    
    //NSLog(@"dictionary is =%@",tempDict);
    
    CGFloat heightForPostImage = 0.0f;
    
    if ([[tempDict objectForKey:@"image_urls"]count] >0) {
        heightForPostImage=310.0f;
    }
    
    if ([[tempDict objectForKey:@"type"] integerValue] == 0) {
        return 137.0f + heightForPostImage;
    }
    else if ([[tempDict objectForKey:@"type"] integerValue] == 1) {
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSString class]]){
            return 137.0f + heightForPostImage ;
        }else{
            return 400.0f ;
        }
    }else if ([[tempDict objectForKey:@"type"] integerValue] == 2){
        return 300.0f;
    }else
        return 400.0f;
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

- (void)scrollViewDidScroll:(UIScrollView *)scrollView
{
    CGFloat sectionHeaderHeight = 10;
    if (scrollView.contentOffset.y<sectionHeaderHeight&&scrollView.contentOffset.y>0)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-scrollView.contentOffset.y, 0, 0, 0);
        
        TablesScrolledUP = NO;
        
        [UIView animateWithDuration:0.5
                         animations:^{
                             HeaderView.frame = CGRectMake(-1, -1, 322, 294);
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
                             HeaderView.frame = CGRectMake(-1, -261, 322, 294);
                             if (isiPhone5) {
                                 PostTableview.frame = CGRectMake(0, 33, 320, 450);
                                 InspiredTableview.frame = CGRectMake(0, 33, 320, 450);
                             }
                             else{
                                 PostTableview.frame = CGRectMake(0, 33, 320, 350);
                                 InspiredTableview.frame = CGRectMake(0, 33, 320, 350);
                             }
                         }
                         completion:^(BOOL finished){
                         }];
    }
}

#pragma mark End Post

-(BOOL)isTwitterInstalled
{
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

-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if(alertView.tag == 1){
        if (buttonIndex == 0) {
            [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
        }
        else if(buttonIndex ==1)
        {
            [self ShareAction];
            [USERDEFAULTS setBool:YES forKey:@"FirstTimeShare"];
            
        }
    }
    if(alertView.tag == 2){
        if(buttonIndex ==1)
        {
            dispatch_async(dispatch_get_main_queue(), ^ {
                deletePost = [[DeletePost alloc]init];
                [deletePost DeletePost:[tempDict objectForKey:@"finao_id"] withID:[tempDict objectForKey:@"uploaddetail_id"]];
            });
            
        }
    }
}

-(void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 )
    {
        self.navigationController.navigationBar.translucent = NO;
        [self.navigationController.view.layer setMasksToBounds:YES];
    }
}
- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETLISTNUMBERS" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETPOSTSINFO" object:nil];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETINSPIREDINFO" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"DELETEDPOST" object:nil];
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    if (![USERDEFAULTS boolForKey:@"FirstTimeShare"])
    {
        UIAlertView* ShareAlert = [[UIAlertView alloc]initWithTitle:@"Finao" message:@"Share Finao" delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"OK", nil];
        ShareAlert.tag = 1;
        [ShareAlert show];
    }
    
    TablesScrolledUP = NO;
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(DeleteCompleted:)
                                                 name:@"DELETEDPOST"
                                               object:nil];
    
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
                                             selector:@selector(GotNotificationinfo:)
                                                 name:@"GETNOTIFICATIONSINFO"
                                               object:nil];
    
    
    PostQueue_gcd = dispatch_queue_create("com.Finao.Posts", NULL);
    
    dispatch_async(PostQueue_gcd, ^{ [self getPostsList]; } );
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Getnumlist = [[GetNumofList alloc]init];
        [Getnumlist GetNumbers];
    });
    
    [self initOthers];
    
}
-(void)LoadOthers:(NSNotification *) notification
{
    ListDic = Getnumlist.ListDic;
    NSDictionary *avatars = [ListDic objectAtIndex:0];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETLISTNUMBERS" object:nil];
    
    FinaoCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfinaos"] ];
    TileCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totaltiles"]];
    FollowingCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfollowings"]];
    FollowersCountLbl.text = [NSString stringWithFormat:@"%@",[avatars objectForKey:@"totalfollowers"]];
}
-(void)getPostsList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        getpostinfo = [[GetPostRecentPostinfo alloc]init];
        [getpostinfo GetPostInfo];
        
    } );
}

-(void)getInspiredList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        getinspiredinfo = [[GetInspiredinfo alloc]init];
        [getinspiredinfo GetInspiredInfo];
        
    } );
}

-(void)DeleteCompleted:(NSNotification*)notify
{
    [APPDELEGATE showHToastCenter:@"Post Deleted"];
    [self getPostsList];
}

-(void)InspiredInfo:(NSNotification*)notify{
    inspiredarray = getinspiredinfo.InspiredListDic;
    //inspiredarray = getpostinfo.FinaoListDic;
    if ([inspiredarray count] == 0) {
        [inspiredarray addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
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
-(void)GetNotificationList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        getNotificationInfo = [[GetNotificationInfo alloc]init];
        [getNotificationInfo GetNotifications];
        
    } );
    
}
-(void)GotNotificationinfo:(NSNotification*)notify{
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];
    notifarray = getNotificationInfo.FinaoListDic;
    if ([notifarray count] == 0) {
        [notifarray addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Notifications Found."];
    }
    else{
        NSString *message = [NSString stringWithFormat:@"%lu %@",(unsigned long)[notifarray count],@"Notifications waiting."];
        [APPDELEGATE showHToast:message];
    }
    
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

-(void)shareClicked:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [postarray objectAtIndex:index];
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share",@"Delete Post", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

-(void)shareClickedInspired:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [inspiredarray objectAtIndex:index];
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share",@"Delete Post", nil];    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return NO;
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == PostTableview){
        tempDict = [postarray objectAtIndex:indexPath.row];
        NSLog(@"Tempdic = %@",tempDict);
        ProfileDetailViewController* profileDetail = [[ProfileDetailViewController alloc]initWithNibName:@"ProfileDetailViewController" bundle:nil];
        [self.navigationController pushViewController:profileDetail animated:YES];
        
        profileDetail.finao_id = [tempDict objectForKey:@"finao_id"];
        profileDetail.Finao_title = [tempDict objectForKey:@"finao_msg"];
        
        if ([[tempDict objectForKey:@"tracking_status"] integerValue]) {
            profileDetail.isPublicstr = @"Follow";
        }else{
            profileDetail.isPublicstr = @"Unfollow";
        }
        profileDetail.SelfUser = NO;
        profileDetail.Finao_status = [tempDict objectForKey:@"finao_status"];
        profileDetail.inspireStatus = [tempDict objectForKey:@"isinspired"];
        profileDetail.SearchusrID = [tempDict objectForKey:@"updateby"];
        
        profileDetail.FriendName = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
        profileDetail.FriendimageURL = profileImageUrl;
        
        [tableView deselectRowAtIndexPath:indexPath animated:NO];
    }
    if (tableView == InspiredTableview){
        
    }
}

@end
