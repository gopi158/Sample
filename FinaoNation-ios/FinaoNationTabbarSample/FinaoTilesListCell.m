//
//  FinaoTilesListCell.m
//  FinaoNationTabbarSample
//
//
//  Created by FinaoNation on 005/06/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoTilesListCell.h"

@implementation FinaoTilesListCell
@synthesize TilesImage;
@synthesize TileName;
@synthesize activityIndicatorView;
@synthesize TileButton;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        
        TilesImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 5, 40, 40)];
        [self.contentView addSubview:TilesImage];
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.center =self.TilesImage.center;
        //[self.contentView addSubview:activityIndicatorView];
        
        TileName = [[UILabel alloc] initWithFrame:CGRectMake(70, 10, 160, 27)];
        TileName.textColor = [UIColor orangeColor];
        TileName.textAlignment = NSTextAlignmentLeft;
        TileName.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:20.0];
        TileName.minimumScaleFactor = 5.0f/[UIFont labelFontSize];
        TileName.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:TileName];
        
        TileButton = [[UIButton alloc] initWithFrame:CGRectMake(215, 15, 70, 25)];
        TileButton.backgroundColor = [UIColor blueColor];
        [TileButton.titleLabel setFont:[UIFont fontWithName:@"HelveticaNeue-Light" size:13]];
        [TileButton setTitle:@"Follow" forState:UIControlStateNormal];
        [self.contentView addSubview:TileButton];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];
    
}

@end

