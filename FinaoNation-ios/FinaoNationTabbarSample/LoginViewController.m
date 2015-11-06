//
//  LoginViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "LoginViewController.h"
#import "AppConstants.h"
#import "Servermanager.h"
#import "NSString+MD5.h"
#import "NSData+MD5.h"
#import <CommonCrypto/CommonDigest.h>
#import "RegisterViewController.h"
#import "TokenManager.h"

@interface LoginViewController ()

@end

@implementation LoginViewController
@synthesize permissions;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
    }
    return self;
}


-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    self.navigationController.navigationBarHidden = YES;
    
    permissions = [[NSArray alloc] initWithObjects:@"ads_management", @"create_note",@"email", @"manage_friendlists", @"photo_upload", @"publish_actions", @"publish_stream", @"share_item", @"status_update", @"user_about_me", @"user_activities", @"user_friends", @"user_subscriptions", @"user_work_history", @"video_upload",@"read_stream",nil];
    
    //    permissions = [[NSArray alloc] initWithObjects:@"offline_access",@"email",nil];
    
    if (![[APPDELEGATE facebook] isSessionValid]) {
        //NSLog(@"SESSION HAS NOT EXPIRED");
        
    } else {
        //NSLog(@"SESSION  EXPIRED");
    }
}



- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [APPDELEGATE initFBLogin];
        
    UIImageView* imageview = [[UIImageView alloc]initWithFrame:CGRectMake(90, 50, 150, 170)];
    imageview.image = [UIImage imageNamed:@"GetStartedImage-black"];
    imageview.backgroundColor = [UIColor clearColor];
    [self.view addSubview:imageview];
    
    
    
    UIView* bgView = [[UIView alloc]initWithFrame:CGRectMake(49, 254, 232, 53)];
    bgView.backgroundColor = [UIColor orangeColor];
    bgView.layer.cornerRadius = 3.0f;
    [self.view addSubview:bgView];
    
    emailtxtfld = [[UITextField alloc]initWithFrame:CGRectMake(50,255,230,25)];
    emailtxtfld.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    emailtxtfld.delegate = self;
    emailtxtfld.placeholder = @"email";
    emailtxtfld.textAlignment = NSTextAlignmentCenter;
    emailtxtfld.backgroundColor = [UIColor whiteColor];
    [self.view addSubview:emailtxtfld];
    
    //Rounded edges only on top for emailtxtfield
    CAShapeLayer * maskLayer = [CAShapeLayer layer];
    maskLayer.path = [UIBezierPath bezierPathWithRoundedRect: emailtxtfld.bounds byRoundingCorners: UIRectCornerTopLeft | UIRectCornerTopRight cornerRadii: (CGSize){3.0, 3.0}].CGPath;
    emailtxtfld.layer.mask = maskLayer;
    
    Passwordtxtfld = [[UITextField alloc]initWithFrame:CGRectMake(50,281,230,25)];
    Passwordtxtfld.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    Passwordtxtfld.delegate = self;
    Passwordtxtfld.placeholder = @"password";
    Passwordtxtfld.secureTextEntry = YES;
    Passwordtxtfld.textAlignment = NSTextAlignmentCenter;
    Passwordtxtfld.backgroundColor = [UIColor whiteColor];
    [self.view addSubview:Passwordtxtfld];
    
    //Rounded edges only on top for Passwordtxtfld
    CAShapeLayer * maskLayer2 = [CAShapeLayer layer];
    maskLayer2.path = [UIBezierPath bezierPathWithRoundedRect: Passwordtxtfld.bounds byRoundingCorners: UIRectCornerBottomLeft | UIRectCornerBottomRight cornerRadii: (CGSize){3.0, 3.0}].CGPath;
    Passwordtxtfld.layer.mask = maskLayer2;
    
    
    UIButton* Loginbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Loginbtn.frame = CGRectMake(50,315,230,30);
    [Loginbtn setTitle:@"Login" forState:UIControlStateNormal];
    [Loginbtn setTitleColor:[UIColor whiteColor] forState:UIControlStateNormal];
    Loginbtn.backgroundColor = [UIColor colorWithRed:(83.0/255.0) green:(134.0/255.0) blue:(217.0/255.0) alpha:1.0];
    Loginbtn.layer.borderWidth = 2.0f;
    Loginbtn.layer.cornerRadius = 3.0f;
    Loginbtn.layer.borderColor = (__bridge CGColorRef)([UIColor colorWithRed:(83.0/255.0) green:(134.0/255.0) blue:(217.0/255.0) alpha:1.0]);
    [Loginbtn addTarget:self action:@selector(Loginbtnclicked) forControlEvents:UIControlEventTouchUpInside];
    Loginbtn.showsTouchWhenHighlighted = YES;
    [Loginbtn setHighlighted:NO];
    [self.view addSubview:Loginbtn];
    
    
    UIButton* FBbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    if (isiPhone5) {
        FBbtn.frame = CGRectMake(85,430,154,30);
    }else{
        FBbtn.frame = CGRectMake(85,370,154,30);
    }
    [FBbtn setImage:[UIImage imageNamed:@"FBLogin"] forState:UIControlStateNormal];
    [FBbtn addTarget:self action:@selector(FBbtnclicked) forControlEvents:UIControlEventTouchUpInside];
    FBbtn.layer.cornerRadius = 3.0f;
    FBbtn.clipsToBounds = YES;
    FBbtn.hidden = YES;
    FBbtn.showsTouchWhenHighlighted = YES;
    [self.view addSubview:FBbtn];
    
    
    UIButton* Registrationbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    if (isiPhone5) {
        Registrationbtn.frame = CGRectMake(85,470,154,40);
        
    }else{
        Registrationbtn.frame = CGRectMake(85,400,154,40);
    }
    [Registrationbtn setTitle:@"Sign up for FINAO" forState:UIControlStateNormal];
    Registrationbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:13.0];
    [Registrationbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
    Registrationbtn.showsTouchWhenHighlighted = YES;
    [Registrationbtn addTarget:self action:@selector(Registrationbtnclicked) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:Registrationbtn];
    [emailtxtfld setKeyboardType:UIKeyboardTypeEmailAddress];
    
    emailtxtfld.text = @"wallace@finaonation.com";
    Passwordtxtfld.text = @"password";
    
    //emailtxtfld.text = @"sawan.kumar@battatech.com";
    //Passwordtxtfld.text = @"qwerty";
    
    [USERDEFAULTS setBool:NO forKey:@"Loggedin"];
    
    [USERDEFAULTS setBool:NO forKey:@"FirstTimeShare"];
    
    [USERDEFAULTS synchronize];
}

-(void)Registrationbtnclicked{
    
    RegisterViewController* reg = [[RegisterViewController alloc]initWithNibName:@"RegisterViewController" bundle:nil];
    [self.navigationController pushViewController:reg animated:YES];
}


#pragma mark Textfield delegate
#pragma mark ---
- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
    if (textField == emailtxtfld) {
        [textField resignFirstResponder];
        return YES;
    }
    if (textField == Passwordtxtfld) {
        [textField resignFirstResponder];
        return YES;
    }
    return YES;
}

- (void)textFieldDidBeginEditing:(UITextField *)textField
{
    
    CGRect frame = self.view.frame;
    frame.origin.y = -(emailtxtfld.frame.origin.y -100);
    [UIView animateWithDuration:0.3f animations:^{
        self.view.frame = frame;
    }];
}

-(void) textFieldDidEndEditing:(UITextField *)textField{
    CGRect frame = self.view.frame;
    frame.origin.y = 0;
    [UIView animateWithDuration:0.3f animations:^{
        self.view.frame = frame;
    }];
}
#pragma mark Textfield delegate
-(void)Loginbtnclicked
{
    
    if ([emailtxtfld.text length] == 0 || [Passwordtxtfld.text length] == 0)
    {
        
        NSString* messageStr = [[NSString alloc]init];
        
        if ([Passwordtxtfld.text length] == 0) {
            messageStr = @"Please enter Password Field";
        }
        if ([emailtxtfld.text length] == 0) {
            messageStr = @"Please enter Password Field";
        }
        
        UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO Nation" message:messageStr delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil];
        [alert show];
    }
    else{
        
        if ([self emailCredibility:emailtxtfld.text]) {
            webservice = [[Servermanager alloc] init];
            [APPDELEGATE showHToastCenter:@"Logging in.."];
            webservice.delegate = self;
            
            NSString* base64str = [self base64String:[NSString stringWithFormat:@"%@:%@",emailtxtfld.text,Passwordtxtfld.text]];
            ////NSLog(@"base64str:%@",base64str);
            [USERDEFAULTS setValue:base64str forKey:@"base64str"];
            [webservice loginBase64:base64str username:emailtxtfld.text password:[Passwordtxtfld.text MD5]];
            TokenManager * tkMgr = [[TokenManager alloc] init];
            [tkMgr storeToken:base64str];
            
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

#pragma FB START
-(void)FBbtnclicked
{
    
    [APPDELEGATE showHToastCenter:@"Logging in.."];
    
    [self login];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
    //#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
    //#endif
    //NSLog(@"message:%@",message);
    //;
    
}


-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
    //NSLog(@"DATA : %@ ",data);
#endif
    //;
    if([[data valueForKey:@"IsSuccess"] integerValue] == 0 )
    {
        [APPDELEGATE  showHToast:@"Login failed"];
    }
    if([[data objectForKey:@"IsSuccess"] integerValue] == 1)
    {
        [APPDELEGATE  showHToast:@"Login Successful"];
        NSMutableDictionary* dic = [data objectForKey:@"item"];
        
        [self StoreAllDefaults:dic];
        
        if (FBregister) {
            [APPDELEGATE loadTabbar:NO];
            
        }else{
            [APPDELEGATE loadTabbar:YES];
        }
        
        [USERDEFAULTS setBool:YES forKey:@"Loggedin"];
        [USERDEFAULTS synchronize];
    }
    else{
        
        UIAlertView* Alert = [[UIAlertView alloc]initWithTitle:@"FINAO NATION" message:@"incorrect user or password" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [Alert show];
        
    }
    
}

-(void)StoreAllDefaults:(NSMutableDictionary*)dic
{
    
    
    //NSLog(@"Dic:%@:FID:%@",dic,FIDString);
    
    if (FBregister) {
        [USERDEFAULTS setValue:FIDString forKey:@"MD5password"];
        NSString* base64str = [self base64String:[NSString stringWithFormat:@"%@:%@",FBemail,FIDString]];
        [USERDEFAULTS setValue:base64str forKey:@"base64str"];
        //NSLog(@"base64str: %@",base64str);
        [USERDEFAULTS setValue:FBemail forKey:@"Email"];
        
    }else{
        [USERDEFAULTS setValue:[Passwordtxtfld.text MD5] forKey:@"MD5password"];
        
        NSString* base64str = [self base64String:[NSString stringWithFormat:@"%@:%@",emailtxtfld.text,Passwordtxtfld.text]];
        //NSLog(@"base64str:%@",base64str);
        [USERDEFAULTS setValue:base64str forKey:@"base64str"];
        
        [USERDEFAULTS setValue:emailtxtfld.text forKey:@"Email"];
        
        //NSLog(@"MD5password:%@",[USERDEFAULTS objectForKey:@"MD5password"]);
    }
    
    //NSLog(@"userid:%@",[dic objectForKey:@"userid"]);
    
    //USERID
    if ([dic objectForKey:@"userid"] == nil || [[dic objectForKey:@"userid"] isEqualToString:@""] ) {
        //NSLog(@"userid IS NULL");
        [USERDEFAULTS setValue:@"64" forKey:@"userid"];
    }
    else{
        [USERDEFAULTS setValue:[dic objectForKey:@"userid"] forKey:@"userid"];
    }
    
    //profile_image
    
    //NSLog(@"profile:%@",[dic objectForKey:@"profile_image"]);
    
    if ([dic objectForKey:@"profile_image"] == nil || [dic objectForKey:@"profile_image"] == nil) {
        //NSLog(@"profile_image IS NULL");
        [USERDEFAULTS setValue:@"" forKey:@"profile_image"];
        
    }
    else{
        [USERDEFAULTS setValue:[dic objectForKey:@"profile_image"] forKey:@"profile_image"];
    }
    
    //profile_image
    
    //NSLog(@"profile_bg_image:%@",[dic objectForKey:@"profile_bg_image"]);
    
    if ([dic objectForKey:@"profile_bg_image"] == nil || [dic objectForKey:@"profile_bg_image"] == nil) {
        //NSLog(@"profile_bg_image IS NULL");
        [USERDEFAULTS setValue:@"" forKey:@"profile_bg_image"];
        
    }
    else{
        [USERDEFAULTS setValue:[dic objectForKey:@"profile_bg_image"] forKey:@"profile_bg_image"];
    }
    
    //fname
    if ([dic objectForKey:@"fname"] == nil || [dic objectForKey:@"fname"] == nil) {
        //NSLog(@"name IS NULL");
        [USERDEFAULTS setValue:@"" forKey:@"name"];
        
    }
    else{
        NSString * firstAndLastName = [NSString stringWithFormat:@"%@ %@", [dic objectForKey:@"fname"],[dic objectForKey:@"lname"]];
        [USERDEFAULTS setValue:firstAndLastName forKey:@"name"];
        [USERDEFAULTS setValue:[dic objectForKey:@"fname"] forKey:@"fname"];
        [USERDEFAULTS setValue:[dic objectForKey:@"lname"] forKey:@"lname"];
    }
    
    //mystory
    if ([dic objectForKey:@"mystory"] == nil || [dic objectForKey:@"mystory"] == nil) {
        //NSLog(@"mystory IS NULL");
        [USERDEFAULTS setValue:@"" forKey:@"mystory"];
    }
    else{
        [USERDEFAULTS setValue:[dic objectForKey:@"mystory"] forKey:@"mystory"];
    }
    
}




- (void)storeAuthData:(NSString *)accessToken expiresAt:(NSDate *)expiresAt {
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setObject:accessToken forKey:@"FBAccessTokenKey"];
    [defaults setObject:expiresAt forKey:@"FBExpirationDateKey"];
    
    [defaults synchronize];
}
#pragma mark - FBSessionDelegate Methods
/**
 * Called when the user has logged in successfully.
 */
- (void)fbDidLogin {
    [self showLoggedIn];
    
    [self storeAuthData:[[APPDELEGATE facebook] accessToken] expiresAt:[[APPDELEGATE facebook] expirationDate]];
    
    
}

-(void)fbDidExtendToken:(NSString *)accessToken expiresAt:(NSDate *)expiresAt {
    //NSLog(@"token extended");
    [self storeAuthData:accessToken expiresAt:expiresAt];
}

/**
 * Called when the user canceled the authorization dialog.
 */
-(void)fbDidNotLogin:(BOOL)cancelled {
    //    [pendingApiCallsController userDidNotGrantPermission];
}

/**
 * Called when the request logout has succeeded.
 */
- (void)fbDidLogout {
    //    pendingApiCallsController = nil;
    
    // Remove saved authorization information if it exists and it is
    // ok to clear it (logout, session invalid, app unauthorized)
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults removeObjectForKey:@"FBAccessTokenKey"];
    [defaults removeObjectForKey:@"FBExpirationDateKey"];
    [defaults synchronize];
    
    [self showLoggedOut];
}

/**
 * Called when the session has expired.
 */
- (void)fbSessionInvalidated {
    //    UIAlertView *alertView = [[UIAlertView alloc]
    //                              initWithTitle:@"Auth Exception"
    //                              message:@"Your session has expired."
    //                              delegate:nil
    //                              cancelButtonTitle:@"OK"
    //                              otherButtonTitles:nil,
    //                              nil];
    //    [alertView show];
    //    [alertView release];
    [self fbDidLogout];
}

#pragma mark - FBRequestDelegate Methods
/**
 * Called when the Facebook API request has returned a response. This callback
 * gives you access to the raw response. It's called before
 * (void)request:(FBRequest *)request didLoad:(id)result,
 * which is passed the parsed response object.
 */
- (void)request:(FBRequest *)request didReceiveResponse:(NSURLResponse *)response {
    //NSLog(@"FBRequest MADHUreceived response : %@",response);
    
}

/**
 * Called when a request returns and its response has been parsed into
 * an object. The resulting object may be a dictionary, an array, a string,
 * or a number, depending on the format of the API response. If you need access
 * to the raw response, use:
 *
 * (void)request:(FBRequest *)request
 *      didReceiveResponse:(NSURLResponse *)response
 */
- (void)request:(FBRequest *)request didLoad:(id)result {
    if ([result isKindOfClass:[NSArray class]]) {
        result = [result objectAtIndex:0];
    }
    //NSLog(@"result : %@",result);
    
    // This callback can be a result of getting the user's basic
    // information or getting the user's permissions.
    if ([result objectForKey:@"name"]) {
        //        [self apiGraphUserPermissions];
        //NSLog(@"NAME LOGIN: %@",[result objectForKey:@"name"]);
        //NSLog(@"first_name LOGIN: %@",[result objectForKey:@"first_name"]);
        //NSLog(@"last_name LOGIN: %@",[result objectForKey:@"last_name"]);
        //NSLog(@"email LOGIN: %@",[result objectForKey:@"email"]);
        //NSLog(@"id LOGIN: %@",[result objectForKey:@"uid"]);
        [self apiGraphUserPermissions];
        //        [self LoginWithFaceBook:[result objectForKey:@"email"] FBid:[result objectForKey:@"uid"]];
        FBregister = YES;
        FIDString = [NSString stringWithFormat:@"%@",[result objectForKey:@"uid"]];
        FBemail = [NSString stringWithFormat:@"%@",[result objectForKey:@"email"]];
        webservice = [[Servermanager alloc] init];
        webservice.delegate = self;
        [webservice RegisterFacebook:[result objectForKey:@"first_name"] Lastname:[result objectForKey:@"last_name"] Email:[result objectForKey:@"email"] UID:[result objectForKey:@"uid"] ];
        
    } else {
        // Processing permissions information
        [APPDELEGATE setUserPermissions:[[result objectForKey:@"data"] objectAtIndex:0]];
    }
    
}

/**
 * Called when an error prevents the Facebook API request from completing
 * successfully.
 */
- (void)request:(FBRequest *)request didFailWithError:(NSError *)error {
    //NSLog(@"Err message: %@", [[error userInfo] objectForKey:@"error_msg"]);
    //NSLog(@"Err code: %ld", (long)[error code]);
}

#pragma mark - Facebook API Calls
/**
 * Make a Graph API Call to get information about the current logged in user.
 */
- (void)apiFQLIMe {
    // Using the "pic" picture since this currently has a maximum width of 100 pixels
    // and since the minimum profile picture size is 180 pixels wide we should be able
    // to get a 100 pixel wide version of the profile picture
    NSMutableDictionary *params = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                   @"SELECT uid,name,email,first_name,last_name, pic FROM user WHERE uid=me()", @"query",
                                   nil];
    //    AppDelegate *delegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    [[APPDELEGATE facebook] requestWithMethodName:@"fql.query"
                                        andParams:params
                                    andHttpMethod:@"POST"
                                      andDelegate:self];
}

- (void)apiGraphUserPermissions {
    //    AppDelegate *delegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    [[APPDELEGATE facebook] requestWithGraphPath:@"me/permissions" andDelegate:self];
}


#pragma - Private Helper Methods

/**
 * Show the logged in menu
 */

- (void)showLoggedIn {
    //    [self.navigationController setNavigationBarHidden:NO animated:NO];
    
    //    self.backgroundImageView.hidden = YES;
    //    loginButton.hidden = YES;
    //    self.menuTableView.hidden = NO;
    
    [self apiFQLIMe];
}

/**
 * Show the logged in menu
 */

- (void)showLoggedOut {
    //    [self.navigationController setNavigationBarHidden:YES animated:NO];
    //
    //    self.menuTableView.hidden = YES;
    //    self.backgroundImageView.hidden = NO;
    //    loginButton.hidden = NO;
    //
    //    // Clear personal info
    //    nameLabel.text = @"";
    //    // Get the profile image
    //    [profilePhotoImageView setImage:nil];
    
    //    [[self navigationController] popToRootViewControllerAnimated:YES];
}

/**
 * Show the authorization dialog.
 */
- (void)login {
    //    AppDelegate *delegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    if (![[APPDELEGATE facebook] isSessionValid]) {
        [[APPDELEGATE facebook] authorize:permissions];
    } else {
        [self showLoggedIn];
    }
}

/**
 * Invalidate the access token and clear the cookie.
 */
- (void)logout {
    //    AppDelegate *delegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    [[APPDELEGATE facebook] logout];
}

/**
 * Helper method called when a menu button is clicked
 */
- (void)menuButtonClicked:(id)sender {
    
}

#pragma FB end
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
