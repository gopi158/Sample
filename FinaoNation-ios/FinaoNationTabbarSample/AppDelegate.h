//
//  AppDelegate.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "MBProgressHUD.h"
#import "FBConnect.h"
//#import "LoginViewController.h"
//#import "RegisterViewController.h"
//@class RegisterViewController;
//@class LoginViewController;

@interface AppDelegate : UIResponder <UIApplicationDelegate,MBProgressHUDDelegate,UITabBarControllerDelegate, UIViewControllerAnimatedTransitioning, UIAlertViewDelegate>
{
    MBProgressHUD *HUD;
    Facebook *facebook;
    //    LoginViewController* Login;
    //    RegisterViewController* regFB;
    UINavigationController * CurrentNav;
    UINavigationController* Nav1;
    UINavigationController* Nav2;
    UINavigationController* Nav3;
    UINavigationController* Nav4;
}
@property (nonatomic, retain)UITabBarController* thisTabbarcontroller;
//FB
@property (nonatomic, retain) Facebook *facebook;
@property (nonatomic, retain) NSMutableDictionary *userPermissions;


@property (strong, nonatomic) UIWindow *window;
@property(strong, nonatomic)UINavigationController * CurrentNav;
@property(strong, nonatomic)UINavigationController * Nav1;
@property(strong, nonatomic)UINavigationController * Nav2;
@property(strong, nonatomic)UINavigationController * Nav3;
@property(strong, nonatomic)UINavigationController * Nav4;
@property (readonly, strong, nonatomic) NSManagedObjectContext *managedObjectContext;
@property (readonly, strong, nonatomic) NSManagedObjectModel *managedObjectModel;
@property (readonly, strong, nonatomic) NSPersistentStoreCoordinator *persistentStoreCoordinator;

- (void)saveContext;
- (NSURL *)applicationDocumentsDirectory;

-(void)loadTabbar : (BOOL)Login;
-(void)showHUDWithMessage:(NSString *) message;
-(void)hideHUD;
-(void)initFBLogin;
+(BOOL) checkNull :(id)objectToBeChecked;
-(void)showHToast:(NSString *) message;
-(void)showHToast:(NSString *) message WithDelegate:(UIViewController *)delegate;
-(void)showHToast:(NSString *) message WithTitle:(NSString *) thistitle WithDelegate:(UIViewController *)delegate;
-(void)TransitionToNotifications;
-(void)showHToastCenter:(NSString *) message;
-(void)showHToastBottom:(NSString *) message;

-(void)gotoProfile;

//-(void)initFBRegister;
//-(NSString*)RetFBAPPid;

@end
