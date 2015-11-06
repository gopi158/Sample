//
//  RegisterViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 21/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "RegisterViewController.h"
#import "LoginViewController.h"
#import "NSString+MD5.h"
#import "NSData+MD5.h"
#import <CommonCrypto/CommonDigest.h>

@interface RegisterViewController ()

@end

@implementation RegisterViewController
@synthesize Fname = Fname_ ;
@synthesize Lname = Lname_ ;
@synthesize Emailaddress = address_ ;
@synthesize password = password_ ;
@synthesize Confirmpassword = Confirmpassword_ ;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Register";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    //    [APPDELEGATE initFBRegister];
    
    self.navigationController.navigationBar.translucent = NO;
    
    Imagename = [NSString stringWithFormat:@"NOIMAGE"];
    
    UITableView* table = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 400) style:UITableViewStylePlain];
    table.delegate = self;
    table.dataSource = self;
    [self.view addSubview:table];
    UIView *fView = [[UIView alloc] initWithFrame:CGRectMake(15, 0, 320, 1)];
    fView.backgroundColor = [UIColor colorWithRed:(224.0/255.0) green:(224.0/255.0) blue:(226.0/255.0) alpha:1.0];
    table.tableFooterView = fView;
    table.scrollEnabled = NO;
    
    profileImgview = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 85, 85)];
    profileImgview.backgroundColor = [UIColor whiteColor];
    profileImgview.layer.shadowColor = [UIColor whiteColor].CGColor;
    profileImgview.layer.shadowOffset = CGSizeMake(15, 5);
    profileImgview.layer.shadowOpacity = 1;
    profileImgview.layer.shadowRadius = 1.0;
    profileImgview.clipsToBounds = NO;
    profileImgview.layer.borderWidth = 1.0f;
    profileImgview.layer.borderColor = (__bridge CGColorRef)([UIColor blackColor]);
    profileImgview.image = [UIImage imageNamed:@"chooseimg"];
    [self.view addSubview:profileImgview];
    
    
    UIButton* imgbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    imgbtn.frame = CGRectMake(10, 10, 85, 85);
    [imgbtn addTarget:self action:@selector(changeprofileImage) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:imgbtn];
}

-(void)changeprofileImage{
    
    
    //NSLog(@"UPdate IMAGE BTN CLICKED");
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle:@"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Take a Photo", @"Choose from Gallery", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}
- (void)willPresentActionSheet:(UIActionSheet *)actionSheet
{
    for (UIView *subview in actionSheet.subviews) {
        if ([subview isKindOfClass:[UIButton class]]) {
            UIButton *button = (UIButton *)subview;
            [button setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
            if ([button.titleLabel.text isEqualToString:@"Cancel"] ) {
                [button setTitleColor:[UIColor blueColor] forState:UIControlStateNormal];
            }
        }
    }
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
    
}

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    
    picker.allowsEditing = YES;
    profileImgview.image = [info objectForKey:@"UIImagePickerControllerEditedImage"];
    
    NSDate *now = [[NSDate alloc] init];
    NSDateFormatter *format = [[NSDateFormatter alloc] init];
    [format setDateFormat:@"MMddHHmmss"];
    
    Imagename =[NSString stringWithFormat:@"Profilepic%@.jpg",[format stringFromDate:now]];
    [picker dismissViewControllerAnimated:YES completion:nil];
    
    
}
- (void)takeNewPhotoFromCamera
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypeCamera])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypeCamera;
        controller.allowsEditing = YES;
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
        controller.allowsEditing = YES;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypePhotoLibrary];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }
}



-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    self.navigationController.navigationBarHidden = NO;
    self.navigationController.navigationBar.tintColor = [UIColor orangeColor];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Continue" style:UIBarButtonItemStylePlain target:self action:@selector(ContinueClicked)];
    
}

-(void)ContinueClicked
{
    //NSLog(@"Imagename:%@",Imagename);
    
    
    if ([FnameField.text length] == 0 || [LnameField.text length]== 0 || [addressField.text length] == 0 || [passwordField.text length] == 0 || [ConfirmpasswordField.text length] == 0)
    {
        
        NSString* messageStr = [[NSString alloc]init];
        
        if ([FnameField.text length] == 0) {
            messageStr = @"Please enter First Name Field";
        }
        
        if ([LnameField.text length] == 0) {
            messageStr = @"Please enter Last Name Field";
        }
        
        if ([addressField.text length] == 0) {
            messageStr = @"Please enter Email address Field";
        }
        
        if ([passwordField.text length] == 0) {
            messageStr = @"Please enter Password Field";
        }
        
        if ([ConfirmpasswordField.text length] == 0) {
            messageStr = @"Please enter Confirm Password Field";
        }
        
        UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO Nation" message:messageStr delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil];
        [alert show];
    }
    else{
        
        if ([self emailCredibility:addressField.text]) {
            
            
            if ([passwordField.text isEqualToString:ConfirmpasswordField.text]) {
                webservice = [[Servermanager alloc] init];
                [APPDELEGATE showHToastCenter:@"Registering.."];
                webservice.delegate = self;
                //                NSData *imageData = UIImagePNGRepresentation(profileImgview.image);
                NSData *imageData = [[NSData alloc]initWithData:UIImageJPEGRepresentation(profileImgview.image,0)];
                
                
                //NSString* base64str = [self base64String:[NSString stringWithFormat:@"%@:%@",addressField.text,passwordField.text]];
                //NSLog(@"base64str:%@",base64str);
                
                [webservice RegisterManual:FnameField.text Lastname:LnameField.text Email:addressField.text PassWord:[passwordField.text MD5] ProfileImage:imageData profileimagename:Imagename];
                
            }
            else
            {
                UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO Nation" message:@"Password Mismatch" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil];
                [alert show];
            }
        }
        else{
            UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO Nation" message:@"Please enter Valid Email address" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil];
            [alert show];
        }
    }
    
}

- (NSString *)base64String:(NSString *)str
{
    NSData *theData = [str dataUsingEncoding: NSASCIIStringEncoding];
    const uint8_t* input = (const uint8_t*)[theData bytes];
    NSInteger length = [theData length];
    
    static char table[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    
    NSMutableData* data = [NSMutableData dataWithLength:((length + 2) / 3) * 4];
    uint8_t* output = (uint8_t*)data.mutableBytes;
    
    NSInteger i;
    for (i=0; i < length; i += 3) {
        NSInteger value = 0;
        NSInteger j;
        for (j = i; j < (i + 3); j++) {
            value <<= 8;
            
            if (j < length) {
                value |= (0xFF & input[j]);
            }
        }
        
        NSInteger theIndex = (i / 3) * 4;
        output[theIndex + 0] =                    table[(value >> 18) & 0x3F];
        output[theIndex + 1] =                    table[(value >> 12) & 0x3F];
        output[theIndex + 2] = (i + 1) < length ? table[(value >> 6)  & 0x3F] : '=';
        output[theIndex + 3] = (i + 2) < length ? table[(value >> 0)  & 0x3F] : '=';
    }
    
    return [[NSString alloc] initWithData:data encoding:NSASCIIStringEncoding];
}

-(BOOL)emailCredibility:(NSString *)checkString
{
    BOOL stricterFilter = YES; // Discussion http://blog.logichigh.com/2010/09/02/validating-an-e-mail-address/
    NSString *stricterFilterString = @"[A-Z0-9a-z\\._%+-]+@([A-Za-z0-9-]+\\.)+[A-Za-z]{2,4}";
    NSString *laxString = @".+@([A-Za-z0-9]+\\.)+[A-Za-z]{2}[A-Za-z]*";
    NSString *emailRegex = stricterFilter ? stricterFilterString : laxString;
    NSPredicate *emailTest = [NSPredicate predicateWithFormat:@"SELF MATCHES %@", emailRegex];
    return [emailTest evaluateWithObject:checkString];
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",[data objectForKey:@"IsSuccess"]);
#endif
    [APPDELEGATE hideHUD];
    
    //NSLog(@"DATA : %@ ",[data objectForKey:@"IsSuccess"]);
    if(![[data valueForKey:@"IsSuccess"] integerValue] == 0 )
    {
        [APPDELEGATE  showHToast:@"isSuccess"];
        NSMutableDictionary* dic = [data objectForKey:@"item"];
        
        [self StoreAllDefaults:dic];
        
        [APPDELEGATE loadTabbar:NO];
        [USERDEFAULTS setBool:YES forKey:@"Loggedin"];
        [USERDEFAULTS synchronize];
        
        
    }
    else{
        [APPDELEGATE  showHToast:@"Failed"];
        UIAlertView* Alert = [[UIAlertView alloc]initWithTitle:@"FINAO NATION" message:@"User Exists" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [Alert show];
        
    }
}

-(void)StoreAllDefaults:(NSMutableDictionary*)dic
{
    //NSLog(@"Dic:%@",dic);
    [USERDEFAULTS setValue:[passwordField.text MD5] forKey:@"MD5password"];
    NSString* base64str = [self base64String:[NSString stringWithFormat:@"%@:%@",addressField.text,passwordField.text]];
    [USERDEFAULTS setValue:base64str forKey:@"base64str"];
    [USERDEFAULTS setValue:addressField.text forKey:@"Email"];
    //NSLog(@"MD5password:%@",[USERDEFAULTS objectForKey:@"MD5password"]);
    [USERDEFAULTS setValue:[dic objectForKey:@"userid"] forKey:@"userid"];
    //NSLog(@"profile:%@",[dic objectForKey:@"profile_image"]);
    [USERDEFAULTS setValue:[dic objectForKey:@"profile_image"] forKey:@"profile_image"];
    //NSLog(@"profile:%@",[dic objectForKey:@"profile_image"]);
    [USERDEFAULTS setValue:[dic objectForKey:@"profile_bg_image"] forKey:@"profile_bg_image"];
    [USERDEFAULTS setValue:[dic objectForKey:@"name"] forKey:@"name"];
    [USERDEFAULTS setValue:[dic objectForKey:@""] forKey:@""];
    [USERDEFAULTS setValue:[dic objectForKey:@"mystory"] forKey:@"mystory"];
}


-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];
    
}


#pragma mark WebDelegate end


#pragma mark -
#pragma mark Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
    return 1;
}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    // Return the number of rows in the section.
    return 5;
}

- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath {
	UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
    
	cell.selectionStyle = UITableViewCellSelectionStyleNone;
	
	UITextField* tf = nil ;
	switch ( indexPath.row ) {
		case 0: {
			tf = FnameField = [self makeTextField:self.Fname placeholder:@"First Name"];
            tf.frame = CGRectMake(120, 12, 200, 30);
            cell.frame = CGRectMake(120, 12, 200, 30);
			[cell addSubview:FnameField];
			break ;
		}
            
        case 1: {
            tf = LnameField = [self makeTextField:self.Lname placeholder:@"Last Name"];
            tf.frame = CGRectMake(120, 12, 200, 30);
            cell.frame = CGRectMake(120, 12, 200, 30);
			[cell addSubview:LnameField];
			break ;
		}
            
		case 2: {
            tf = addressField = [self makeTextField:self.Emailaddress placeholder:@"Email"];
            tf.frame = CGRectMake(20, 12, 300, 30);
			[cell addSubview:addressField];
			break ;
		}
		case 3: {
            tf = passwordField = [self makeTextField:self.password placeholder:@"Password"];
            tf.frame = CGRectMake(20, 12, 300, 30);
			[cell addSubview:passwordField];
			break ;
		}
		case 4: {
            tf = ConfirmpasswordField = [self makeTextField:self.Confirmpassword placeholder:@"Confirm Password"];
            tf.frame = CGRectMake(20, 12, 300, 30);
			[cell addSubview:ConfirmpasswordField];
			break ;
		}
	}
    
    
	tf.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
	[tf addTarget:self action:@selector(textFieldFinished:) forControlEvents:UIControlEventEditingDidEndOnExit];
	tf.delegate = self ;
    
    return cell;
}

#pragma mark -
#pragma mark Table view delegate

#pragma mark -
#pragma mark Memory management

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
}

- (void)viewDidUnload {
    
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

- (IBAction)textFieldFinished:(id)sender {
}

-(void)textFieldDidBeginEditing:(UITextField *)textField{
    
    if (!isiPhone5)
    {
        
        if (  textField == passwordField ||textField == ConfirmpasswordField)
        {
            if (!FrameisUP)
            {
                CGRect frame = self.view.frame;
                frame.origin.y  = self.view.frame.origin.y - 30;
                self.view.frame = frame;
                FrameisUP = YES;
            }
        }
    }
    
}

- (void)textFieldDidEndEditing:(UITextField *)textField {
	if ( textField == FnameField ) {
		self.Fname = textField.text ;
	} else if ( textField == LnameField ) {
        self.Lname = textField.text ;
    } else if ( textField == addressField ) {
        self.Emailaddress = textField.text ;
    } else if ( textField == passwordField ) {
        self.password = textField.text ;
    } else if ( textField == ConfirmpasswordField ) {
        self.Confirmpassword = textField.text ;
    }
    if (!isiPhone5)
    {
        if (FrameisUP) {
            CGRect frame = self.view.frame;
            frame.origin.y  = self.view.frame.origin.y + 30;
            self.view.frame = frame;
            FrameisUP = NO;
        }
    }
}


//
//-(void)RegisterWithFB:(NSString*)Firstname LName:(NSString*)LastName Email:(NSString*)Email Facebookid:(NSString*)FBid
//{
//    //NSLog(@"email : %@",Email);
//    //NSLog(@"Fid : %@",FBid);
//
//    if (Firstname == nil || LastName == nil || Email == nil || FBid == nil)
//    {
//        UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO Nation" message:@"email and id fetched are NULL please check the SDK" delegate:self cancelButtonTitle:@"OK" otherButtonTitles: nil];
//        [alert show];
//
//    }
//    else{
//
//        webservice = [[Servermanager alloc] init];
//        [APPDELEGATE showHToastCenter:@"Registering using facebook"];
//        webservice.delegate = self;
//        [webservice RegisterFacebook:Firstname Lastname:LastName Email:Email UID:FBid];
//    }
//
//}
//
//#pragma FB end
@end

