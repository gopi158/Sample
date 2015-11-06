//
//  FinaoTilesCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface FinaoTilesCell : UITableViewCell{

    UIImageView* TileImage;
    UILabel* TileCaption;
}
@property(nonatomic,retain)UIImageView* TileImage;
@property(nonatomic,retain)UILabel* TileCaption;

@end
