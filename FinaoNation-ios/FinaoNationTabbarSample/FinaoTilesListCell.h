//
//  FinaoTilesListCell.h
//  FinaoNationTabbarSample
//
//  Created by FINAO NATION on 5/6/14.
//  Copyright (c) 2014 FINAO NATION. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface FinaoTilesListCell : UITableViewCell
{
    UIImageView* TilesImage;
    UILabel* TileName;
    UIActivityIndicatorView *activityIndicatorView;
    UIButton * TileButton;
}
@property(nonatomic,retain)UIImageView* TilesImage;
@property(nonatomic,retain)UILabel* TileName;
@property(nonatomic,retain)UIButton * TileButton;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

@end

