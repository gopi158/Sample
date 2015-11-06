//
//  SearchViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SearchViewController.h"
#import "AppConstants.h"
#import "SearchCell.h"
#import "UIImageView+AFNetworking.h"
#import "SearchDetailNewViewController.h"
#import "QREncodeViewController.h"
#import "FinaoQRScanViewController.h"

dispatch_queue_t SearchQueue_gcd;


@interface SearchViewController ()
@property (nonatomic, retain) QREncodeViewController * qrEncodeViewController ;
@property (nonatomic, retain) FinaoQRScanViewController * qrScanViewController ;
@property int segmentedIndexSaved;
@property CGRect frameForContentController;
@property (nonatomic, retain) UISegmentedControl *segmentedControl;
@property (nonatomic, retain) UIViewController * currentViewController;
@end

@implementation SearchViewController


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_NORMAL_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_NORMAL, NSFontAttributeName, nil]
                                                 forState:UIControlStateNormal];
        
        [[UITabBarItem appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                           TABBAR_SELECTED_TEXTCOLOR, NSForegroundColorAttributeName,
                                                           TABBAR_TEXT_FONT_SIZE_SELECTED, NSFontAttributeName, nil]
                                                 forState:UIControlStateSelected];
        self.title = @"Search";
        
        self.tabBarItem.image = [UIImage imageNamed:@"search"];
    }
    return self;
}

#pragma mark Screen Resolution
- (CGFloat) window_height   {
    return [UIScreen mainScreen].applicationFrame.size.height;
}

- (CGFloat) window_width   {
    return [UIScreen mainScreen].applicationFrame.size.width;
}

#pragma mark Life Cycle
- (void)viewDidLoad
{
    [super viewDidLoad];
    [APPDELEGATE setCurrentNav:self.navigationController];
    if(self.url == nil){
        self.url = @"http://www.finaonation.com";
    }
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
        
    }
    
    isSlidable = YES;
    
    if ([[[UIDevice currentDevice]systemVersion] floatValue] >= 7 ) {
        self.navigationController.navigationBar.translucent = NO;
        
    }
    
    self.navigationController.navigationBar.barTintColor = [UIColor lightGrayColor];
    
    if( isiPhone5){
        SearchTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 45, 320, 440) style:UITableViewStylePlain];
    }
    else{
        SearchTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 45, 320, 330) style:UITableViewStylePlain];
        
    }
    
    
    SearchTable.delegate = self;
    SearchTable.dataSource = self;
    [self.view addSubview:SearchTable];
    [self.view bringSubviewToFront:SearchTable];
    SearchTable.hidden = YES;
    
    //Add the search bar
    sBar = [[UISearchBar alloc]initWithFrame:CGRectMake(0, 0, 320, 44)];
    sBar.barStyle = UIBarStyleDefault;
    [sBar setBackgroundColor:[UIColor lightGrayColor]];
    for (UIView *searchBarSubview in [sBar subviews]) {
        if ([searchBarSubview conformsToProtocol:@protocol(UITextInputTraits)]) {
            @try {
                [(UITextField *)searchBarSubview setBackgroundColor:[UIColor whiteColor]];
                [(UITextField *)searchBarSubview setBorderStyle:UITextBorderStyleRoundedRect];
            }
            @catch (NSException * e) {
                // ignore exception
            }
        }
    }
    sBar.autocorrectionType = UITextAutocorrectionTypeNo;
    sBar.autocapitalizationType = UITextAutocapitalizationTypeNone;
    
    sBar.placeholder = @"Search for people, tiles, or FINAOs";
    sBar.delegate = self;
    
    [self.view addSubview:sBar];
    sBar.tintColor = [UIColor clearColor];
    
    UIView *divider1 = [[UIView alloc]initWithFrame:CGRectMake(0, 42, [[UIScreen mainScreen]bounds].size.width, 1)];
    divider1.backgroundColor = [UIColor lightGrayColor];
    
    [self.view addSubview:divider1];
    
    
    UIView *divider2 = [[UIView alloc]initWithFrame:CGRectMake(0, 88, [[UIScreen mainScreen]bounds].size.width, 1)];
    divider2.backgroundColor = [UIColor lightGrayColor];
    
    [self.view addSubview:divider2];

    

    if ([[[UIDevice currentDevice] systemVersion] floatValue] >= 7.0)
    {
        NSArray *searchBarSubViews = [[sBar.subviews objectAtIndex:0] subviews];
        
        for (id img in searchBarSubViews)
        {
            if ([img isKindOfClass:NSClassFromString(@"UISearchBarBackground")])
            {
                [img removeFromSuperview];
            }
        }
    }
    else
    {
        [[sBar.subviews objectAtIndex:0] removeFromSuperview];
    }
    
    SearchTable.tableFooterView = [[UIView alloc]init];
    
    SearchTxtStr = [[NSString alloc]init];
    //Create the segmented control
    NSArray *itemArray = [NSArray arrayWithObjects: @"Share QR", @"Scan QR", nil];
    self.segmentedControl = [[UISegmentedControl alloc] initWithItems:itemArray];
    self.segmentedControl.frame = CGRectMake(self.view.bounds.origin.x + 10, self.view.bounds.origin.y + 50, self.view.bounds.size.width - 20, 30);;

    self.segmentedControl.selectedSegmentIndex = 0;
    [self.segmentedControl addTarget:self
                              action:@selector(pickOne:)
                    forControlEvents:UIControlEventValueChanged];
	[self.view addSubview:self.segmentedControl];

    
    [[UISegmentedControl appearance] setTintColor:[UIColor orangeColor]];
    [[UISegmentedControl appearance] setTitleTextAttributes:@{NSForegroundColorAttributeName:[UIColor orangeColor]} forState:UIControlStateNormal];
    
    
}


-(void)viewDidDisappear:(BOOL)animated{

    [super viewDidDisappear:animated];

    [webservice cancelAllRequest];
    
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    SearchTable.hidden = YES;
    
    self.frameForContentController = CGRectMake(self.view.bounds.origin.x, self.view.bounds.origin.y + 100, self.view.bounds.size.width, self.view.bounds.size.height -100);
    
    [self displayQRGenContentController];

    self.segmentedControl.selectedSegmentIndex = 0;
    
    self.segmentedIndexSaved = 0;
    
}


#pragma mark Segmented control
- (void)transitionWithDelay {
    
    self.qrEncodeViewController = [[QREncodeViewController alloc] initWithNibName:@"QREncodeViewController" bundle:nil];
    
    self.qrEncodeViewController.view.frame = self.frameForContentController;
    
    self.qrEncodeViewController.encodeURL = self.url;
    
    //NSLog(@"self.url = %@",self.url);
    
    [self addChildViewController:self.qrEncodeViewController];
    
    [self transitionFromViewController:self.currentViewController toViewController:self.qrEncodeViewController duration:0.25 options:UIViewAnimationOptionTransitionFlipFromRight animations:^{
        [self.currentViewController.view removeFromSuperview];
        [self.view addSubview:self.qrEncodeViewController.view];
    } completion:^(BOOL finished) {
        [self.currentViewController removeFromParentViewController];
        self.currentViewController = self.qrEncodeViewController;
    }];
}

-(void) pickOne:(id)sender{
    
    UISegmentedControl *segmentedControl = (UISegmentedControl *)sender;
    int index =  (int)[segmentedControl selectedSegmentIndex];
    if(self.segmentedIndexSaved == 0 && index == 0){
        self.segmentedIndexSaved  = 0;
        return;
    }
    else if(self.segmentedIndexSaved == 1 && index == 1){
        self.segmentedIndexSaved  = 1;
        return;
    }
    else if(self.segmentedIndexSaved == 0 && index == 1){
        self.segmentedIndexSaved  = 1;
        self.qrScanViewController = [[FinaoQRScanViewController alloc]init];
        
        self.qrScanViewController.view.frame = self.frameForContentController;
        [self addChildViewController:self.qrScanViewController];
        
        [self transitionFromViewController:self.currentViewController toViewController:self.qrScanViewController duration:0.25 options:UIViewAnimationOptionTransitionFlipFromLeft animations:^{
            [self.qrEncodeViewController.view removeFromSuperview];
            [self.view addSubview:self.qrScanViewController.view];
        } completion:^(BOOL finished) {
            [self.qrScanViewController didMoveToParentViewController:self];
            [self.currentViewController removeFromParentViewController];
            self.currentViewController = self.qrScanViewController;
        }];
        return;
    }
    else if(self.segmentedIndexSaved == 1 && index == 0){
        self.segmentedIndexSaved  = 0;
        [self performSelector:@selector(transitionWithDelay) withObject:nil afterDelay:1];
        return;
    }

}

- (void) displayQRGenContentController
{
    //QR Generation
    self.qrEncodeViewController = [[QREncodeViewController alloc] initWithNibName:@"QREncodeViewController" bundle:nil];
    self.qrEncodeViewController.encodeURL = self.url;
    [self addChildViewController:self.qrEncodeViewController];
    self.qrEncodeViewController.view.frame = self.frameForContentController;
    [self.view addSubview:self.qrEncodeViewController.view];
    [self.qrEncodeViewController didMoveToParentViewController:self];
    self.currentViewController = self.qrEncodeViewController;
}

- (void) displayQRScanController
{
    // QR Scan
    self.qrScanViewController = [[FinaoQRScanViewController alloc]init];
    [self addChildViewController:self.qrScanViewController];
    self.qrScanViewController.view.frame = self.frameForContentController;
    [self.view addSubview:self.qrScanViewController.view];
    [self.qrScanViewController didMoveToParentViewController:self];
}

- (void) displayContentController: (UIViewController*) content;
{
    [self addChildViewController:content];
    content.view.frame = self.frameForContentController;
    [self.view addSubview:content.view];
    [content didMoveToParentViewController:self];
}

- (void) hideContentController: (UIViewController*) content 
{
    [content.view removeFromSuperview];
    [content removeFromParentViewController];
    content = nil;
}


#pragma mark UISEARCHBAR DELEGATE START

- (void)searchBarTextDidEndEditing:(UISearchBar *)searchBar {
    [sBar resignFirstResponder];
    SearchTable.hidden = YES;
    [self.view endEditing:YES];
    [webservice cancelAllRequest];
}


- (void)searchBarCancelButtonClicked:(UISearchBar *) searchBar{
    

    [searchBar resignFirstResponder];
    SearchTable.hidden = YES;
    [self.view endEditing:YES];
    [webservice cancelAllRequest];

}
- (void)searchBar:(UISearchBar *)searchBar textDidChange:(NSString *)searchText
{
    
    //NSLog(@"SEARCH TEXT:%@",searchText);
    SearchTxtStr = searchText;
    
    if ([searchText length]>0) {
        SearchQueue_gcd = dispatch_queue_create("com.Finao.Searchlist", NULL);
        dispatch_async(SearchQueue_gcd, ^{ [self GetSearchResult]; } );
        SearchTable.hidden = NO;
        [self.view bringSubviewToFront:SearchTable];

    }
    
    if ([searchText length] == 0) {

        SearchTable.hidden = YES;
        [self.view endEditing:YES];
        [sBar resignFirstResponder];
        [webservice cancelAllRequest];

    }
}
- (void)searchBarSearchButtonClicked:(UISearchBar *)searchBar
{
    [searchBar resignFirstResponder];
    // Do the search...
    [webservice cancelAllRequest];
    if ([searchBar.text length]>0) {
        [APPDELEGATE showHToastCenter:@"Searching..."];
        SearchTable.hidden = NO;
        [self.view bringSubviewToFront:SearchTable];
        SearchQueue_gcd = dispatch_queue_create("com.Finao.Searchlist", NULL);
        dispatch_async(SearchQueue_gcd, ^{ [self GetSearchResult]; } );
    }

}


#pragma mark UISEARCHBAR DELEGATE END

-(void)GetSearchResult{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        webservice = [[Servermanager alloc]init];
        webservice.delegate = self;
        //NSLog(@"SearchTxtStr:%@",SearchTxtStr);
        [webservice cancelAllRequest];
        [webservice GetSearchList:SearchTxtStr];
    });
}
#pragma mark WebDelegate Start

-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    
    SearchArrayList = [[NSMutableArray alloc]init];

    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");

        NOSEARCHITEMS = YES;
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");

            NOSEARCHITEMS = NO;

            SearchArrayList = [data objectForKey:@"item"];
            //NSLog(@"SearchArrayList:%@",SearchArrayList);
        }
    
    [SearchTable reloadData];
    [APPDELEGATE hideHUD];
    
}

-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
#ifdef DEBUG
    //NSLog(@"StatusCode at register : %ld",(long)statusCode);
#endif
    
    [APPDELEGATE hideHUD];
}


-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    SearchCell *cell = (SearchCell *)[tableView dequeueReusableCellWithIdentifier:@"SearchCell"];
    
    if(cell == nil)
        cell = [[SearchCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"SearchCell"];
    
    NSDictionary *tempDict = [SearchArrayList objectAtIndex:indexPath.row];
    
    if (NOSEARCHITEMS) {

    }
    else{
         //NSLog(@"tempDict:%@",tempDict);
        cell.SearchName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"name"]];
        if ([tempDict objectForKey:@"image"] == nil || [tempDict objectForKey:@"image"] == NULL || [tempDict objectForKey:@"image"]  == [NSNull null]) {
            cell.SearchImageview.image  = [UIImage imageNamed:@"No_Image@2x"];
        }
        else{
            NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
            [cell.SearchImageview setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"profile"]];
        }
        cell.SearchName.font = [UIFont systemFontOfSize:20.0f];
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    return cell;
}

-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 60.0f;
}
-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [SearchArrayList count];
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    
    NSDictionary *tempDict = [SearchArrayList objectAtIndex:indexPath.row];
    
    //NSLog(@"temp DICT : %@",tempDict);
    
    if(!NOSEARCHITEMS){
    SearchDetailNewViewController* searchDetails = [[SearchDetailNewViewController alloc]initWithNibName:@"SearchDetailNewViewController" bundle:nil];
    [self.navigationController pushViewController:searchDetails animated:YES];
    
    searchDetails.Firstname = [tempDict objectForKey:@"name"];
    searchDetails.Lastname = [tempDict objectForKey:@""];
    searchDetails.StoryText = [tempDict objectForKey:@"mystory"];
    NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"image"]];
    searchDetails.imageUrlStr = imageUrl1;
    searchDetails.pssedDict = tempDict;
    searchDetails.NumofFinaos = [tempDict objectForKey:@"totalfinaos"];
    searchDetails.NumofTiles = [tempDict objectForKey:@"totaltiles"];
    searchDetails.NumofFollowing = [tempDict objectForKey:@"totalfollowings"];
    searchDetails.SearchusrID = [tempDict objectForKey:@"resultid"];
    
    [tableView deselectRowAtIndexPath:indexPath animated:NO];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end