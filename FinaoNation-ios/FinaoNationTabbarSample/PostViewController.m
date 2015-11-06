//
//  PostViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "PostViewController.h"
#import "AppConstants.h"
#import "PostCell.h"
#import "PostFinaoListViewController.h"
#import "ELCImagePickerController.h"
#import "ELCAlbumPickerController.h"
#import "ELCAssetTablePicker.h"
#import <MediaPlayer/MediaPlayer.h>
#import <AVFoundation/AVFoundation.h>
#import "PostFinaoUpdate.h"
#import "AssetsLibrary/AssetsLibrary.h"

#define MAXIMAGESINARRAY 4

@interface PostViewController ()


@end

@implementation PostViewController

@synthesize FinaoIDStr;
PostFinaoUpdate *PostUpdate;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Create a FINAO ";
        
    }
    return self;
}

-(void)PostClicked
{
    if ([txtview.text isEqualToString:@"Click here to start typing..."]
        || [txtview.text isEqualToString:@""])
    {
        [APPDELEGATE showHToastCenter:@"Please enter the  upload text."];
        txtview.text = @"Click here to start typing...";
        [txtview resignFirstResponder];
    }else{
        PostUpdate = [[PostFinaoUpdate alloc]init];
        [PostUpdate PostImageForUpdateFinao:[USERDEFAULTS valueForKey:@"userid"] ImgData:ChosenImageData ImgName:chosenImagesNames Finaoid:self.FinaoIDStr CaptionData:choosenImageCaption upload_text:txtview.text];
    }
}

-(void)PostedWasSuccessful:(NSNotification*)notification
{
    [self.navigationController popToRootViewControllerAnimated:YES];
    [APPDELEGATE gotoProfile];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [APPDELEGATE setCurrentNav:self.navigationController];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Post" style:UIBarButtonItemStylePlain target:self action:@selector(PostClicked)];
    
    chosenImagesNames = [[NSMutableArray alloc]init];
    ChosenImageData = [[NSMutableArray alloc]init];
    choosenImageCaption = [[NSMutableArray alloc]init];
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
        
        
    }
    txtview = [[UITextView alloc]init ];
    txtview.frame = CGRectMake(0, 0, 320, 65);
    txtview.text = @"Click here to start typing...";
    txtview.textColor = [UIColor lightGrayColor];
    txtview.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15.0f];
    txtview.delegate = self;
    txtview.text = @"Click here to start typing...";
    [self.view addSubview:txtview];
    
    Upload_pic_table = [[UITableView alloc]initWithFrame:CGRectMake(115, -40, 100, 320) style:UITableViewStylePlain];
    Upload_pic_table.delegate = self;
    Upload_pic_table.dataSource = self;
    [self.view addSubview:Upload_pic_table];
    
    Upload_pic_table.transform=CGAffineTransformMakeRotation(-M_PI/2);
    [Upload_pic_table setSeparatorStyle:UITableViewCellSeparatorStyleNone];
    
    if (isiPhone5) {
        toolbar = [[UIToolbar alloc] initWithFrame:CGRectMake(0, 410, 320, 40)];
    }
    else{
        toolbar = [[UIToolbar alloc] initWithFrame:CGRectMake(0, 330, 320, 40)];
    }
    
    UIButton *btnCam = [UIButton buttonWithType:UIButtonTypeCustom];
    [btnCam setFrame:CGRectMake(0, 0, 30, 30)];
    [btnCam setBackgroundImage:[UIImage imageNamed:@"Camera_Post"] forState:UIControlStateNormal];
    btnCam.showsTouchWhenHighlighted = YES;
    [btnCam setHighlighted:NO];
    [btnCam addTarget:self action:@selector(CameraTapped) forControlEvents:UIControlEventTouchUpInside];
    UIBarButtonItem *button1 = [[UIBarButtonItem alloc] initWithCustomView:btnCam];
    
    UIBarButtonItem *flexibleSpace = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil];
    
    
    UIButton *btnGal = [UIButton buttonWithType:UIButtonTypeCustom];
    [btnGal setFrame:CGRectMake(270, 0, 30, 30)];
    [btnGal setBackgroundImage:[UIImage imageNamed:@"Gallery_Post"] forState:UIControlStateNormal];
    btnGal.showsTouchWhenHighlighted = YES;
    [btnGal setHighlighted:NO];
    
    [btnGal addTarget:self action:@selector(galleryTapped) forControlEvents:UIControlEventTouchUpInside];
    UIBarButtonItem *button2 = [[UIBarButtonItem alloc] initWithCustomView:btnGal];
    
    [toolbar setItems:[NSArray arrayWithObjects:button1,flexibleSpace,button2, nil]];
    
    [self.view addSubview:toolbar];
    
    ALAuthorizationStatus status = [ALAssetsLibrary authorizationStatus];
    if (status != ALAuthorizationStatusAuthorized) {
        [APPDELEGATE showHToastCenter:@"Please tuen on access to photos for FINAO app in settings privacy"];
    }
}




-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    return 120.0f;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    
    return [ChosenImageData count];
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    PostCell* cell = [[PostCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"PostCell"];
    
    cell.PostImage.image = [UIImage imageWithData:[ChosenImageData objectAtIndex:indexPath.row]];
    [cell.delbtn addTarget:self action:@selector(CellDelbtnClicked:) forControlEvents:UIControlEventTouchUpInside];
    cell.delbtn.tag = indexPath.row;
    
    cell.txtfld.delegate = self;
    cell.txtfld.tag = indexPath.row;
    return cell;
}

- (void)textFieldDidEndEditing:(UITextField *)textField
{
    [choosenImageCaption removeObjectAtIndex:textField.tag];
    [choosenImageCaption insertObject:textField.text atIndex:textField.tag];
    
}

int rowtobedeleted;
-(void) CellDelbtnClicked:(UIButton*)button{
    
    UIAlertView *Alert = [[UIAlertView alloc] initWithTitle:@"Finao" message:@"Do you want to Delete"
                                                   delegate:self cancelButtonTitle:@"No" otherButtonTitles:@"yes",nil];
    
    [Alert show];
    
}

#pragma mark UIAlertView
- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex {
	// NO = 0, YES = 1
	if(buttonIndex){
        // Do whatever "YES" is
        [chosenImagesNames removeObjectAtIndex:rowtobedeleted];
        [ChosenImageData removeObjectAtIndex:rowtobedeleted];
        [choosenImageCaption removeObjectAtIndex:rowtobedeleted];
        [Upload_pic_table reloadData];
    }
}

- (void)textViewDidBeginEditing:(UITextView *)textView
{
    if ([textView.text isEqualToString:@"Click here to start typing..."]) {
        txtview.text = @"";
        txtview.textColor = [UIColor blackColor];
    }
    [txtview becomeFirstResponder];
}


- (void)textViewDidEndEditing:(UITextView *)textView
{
    if ([textView.text isEqualToString:@""]) {
        textView.text = @"Click here to start typing...";
        textView.textColor = [UIColor lightGrayColor];
    }
    [textView resignFirstResponder];
}

- (BOOL)textView:(UITextView *)textView shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text {
    
    if([text isEqualToString:@"\n"]) {
        [textView resignFirstResponder];
        return NO;
    }
    
    return YES;
}
-(void)PostedImagesandCaption:(NSNotification*)notification{
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"REMOVEPOSTIMAGESPOSTSUBMITTED" object:nil];
    
    [chosenImagesNames removeAllObjects];
    [ChosenImageData removeAllObjects];
    [choosenImageCaption removeAllObjects];
    [Upload_pic_table reloadData];
    txtview.textColor = [UIColor lightGrayColor];
    
}
-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    //[txtview becomeFirstResponder];
    
    isSlidable = YES;
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(PostedImagesandCaption:)
                                                 name:@"REMOVEPOSTIMAGESPOSTSUBMITTED"
                                               object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(PostedWasSuccessful:)
                                                 name:@"POSTWASSUCCESSFULL"
                                               object:nil];
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
        
    }
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    
    
    
    
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWillShow:) name:UIKeyboardWillShowNotification object:nil];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWillHide:) name:UIKeyboardWillHideNotification object:nil];
    
}

-(void)CameraTapped{
    
    if (MAXIMAGESINARRAY-[chosenImagesNames count])
    {
        if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypeCamera])
        {
            UIImagePickerController *controller = [[UIImagePickerController alloc] init];
            controller.sourceType = UIImagePickerControllerSourceTypeCamera;
            controller.allowsEditing = YES;
            controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypeCamera];
            controller.videoQuality = UIImagePickerControllerQualityTypeLow;
            controller.videoMaximumDuration = 10;
            controller.delegate = self;
            [self.navigationController presentViewController: controller animated: YES completion: nil];
        }else{
            
            UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO" message:@"Camera not available" delegate:self cancelButtonTitle:@"OK" otherButtonTitles:nil];
            [alert show];
        }
    }
    else{
        UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO" message:@"Maximum images reached, please delete one or more" delegate:self cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alert show];
        
    }
}
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    picker.allowsEditing = YES;
	[picker dismissViewControllerAnimated:YES completion:nil];
    
    NSString *mediaType = [info objectForKey:UIImagePickerControllerMediaType];
    
    if ([mediaType isEqualToString:@"public.image"]){
        UIImage *image = [info objectForKey:UIImagePickerControllerEditedImage];
        NSData *imageData = [[NSData alloc]initWithData:UIImageJPEGRepresentation(image,0)];
        
        NSDate *now = [[NSDate alloc] init];
        NSDateFormatter *format = [[NSDateFormatter alloc] init];
        [format setDateFormat:@"MMddHHmmss"];
        
        NSString* fileName =[NSString stringWithFormat:@"%@_%lu.jpg",[format stringFromDate:now],(unsigned long)[chosenImagesNames count]+1 ];
        [chosenImagesNames addObject:fileName];
        [choosenImageCaption addObject:@""];
        [ChosenImageData addObject:imageData];
        [Upload_pic_table reloadData];
    }else if ([mediaType isEqualToString:@"public.movie"]){
        
        if (CFStringCompare ((__bridge_retained CFStringRef) mediaType, kUTTypeMovie, 0)
            == kCFCompareEqualTo) {
            
            NSString *moviePath = [NSString stringWithFormat:@"%@",[[info objectForKey:
                                                                     UIImagePickerControllerMediaURL] path]];
            
            NSDate *now = [[NSDate alloc] init];
            NSDateFormatter *format = [[NSDateFormatter alloc] init];
            [format setDateFormat:@"MMddHHmmss"];
            
            NSString* fileName =[NSString stringWithFormat:@"%@.mp4",[format stringFromDate:now] ];
            
            [chosenImagesNames addObject:fileName];
            [choosenImageCaption addObject:@""];
            [ChosenImageData addObject:[[NSData alloc ]initWithContentsOfFile:moviePath]];
            
            [Upload_pic_table reloadData];
            
            
            NSString *mediaType = [info objectForKey: UIImagePickerControllerMediaType];
            if (CFStringCompare ((__bridge_retained CFStringRef) mediaType, kUTTypeMovie, 0) == kCFCompareEqualTo)
            {
                if (UIVideoAtPathIsCompatibleWithSavedPhotosAlbum(moviePath))
                {
                    NSString *docDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
                    NSString *videoPath1 =[NSString stringWithFormat:@"%@/xyz.mov",docDir];
                    NSURL *videoURL = [info objectForKey:UIImagePickerControllerMediaURL];
                    NSData *videoData = [NSData dataWithContentsOfURL:videoURL];
                    [videoData writeToFile:videoPath1 atomically:NO];
                }
            }
            
            AVURLAsset *avAsset = [AVURLAsset URLAssetWithURL:[NSURL fileURLWithPath:moviePath] options:nil];
            NSArray *compatiblePresets = [AVAssetExportSession exportPresetsCompatibleWithAsset:avAsset];
            
            if ([compatiblePresets containsObject:AVAssetExportPresetLowQuality])
            {
                AVAssetExportSession *exportSession = [[AVAssetExportSession alloc]initWithAsset:avAsset presetName:AVAssetExportPresetPassthrough];
                NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
                moviePath = [NSString stringWithFormat:@"%@/%@", [paths objectAtIndex:0],fileName];
                exportSession.outputURL = [NSURL fileURLWithPath:moviePath];
                //NSLog(@"videopath of your mp4 file = %@",moviePath);  // PATH OF YOUR .mp4 FILE
                exportSession.outputFileType = AVFileTypeMPEG4;
                
                [exportSession exportAsynchronouslyWithCompletionHandler:^{
                    
                    switch ([exportSession status]) {
                            
                        case AVAssetExportSessionStatusFailed:
                            
                            break;
                            
                        case AVAssetExportSessionStatusCancelled:
                            
                            break;
                            
                        default:
                            
                            break;
                            
                    }
                    UISaveVideoAtPathToSavedPhotosAlbum(moviePath, self, nil, nil);
                    
                }];
            }
        }
    }else{
        
        //NSLog(@"NONE CAME WHILE PHOTO OR THE IMAGE IS POSTED");
    }
    
}


- (void)video:(NSString*)videoPath didFinishSavingWithError:(NSError*)error contextInfo:(void*)contextInfo
{
    if (error) {
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Error" message:@"Video Saving Failed"  delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil, nil];
        [alert show];
    }else{
        
        NSDate *now = [[NSDate alloc] init];
        NSDateFormatter *format = [[NSDateFormatter alloc] init];
        [format setDateFormat:@"MMddHHmmss"];
        
        NSString* fileName =[NSString stringWithFormat:@"%@.mp4",[format stringFromDate:now] ];
        
        AVURLAsset *avAsset = [AVURLAsset URLAssetWithURL:[NSURL fileURLWithPath:videoPath] options:nil];
        NSArray *compatiblePresets = [AVAssetExportSession exportPresetsCompatibleWithAsset:avAsset];
        
        if ([compatiblePresets containsObject:AVAssetExportPresetLowQuality])
        {
            AVAssetExportSession *exportSession = [[AVAssetExportSession alloc]initWithAsset:avAsset presetName:AVAssetExportPresetPassthrough];
            NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
            videoPath = [NSString stringWithFormat:@"%@/%@",[paths objectAtIndex:0],fileName];
            exportSession.outputURL = [NSURL fileURLWithPath:videoPath];
            exportSession.outputFileType = AVFileTypeMPEG4;
            
            [exportSession exportAsynchronouslyWithCompletionHandler:^{
                
                switch ([exportSession status]) {
                        
                    case AVAssetExportSessionStatusFailed:
                        //NSLog(@"Export failed: %@", [[exportSession error] localizedDescription]);
                        
                        break;
                        
                    case AVAssetExportSessionStatusCancelled:
                        
                        //NSLog(@"Export canceled");
                        
                        break;
                        
                    default:
                        
                        break;
                        
                }
                UISaveVideoAtPathToSavedPhotosAlbum(videoPath, self, nil, nil);
                //                [exportSession release];
                
            }];
            
            //            NSURL *videoURL = [info objectForKey:UIImagePickerControllerMediaURL];
            NSData *video1Data = [NSData dataWithContentsOfURL:[NSURL URLWithString:videoPath]];
            
            //NSLog(@"videoPath:%@ \n %@",videoPath,video1Data);
            [chosenImagesNames addObject:fileName];
            [choosenImageCaption addObject:@""];
            [ChosenImageData addObject:video1Data];
            [Upload_pic_table reloadData];
        }
    }
}

-(void)galleryTapped{
    
    //NSLog(@"Gallery TAPPED");
    
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypePhotoLibrary])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        controller.allowsEditing = YES;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypePhotoLibrary];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }
}

- (void)keyboardWillShow:(NSNotification *)notification {
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.3];
    
    CGRect frame = toolbar.frame;
    frame.origin.y = self.view.frame.size.height - 255.0;
    toolbar.frame = frame;
    
    [UIView commitAnimations];
}
- (void)keyboardWillHide:(NSNotification *)notification {
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.3];
    
    CGRect frame = toolbar.frame;
    frame.origin.y = self.view.frame.size.height - 90.0;
    toolbar.frame = frame;
    
    [UIView commitAnimations];
}
- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:UIKeyboardWillShowNotification object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:UIKeyboardWillHideNotification object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"POSTWASSUCCESSFULL" object:nil];
}

#pragma mark ELCImagePickerControllerDelegate Methods

- (void)elcImagePickerController:(ELCImagePickerController *)picker didFinishPickingMediaWithInfo:(NSArray *)info
{
    [self dismissViewControllerAnimated:YES completion:nil];
    
    
    NSMutableArray *images = [NSMutableArray arrayWithCapacity:[info count]];
	
    
    NSUInteger indexImageArray = 0;
	for (NSDictionary *dict in info)
    {
        
        UIImage *image = [dict objectForKey:UIImagePickerControllerOriginalImage];
        [images addObject:image];
        
		UIImageView *imageview = [[UIImageView alloc] initWithImage:image];
		[imageview setContentMode:UIViewContentModeScaleAspectFit];
        
        
        NSData *imageData = [[NSData alloc]initWithData:UIImageJPEGRepresentation(image,0)];
        
        NSDate *now = [[NSDate alloc] init];
        NSDateFormatter *format = [[NSDateFormatter alloc] init];
        [format setDateFormat:@"MMddHHmmss"];
        
        ++indexImageArray;
        NSString* fileName =[NSString stringWithFormat:@"%@_%lu.jpg",[format stringFromDate:now],(unsigned long)indexImageArray ];
        [chosenImagesNames addObject:fileName];
        [choosenImageCaption addObject:@""];
        [ChosenImageData addObject:imageData];
	}
    [Upload_pic_table reloadData];
}

- (void)elcImagePickerControllerDidCancel:(ELCImagePickerController *)picker
{
    [self dismissViewControllerAnimated:YES completion:nil];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
