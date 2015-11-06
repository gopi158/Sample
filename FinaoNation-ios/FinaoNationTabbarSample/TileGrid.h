//
//  TileGrid.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 05/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TileGrid : UICollectionViewCell
{
//    UIImageView* TileImage;
    UILabel* TileName;
}
@property(nonatomic,retain)UILabel* TileName;
//@property(nonatomic,strong)UIImageView* TileImage;

//- (void)setTileImage:(NSString*)URL;
@end
