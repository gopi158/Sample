//
//  AppConstants.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//
#import "AppDelegate.h"
#import "ServiceCallsManager.h"

#ifndef FinaoNationTabbarSample_AppConstants_h
#define FinaoNationTabbarSample_AppConstants_h

BOOL isSlidable ;
#define isiPhone5  ([[UIScreen mainScreen] bounds].size.height == 568)?TRUE:FALSE

//Base url
//#define BASEURL @"http://finaonation.com/mobile/"
//define BASEURL @"http://skootweet.com/preprod/mobile/"
//#define BASEURL @"http://finaonationb.com/devwebservices/"
#define BASEURL @"http://finaonationb.com/mobilewebservices/"

#define CALLMANAGER (ServiceCallsManager *)[ServiceCallsManager sharedManager]

//Tabbar controller tint Color
#define TABBAR_COLOR [UIColor orangeColor]
#define TABBAR_COLOR_IOS6 [UIColor orangeColor]

//NavigationController tint Color
#define NAVBAR_COLOR [UIColor whiteColor]

//UITabbar Text Color on Normal State
#define TABBAR_NORMAL_TEXTCOLOR [UIColor grayColor]

//UITabbar Text Color on Selected State
#define TABBAR_SELECTED_TEXTCOLOR [UIColor orangeColor]

//UITabbar Text Font and size NORMAL
#define TABBAR_TEXT_FONT_SIZE_NORMAL [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0]

//UITabbar Text Font and size SELECTED
#define TABBAR_TEXT_FONT_SIZE_SELECTED [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0]

#define USERDEFAULTS [NSUserDefaults standardUserDefaults]

#define APPDELEGATE (AppDelegate *)[[UIApplication sharedApplication] delegate]


#endif
