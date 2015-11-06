    //
//  TilesViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 03/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TilesViewController.h"
#import "TileGrid.h"
#import "UIImageView+AFNetworking.h"
#import "TilesDetailViewController.h"

@interface TilesViewController ()

@end

@implementation TilesViewController

@synthesize Userid;
@synthesize SelfUser;
@synthesize imageurl;
@synthesize FriendusrName;

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
    // Do any additional setup after loading the view, typically from a nib
    [self getTilesList];
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
}

-(void)getTilesList{
    
    dispatch_async(dispatch_get_main_queue(), ^ {
        if (SelfUser) {
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotTiLesListinDictionary:)
                                                         name:@"GETTILESLIST"
                                                       object:nil];
            gettiles = [[GetTiles alloc]init];
            [gettiles GetTilesListFromServer];
        }
        else
        {
            [[NSNotificationCenter defaultCenter] addObserver:self
                                                     selector:@selector(GotTiLesListinDictionary:)
                                                         name:@"GETSEARCHTILESLIST"
                                                       object:nil];
            
            GetTilesListProfile = [[GetTilesForSearch alloc]init];
            [GetTilesListProfile GetSearchTilesListFromServer:Userid];
        }
    } );
}

-(void)GotTiLesListinDictionary:(NSNotification *) notification
{
    if (SelfUser) {
        arrTiles = gettiles.TilesListDic;
    }else{
        arrTiles = GetTilesListProfile.TilesListDic;
    }
    
    //NSLog(@"arrTiles:%@",arrTiles);
    
    if (SelfUser) {
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETTILESLIST" object:nil];
    }else{
        [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETSEARCHTILESLIST" object:nil];
    }
    if ([arrTiles count] == 0) {
        [arrTiles addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOTiles = TRUE;
    }
    if ([arrTiles count] > 0){
        UICollectionViewFlowLayout *layout=[[UICollectionViewFlowLayout alloc] init];
        
        if (isiPhone5) {
            _collectionView=[[UICollectionView alloc] initWithFrame:CGRectMake(20, 20, 280, 430) collectionViewLayout:layout];
            
        }
        else{
            _collectionView=[[UICollectionView alloc] initWithFrame:CGRectMake(20, 20, 280, 330) collectionViewLayout:layout];
        }
        
        [_collectionView setDataSource:self];
        [_collectionView setDelegate:self];
        
        [_collectionView registerClass:[UICollectionViewCell class] forCellWithReuseIdentifier:@"cellIdentifier"];
        [_collectionView setBackgroundColor:[UIColor whiteColor]];
        
        [self.view addSubview:_collectionView];
    }
}

- (NSInteger)collectionView:(UICollectionView *)collectionView numberOfItemsInSection:(NSInteger)section
{
    return [arrTiles count];
}

// The cell that is returned must be retrieved from a call to -dequeueReusableCellWithReuseIdentifier:forIndexPath:
- (UICollectionViewCell *)collectionView:(UICollectionView *)collectionView cellForItemAtIndexPath:(NSIndexPath *)indexPath
{
    UICollectionViewCell *cell=[collectionView dequeueReusableCellWithReuseIdentifier:@"cellIdentifier" forIndexPath:indexPath];
    
    NSDictionary *tempDict = [arrTiles objectAtIndex:indexPath.row];
    if (NOTiles) {
        UIImageView *TileImageView = [[UIImageView alloc] init];
        TileImageView.frame = cell.contentView.bounds;
        [cell.contentView addSubview:TileImageView];
        
        TileImageView.backgroundColor = [UIColor lightGrayColor];
        
        UILabel* Lbl = [[UILabel alloc]init];
        Lbl.frame = CGRectMake(0, 35, 35, 25);
        Lbl.backgroundColor = [UIColor blackColor];
        Lbl.opaque = NO;
        Lbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:9.0];
        Lbl.textColor = [UIColor whiteColor];
        Lbl.textAlignment = NSTextAlignmentCenter;
        [cell.contentView addSubview:Lbl];
        Lbl.text = [arrTiles objectAtIndex:indexPath.row];
    }else{
        UIImageView *TileImageView = [[UIImageView alloc] init];
        TileImageView.frame = cell.contentView.bounds;
        [cell.contentView addSubview:TileImageView];
        TileImageView.tag = 100;
        
        NSString* imagetile = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"tile_image"]];
        [TileImageView setImageWithURL:[NSURL URLWithString:imagetile] placeholderImage:[UIImage imageNamed:@"logo_finao"]];
        
        cell.backgroundColor=[UIColor lightGrayColor];
        
        
        //Add uilabel
        
        UILabel* Lbl = [[UILabel alloc]init];
        Lbl.frame = CGRectMake(0, 30, 35, 10);
        Lbl.backgroundColor = [UIColor blackColor];
        Lbl.opaque = NO;
        Lbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:5.0];
        Lbl.textColor = [UIColor whiteColor];
        Lbl.textAlignment = NSTextAlignmentCenter;
        [cell.contentView addSubview:Lbl];
        
        Lbl.text = [tempDict objectForKey:@"tile_name"];
    }
    return cell;
}

- (CGSize)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout*)collectionViewLayout sizeForItemAtIndexPath:(NSIndexPath *)indexPath
{
    return CGSizeMake(35, 35);
}


-(void)collectionView:(UICollectionView *)collectionView didSelectItemAtIndexPath:(NSIndexPath *)indexPath{
    
    //NSLog(@"arrTilesList:%@",arrTiles);
    
    NSDictionary *tempDict = [arrTiles objectAtIndex:indexPath.row];
    
    //NSLog(@"Temp:%@",tempDict);
    
    TilesDetailViewController* tileDetail = [[TilesDetailViewController alloc]initWithNibName:@"TilesDetailViewController" bundle:nil];
    tileDetail.TileIDStr = [tempDict objectForKey:@"tile_id"];
    tileDetail.FriendsImageURL = [USERDEFAULTS valueForKey:@"profile_image"];
    
    tileDetail.SelfUser = SelfUser;
    
    if (SelfUser) {
        tileDetail.PassesUsrid = [USERDEFAULTS valueForKey:@"userid"];
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@%@",@"",[USERDEFAULTS valueForKey:@"profile_image"]];
        //NSLog(@"imageUrl1:%@",imageUrl1);
        tileDetail.FriendsImageURL = imageUrl1;
        tileDetail.Friendsname = [NSString stringWithFormat:@"%@ %@",[USERDEFAULTS valueForKey:@"name"],[USERDEFAULTS valueForKey:@""]];
    }else{
        tileDetail.PassesUsrid = Userid;
        NSString* imageUrl1 = [NSString stringWithFormat:@"%@",imageurl];
        //NSLog(@"imageUrl1:%@",imageUrl1);
        tileDetail.FriendsImageURL = imageUrl1;
        tileDetail.Friendsname = FriendusrName;
    }
    [self.navigationController pushViewController:tileDetail animated:YES];
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
