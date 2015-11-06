//
//  TilesListTableViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//
//


#import "TilesListTableViewController.h"

@interface TilesListTableViewController ()
@end

@implementation TilesListTableViewController
@synthesize Userid;

bool tableAdded;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Tiles";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    tableAdded = NO;
    [self getTilesList];
}

// getTilesList
-(void)getTilesList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        GetPublicTilesUserIdParam = [[GetPublicTilesUserId alloc]init];
        [GetPublicTilesUserIdParam GetPublicTilesUserId:Userid];
    } );
}

//FollowAllTiles
-(void)FollowAllTiles{
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(ReturnFollowAllTiles:)
                                                 name:@"FOLLOWUSERALLTILE"
                                               object:nil];
    dispatch_async(dispatch_get_main_queue(), ^ {
        FollowAllTilesUserId *Param = [[FollowAllTilesUserId alloc]init];
        [Param FollowAllTilesUserId:Userid];
    } );
}

-(void)ReturnFollowAllTiles:(NSNotification *) notification
{
}

//UnFollowAllTiles
-(void)UnFollowAllTiles:(NSString *) tileId
{
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(ReturnUnFollowAllTiles:)
                                                 name:@"FOLLOWUSERALLTILE"
                                               object:nil];
    dispatch_async(dispatch_get_main_queue(), ^ {
        UnFollowAllTilesForUserId *Param = [[UnFollowAllTilesForUserId alloc]init];
        [Param UnFollowAllTilesUserId:Userid withTileId:tileId];
    } );
}


-(void)ReturnUnFollowAllTiles:(NSNotification *) notification
{
}
// Unfollow specific tile

-(void)UnFollowSpecificTiles:(NSString *) tileId
{
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(ReturnUnFollowSpecificTiles:)
                                                 name:@"FOLLOWUSERALLTILE"
                                               object:nil];
    dispatch_async(dispatch_get_main_queue(), ^ {
        UnFollowAllTilesForUserId *Param = [[UnFollowAllTilesForUserId alloc]init];
        [Param UnFollowAllTilesUserId:Userid withTileId:tileId];
    } );
}

-(void)ReturnUnFollowSpecificTiles:(NSNotification *) notification
{
}

// follow specific tile

-(void)FollowSpecificTiles:(NSString *) tileId
{
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(ReturnFollowSpecificTiles:)
                                                 name:@"FOLLOWUSERALLTILE"
                                               object:nil];
    dispatch_async(dispatch_get_main_queue(), ^ {
        UnFollowAllTilesForUserId *Param = [[UnFollowAllTilesForUserId alloc]init];
        [Param UnFollowAllTilesUserId:Userid withTileId:tileId];
    } );
}

-(void)ReturnFollowSpecificTiles:(NSNotification *) notification
{
}

#pragma View lifecycle
-(void)viewWillDisappear:(BOOL)animated
{
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:@"GETPUBLICTILESUSERID"
                                                  object:nil];
    [super viewWillDisappear:animated];
}
-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GotTilessListinDictionary:)
                                                 name:@"GETPUBLICTILESUSERID"
                                               object:nil];
}

- (void)addTaleList
{
    if(tableAdded == YES){
        [TilesListTableview reloadData];
        return;
    }
    if (isiPhone5) {
        TilesListTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 450) style:UITableViewStylePlain];
    }
    else{
        TilesListTableview = [[UITableView alloc]initWithFrame:CGRectMake(0, 0, 320, 375) style:UITableViewStylePlain];
        
    }
    TilesListTableview.delegate = self;
    TilesListTableview.dataSource = self;
    [self.view addSubview:TilesListTableview];
    TilesListTableview.tableFooterView = [[UIView alloc]init];
}

-(void)GotTilessListinDictionary:(NSNotification *) notification
{
    arrayTiles = [[NSMutableArray alloc] init];
    NSMutableDictionary *firstRow = [[NSMutableDictionary alloc] initWithCapacity:1];
    [firstRow setValue:@"All Tiles" forKey:@"tile_name"];
    [firstRow setValue:@"1" forKey:@"status"];
    [firstRow setValue:@"0" forKey:@"tile_id"];
    [firstRow setValue:@"" forKey:@"tile_image"];
    [firstRow setValue:@"1" forKey:@"status"];
    [firstRow setValue:@"1" forKey:@"type"];
    [arrayTiles addObject:firstRow];
    [arrayTiles addObjectsFromArray: GetPublicTilesUserIdParam.PublicTilesForUserId];
    
    if (![arrayTiles count]) {
        [arrayTiles addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOFOLLOWERS = TRUE;
    }
    [self addTaleList];
    
}


#pragma mark UItableview

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [arrayTiles count];
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 50.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    if (NOFOLLOWERS) {
        UITableViewCell *cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:nil];
        
        cell.textLabel.textColor = [UIColor lightGrayColor];
        //NSLog(@"arrayTiles:%@", arrayTiles);
        cell.textLabel.text = [arrayTiles objectAtIndex:indexPath.row];
        return cell;
    }
    else{
        FinaoTilesListCell *cell = (FinaoTilesListCell *)[tableView dequeueReusableCellWithIdentifier:@"FinaoTilesListCell"];
        if(cell == nil)
            cell = [[FinaoTilesListCell alloc] initWithStyle:UITableViewCellStyleValue1 reuseIdentifier:@"FinaoTilesListCell"];
        NSDictionary *tempDict = [arrayTiles objectAtIndex:indexPath.row];
        //NSLog(@"tempDict:%@",tempDict);
        cell.TileName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"tile_name"]];
        
        if ([[tempDict objectForKey:@"type"] integerValue] == 1) {
            cell.TileButton.backgroundColor = [UIColor blueColor];
            [cell.TileButton setTitle:@"Follow" forState:UIControlStateNormal];
        }
        else  if ([[tempDict objectForKey:@"type"] integerValue] == 0) {
            cell.TileButton.backgroundColor = [UIColor orangeColor];
            [cell.TileButton setTitle:@"Following" forState:UIControlStateNormal];
            
        }
        
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"tile_image"]];
        if ([tempDict objectForKey:@"tile_image"] == nil) {
            [cell.TilesImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
        }
        else{
            NSURLRequest *urlRequest = [NSURLRequest requestWithURL: [NSURL URLWithString:[imageUrl1 stringByReplacingOccurrencesOfString:@" " withString:@"%20"]]];
            __weak FinaoTilesListCell *weakCell = cell;
            
            [cell.TilesImage setImageWithURLRequest: urlRequest
                                   placeholderImage: [UIImage imageNamed:@"logo_finao"]
                                            success: ^(NSURLRequest *request, NSHTTPURLResponse *response, UIImage *image) {

                                                __strong FinaoTilesListCell *strongCell = weakCell;
                                                strongCell.TilesImage.image = image;
                                                [strongCell.activityIndicatorView stopAnimating];
                                                [strongCell.activityIndicatorView setHidden:YES];
                                                
                                            }
                                            failure:^(NSURLRequest *request, NSHTTPURLResponse *response, NSError *error){
                                                
                                                //NSLog(@"ERROR WHILE IMAGE IS DOWNLOADING : %@",error);
                                                
                                                __strong FinaoTilesListCell *strongCell = weakCell;
                                                [strongCell.TilesImage setImage:[UIImage imageNamed:@"No_Image@2x"]];
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
    
    NSDictionary *tempDict = [arrayTiles objectAtIndex:indexPath.row];
    NSLog(@"temp DICT : %@",tempDict);
    [self getTilesList];
}


#pragma mark uitableview end
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
