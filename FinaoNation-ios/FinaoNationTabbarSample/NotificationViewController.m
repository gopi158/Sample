//
//  NotificationViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "NotificationViewController.h"

@interface NotificationViewController ()

@end

@implementation NotificationViewController

GetNotificationInfo *getNotificationInfo;
@synthesize  Userid;
@synthesize SelfUser;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Notifications";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self getNotificationsList];
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
}

-(void)getNotificationsList{
    
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotNotificationinfo:)
                                                 name:@"GETNOTIFICATIONSINFO"
                                               object:nil];
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        [self GetNotificationList];
    });
}

-(void)GetNotificationList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        
        getNotificationInfo = [[GetNotificationInfo alloc]init];
        [getNotificationInfo GetNotifications];
        
    } );
    
}
-(void)GotNotificationinfo:(NSNotification*)notify{
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETNOTIFICATIONSINFO" object:nil];
    arrNotifications = getNotificationInfo.FinaoListDic;
    if ([arrNotifications count] == 0) {
        [arrNotifications addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Notifications Found."];
    }
    else{
        NSString *message = [NSString stringWithFormat:@"%lu %@",(unsigned long)[arrNotifications count],@"Notifications waiting."];
        [APPDELEGATE showHToastCenter:message];
    }
    if (isiPhone5) {
        NotificationTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 450) style:UITableViewStylePlain];
    }
    else{
        NotificationTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 375) style:UITableViewStylePlain];
        
    }
    NotificationTableview.delegate = self;
    NotificationTableview.dataSource = self;
    [self.view addSubview:NotificationTableview];
    NotificationTableview.tableFooterView = [[UIView alloc]init];
}

#pragma mark uitableview

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [arrNotifications count];
    
}
- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    return 60.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    if (NONotifications)
    {
        UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
        
        cell.textLabel.textColor = [UIColor lightGrayColor];
        cell.textLabel.text = [arrNotifications objectAtIndex:indexPath.row];
        
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        return cell;
    }
    else
    {
        NotificationTableVuewCell *cell = (NotificationTableVuewCell *)[tableView dequeueReusableCellWithIdentifier:@"aCell"];
        
        
        if(cell == nil)
            cell = [[NotificationTableVuewCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"NotificationTableVuewCell"];
        
        cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
        
        NSDictionary *tempDict = [arrNotifications objectAtIndex:indexPath.row];
        
        cell.NotificationMessage.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"action"]];
        cell.UpdateDate.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"createddate"]];
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"profile_image"]];
        
        NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString:[imageUrl1 stringByReplacingOccurrencesOfString:@" " withString:@"%20"]]];

        __weak NotificationTableVuewCell *weakCell = cell;
        
        [cell.NotificationImage setImageWithURLRequest: urlRequest
                                      placeholderImage: [UIImage imageNamed:@"No_Image@2x"]
                                               success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {
                                                   
                                                   
                                                   NSInteger status = (NSInteger)[(NSHTTPURLResponse *) response statusCode];
                                                   
                                                   __strong NotificationTableVuewCell *strongCell = weakCell;
                                                   strongCell.NotificationImage.image = image;
                                                   [strongCell.activityIndicatorView stopAnimating];
                                                   [strongCell.activityIndicatorView setHidden:YES];
                                                   
                                               }
                                               failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                   
                                                   //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                   
                                                   __strong NotificationTableVuewCell *strongCell = weakCell;
                                                   [strongCell.NotificationImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
                                               }
         
         ];
        
        [cell.activityIndicatorView setHidden:YES];
        [cell.activityIndicatorView stopAnimating];
        
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
        
        return cell;
    }
    
    
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    NSDictionary *tempDict = [arrNotifications objectAtIndex:indexPath.row];
    
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
