//
//  SearchORFollowingDetailViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SearchORFollowingDetailViewController.h"
#import "AppConstants.h"
#import "Reachability.h"
#import "UIImageView+AFNetworking.h"
#import "FinaoFollowingCell.h"
#import "FinaoTableCell.h"
#import "FinaoTilesCell.h"
#import "TilesDetailViewController.h"
#import "FollowingDetailViewController.h"
#import "ProfileDetailViewController.h"

dispatch_queue_t FinaoQueue_gcd;


@interface SearchORFollowingDetailViewController ()

@end

@implementation SearchORFollowingDetailViewController

@synthesize imageUrlStr;
@synthesize StoryText;
@synthesize NumofFinaos;
@synthesize NumofTiles;
@synthesize NumofFollowing;
@synthesize Firstname;
@synthesize Lastname;
@synthesize SearchusrID;
@synthesize PassesUsrid;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        
        //FOR GETTING FINAO LIST
        [[NSNotificationCenter defaultCenter] addObserver:self
                                                 selector:@selector(GotFinaoListinDictionary:)
                                                     name:@"GETSEARCHFINAOLIST"
                                                   object:nil];
        
        //FOR FOLLOWING LIST
        [[NSNotificationCenter defaultCenter] addObserver:self
                                                 selector:@selector(GotFollowingListinDictionary:)
                                                     name:@"GETSEARCHFOLLOWINGLIST"
                                                   object:nil];
        
        //FOR TILES LIST
        [[NSNotificationCenter defaultCenter] addObserver:self
                                                 selector:@selector(GotTiLesListinDictionary:)
                                                     name:@"GETSEARCHTILESLIST"
                                                   object:nil];
    }
    return self;
}
-(BOOL)CheckReachability {
    
    Reachability* reachability = [Reachability reachabilityForInternetConnection];
    [Reachability reachabilityWithHostName:@"www.apple.com"];    // set your host name here
    NetworkStatus remoteHostStatus = [reachability currentReachabilityStatus];
    
    if (remoteHostStatus == NotReachable)
        return NO;
    else
        return YES;
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self loadOthers];
}

-(void)loadOthers{
    
    HeaderView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 320, 130)];
    HeaderView.backgroundColor = [ UIColor whiteColor];
    [self.view addSubview:HeaderView];
    
    UIImageView* imgview = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 70, 70)];
    imgview.layer.borderColor = [UIColor grayColor].CGColor;
    imgview.layer.borderWidth = 1.0f;
    imgview.image = [UIImage imageNamed:@"profile"];
    [HeaderView addSubview:imgview];

    UILabel* ProfileName = [[UILabel alloc]initWithFrame:CGRectMake(95, 10, 210, 20)];
    ProfileName.textColor = [UIColor orangeColor];
    ProfileName.text = [NSString stringWithFormat:@"%@ %@",Firstname,Lastname];
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15.0];
    ProfileName.adjustsFontSizeToFitWidth = YES;
    [HeaderView addSubview:ProfileName];
    
    UITextView* txtview = [[UITextView alloc]initWithFrame:CGRectMake(90, 30, 210, 50)];
    txtview.text = [NSString stringWithFormat:@"%@",StoryText];
    txtview.editable = NO;
    [HeaderView addSubview:txtview];

    [imgview setImageWithURL:[NSURL URLWithString:imageUrlStr] placeholderImage:[UIImage imageNamed:@"profile"]];
    
    ProfileimageData = [NSData dataWithContentsOfURL:[NSURL URLWithString:imageUrlStr]];
    
    FinaoCountLbl = [[UILabel alloc]initWithFrame:CGRectMake(20, 96, 20, 15)];
    FinaoCountLbl.text = [NSString stringWithFormat:@"%@",NumofFinaos];
    FinaoCountLbl.adjustsFontSizeToFitWidth = YES;
    FinaoCountLbl.backgroundColor = [UIColor clearColor];
    FinaoCountLbl.textColor = [UIColor orangeColor];
    [HeaderView addSubview:FinaoCountLbl];
    
    TileCountLbl = [[UILabel alloc]initWithFrame:CGRectMake(120, 96, 20, 15)];
    TileCountLbl.text = [NSString stringWithFormat:@"%@",NumofTiles];
    TileCountLbl.adjustsFontSizeToFitWidth = YES;
    TileCountLbl.backgroundColor = [UIColor clearColor];
    TileCountLbl.textColor = [UIColor orangeColor];
    [HeaderView addSubview:TileCountLbl];
    
    FollowingCountLbl = [[UILabel alloc]initWithFrame:CGRectMake(220, 96, 20, 15)];
    FollowingCountLbl.text = [NSString stringWithFormat:@"%@",NumofFollowing];;
    FollowingCountLbl.adjustsFontSizeToFitWidth = YES;
    FollowingCountLbl.backgroundColor = [UIColor clearColor];
    FollowingCountLbl.textColor = [UIColor orangeColor];
    [HeaderView addSubview:FollowingCountLbl];
    
    Finoasbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Finoasbtn.frame = CGRectMake(10, 90, 100, 25);
    Finoasbtn.selected = YES;
    [Finoasbtn setTitle:@"\tFinoas" forState:UIControlStateNormal];
    Finoasbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11];
    Finoasbtn.layer.borderWidth = 1.0f;
    Finoasbtn.layer.borderColor = [UIColor orangeColor].CGColor;
    
    [Finoasbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
    [Finoasbtn setTitleColor:[UIColor whiteColor] forState:UIControlStateSelected];
    [Finoasbtn setBackgroundImage:[UIImage imageNamed:@"Orangebtn"] forState:UIControlStateSelected];
    [Finoasbtn addTarget:self action:@selector(FinaoBtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Finoasbtn];
    
    Tilesbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Tilesbtn.frame = CGRectMake(110, 90, 100, 25);
    [Tilesbtn setTitle:@"\tTiles" forState:UIControlStateNormal];
    Tilesbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11];
    Tilesbtn.layer.borderWidth = 1.0f;
    Tilesbtn.layer.borderColor = [UIColor orangeColor].CGColor;
    [Tilesbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
    [Tilesbtn setTitleColor:[UIColor whiteColor] forState:UIControlStateSelected];
    [Tilesbtn setBackgroundImage:[UIImage imageNamed:@"Orangebtn"] forState:UIControlStateSelected];
    [Tilesbtn addTarget:self action:@selector(TilesbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [HeaderView addSubview:Tilesbtn];
    
    Followingbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    Followingbtn.frame = CGRectMake(210, 90, 100, 25);
    [Followingbtn setTitle:@"\t Following" forState:UIControlStateNormal];
    Followingbtn.titleLabel.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11];
    Followingbtn.layer.borderWidth = 1.0f;
    Followingbtn.layer.borderColor = [UIColor orangeColor].CGColor;
    [Followingbtn setTitleColor:[UIColor orangeColor] forState:UIControlStateNormal];
    [Followingbtn setTitleColor:[UIColor whiteColor] forState:UIControlStateSelected];
    [Followingbtn setBackgroundImage:[UIImage imageNamed:@"Orangebtn"] forState:UIControlStateSelected];
    [Followingbtn addTarget:self action:@selector(FollowingbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    
    [HeaderView addSubview:Followingbtn];
    
    if (Finoasbtn.isSelected) {
        FinaoCountLbl.textColor = [UIColor whiteColor];
    }
    else
    {
        FinaoCountLbl.textColor = [UIColor orangeColor];
    }
    
    [HeaderView bringSubviewToFront:FinaoCountLbl];
    [HeaderView bringSubviewToFront:TileCountLbl];
    [HeaderView bringSubviewToFront:FollowingCountLbl];
    
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.Tileslist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self GetSearchFinao]; } );
    
}

-(void)GetSearchFinao{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        GetFinoasListProfile  = [[GetFinaoForSearch alloc]init];
        GetFinoasListProfile.PassesUsrid = PassesUsrid;
        [GetFinoasListProfile GetSearchFinaoListFromServer:SearchusrID];
    });
}

-(void)SettingsClicked{
    
    
}

-(void)GotFinaoListinDictionary:(NSNotification *) notification
{
    
    arrFINAOLIST = [[NSMutableArray alloc]init];
    
    if ([arrFINAOLIST count] == 0) {
        [arrFINAOLIST addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNew = TRUE;
    }
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHFINAOLIST" object:nil];
    
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.Followinglist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self getFollowingList]; } );
    
    [self LoadFinaoTables];
}

-(void)GotFollowingListinDictionary:(NSNotification *) notification
{
    arrFollowingList = [[NSMutableArray alloc]init];
    arrFollowingList = GetFollowingListProfile.FollowingListDic;
    
    if (![arrFollowingList count]) {
        [arrFollowingList addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFollowings = TRUE;
    }
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHFOLLOWINGLIST" object:nil];
    
    
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.Tileslist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self getTilesList]; } );
    
}

-(void)getFollowingList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetFollowingListProfile = [[GetSearchFollowingList alloc]init];
        [GetFollowingListProfile GetSearchFollowingListFromServer:SearchusrID];
        
    } );
}

-(void)getTilesList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        GetTilesListProfile = [[GetTilesForSearch alloc]init];
        [GetTilesListProfile GetSearchTilesListFromServer:SearchusrID];
        
    } );
}

//GotTiLesListinDictionary

-(void)GotTiLesListinDictionary:(NSNotification *) notification
{
    
    arrTilesList = [[NSMutableArray alloc]init];
    
    //NSLog(@"arrTilesList:%@",arrTilesList);
    arrTilesList = GetTilesListProfile.TilesListDic;
    //    //NSLog(@"arrFollowingList:%@",arrTilesList);
    
    if (![arrTilesList count]) {
        [arrTilesList addObject:@"No Items Found."];
        NOTiles = TRUE;
    }
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHTILESLIST" object:nil];
    
}


-(void)FinaoBtnClicked
{
    if (Followingbtn.selected) {
        Followingbtn.selected = NO;
    }
    
    if (Tilesbtn.selected) {
        Tilesbtn.selected = NO;
    }
    Finoasbtn.selected = YES;
    FinaoCountLbl.textColor = [UIColor whiteColor];
    FollowingCountLbl.textColor = [UIColor orangeColor];
    TileCountLbl.textColor = [UIColor orangeColor];
    [self LoadFinaoTables];
    
}

-(void)TilesbtnClicked
{
    
    //    Followingbtn.selected = YES;
    if (Finoasbtn.selected) {
        Finoasbtn.selected = NO;
    }
    
    if (Followingbtn.selected) {
        Followingbtn.selected = NO;
    }
    
    Tilesbtn.selected = YES;
    
    TileCountLbl.textColor = [UIColor whiteColor];
    FinaoCountLbl.textColor = [UIColor orangeColor];
    FollowingCountLbl.textColor = [UIColor orangeColor];
    
    TilesTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 130, 320, 230) style:UITableViewStylePlain];
    TilesTable.delegate = self;
    TilesTable.dataSource = self;
    [self.view addSubview:TilesTable];
    
    TilesTable.tableFooterView = [[UIView alloc]init];
    if (TablesScrolledUP) {
        TilesTable.frame = CGRectMake(0, 50, 320, 330);
        HeaderView.frame = CGRectMake(0, -80, 320, 130);
    }
    else{
        HeaderView.frame = CGRectMake(0, 0, 320, 130);
        TilesTable.frame = CGRectMake(0, 130, 320, 330);
    }
}

-(void)FollowingbtnClicked
{
    
    Followingbtn.selected = YES;
    if (Finoasbtn.selected) {
        Finoasbtn.selected = NO;
    }
    if (Tilesbtn.selected) {
        Tilesbtn.selected = NO;
    }
    
    FinaoCountLbl.textColor = [UIColor orangeColor];
    TileCountLbl.textColor = [UIColor orangeColor];
    FollowingCountLbl.textColor = [UIColor whiteColor];
    
    FollowingTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 130, 320, 230) style:UITableViewStylePlain];
    FollowingTable.delegate = self;
    FollowingTable.dataSource = self;
    [self.view addSubview:FollowingTable];
    
    FollowingTable.tableFooterView = [[UIView alloc]init];
    if (TablesScrolledUP) {
        FollowingTable.frame = CGRectMake(0, 50, 320, 330);
        HeaderView.frame = CGRectMake(0, -80, 320, 130);
    }
    else{
        HeaderView.frame = CGRectMake(0, 0, 320, 130);
        FollowingTable.frame = CGRectMake(0, 130, 320, 330);
    }
}

//-(void)FollowersbtnClicked
//{
//
//}
#pragma mark Btn Action end

-(void)LoadFinaoTables{
    
    FinaoTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 130, 320, 230) style:UITableViewStylePlain];
    FinaoTable.delegate = self;
    FinaoTable.dataSource = self;
    [self.view addSubview:FinaoTable];
    FinaoTable.hidden = NO;
    FinaoTable.tableFooterView = [[UIView alloc]init];
    
    if (FirStTime) {
        FirStTime = NO;
        if (TablesScrolledUP) {
            FinaoTable.frame = CGRectMake(0, 50, 320, 330);
            HeaderView.frame = CGRectMake(0, -80, 320, 130);
            [self.view bringSubviewToFront:HeaderView];
        }
        else{
            FinaoTable.frame = CGRectMake(0, 130, 320, 330);
            HeaderView.frame = CGRectMake(0, 0, 320, 130);
            [self.view bringSubviewToFront:HeaderView];
            
        }
    }
    else{
        FirStTime = YES;
        if (TablesScrolledUP) {
            FinaoTable.frame = CGRectMake(0, 50, 320, 330);
            HeaderView.frame = CGRectMake(0, -80, 320, 130);
            [self.view bringSubviewToFront:HeaderView];
            
        }
        else{
            FinaoTable.frame = CGRectMake(0, 130, 320, 330);
            HeaderView.frame = CGRectMake(0, 0, 320, 130);
            [self.view bringSubviewToFront:HeaderView];
            
        }
    }
    
}

#pragma mark TableView

- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    
    CGFloat sectionHeaderHeight = 10;
    if (scrollView.contentOffset.y<sectionHeaderHeight&&scrollView.contentOffset.y>0)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-scrollView.contentOffset.y, 0, 0, 0);
        TablesScrolledUP = NO;
        HeaderView.frame = CGRectMake(0, 0, 320, 130);
        [self.view bringSubviewToFront:HeaderView];
        if (Finoasbtn.selected) {
            FinaoTable.frame = CGRectMake(0, 130, 320, 330);
            [FinaoTable reloadData];
        }
        if (Tilesbtn.selected) {
            TilesTable.frame = CGRectMake(0, 130, 320, 330);
            [TilesTable reloadData];
        }
        
        if (Followingbtn.selected) {
            FollowingTable.frame = CGRectMake(0, 130, 320, 330);
            [FollowingTable reloadData];
        }
        
    } else if (scrollView.contentOffset.y>sectionHeaderHeight)
    {
        scrollView.contentInset = UIEdgeInsetsMake(-sectionHeaderHeight, 0, 0, 0);
        TablesScrolledUP = YES;
        
        HeaderView.frame = CGRectMake(0, -80, 320, 130);
        if (Finoasbtn.selected) {
            FinaoTable.frame = CGRectMake(0, 50, 320, 330);
            [FinaoTable reloadData];
        }
        if (Tilesbtn.selected) {
            TilesTable.frame = CGRectMake(0, 50, 320, 330);
            [TilesTable reloadData];
            
        }
        
        
        
        if (Followingbtn.selected) {
            FollowingTable.frame = CGRectMake(0, 50, 320, 330);
            [FollowingTable reloadData];
        }
    }
    
}


- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == FinaoTable){
        return 60.0f;
    }
    else
        if (tableView == TilesTable){
            return 60.0f;
        }
        else{
            return 60.0f;
        }
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    if (tableView == FinaoTable) {
        return [arrFINAOLIST count];
    }
    else
        if (tableView == TilesTable)
        {
            return [arrTilesList count];
        }
        else
            return [arrFollowingList count];
}


- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (tableView == FinaoTable) {
        
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        
        if (UserisNew) {
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrFINAOLIST objectAtIndex:indexPath.row];
        }
        else{
            cell.textLabel.textColor = [UIColor lightGrayColor];
            NSDictionary *tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
            cell.textLabel.text = [tempDict objectForKey:@"finao_title"]; //finao_msg
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        
        return cell;
    }else if (tableView == TilesTable){
        
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        
        if (NOTiles) {
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrTilesList objectAtIndex:indexPath.row];
        }
        else{
            cell.textLabel.textColor = [UIColor lightGrayColor];
            NSDictionary *tempDict = [arrTilesList objectAtIndex:indexPath.row];
            cell.textLabel.text = [tempDict objectForKey:@"tile_name"];
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        
        return cell;
        
    }
    else if(tableView == FollowingTable){
        
        if (NOFollowings)
        {
            UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
            
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrFollowingList objectAtIndex:indexPath.row];
            
            cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
            return cell;
        }
        else
        {
            FinaoFollowingCell *cell = (FinaoFollowingCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
            
            
            if(cell == nil)
                cell = [[FinaoFollowingCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoFollowingCell"];
            
            NSDictionary *tempDict = [arrFollowingList objectAtIndex:indexPath.row];
            
            cell.FollowingName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"name"]];
            
            
            NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            
            
            NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString: imageUrl1]];
            __weak FinaoFollowingCell *weakCell = cell;
            
            [cell.FollowingImage setImageWithURLRequest: urlRequest
                                       placeholderImage: nil
                                                success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {       
                                                    __strong FinaoFollowingCell *strongCell = weakCell;
                                                    strongCell.FollowingImage.image = image;
                                                    [strongCell.activityIndicatorView stopAnimating];
                                                    [strongCell.activityIndicatorView setHidden:YES];
                                                    
                                                }
                                                failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                    
                                                    //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                    
                                                    __strong FinaoFollowingCell *strongCell = weakCell;
                                                    [strongCell.FollowingImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                                                }
             
             ];
            
            [cell.activityIndicatorView setHidden:YES];
            [cell.activityIndicatorView stopAnimating];
            
            
            cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
            
            return cell;
        }
    }else{
        UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
        
        cell.textLabel.minimumScaleFactor = 8.0f;
        
        return cell;
    }
    
}


-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (tableView == FinaoTable){
        
        
        NSDictionary *tempDict = [arrFINAOLIST objectAtIndex:indexPath.row];
        
        ProfileDetailViewController* profileDetail = [[ProfileDetailViewController alloc]initWithNibName:@"ProfileDetailViewController" bundle:nil];
        [self.navigationController pushViewController:profileDetail animated:YES];
        //NSLog(@"finao_title:%@",[tempDict objectForKey:@"finao_title"]); //finao_msg
        profileDetail.finao_id = [tempDict objectForKey:@"finao_id"];
        profileDetail.Finao_title = [tempDict objectForKey:@"finao_title"]; //finao_msg
        
        if ([[tempDict objectForKey:@"tracking_status"] integerValue]==0) {
            profileDetail.isPublicstr = @"Follow";
        }else{
            profileDetail.isPublicstr = @"Unfollow";
        }
        profileDetail.SelfUser = NO;
        profileDetail.SearchusrID = SearchusrID;
        profileDetail.FriendName = [NSString stringWithFormat:@"%@ %@",Firstname,Lastname];
        profileDetail.FriendimageURL = imageUrlStr;
        profileDetail.Finao_status = [tempDict objectForKey:@"finao_status"];
    }
    else
        if(tableView == TilesTable){
            
            //NSLog(@"arrTilesList:%@",arrTilesList);
            
            NSDictionary *tempDict = [arrTilesList objectAtIndex:indexPath.row];
            
            //NSLog(@"Temp:%@",[tempDict objectForKey:@"tile_id"]);
            
            TilesDetailViewController* tileDetail = [[TilesDetailViewController alloc]initWithNibName:@"TilesDetailViewController" bundle:nil];
            tileDetail.PassesUsrid = [tempDict objectForKey:@"userid"];
            tileDetail.TileIDStr = [tempDict objectForKey:@"tile_id"];
            tileDetail.WebStringExtra = [NSString stringWithFormat:@"%@%@",@"&ispublic=1&actual_user_id=",[USERDEFAULTS valueForKey:@"userid"]];
            tileDetail.Friendsname = [NSString stringWithFormat:@"%@ %@",Firstname,Lastname];
            tileDetail.FriendsImageURL = imageUrlStr;
            tileDetail.SelfUser = NO;
            
            [self.navigationController pushViewController:tileDetail animated:YES];
            
            
        }
        else if(tableView == FollowingTable){
            
            NSDictionary *tempDict = [arrFollowingList objectAtIndex:indexPath.row];
            
            //NSLog(@"arrFollowingList = %@",arrFollowingList);
            
            FollowingDetailViewController* searchFollowing = [[FollowingDetailViewController alloc]initWithNibName:@"FollowingDetailViewController" bundle:nil];
            [self.navigationController pushViewController:searchFollowing animated:YES];
            
            
            searchFollowing.Firstname = [tempDict objectForKey:@"name"];
            searchFollowing.Lastname = [tempDict objectForKey:@""];
            searchFollowing.StoryText = [tempDict objectForKey:@"mystory"];
            NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            searchFollowing.imageUrlStr = imageUrl;
            
            searchFollowing.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
            searchFollowing.NumofTiles = [tempDict objectForKey:@"totaltiles"];
            searchFollowing.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
            searchFollowing.SearchusrID = [tempDict objectForKey:@"userid"];
        }
    
    [tableView deselectRowAtIndexPath:indexPath animated:NO];
}


#pragma mark Tableview end


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
