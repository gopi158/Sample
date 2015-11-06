//
//  ProfileDetailViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileDetailViewController.h"
#import "AppConstants.h"
#import "ProfileDetailTableCell.h"
#import "UIImageView+AFNetworking.h"
@interface ProfileDetailViewController ()

@end

@implementation ProfileDetailViewController

@synthesize finao_id;
@synthesize Finao_title;
@synthesize isPublicstr;
@synthesize Finao_status;
@synthesize inspireStatus;
@synthesize SelfUser;
@synthesize SearchusrID;
@synthesize FriendName;
@synthesize FriendimageURL;

dispatch_queue_t FinaoQueue_gcd;
NSString *shareString;
NSString* name;
UIImageView *shareImage;
NSDictionary *tempDict;
NSURL *shareUrl;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        UIImage *image = [UIImage imageNamed:@"logoheader.png"];
        self.navigationItem.titleView = [[UIImageView alloc] initWithImage:image];
    }
    return self;
}

-(void)ChangeFinao_StatusClicked{
    
    
    [self.view bringSubviewToFront:ChangeFinao_Status_View];
    ChangeFinao_Status_View.hidden = NO;
    
}

-(void)Change_PublicStatus_btnClicked
{
    if([isPubliclbl.text isEqualToString:@"Public"]){
        //        isPubliclbl.text = @"Private";
        [self ChangefromPubToPriv:@"0"];
    }else if([isPubliclbl.text isEqualToString:@"Private"]){
        //        isPubliclbl.text = @"Public";
        [self ChangefromPubToPriv:@"1"];
    }
    
    if([isPubliclbl.text isEqualToString:@"Follow"]){
        isPubliclbl.text = @"Unfollow";
        [self ChangefromfollowTounfollow];
    }else if([isPubliclbl.text isEqualToString:@"Unfollow"]){
        isPubliclbl.text = @"Follow";
        [self ChangefromfollowTounfollow];
    }
}
-(void)ChangefromfollowTounfollow{
    
    
}
-(void)ChangefromPubToPriv:(NSString*)Value{
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(PrivatePublicnotification:)
                                                 name:@"CHANGEPRIVATETOPUBLIC"
                                               object:nil];
    makeprivtopublic = [[MakePrivtoPub alloc]init];
    [makeprivtopublic ChangePublictoPrivate:[USERDEFAULTS valueForKey:@"userid"] Type:@"1" finaoid:finao_id status:Value];
    
}

-(void)PrivatePublicnotification:(NSNotification*)notification
{
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"CHANGEPRIVATETOPUBLIC" object:nil];
    
    if([isPubliclbl.text isEqualToString:@"Public"]){
        isPubliclbl.text = @"Private";
        //NSLog(@"PUBLIC ---------> PRIVATE");
    }else if([isPubliclbl.text isEqualToString:@"Private"]){
        isPubliclbl.text = @"Public";
        //NSLog(@"PRIVATE ---------> PUBLIC");
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    UIView* DetailHeader = [[UIView alloc]initWithFrame:CGRectMake(-1, -5, 322, 80)];
    DetailHeader.layer.borderColor = [UIColor lightGrayColor].CGColor; // set color as you want.
    DetailHeader.layer.borderWidth = 1.0; // set as you want.
    [self.view addSubview:DetailHeader];
    
    UILabel* FinaoTitle = [[UILabel alloc]initWithFrame:CGRectMake(20, 10, 280, 35)];
    FinaoTitle.backgroundColor = [UIColor clearColor];
    FinaoTitle.text = Finao_title;
    FinaoTitle.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    FinaoTitle.adjustsFontSizeToFitWidth = YES;
    FinaoTitle.minimumScaleFactor = 7.0f;
    FinaoTitle.numberOfLines = 3;
    FinaoTitle.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:FinaoTitle];
    
    Change_PublicStatus_btn = [UIButton buttonWithType:UIButtonTypeCustom];
    Change_PublicStatus_btn.frame = CGRectMake(20, 50, 50, 20);//20, 50, 50, 20
    [Change_PublicStatus_btn addTarget:self action:@selector(Change_PublicStatus_btnClicked) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:Change_PublicStatus_btn];
    
    isPubliclbl = [[UILabel alloc]initWithFrame:CGRectMake(20, 50, 70, 20)];
    isPubliclbl.backgroundColor = [UIColor clearColor];
    isPubliclbl.text = isPublicstr;
    isPubliclbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
    isPubliclbl.adjustsFontSizeToFitWidth = YES;
    isPubliclbl.minimumScaleFactor = 7.0f;
    //    isPubliclbl.numberOfLines = 3;
    isPubliclbl.textAlignment = NSTextAlignmentRight;
    isPubliclbl.textColor = [UIColor orangeColor];
    [self.view addSubview:isPubliclbl];
    
    ChangeFinao_Status = [UIButton buttonWithType:UIButtonTypeCustom];
    ChangeFinao_Status.frame = CGRectMake(220, 50, 80, 20);//200, 40, 80, 20
    [ChangeFinao_Status addTarget:self action:@selector(ChangeFinao_StatusClicked) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:ChangeFinao_Status];
    
    Finao_statuslbl = [[UILabel alloc]initWithFrame:CGRectMake(220, 50, 80, 20)];
    Finao_statuslbl.text = @"Unknown";
    Finao_statuslbl.backgroundColor = [UIColor blueColor]; // for testing
    if ([Finao_status integerValue] == 3) {
        Finao_statuslbl.text = @"Complete";
        Finao_statuslbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
        Finao_statuslbl.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
    }
    else{
        
        if ([Finao_status integerValue] == 38 || [Finao_status integerValue] == 0) {
            Finao_statuslbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
            Finao_statuslbl.text = @"Ontrack";
            Finao_statuslbl.backgroundColor = [UIColor lightGrayColor];
        }
        else
            if([Finao_status integerValue] == 39 || [Finao_status integerValue] == 1){
                Finao_statuslbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
                Finao_statuslbl.text = @"Ahead";
                Finao_statuslbl.backgroundColor = [UIColor orangeColor];
            }
            else if([Finao_status integerValue] == 40 || [Finao_status integerValue] == 2){
                Finao_statuslbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
                Finao_statuslbl.text = @"Behind";
                Finao_statuslbl.backgroundColor = [UIColor redColor];
            }
            else if([Finao_status integerValue] == 41 || [Finao_status integerValue] == 4){
                Finao_statuslbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
                Finao_statuslbl.text = @"Complete";
                Finao_statuslbl.backgroundColor = [UIColor greenColor];
            }
    }
    Finao_statuslbl.adjustsFontSizeToFitWidth = YES;
    Finao_statuslbl.minimumScaleFactor = 3.0f;
    
    Finao_statuslbl.textAlignment = NSTextAlignmentCenter;
    Finao_statuslbl.textColor = [UIColor whiteColor];
    [self.view addSubview:Finao_statuslbl];
    
    if (SelfUser) {
        
        ChangeFinao_Status_View = [[UIView alloc]initWithFrame:CGRectMake(180, 50, 120, 160)];
        ChangeFinao_Status_View.backgroundColor = [UIColor lightGrayColor];
        [self.view addSubview:ChangeFinao_Status_View];
        
        [self addBtnstouiview];
        ChangeFinao_Status_View.hidden = YES;
        
    }
    
    
    [APPDELEGATE showHToastCenter:@"Loading..."];
    
    //NSLog(@"finao_id:%@",finao_id);
    
    UITapGestureRecognizer *tapGestureRecognize = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(singleTapGestureRecognizer:)];
    tapGestureRecognize.delegate = self;
    tapGestureRecognize.numberOfTapsRequired = 1;
    //    [tapGestureRecognize requireGestureRecognizerToFail:dtapGestureRecognize];
    [self.view addGestureRecognizer:tapGestureRecognize];
    
    
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.FINAOPROFILEDETAILSlist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self GetFinaoDetails]; } );
    
    [self addProfile_finao_table];
}

-(void)singleTapGestureRecognizer:(UIGestureRecognizer *)gestureRecognizer
{
    ChangeFinao_Status_View.hidden = YES;
}

-(void)addBtnstouiview{
    
    UIButton* Ontrackbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Ontrackbtn.frame = CGRectMake(0, 0, ChangeFinao_Status_View.frame.size.width, 40);
    [Ontrackbtn setTitle:@"Ontrack" forState:UIControlStateNormal];
    Ontrackbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
    Ontrackbtn.titleLabel.adjustsFontSizeToFitWidth = YES;
    Ontrackbtn.titleLabel.minimumScaleFactor = 7.0f;
    Ontrackbtn.backgroundColor = [UIColor lightGrayColor];
    [Ontrackbtn addTarget:self action:@selector(OntrackbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [ChangeFinao_Status_View addSubview:Ontrackbtn];
    
    
    UIButton* Aheadbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Aheadbtn.frame = CGRectMake(0, 40, ChangeFinao_Status_View.frame.size.width, 40);
    [Aheadbtn setTitle:@"Ahead" forState:UIControlStateNormal];
    Aheadbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
    Aheadbtn.titleLabel.adjustsFontSizeToFitWidth = YES;
    Aheadbtn.titleLabel.minimumScaleFactor = 7.0f;
    Aheadbtn.backgroundColor = [UIColor orangeColor];
    [Aheadbtn addTarget:self action:@selector(AheadbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [ChangeFinao_Status_View addSubview:Aheadbtn];
    
    UIButton* Behindbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Behindbtn.frame = CGRectMake(0, 80, ChangeFinao_Status_View.frame.size.width, 40);
    [Behindbtn setTitle:@"Behind" forState:UIControlStateNormal];
    Behindbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
    Behindbtn.titleLabel.adjustsFontSizeToFitWidth = YES;
    Behindbtn.titleLabel.minimumScaleFactor = 7.0f;
    Behindbtn.backgroundColor = [UIColor redColor];
    [Behindbtn addTarget:self action:@selector(BehindbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [ChangeFinao_Status_View addSubview:Behindbtn];
    
    UIButton* Completebtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Completebtn.frame = CGRectMake(0, 120, ChangeFinao_Status_View.frame.size.width, 40);
    [Completebtn setTitle:@"Complete" forState:UIControlStateNormal];
    Completebtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
    Completebtn.titleLabel.adjustsFontSizeToFitWidth = YES;
    Completebtn.titleLabel.minimumScaleFactor = 7.0f;
    Completebtn.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
    [Completebtn addTarget:self action:@selector(CompletebtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [ChangeFinao_Status_View addSubview:Completebtn];
}
-(void)CompletebtnClicked{
    //NSLog(@"Completebtn clicked");
    Finao_statuslbl.text = @"Complete";
    Finao_statuslbl.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
    
    ChangeTrackInfo = [[ChangeTrackinfo alloc]init];
    [ChangeTrackInfo ChangeTrackInfo:[USERDEFAULTS valueForKey:@"userid"] Type:@"2" finaoid:finao_id status:@"41" isPublic:isPublicstr];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UpdateTrackinfonotification:)
                                                 name:@"UPDATETRACKINFO"
                                               object:nil];
}

-(void)BehindbtnClicked{
    //NSLog(@"Behindbtn clicked");
    Finao_statuslbl.text = @"Behind";
    Finao_statuslbl.backgroundColor = [UIColor redColor];
    
    ChangeTrackInfo = [[ChangeTrackinfo alloc]init];
    [ChangeTrackInfo ChangeTrackInfo:[USERDEFAULTS valueForKey:@"userid"] Type:@"2" finaoid:finao_id status:@"40" isPublic:isPublicstr];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UpdateTrackinfonotification:)
                                                 name:@"UPDATETRACKINFO"
                                               object:nil];
}

-(void)AheadbtnClicked{
    //NSLog(@"Aheadbtn clicked");
    Finao_statuslbl.text = @"Ahead";
    Finao_statuslbl.backgroundColor = [UIColor orangeColor];
    
    /*
     38 ontrack
     39 Ahead
     40 Behind
     1 complete
     */
    
    ChangeTrackInfo = [[ChangeTrackinfo alloc]init];
    [ChangeTrackInfo ChangeTrackInfo:[USERDEFAULTS valueForKey:@"userid"] Type:@"2" finaoid:finao_id status:@"39" isPublic:isPublicstr];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UpdateTrackinfonotification:)
                                                 name:@"UPDATETRACKINFO"
                                               object:nil];
}

-(void)UpdateTrackinfonotification:(NSNotification*)notification
{
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"UPDATETRACKINFO" object:nil];
    
    ChangeFinao_Status_View.hidden = YES;
}



-(void)OntrackbtnClicked{
    //NSLog(@"Ontrack clicked");
    Finao_statuslbl.text = @"Ontrack";
    Finao_statuslbl.backgroundColor = [UIColor lightGrayColor];
    
    ChangeTrackInfo = [[ChangeTrackinfo alloc]init];
    [ChangeTrackInfo ChangeTrackInfo:[USERDEFAULTS valueForKey:@"userid"] Type:@"2" finaoid:finao_id status:@"38" isPublic:isPublicstr];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(UpdateTrackinfonotification:)
                                                 name:@"UPDATETRACKINFO"
                                               object:nil];
}

-(void)GetFinaoDetails{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Servermanager* webservice = [[Servermanager alloc]init];
        webservice.delegate = self;
        if (SelfUser) {
            //[webservice GetProfile_finaos:[USERDEFAULTS valueForKey:@"userid"] FinaoID:finao_id];
            [webservice GetPPublicPostsForFinaoId:finao_id];
            
            
        }else{
            [webservice GetProfile_finaos:SearchusrID FinaoID:finao_id];
        }
    });
}

#pragma mark WEBservice delegate
- (void)addProfile_finao_table
{
    if (isiPhone5) {
        profile_finao_table = [[UITableView alloc]initWithFrame:CGRectMake(0, 75, 320, 380) style:UITableViewStylePlain];
    }
    else{
        profile_finao_table = [[UITableView alloc]initWithFrame:CGRectMake(0, 75, 320, 290) style:UITableViewStylePlain];
        
    }
    profile_finao_table.delegate = self;
    profile_finao_table.dataSource = self;
    [self.view addSubview:profile_finao_table];
    profile_finao_table.tableFooterView = [[UIView alloc]init];
    [profile_finao_table setSeparatorStyle:UITableViewCellSeparatorStyleSingleLine];
}

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            arrFINAOLIST = [data objectForKey:@"item"];
            NSLog(@"NSARRAY TYPE %@", arrFINAOLIST);
        }
        else{
            [APPDELEGATE showHToast:@"No items"];
        }
    
    NSLog(@"arrFINAOLIST:%@",arrFINAOLIST);
    
    [APPDELEGATE hideHUD];
    
    [profile_finao_table reloadData];
    
}
-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
    
}

#pragma mark Tableview Start

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
    if ([[tempDict objectForKey:@"image_urls"] count] == 0) {
        return 117.0f;
    }else{
        return 430.0f;
    }
}

- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
    NSLog(@"Tempdic = %@",tempDict);
    ProfileDetailTableCell *cell = (ProfileDetailTableCell *)[tableView dequeueReusableCellWithIdentifier:@"ProfileDetailTableCell"];
    if(cell == nil)
        cell = [[ProfileDetailTableCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"ProfileDetailFianoCell"];
    
    //NSLog(@"Tempdic = %@",tempDict);
    cell.shareBtn.tag = indexPath.row;
    if (!SelfUser) //Friends details
    {
        cell.shareBtn.tag = indexPath.row;
        [cell.shareBtn addTarget:self action:@selector(spamBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        
        NSLog(@"FriendimageURL:%@",FriendimageURL);
        cell.postImageView.hidden = YES;
        [cell.ProfileImage setImageWithURL:[NSURL URLWithString:FriendimageURL]];
        cell.ProfileName.text = [NSString stringWithFormat:@"%@",FriendName];
        
        
        ////////////////
        cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Finao_msg2.text = @"";
        }
        if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
            
            cell.Finao_detail_table.hidden = YES;
            cell.Upload_text.frame = CGRectMake(cell.Upload_text.frame.origin.x+10, 400, cell.frame.size.width-10, cell.Upload_text.frame.size.height);
            
            cell.Finao_Symbol.frame = CGRectMake(cell.Finao_Symbol.frame.origin.x +10, 400, cell.Finao_Symbol.frame.size.width, cell.Finao_Symbol.frame.size.height);
            
            cell.shareBtn.frame = CGRectMake(cell.shareBtn.frame.origin.x, 400, cell.shareBtn.frame.size.width,cell.shareBtn.frame.size.height);
            cell.VideoImageview.hidden = YES;
        }
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
            cell.inspireStatus.text = @"Inspiring";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.textColor = [UIColor whiteColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
            cell.inspireStatus.text = @"Inspired";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.backgroundColor = [UIColor whiteColor];
            cell.inspireStatus.textColor = [UIColor redColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
            || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
               || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            };
        }
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Upload_text.text = @"";
        }
        cell.ProfileName.text = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
        
        //NSLog(@"temp = %@",tempDict);
        
        cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
        }
        [cell ChangeFramesHomecell];
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
            cell.Images_arr = [tempDict objectForKey:@"image_urls"];
        }
        if ([cell.Images_arr count] == 0) {
            [cell ChangeFrameShare];
        }
        cell.playbtn.hidden = YES; // force off
        if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
            || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
               || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:50.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            }
        }
        
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
        
        
    }
    else if (SelfUser){
        NSLog(@"tempDict is =%@",tempDict);
        cell.shareBtn.tag = indexPath.row;
        [cell.shareBtn addTarget:self action:@selector(shareBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        
        cell.postImageView.hidden = YES;
        
        NSString* imageUrl = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"profile_image"]];
        
        [cell.ProfileImage setImageWithURL:[NSURL URLWithString:imageUrl]];
        
        cell.Finao_msg.text = [tempDict objectForKey:@"finao_msg"];
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Finao_msg2.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Finao_msg2.text = @"";
        }
        if ([[tempDict objectForKey:@"image_urls"] count] > 0) {
            
            cell.Finao_detail_table.hidden = YES;
            cell.Upload_text.frame = CGRectMake(cell.Upload_text.frame.origin.x+10, 400, cell.frame.size.width-10, cell.Upload_text.frame.size.height);
            
            cell.Finao_Symbol.frame = CGRectMake(cell.Finao_Symbol.frame.origin.x +10, 400, cell.Finao_Symbol.frame.size.width, cell.Finao_Symbol.frame.size.height);
            
            NSString *profileimageUrlFromResponse=[tempDict objectForKey:@"profile_image"];
            if(profileimageUrlFromResponse == nil)
                profileimageUrlFromResponse = [USERDEFAULTS valueForKey:@"profile_image"];
            cell.ProfileImage.image =[UIImage imageWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:profileimageUrlFromResponse]]];
            
            cell.shareBtn.frame = CGRectMake(cell.shareBtn.frame.origin.x, 400, cell.shareBtn.frame.size.width,cell.shareBtn.frame.size.height);
            cell.VideoImageview.hidden = YES;
        }
        if ([[tempDict objectForKey:@"isinspired"] integerValue] == 0) {
            cell.inspireStatus.text = @"Inspiring";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.textColor = [UIColor whiteColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        else if ([[tempDict objectForKey:@"isinspired"] integerValue] == 1) {
            cell.inspireStatus.text = @"Inspired";
            cell.inspireStatus.backgroundColor = [UIColor orangeColor];
            cell.inspireStatus.backgroundColor = [UIColor whiteColor];
            cell.inspireStatus.textColor = [UIColor redColor];
            cell.inspireStatus.layer.borderColor = [UIColor orangeColor ].CGColor;
            
        }
        if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
            || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
               || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            }
        }
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"upload_text"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"upload_text"];
        }
        else{
            cell.Upload_text.text = @"";
        }
        cell.ProfileName.text = [NSString stringWithFormat:@"%@",[USERDEFAULTS valueForKey:@"name"]];
        
        //NSLog(@"temp = %@",tempDict);
        
        cell.UpdatedDate.text = [tempDict objectForKey:@"updateddate"];
        
        if (![AppDelegate checkNull:[tempDict objectForKey:@"finao_msg"]]) {
            cell.Upload_text.text = [tempDict objectForKey:@"finao_msg"];
        }
        [cell ChangeFramesHomecell];
        if ([[tempDict objectForKey:@"image_urls"] isKindOfClass:[NSArray class]]) {
            cell.Images_arr = [tempDict objectForKey:@"image_urls"];
        }
        if ([cell.Images_arr count] == 0) {
            [cell ChangeFrameShare];
        }
        cell.playbtn.hidden = YES; // force off
        if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
            || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
            cell.finao_status.text = @"Ontrack";
            cell.finao_status.backgroundColor = [UIColor lightGrayColor];
            
        }
        else {
            if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
               || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
                cell.finao_status.text = @"Ahead";
                cell.finao_status.backgroundColor = [UIColor colorWithRed:50.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
                cell.finao_status.text = @"Behind";
                cell.finao_status.backgroundColor = [UIColor redColor];
            }
            else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                    || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
                cell.finao_status.text = @"Complete";
                cell.finao_status.backgroundColor = [UIColor greenColor];
            };
        }
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
    }
    return cell;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    return [arrFINAOLIST count];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

-(void)spamBtnClicked:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [arrFINAOLIST objectAtIndex:index];
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
    
    
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share",@"Follow this Tile", @"Flag as Inappropriate", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

-(void)shareBtnClicked:(id)sender{
    UIButton * theButton = (UIButton *) sender;
    NSInteger index = theButton.tag;
    tempDict = [arrFINAOLIST objectAtIndex:index];
    shareString = [tempDict objectForKey:@"finao_msg"];
    [shareImage setImageWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profile_image"]]]];
    name = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"profilename"]];
    
    
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:nil
                                                             delegate:self cancelButtonTitle: @"Cancel" destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Share", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

-(BOOL)isTwitterInstalled {
    if([SLComposeViewController isAvailableForServiceType:SLServiceTypeTwitter])
        return YES;
    else
        return NO;
}
-(BOOL)isFBInstalled {
    if([SLComposeViewController isAvailableForServiceType:SLServiceTypeFacebook])
        return YES;
    else
        return NO;
}
-(void)ShareAction{
    if(![self isTwitterInstalled]){
        UIAlertView *alertView =
        [[UIAlertView alloc]
         initWithTitle:@"Sorry" message:@"You can't share via Twitter yet, make sure your phone has a Twitter app installed and you have at least one Twitter account setup in your settings" delegate:nil
         cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alertView show];
    }
    if(![self isFBInstalled]){
        UIAlertView *alertView =
        [[UIAlertView alloc]
         initWithTitle:@"Sorry" message:@"You can't share via Facebook yet, make sure your phone has a Facebook app installed and you have at least one Facebook account setup in your settings" delegate:nil
         cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alertView show];
    }
    NSArray *activityItems = [NSArray arrayWithObjects:shareString, shareImage.image, shareUrl, nil];
    UIActivityViewController *activityViewController = [[UIActivityViewController alloc] initWithActivityItems:activityItems applicationActivities:nil];
    activityViewController.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
    if (NSFoundationVersionNumber > NSFoundationVersionNumber_iOS_6_1) {
        activityViewController.excludedActivityTypes = @[UIActivityTypePrint, UIActivityTypeCopyToPasteboard,UIActivityTypeAssignToContact, UIActivityTypeSaveToCameraRoll, UIActivityTypePostToWeibo, UIActivityTypeAddToReadingList, UIActivityTypeAirDrop];
        
    }
    [self presentViewController:activityViewController animated:YES completion:nil];
}
- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex == 0)
    {
        [self ShareAction];
        //            [self takeNewPhotoFromCamera];
    }
    else if (buttonIndex == 1)
    {
        //            [self choosePhotoFromExistingImages];
    }
    else if (buttonIndex == 2)
    {
        
    }
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return NO;
}

- (void)willPresentActionSheet:(UIActionSheet *)actionSheet
{
    for (UIView *subview in actionSheet.subviews) {
        if ([subview isKindOfClass:[UIButton class]]) {
            UIButton *button = (UIButton *)subview;
            [button setTitleColor:[UIColor lightGrayColor] forState:UIControlStateNormal];
            if ([button.titleLabel.text isEqualToString:@"Cancel"] ) {
                [button setTitleColor:[UIColor blueColor] forState:UIControlStateNormal];
            }
        }
    }
}

@end
