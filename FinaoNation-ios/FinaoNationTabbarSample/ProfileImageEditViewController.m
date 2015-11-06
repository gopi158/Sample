//
//  ProfileImageEditViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 08/04/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileImageEditViewController.h"
#import "Servermanager.h"
#import "AppConstants.h"
#import "UpdateUserProfileImage.h"

@interface ProfileImageEditViewController ()

@end

@interface ProfileImageEditViewController ()

@property (nonatomic ,strong)UIImageView *navigationBarLogoImage;

@end

@implementation ProfileImageEditViewController

@synthesize profileImageUrl = profileImageUrl_;
@synthesize profileImage = _profileImage;
@synthesize navigationBarLogoImage = navigationBarLogoImage_;

UpdateUserProfileImage * updateUserProfileImage;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {

     }
    return self;
}

-(void)UserProfileImageCompleted:(NSNotification *)notification {
    NSDictionary * listDict = updateUserProfileImage.ListDic;
    NSLog(@"Response from updateUserProfileImage: %@", listDict);
    [self.navigationController popViewControllerAnimated:YES];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.navigationBarLogoImage = [[UIImageView alloc]initWithFrame:CGRectMake(150, 10 , 20, 30)];
    self.navigationBarLogoImage.image = [UIImage imageNamed:@"logo_finao.png"];
    self.navigationBarLogoImage.tag  = 1;
    [self.navigationController.navigationBar addSubview:self.navigationBarLogoImage];
    self.navigationController.navigationBar.translucent = NO;
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    self.navigationController.navigationBar.backgroundColor = [UIColor clearColor];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemDone target:self action:@selector(DoneClicked)];
        [APPDELEGATE showHToastCenter:@" Click on Image change."];
    
    _profileImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 300, 250) ];
    _profileImage.image = [UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",self.profileImageUrl]]]];
    
    if([self respondsToSelector:@selector(edgesForExtendedLayout)])
        self.edgesForExtendedLayout = UIRectEdgeNone;
    self.view.backgroundColor = [UIColor whiteColor];

    [self.view addSubview:_profileImage];
    UITapGestureRecognizer *singleTap = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(imageTapped)];
    singleTap.numberOfTapsRequired = 1;
    _profileImage.userInteractionEnabled = YES;
    [_profileImage addGestureRecognizer:singleTap];
    
    //Adding the image to the footer
    UIImageView* imageview = [[UIImageView alloc]initWithFrame:CGRectMake(90, 310, 120, 150)];
    imageview.image = [UIImage imageNamed:@"GetStartedImage-black"];
    [self.view addSubview:imageview];
}

-(void)DoneClicked{
    [APPDELEGATE showHToastCenter:@"Image Updated."];
    updateUserProfileImage = [[UpdateUserProfileImage alloc] init];
    NSData *imageData = UIImageJPEGRepresentation(_profileImage.image, 0.7);
    [updateUserProfileImage UpdateUserProfileImage:imageData];
}
-(void)imageTapped{
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Select Photos from"
                                                             delegate:(id)self cancelButtonTitle:nil destructiveButtonTitle:nil
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

- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
	[picker dismissViewControllerAnimated:YES completion:nil];
    _profileImage.image = [info objectForKey:@"UIImagePickerControllerOriginalImage"];
    
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


-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    self.tabBarController.tabBar.hidden = YES;
    self.tabBarController.view.backgroundColor = [UIColor whiteColor];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UserProfileImageCompleted:)
                                                 name:@"PROFILEUPDATEIMAGESUCCESSFULL"
                                               object:nil];
}

-(void)viewWillDisappear:(BOOL)animated{
    [super viewWillDisappear:YES];
    self.navigationBarLogoImage = Nil;
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"PROFILEUPDATEIMAGESUCCESSFULL" object:nil];
    [[self.navigationController.navigationBar viewWithTag:1]removeFromSuperview];
    
    [self.navigationBarLogoImage removeFromSuperview];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];}

@end
