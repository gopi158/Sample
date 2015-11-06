//
//  FollowingViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FollowingViewController.h"
#import "FinaoFollowingCell.h"
#import "UIImageView+AFNetworking.h"
#import "SearchDetailNewViewController.h"

@interface FollowingViewController ()

@end

@implementation FollowingViewController

@synthesize  Userid;
@synthesize SelfUser;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Following";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self getFollowingList];
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
}

-(void)getFollowingList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        if (SelfUser) {
            //FOR FOLLOWING LIST
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotFollowingListinDictionary:)
                                                         name:@"GETFOLLOWINGLIST"
                                                       object:nil];
            GetFollowing = [[GetFollowingList alloc]init];
            [GetFollowing GetFollowingListFromServer];
        }else{
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotFollowingListinDictionary:)
                                                         name:@"GETSEARCHFOLLOWINGLIST"
                                                       object:nil];

            GetFollowingListProfile = [[GetSearchFollowingList alloc]init];
            [GetFollowingListProfile GetSearchFollowingListFromServer:Userid];
        }
    } );
}

-(void)GotFollowingListinDictionary:(NSNotification *) notification
{
    
    arrFollowings = [[NSMutableArray alloc]init];
        
    if (SelfUser) {
        arrFollowings = GetFollowing.FollowingListDic;
    }else{
        arrFollowings = GetFollowingListProfile.FollowingListDic;
    }
    
    //    //NSLog(@"arrFollowingList:%@",arrFollowingList);
//    arrFollowings = GetFollowing.FollowingListDic;
        //NSLog(@"arrFollowingList:%@",arrFollowings);
    
    if (![arrFollowings count]) {
        [arrFollowings addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFollowings = TRUE;
    }
    
    if (SelfUser) {
         [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFOLLOWINGLIST" object:nil];
    }else{
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHFOLLOWINGLIST" object:nil];
    }
    
//
    
    if (isiPhone5) {
        FollowingTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 450) style:UITableViewStylePlain];
    }
    else{
        FollowingTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 375) style:UITableViewStylePlain];
        
    }
    FollowingTableview.delegate = self;
    FollowingTableview.dataSource = self;
    [self.view addSubview:FollowingTableview];
    FollowingTableview.tableFooterView = [[UIView alloc]init];
}
#pragma mark uitableview

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [arrFollowings count];
    
}
- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    return 60.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (NOFollowings)
    {
        UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
        
        cell.textLabel.textColor = [UIColor lightGrayColor];
        cell.textLabel.text = [arrFollowings objectAtIndex:indexPath.row];
        
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        return cell;
    }
    else
    {
        FinaoFollowingCell *cell = (FinaoFollowingCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
        
        
        if(cell == nil)
            cell = [[FinaoFollowingCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoFollowingCell"];
        
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        NSDictionary *tempDict = [arrFollowings objectAtIndex:indexPath.row];
        
        cell.FollowingName.text = [NSString stringWithFormat:@"%@ %@",[tempDict objectForKey:@"fname"],[tempDict objectForKey:@"lname"]];
        
        
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
        
        NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString:[imageUrl1 stringByReplacingOccurrencesOfString:@" " withString:@"%20"]]];
        
//        NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString: imageUrl1]];
        __weak FinaoFollowingCell *weakCell = cell;
        
        [cell.FollowingImage setImageWithURLRequest: urlRequest
                                   placeholderImage: [UIImage imageNamed:@"No_Image@2x"]
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
        
        
        //                cell.selectionStyle = UITableViewCellSelectionStyleNone;
        
        return cell;
    }
    
    
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{

    NSDictionary *tempDict = [arrFollowings objectAtIndex:indexPath.row];
    
    //NSLog(@"temp DICT : %@",tempDict);
    
    
    SearchDetailNewViewController* searchDetails = [[SearchDetailNewViewController alloc]initWithNibName:@"SearchDetailNewViewController" bundle:nil];
    [self.navigationController pushViewController:searchDetails animated:YES];
    
    searchDetails.Firstname = [tempDict objectForKey:@"name"];
    searchDetails.Lastname = [tempDict objectForKey:@""];
    searchDetails.StoryText = [tempDict objectForKey:@"mystory"];
    NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"h",[tempDict objectForKey:@"image"]];
    searchDetails.imageUrlStr = imageUrl1;
    
    searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
    searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
    searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
    searchDetails.SearchusrID = [tempDict objectForKey:@"userid"];
    
    [tableView deselectRowAtIndexPath:indexPath animated:NO];
}

#pragma mark uitableview end
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
