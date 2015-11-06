//
//  TilesDetailViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 11/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TilesDetailViewController.h"
#import "TileDetailCell.h"
#import "AppConstants.h"
//#import "ProfileFinaoDetailViewController.h"
#import "ProfileDetailViewController.h"
#import "UIImageView+AFNetworking.h"

dispatch_queue_t TileQueue_gcd;

@interface TilesDetailViewController ()

@end

@implementation TilesDetailViewController

@synthesize Friendsname;
@synthesize FriendsImageURL;
@synthesize SelfUser;
@synthesize TileIDStr,PassesUsrid;
@synthesize WebStringExtra;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        UIImage *image = [UIImage imageNamed:@"logoheader.png"];
        self.navigationItem.titleView = [[UIImageView alloc] initWithImage:image];
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];

    arrTileLIST = [[NSMutableArray alloc]init];
    
    [APPDELEGATE showHToastCenter:@"Loading..."];
    
    
    TileQueue_gcd = dispatch_queue_create("com.Finao.TILEDETAILSlist", NULL);
    dispatch_async(TileQueue_gcd, ^{ [self GetTileDetails]; } );
    
    TileDetailTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 320) style:UITableViewStylePlain];
    TileDetailTable.delegate = self;
    TileDetailTable.dataSource = self;
    [self.view addSubview:TileDetailTable];

    TileDetailTable.tableFooterView = [[UIView alloc]init];
}

-(void)GetTileDetails{

    //NSLog(@"TileIDStr:%@",TileIDStr);
    //NSLog(@"PassesUsrid:%@",PassesUsrid);
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Servermanager* webservice = [[Servermanager alloc]init];
        webservice.delegate = self;
        if (WebStringExtra == nil) {
            WebStringExtra = @"";
        }
        
        [webservice GetFinaosForTile:TileIDStr UID:PassesUsrid ExtraString:WebStringExtra];
    });
}

#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
#ifdef DEBUG
        //NSLog(@"Tiles details : %@ ",data);
#endif
    [APPDELEGATE hideHUD];
    
   
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            arrTileLIST = [data objectForKey:@"item"];
        }
    
    [TileDetailTable reloadData];
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];

}

#pragma mark Tableview Start

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 80.0f;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    // Return the number of rows in the section.
    return [arrTileLIST count];
    
}


// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    
    NSDictionary *tempDict = [arrTileLIST objectAtIndex:indexPath.row];
    
    TileDetailCell *cell = (TileDetailCell *)[tableView dequeueReusableCellWithIdentifier:@"TileDetailCell"];
    if(cell == nil)
        cell = [[TileDetailCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"TileDetailCell"];
    
    //NSLog(@"TempDict : %@",tempDict);
    
    cell.TileDetailName.text = [tempDict objectForKey:@"finao_msg"];

    NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"finao_image"]];
    [cell.TileDetailImageview setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"logo_finao"]];
    
    if ([[tempDict objectForKey:@"finao_status_Ispublic"] integerValue] == 1) {
        cell.TileDetailPri_pub.text = @"Public";
    }
    else{
        cell.TileDetailPri_pub.text = @"Private";
    }
    
    if ([[tempDict objectForKey:@"finao_status"] integerValue] == 38
        || [[tempDict objectForKey:@"finao_status"] integerValue] == 0) {
        cell.TileDetailStatus.text = @"Ontrack";
        cell.TileDetailStatus.backgroundColor = [UIColor lightGrayColor];
    }
    else
        if([[tempDict objectForKey:@"finao_status"] integerValue] == 39
           || [[tempDict objectForKey:@"finao_status"] integerValue] == 1){
            cell.TileDetailStatus.text = @"Ahead";
            cell.TileDetailStatus.backgroundColor = [UIColor colorWithRed:0.0f/255.0f green:155.0f/255.0f blue:0.0f/255.0f alpha:1.0f];
        }
        else if([[tempDict objectForKey:@"finao_status"] integerValue] == 40
                || [[tempDict objectForKey:@"finao_status"] integerValue] == 2){
            cell.TileDetailStatus.text = @"Behind";
            cell.TileDetailStatus.backgroundColor = [UIColor redColor];
            
        }
        else if([[tempDict objectForKey:@"finao_status"] integerValue] == 41
                || [[tempDict objectForKey:@"finao_status"] integerValue] == 4){
            cell.TileDetailStatus.text = @"Complete";
            cell.TileDetailStatus.backgroundColor = [UIColor greenColor];
            
        }
    
    // convert to date
    NSDateFormatter *dateFormat = [[NSDateFormatter alloc] init];
    // ignore +11 and use timezone name instead of seconds from gmt
    [dateFormat setDateFormat:@"YYYY-MM-dd HH:mm:ss"];
    //        [dateFormat setTimeZone:[NSTimeZone timeZoneWithName:@"Australia/Melbourne"]];
    NSDate *dte = [dateFormat dateFromString:[tempDict objectForKey:@"createddate"]];
    //        //NSLog(@"Date: %@", dte);
    
    // back to string
    NSDateFormatter *dateFormat2 = [[NSDateFormatter alloc] init];
    [dateFormat2 setDateFormat:@"dd MMM"];
    //        [dateFormat2 setTimeZone:[NSTimeZone timeZoneWithName:@"Australia/Melbourne"]];
    NSString *dateString = [dateFormat2 stringFromDate:dte];
    //        //NSLog(@"DateString: %@", dateString); // return for the Updated date
    
    cell.TileDetailDate.text = dateString;
    
    cell.selectionStyle = UITableViewCellSelectionStyleNone;
    
    
    return cell;
}


-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    NSDictionary *tempDict = [arrTileLIST objectAtIndex:indexPath.row];
    ProfileDetailViewController* profileDetail = [[ProfileDetailViewController alloc]initWithNibName:@"ProfileDetailViewController" bundle:nil];
    [self.navigationController pushViewController:profileDetail animated:YES];
    //NSLog(@"finao_title:%@",[tempDict objectForKey:@"finao_msg"]);//finao_msg
    profileDetail.finao_id = [tempDict objectForKey:@"finao_id"];
    profileDetail.Finao_title = [tempDict objectForKey:@"finao_msg"];//finao_msg
    
    if ([[tempDict objectForKey:@"finao_status_ispublic"] integerValue] == 1) {
        profileDetail.isPublicstr = @"Public";
    }else{
        profileDetail.isPublicstr = @"Private";
    }
    
    if (SelfUser) {
        profileDetail.SelfUser = YES;
    }
    else{
        profileDetail.SelfUser = NO;
    }
    profileDetail.SearchusrID = PassesUsrid;
    profileDetail.FriendName = Friendsname;
    profileDetail.FriendimageURL = FriendsImageURL;
    
    if ([[tempDict objectForKey:@"finao_status_Ispublic"] integerValue]) {
        profileDetail.isPublicstr = @"Public";
    }else{
        profileDetail.isPublicstr = @"Private";
    }
    profileDetail.Finao_status = [tempDict objectForKey:@"finao_status_Ispublic"];
    profileDetail.Finao_title = [tempDict objectForKey:@"finao_msg"];
    
    
}
#pragma mark Tableview END


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
