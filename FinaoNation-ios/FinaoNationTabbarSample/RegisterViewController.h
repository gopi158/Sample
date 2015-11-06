//
//  RegisterViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 21/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AppConstants.h"
#import "Servermanager.h"
//#import "FBConnect.h"

@interface RegisterViewController : UIViewController<UITextFieldDelegate,WebServiceDelegate,UITableViewDataSource,UITableViewDelegate,UIImagePickerControllerDelegate,UINavigationControllerDelegate,UIActionSheetDelegate>
{
        
	NSString* Fname ;
    NSString* Lname ;
	NSString* Emailaddress;
	NSString* password;
	NSString* Confirmpassword;
	
	UITextField* FnameField;
    UITextField* LnameField;
	UITextField* addressField;
	UITextField* passwordField;
	UITextField* ConfirmpasswordField;
    
    NSString* Imagename;
    
    Servermanager* webservice;
    UIImageView * profileImgview;
    BOOL FrameisUP;
    //FB
//    NSArray *permissions;
//    Facebook* facebook;
}
//FB
//@property(readonly) Facebook *facebook;
//@property (nonatomic, retain) NSArray *permissions;

// Creates a textfield with the specified text and placeholder text
-(UITextField*) makeTextField: (NSString*)text
                  placeholder: (NSString*)placeholder  ;

// Handles UIControlEventEditingDidEndOnExit
- (IBAction)textFieldFinished:(id)sender ;

@property (nonatomic,copy) NSString* Fname ;
@property (nonatomic,copy) NSString* Lname ;
@property (nonatomic,copy) NSString* Emailaddress ;
@property (nonatomic,copy) NSString* password ;
@property (nonatomic,copy) NSString* Confirmpassword ;

@end
