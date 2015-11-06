//
//  FollowersViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FollowersViewController.h"
#import "FinaoFollowersCell.h"
#import "UIImageView+AFNetworking.h"
#import "SearchDetailNewViewController.h"

@interface FollowersViewController ()

@end

@implementation FollowersViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Followers";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self getFollowersList];
}

-(void)getFollowersList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        GetFollowers = [[GetFollowersList alloc]init];
        [GetFollowers GetFollowersListFromServer];
    } );
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotFollowersListinDictionary:)
                                                 name:@"GETFOLLOWERSLIST"
                                               object:nil];
}


-(void)viewWillDisAppear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                 name:@"GETFOLLOWERSLIST"
                                               object:nil];
}
-(void)GotFollowersListinDictionary:(NSNotification *) notification
{
    arrFollowers = GetFollowers.FollowersListDic;
    ////NSLog(@"arrFollowersLIST:%@",arrFollowers);
    
    if (![arrFollowers count]) {
        [arrFollowers addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFOLLOWERS = TRUE;
    }
    if (isiPhone5) {
        FollowersTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 450) style:UITableViewStylePlain];
    }
    else{
        FollowersTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 375) style:UITableViewStylePlain];
        
    }
    FollowersTableview.delegate = self;
    FollowersTableview.dataSource = self;
    [self.view addSubview:FollowersTableview];
    FollowersTableview.tableFooterView = [[UIView alloc]init];
    
}


#pragma mark UItableview

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [arrFollowers count];
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 60.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    if (NOFOLLOWERS) {
        UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
        
        cell.textLabel.textColor = [UIColor lightGrayColor];
        ////NSLog(@"arrFollowersLIST:%@",arrFollowers);
        cell.textLabel.text = [arrFollowers objectAtIndex:indexPath.row];
        return cell;
    }
    else{
        FinaoFollowersCell *cell = (FinaoFollowersCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
        if(cell == nil)
            cell = [[FinaoFollowersCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoFollowersCell"];
        NSDictionary *tempDict = [arrFollowers objectAtIndex:indexPath.row];
        ////NSLog(@"tempDict:%@",tempDict);
        cell.FollowersName.text = [NSString stringWithFormat:@"%@ %@",[tempDict objectForKey:@"fname"],[tempDict objectForKey:@"lname"]];
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
        if ([tempDict objectForKey:@"image"] == nil) {
            [cell.FollowersImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
        }
        else{
            NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString:[imageUrl1 stringByReplacingOccurrencesOfString:@" " withString:@"%20"]]];
            __weak FinaoFollowersCell *weakCell = cell;
            
            [cell.FollowersImage setImageWithURLRequest: urlRequest
                                       placeholderImage: [UIImage imageNamed:@"No_Image@2x"]
                                                success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {
                                                    
                                                    __strong FinaoFollowersCell *strongCell = weakCell;
                                                    strongCell.FollowersImage.image = image;
                                                    [strongCell.activityIndicatorView stopAnimating];
                                                    [strongCell.activityIndicatorView setHidden:YES];
                                                    
                                                }
                                                failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                    
                                                    //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                    
                                                    __strong FinaoFollowersCell *strongCell = weakCell;
                                                    [strongCell.FollowersImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                                                    [strongCell.activityIndicatorView stopAnimating];
                                                    [strongCell.activityIndicatorView setHidden:YES];
                                                }
             
             ];
            [cell.activityIndicatorView setHidden:YES];
            [cell.activityIndicatorView stopAnimating];
        }
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        return cell;
    }
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    NSDictionary *tempDict = [arrFollowers objectAtIndex:indexPath.row];
    ////NSLog(@"temp DICT : %@",tempDict);
    SearchDetailNewViewController* searchDetails = [[SearchDetailNewViewController alloc]initWithNibName:@"SearchDetailNewViewController" bundle:nil];
    [self.navigationController pushViewController:searchDetails animated:YES];
    
    searchDetails.Firstname = [tempDict objectForKey:@"name"];
    searchDetails.Lastname = [tempDict objectForKey:@""];
    searchDetails.StoryText = [tempDict objectForKey:@"mystory"];
    NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
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
