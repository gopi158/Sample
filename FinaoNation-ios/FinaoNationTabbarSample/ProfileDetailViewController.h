//
//  ProfileDetailViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"
#import "MakePrivtoPub.h"
#import "ChangeTrackinfo.h"
@interface ProfileDetailViewController : UIViewController<UITableViewDataSource,UITableViewDelegate,WebServiceDelegate,UIActionSheetDelegate,UIGestureRecognizerDelegate>{
    NSString* isPublicstr;
    NSString* Finao_status;
    NSString* inspireStatus;
    NSString* finao_id;
    NSString* Finao_title;
    NSMutableArray* arrFINAOLIST;
    UITableView* profile_finao_table;
    UILabel* isPubliclbl;
    UILabel* Finao_statuslbl;
    UIButton* ChangeFinao_Status,*Change_PublicStatus_btn;
    BOOL SelfUser;
    NSString* SearchusrID;
    NSString* FriendName;
    NSString* FriendimageURL;
    
    UIView* ChangeFinao_Status_View;
    
    MakePrivtoPub* makeprivtopublic;
    ChangeTrackinfo* ChangeTrackInfo;
}
@property(nonatomic,retain)NSString* FriendimageURL;
@property(nonatomic,retain)NSString* FriendName;
@property(nonatomic,assign)BOOL SelfUser;
@property(nonatomic,retain)NSString* SearchusrID;
@property(nonatomic,retain)NSString* finao_id;
@property(nonatomic,retain)NSString* Finao_title;
@property(nonatomic,retain)NSString* isPublicstr;
@property(nonatomic,retain)NSString* Finao_status;
@property(nonatomic,retain)NSString* inspireStatus;

@end
