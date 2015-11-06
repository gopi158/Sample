//
//  FinaoViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoViewController.h"
#import "ProfileDetailViewController.h"
#import "CreateFinaoViewController.h"

@interface FinaoViewController ()

@end

@implementation FinaoViewController

@synthesize Userid;
@synthesize SelfUser;
@synthesize imageurl;
@synthesize FriendusrName;

dispatch_queue_t PostQueue_gcd;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"FINAOs";

    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.navigationController.navigationBar.translucent = NO;
    [self GetFinaoList];
}
-(void)GetFinaoList{
    dispatch_async(dispatch_get_main_queue(), ^ {
        if (SelfUser) {
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotFinaoListinDictionary:)
                                                         name:@"GETFINAOLIST"
                                                       object:nil];
            
            GetFinoaList  = [[GetFinaoList alloc]init];
            [GetFinoaList GetFinaoListFromServer];
        }else{
            
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotFinaoListinDictionary:)
                                                         name:@"GETSEARCHFINAOLIST"
                                                       object:nil];
            
            GetFinoasListProfile  = [[GetFinaoForSearch alloc]init];
            GetFinoasListProfile.PassesUsrid = [USERDEFAULTS valueForKey:@"userid"];
            //NSLog(@"USERID:%@",Userid);
            [GetFinoasListProfile GetSearchFinaoListFromServer:Userid];
        }
        
    } );
    
}
-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    //FOR GETTING FINAO LIST

    
    
}

-(void)GotFinaoListinDictionary:(NSNotification *) notification
{

    if (SelfUser) {
        arrFinao = GetFinoaList.FinaoListDic;
    }else{
        arrFinao = GetFinoasListProfile.FinaoListDic;
    }
    
    if ([arrFinao count] == 0) {
        [arrFinao addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        UserisNew = TRUE;
    }
    
    if (SelfUser) {
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFINAOLIST" object:nil];
    }else{
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHFINAOLIST" object:nil];
    }
    
    if (isiPhone5) {
        FinaoTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 450) style:UITableViewStylePlain];
    }
    else{
        FinaoTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 375) style:UITableViewStylePlain];

    }
    FinaoTableview.delegate = self;
    FinaoTableview.dataSource = self;
    [self.view addSubview:FinaoTableview];
    
    
    if (SelfUser) {
        UIView* headerView = [[UIView alloc]initWithFrame:CGRectMake(0, 10, 320, 40)];
        headerView.backgroundColor = [UIColor orangeColor];
        UILabel* headerLbl = [[UILabel alloc]initWithFrame:CGRectMake(80, 10, 160, 20)];
        headerLbl.text = @"Create a new FINAO";
        headerLbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15];
        headerLbl.textColor = [UIColor whiteColor];
        headerLbl.backgroundColor = [UIColor clearColor];
        [headerView addSubview:headerLbl];
        
        
        UIButton* headerbtn = [UIButton buttonWithType:UIButtonTypeCustom];
        headerbtn.frame = CGRectMake(0, 10, 320, 40);
        [headerbtn addTarget:self action:@selector(CreateFinaoClicked) forControlEvents:UIControlEventTouchUpInside];
        [headerView addSubview:headerbtn];
        
        FinaoTableview.tableHeaderView = headerView;
    }
    FinaoTableview.tableFooterView = [[UIView alloc]init];
}

-(void)CreateFinaoClicked{
    
    CreateFinaoViewController* CreateFinao = [[CreateFinaoViewController alloc]initWithNibName:@"CreateFinaoViewController" bundle:nil];
    [self.navigationController pushViewController:CreateFinao animated:YES];
    
}

#pragma mark uitabaleview related

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    
    NSDictionary *tempDict = [arrFinao objectAtIndex:indexPath.row];
    
    ProfileDetailViewController* profileDetail = [[ProfileDetailViewController alloc]initWithNibName:@"ProfileDetailViewController" bundle:nil];
    [self.navigationController pushViewController:profileDetail animated:YES];
    //NSLog(@"finao_msg:%@",[tempDict objectForKey:@"finao_msg"]);
    profileDetail.finao_id = [tempDict objectForKey:@"finao_id"];
    profileDetail.Finao_title = [tempDict objectForKey:@"finao_msg"];
    
    if ([[tempDict objectForKey:@"tracking_status"] integerValue] == 1) {
        profileDetail.isPublicstr = @"Public";
    }else{
        profileDetail.isPublicstr = @"Private";
    }
    profileDetail.SelfUser = SelfUser;
    profileDetail.Finao_status = [tempDict objectForKey:@"finao_status"];
    
    if (!SelfUser) {
        profileDetail.SearchusrID = [NSString stringWithFormat:@"%@",Userid];
        profileDetail.FriendName = [NSString stringWithFormat:@"%@",FriendusrName];
        profileDetail.FriendimageURL = imageurl;
        profileDetail.Finao_status = [tempDict objectForKey:@"finao_status"];
        if ([[tempDict objectForKey:@"tracking_status"] integerValue]) {
            profileDetail.isPublicstr = @"Follow";
        }else{
            profileDetail.isPublicstr = @"Unfollow";
        }
    }
    
    [tableView deselectRowAtIndexPath:indexPath animated:NO];
    
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
        return [arrFinao count];
    
}
- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
        return 60.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{

    UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
    
    cell.textLabel.minimumScaleFactor = 8.0f/[UIFont labelFontSize];
    cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
    
    if (SelfUser) {
        
        if (UserisNew) {
            cell.textLabel.textColor = [UIColor lightGrayColor];
            cell.textLabel.text = [arrFinao objectAtIndex:indexPath.row];
        }
        else{
            cell.textLabel.textColor = [UIColor lightGrayColor];
            NSDictionary *tempDict = [arrFinao objectAtIndex:indexPath.row];
            cell.textLabel.text = [tempDict objectForKey:@"finao_msg"];
        }
    }
    else{
        cell.textLabel.textColor = [UIColor lightGrayColor];
        NSDictionary *tempDict = [arrFinao objectAtIndex:indexPath.row];
        if ([tempDict isKindOfClass:[NSDictionary class]]) {
            cell.textLabel.text = [tempDict objectForKey:@"finao_msg"];
        }
    }
    
    cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    
    return cell;

}
#pragma mark uitableview end

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
