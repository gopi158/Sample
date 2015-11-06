//
//  PostFinaoListViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "PostFinaoListViewController.h"
#import "AppConstants.h"
#import "CreateFinaoViewController.h"
#import "AssetsLibrary/AssetsLibrary.h"

@interface PostFinaoListViewController ()

@end

@implementation PostFinaoListViewController

dispatch_queue_t FinaoQueue_gcd;

@synthesize UpdateImages_names;
@synthesize UpdateImages_data;
@synthesize UpdateImages_caption;
@synthesize UploadUpdatedTxt;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_NORMAL_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_NORMAL, NSFontAttributeName, nil]
                                                 forState:UIControlStateNormal];
        
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_SELECTED_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_SELECTED, NSFontAttributeName, nil]
                                                 forState:UIControlStateSelected];
        self.title = @"Post ";
        
        
        
        self.tabBarItem.image = [UIImage imageNamed:@"post"];
        self.tabBarItem.title = @"Post";
    }
    return self;
}
-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    
    ALAuthorizationStatus status = [ALAssetsLibrary authorizationStatus];
    if (status != ALAuthorizationStatusAuthorized) {
        [APPDELEGATE showHToast:@"Please turn on access to photos for FINAO app in settings privacy"];
    }
    arrFinaoList = [[NSMutableArray alloc]init];
    [APPDELEGATE showHToastCenter:@"Loading..."];
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.FINAOPROFILEDETAILSlist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self GetFinaoList]; } );
    isTablecellSelected = NO;
}

-(void)NextClicked{
    
    if (isTablecellSelected) {
        PostViewController* PostVC = [[PostViewController alloc]initWithNibName:@"PostViewController" bundle:nil];
        PostVC.FinaoIDStr = FinaoIDStr;
        [self.navigationController pushViewController:PostVC animated:YES];
    }
    else{
        [APPDELEGATE showHToastCenter:@"Please select a FONAO first from the list"];
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"" style:UIBarButtonItemStylePlain target:self action:@selector(NextClicked)];
    [self.navigationItem.rightBarButtonItem setTitleTextAttributes:
     [NSDictionary dictionaryWithObjectsAndKeys:
      [UIColor orangeColor], NSForegroundColorAttributeName,nil]
                                                          forState:UIControlStateNormal];
    
    FinaosTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, self.view.frame.size.height-50) style:UITableViewStylePlain];
    FinaosTable.delegate = self;
    FinaosTable.dataSource = self;
    FinaosTable.tableFooterView = [[UIView alloc]init];
    
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
    
    FinaosTable.tableHeaderView = headerView;
    [self.view addSubview:FinaosTable];
    
    arrFinaoList = [[NSMutableArray alloc]init];
    [APPDELEGATE showHToastCenter:@"Loading..."];
    FinaoQueue_gcd = dispatch_queue_create("com.Finao.FINAOPROFILEDETAILSlist", NULL);
    dispatch_async(FinaoQueue_gcd, ^{ [self GetFinaoList]; } );
}
-(void)GetFinaoList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        Servermanager* webservice = [[Servermanager alloc]init];
        webservice.delegate = self;
        [webservice GetFinaoListFromServer:[USERDEFAULTS valueForKey:@"userid"]];
    });
}

#pragma mark WEBservice delegate
-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            arrFinaoList = [data objectForKey:@"item"];
        }
    [APPDELEGATE hideHUD];
    [FinaosTable reloadData];
}

-(void)CreateFinaoClicked{
    
    CreateFinaoViewController* CreateFinao = [[CreateFinaoViewController alloc]initWithNibName:@"CreateFinaoViewController" bundle:nil];
    CreateFinao.kAdjust = 65;
    [self.navigationController pushViewController:CreateFinao animated:YES];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [arrFinaoList count];
}

-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 44.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    NSDictionary *tempDict = [arrFinaoList objectAtIndex:indexPath.row];
    UITableViewCell* cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
    
    cell.textLabel.minimumScaleFactor = 8.0f;
    cell.textLabel.font = [UIFont systemFontOfSize:15.0f];
    cell.textLabel.textColor = [UIColor lightGrayColor];
    cell.textLabel.text =  [tempDict objectForKey:@"finao_msg"];
    
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSDictionary *tempDict = [arrFinaoList objectAtIndex:indexPath.row];
    
    UITableViewCell* newCell = [tableView cellForRowAtIndexPath:indexPath];
    int newRow = (int)[indexPath row];
    int oldRow = (int)(lastIndexPath != nil) ? (int)[lastIndexPath row] : -1;
    
    if(newRow != oldRow)
    {
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
        UITableViewCell* oldCell = [tableView cellForRowAtIndexPath:lastIndexPath];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        lastIndexPath = indexPath;
        isTablecellSelected = YES;
    }else if(newRow == oldRow){
        newCell.accessoryType = UITableViewCellAccessoryNone;
        UITableViewCell* oldCell = [tableView cellForRowAtIndexPath:lastIndexPath];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        lastIndexPath = 0;
        isTablecellSelected = NO;
        
    }
    if (isTablecellSelected) {
        FinaoIDStr = [tempDict objectForKey:@"finao_id"];
    }
    [self NextClicked];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
