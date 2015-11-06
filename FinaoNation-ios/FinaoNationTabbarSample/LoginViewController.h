//
//  LoginViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"
#import "FBConnect.h"

@interface LoginViewController : UIViewController<UITextFieldDelegate,WebServiceDelegate,FBRequestDelegate,FBDialogDelegate,FBSessionDelegate>
{
    UITextField* emailtxtfld;
    UITextField* Passwordtxtfld;
    Servermanager* webservice;
    //FB
    NSArray *permissions;
    BOOL FBregister;
    NSString* FIDString;
    NSString* FBemail;
}
//FB
@property (nonatomic, retain) NSArray *permissions;
@end
