
//  AppDelegate.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "AppDelegate.h"
#import "HomeScreenViewController.h"
#import "SearchViewController.h"
#import "PostFinaoListViewController.h"
#import "ProfileV1ViewController.h"
#import "AppConstants.h"
#import "MFSideMenuContainerViewController.h"
#import "SlideNoteViewController.h"
#import "UIView+Toast.h"
#import "LoginViewController.h"
#import "RegisterViewController.h"
#import "NotificationViewController.h"

static NSString* kAppId = @"1429595363945000";

@interface AppDelegate ()
<UINavigationControllerDelegate>
{

}
@end
@implementation AppDelegate
@synthesize CurrentNav,Nav1, Nav2,Nav3,Nav4;
@synthesize thisTabbarcontroller;
@synthesize facebook;
@synthesize userPermissions;

@synthesize managedObjectContext = _managedObjectContext;
@synthesize managedObjectModel = _managedObjectModel;
@synthesize persistentStoreCoordinator = _persistentStoreCoordinator;



- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    self.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];
    
    //    [self initFBRegister];

    if (![USERDEFAULTS boolForKey:@"Loggedin"])
    {
        LoginViewController* Login = [[LoginViewController alloc]initWithNibName:@"LoginViewController" bundle:nil];
        
        UINavigationController* nav = [[UINavigationController alloc]initWithRootViewController:Login];
        self.window.rootViewController = nav;
        
    }
    else
    {
        
        self.thisTabbarcontroller = [[UITabBarController alloc]init];
        self.thisTabbarcontroller.viewControllers = [self initiliseTabbar];
        self.thisTabbarcontroller.tabBar.tintColor = TABBAR_COLOR;
        self.thisTabbarcontroller.selectedIndex = 0;
        self.thisTabbarcontroller.delegate = self;
        [[UITabBar appearance]setBarTintColor:[UIColor whiteColor]];
        self.window.rootViewController = self.thisTabbarcontroller;
    }
    
    [self.window makeKeyAndVisible];
    [APPDELEGATE  showHToastBottom:@"Version 1.02"];
    [self cancelAllLocalNotifications];
    [[UIApplication sharedApplication]registerForRemoteNotificationTypes:
     UIRemoteNotificationTypeBadge |
     UIRemoteNotificationTypeAlert |
     UIRemoteNotificationTypeSound];
    return YES;
}



-(void)cancelAllLocalNotifications{
    UIApplication* app = [UIApplication sharedApplication];
    //NSArray*  oldNotifications = [app scheduledLocalNotifications];
    [app cancelAllLocalNotifications];
}

- (void)application:(UIApplication *)application didReceiveLocalNotification:(UILocalNotification *)notification {
    
    UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Finao" message:@"Notifications pending" delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"OK", nil];
    
    [alertView show];
}
#pragma mark - UIAlertViewDelegate methods
- (void)alertView:(UIAlertView *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex {
    if (buttonIndex == 1)
    {
        NotificationViewController *notif = [[NotificationViewController alloc]init];
        [self.CurrentNav pushViewController:notif animated:YES];
    }
    else
    {
        NSLog(@"cancel");
    }
}

- (void)alertView:(UIAlertView *)alertView didDismissWithButtonIndex:(NSInteger)buttonIndex {

}

-(void)TransitionToNotifications
{

}
-(void)loadTabbar : (BOOL)Login
{
    
   self.thisTabbarcontroller = [[UITabBarController alloc]init];
    
    self.thisTabbarcontroller.viewControllers = [self initiliseTabbar];
    
    self.thisTabbarcontroller.tabBar.tintColor = TABBAR_COLOR;
    
    if (Login) {
        self.thisTabbarcontroller.selectedIndex = 0;
    }
    else{
        self.thisTabbarcontroller.selectedIndex = 3;
    }
    self.window.rootViewController = self.thisTabbarcontroller;
}

-(void)gotoProfile
{
    self.thisTabbarcontroller.selectedIndex = 3;
}
-(NSArray*)initiliseTabbar{
    
    NSArray* Retval;
    
    //HomeScreenViewController
    HomeScreenViewController* home = [[HomeScreenViewController alloc]initWithNibName:@"HomeScreenViewController" bundle:nil];
    self.CurrentNav = self.Nav1 =[[UINavigationController alloc]initWithRootViewController:home];
    self.Nav1.navigationBar.tintColor = NAVBAR_COLOR;
    
    //SearchViewController
    SearchViewController* search = [[SearchViewController alloc]initWithNibName:@"SearchViewController" bundle:nil];
    self.Nav2 = [[UINavigationController alloc]initWithRootViewController:search];
    self.Nav2.navigationBar.tintColor = NAVBAR_COLOR;
    
    //PostViewController
    PostFinaoListViewController* post = [[PostFinaoListViewController alloc]initWithNibName:@"PostFinaoListViewController" bundle:nil];
    self.Nav3 = [[UINavigationController alloc]initWithRootViewController:post];
    self.Nav3.navigationBar.tintColor = NAVBAR_COLOR;
    
    //ProfileViewController
    ProfileV1ViewController* profile = [[ProfileV1ViewController alloc]initWithNibName:@"ProfileV1ViewController" bundle:nil];
    self. Nav4 = [[UINavigationController alloc]initWithRootViewController:profile];
    self.Nav4.navigationBar.tintColor = NAVBAR_COLOR;
    
    Retval = [NSArray arrayWithObjects:self.Nav1,self.Nav2,self.Nav3,self.Nav4, nil];
    return Retval;
}



+(BOOL) checkNull :(id)objectToBeChecked{
    
    if (objectToBeChecked == NULL || objectToBeChecked == nil || objectToBeChecked == Nil || [objectToBeChecked isKindOfClass:[NSNull class]]) {
        return TRUE;
    }
    
    return FALSE;
    
}

#pragma FB

-(void)initFBLogin{
    
    
    // Initialize Facebook
    
    LoginViewController* Login = [[LoginViewController alloc]initWithNibName:@"LoginViewController" bundle:nil];
    // Initialize Facebook
    facebook = [[Facebook alloc] initWithAppId:kAppId andDelegate:Login];
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    if ([defaults objectForKey:@"FBAccessTokenKey"] && [defaults objectForKey:@"FBExpirationDateKey"]) {
        facebook.accessToken = [defaults objectForKey:@"FBAccessTokenKey"];
        facebook.expirationDate = [defaults objectForKey:@"FBExpirationDateKey"];
    }
    
    userPermissions = [[NSMutableDictionary alloc] initWithCapacity:1];
    
    if (!kAppId) {
        UIAlertView *alertView = [[UIAlertView alloc]
                                  initWithTitle:@"Setup Error"
                                  message:@"Missing app ID. You cannot run the app until you provide this in the code."
                                  delegate:self
                                  cancelButtonTitle:@"OK"
                                  otherButtonTitles:nil,
                                  nil];
        [alertView show];
    }
    else {
        NSString *url = [NSString stringWithFormat:@"fb%@://authorize",kAppId];
        BOOL bSchemeInPlist = NO; // find out if the sceme is in the plist file.
        NSArray* aBundleURLTypes = [[NSBundle mainBundle] objectForInfoDictionaryKey:@"CFBundleURLTypes"];
        if ([aBundleURLTypes isKindOfClass:[NSArray class]] &&
            ([aBundleURLTypes count] > 0)) {
            NSDictionary* aBundleURLTypes0 = [aBundleURLTypes objectAtIndex:0];
            if ([aBundleURLTypes0 isKindOfClass:[NSDictionary class]]) {
                NSArray* aBundleURLSchemes = [aBundleURLTypes0 objectForKey:@"CFBundleURLSchemes"];
                if ([aBundleURLSchemes isKindOfClass:[NSArray class]] &&
                    ([aBundleURLSchemes count] > 0)) {
                    NSString *scheme = [aBundleURLSchemes objectAtIndex:0];
                    if ([scheme isKindOfClass:[NSString class]] &&
                        [url hasPrefix:scheme]) {
                        bSchemeInPlist = YES;
                    }
                }
            }
        }
        // Check if the authorization callback will work
        BOOL bCanOpenUrl = [[UIApplication sharedApplication] canOpenURL:[NSURL URLWithString: url]];
        if (!bSchemeInPlist || !bCanOpenUrl) {
            UIAlertView *alertView = [[UIAlertView alloc]
                                      initWithTitle:@"Setup Error"
                                      message:@"Invalid or missing URL scheme. You cannot run the app until you set up a valid URL scheme in your .plist."
                                      delegate:self
                                      cancelButtonTitle:@"OK"
                                      otherButtonTitles:nil,
                                      nil];
            [alertView show];
        }
    }
    
}

- (BOOL)application:(UIApplication *)application handleOpenURL:(NSURL *)url {
    //NSLog(@"application handleOpenURL  %@",url);
    return [self.facebook handleOpenURL:url];
}

- (BOOL)application:(UIApplication *)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation {
    
    //NSLog(@"application openURL  %@",url);
    if ([[url absoluteString]isEqualToString:@"iOSDevFinao"])
        return NO;
    else//
        return [self.facebook handleOpenURL:url];
}


#pragma mark - App Delegate methods

- (void)applicationWillResignActive:(UIApplication *)application
{
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    
}

- (void)applicationWillEnterForeground:(UIApplication *)application
{
    
}


- (void)applicationDidBecomeActive:(UIApplication *)application {
    [[self facebook] extendAccessTokenIfNeeded];
}

- (void)applicationWillTerminate:(UIApplication *)application
{
    [self saveContext];
}

- (void)saveContext
{
    NSError *error = nil;
    NSManagedObjectContext *managedObjectContext = self.managedObjectContext;
    if (managedObjectContext != nil) {
        if ([managedObjectContext hasChanges] && ![managedObjectContext save:&error]) {
            //NSLog(@"Unresolved error %@, %@", error, [error userInfo]);
        }
    }
}

#pragma mark - Core Data stack
- (NSManagedObjectContext *)managedObjectContext
{
    if (_managedObjectContext != nil) {
        return _managedObjectContext;
    }
    
    NSPersistentStoreCoordinator *coordinator = [self persistentStoreCoordinator];
    if (coordinator != nil) {
        _managedObjectContext = [[NSManagedObjectContext alloc] init];
        [_managedObjectContext setPersistentStoreCoordinator:coordinator];
    }
    return _managedObjectContext;
}

- (NSManagedObjectModel *)managedObjectModel
{
    if (_managedObjectModel != nil) {
        return _managedObjectModel;
    }
    NSURL *modelURL = [[NSBundle mainBundle] URLForResource:@"FinaoNationTabbarSample" withExtension:@"momd"];
    _managedObjectModel = [[NSManagedObjectModel alloc] initWithContentsOfURL:modelURL];
    return _managedObjectModel;
}

- (NSPersistentStoreCoordinator *)persistentStoreCoordinator
{
    if (_persistentStoreCoordinator != nil) {
        return _persistentStoreCoordinator;
    }
    
    NSURL *storeURL = [[self applicationDocumentsDirectory] URLByAppendingPathComponent:@"FinaoNationTabbarSample.sqlite"];
    
    NSError *error = nil;
    _persistentStoreCoordinator = [[NSPersistentStoreCoordinator alloc] initWithManagedObjectModel:[self managedObjectModel]];
    if (![_persistentStoreCoordinator addPersistentStoreWithType:NSSQLiteStoreType configuration:nil URL:storeURL options:nil error:&error]) {

    }
    
    return _persistentStoreCoordinator;
}

#pragma mark - Application's Documents directory

- (NSURL *)applicationDocumentsDirectory
{
    return [[[NSFileManager defaultManager] URLsForDirectory:NSDocumentDirectory inDomains:NSUserDomainMask] lastObject];
}


#pragma mark - UINavigationControllerDelegate

- (id ) tabBarController:(UITabBarController*)tabBarController
animationControllerForTransitionFromViewController:(UIViewController*)fromVC
        toViewController:(UIViewController*)toVC
{
    return self;
}

- (NSTimeInterval)transitionDuration:(id <UIViewControllerContextTransitioning>)transitionContext {
    return 0.30f;
}
- (void) animateTransition:(id)transitionContext
{
    static const CGFloat DampingConstant     = 0.75;
    static const CGFloat InitialVelocity     = 0.5;
    static const CGFloat PaddingBetweenViews = 20;
    
    UIView* inView           = [transitionContext containerView];
    UIViewController* fromVC = [transitionContext viewControllerForKey:UITransitionContextFromViewControllerKey];
    UIView* fromView         = [fromVC view];
    UIViewController* toVC   = [transitionContext viewControllerForKey:UITransitionContextToViewControllerKey];
    UIView* toView           = [toVC view];
    inView.backgroundColor = [UIColor blackColor];
    CGRect centerRect = [transitionContext finalFrameForViewController:toVC];
    CGRect leftRect   = CGRectOffset(centerRect, -(CGRectGetWidth(centerRect)+PaddingBetweenViews), 0);
    CGRect rightRect  = CGRectOffset(centerRect, CGRectGetWidth(centerRect)+PaddingBetweenViews, 0);
    if ( [self.thisTabbarcontroller.viewControllers indexOfObject:fromVC] <
        [self.thisTabbarcontroller.viewControllers indexOfObject:toVC]  )
    {
        toView.frame = rightRect;
        [inView addSubview:toView];
        [UIView animateWithDuration:[self transitionDuration:transitionContext]
                              delay:0.0
             usingSpringWithDamping:DampingConstant
              initialSpringVelocity:InitialVelocity
                            options:0
                         animations:^{
                             fromView.frame = leftRect;
                             toView.frame = centerRect;
                         }
                         completion:^(BOOL finished) {
                             [transitionContext completeTransition:YES];
                         }];
    }
    else
    {
        toView.frame = leftRect;
        [inView addSubview:toView];
        [UIView animateWithDuration:[self transitionDuration:transitionContext]
                              delay:0.0
             usingSpringWithDamping:DampingConstant
              initialSpringVelocity:-InitialVelocity
                            options:0
                         animations:^{
                             fromView.frame = rightRect;
                             toView.frame = centerRect;
                         }
                         completion:^(BOOL finished) {
                             [transitionContext completeTransition:YES];
                         }];
    }
}


#pragma HUDs and TOASTs
-(void)showHToastOneSec:(NSString *) message
{
    @try {
        [self.window makeToast:message
                      duration:1.0
                      position:@"top"];
    } @catch (NSException *exception) {}
}
-(void)showHToast:(NSString *) message
{
    @try {
        [self.window makeToast:message
                      duration:2.0
                      position:@"top"];
    }
    @catch (NSException *exception) {
    }
}
-(void)showHToast:(NSString *) message WithTitle:(NSString *) thistitle WithDelegate:(UIViewController *)delegate
{
    @try {
        [self.window makeToast:message
                      duration:2.0
                      position:@"top"
                    title:nil
                  WithDelegate:(UIViewController *)delegate];
    }
    @catch (NSException *exception) {
    }
}

-(void)showHToast:(NSString *) message WithDelegate:(UIViewController *)delegate
{
    @try {
        [self.window makeToast:message
                      duration:2.0
                      position:@"top"
          WithDelegate:(UIViewController *)delegate];
    }
    @catch (NSException *exception) {
    }
}

-(void)showHToastBottom:(NSString *) message
{
    @try {
        [self.window makeToast:message
                      duration:2.0
                      position:@"bottom"];
    } @catch (NSException *exception) {}
}

-(void)showHToastCenter:(NSString *) message
{
    @try {
        [self.window makeToast:message
                      duration:2.0
                      position:@"center"];
    } @catch (NSException *exception) {}
}

-(void)showHToastCenterOneSec:(NSString *) message
{
    @try {
        [self.window makeToast:message
                      duration:0.5
                      position:@"center"];
    } @catch (NSException *exception) {}
}

-(void)showHUDWithMessage:(NSString *) message
{
    [self showHToastCenterOneSec: message];
}

-(void)hideHUD
{
    
}
@end
