//
//  FinaoTilesCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoTilesCell.h"

@implementation FinaoTilesCell

@synthesize TileCaption;
@synthesize TileImage;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        
        TileImage = [[UIImageView alloc]initWithFrame:CGRectMake(40, 20, 240, 200)];
        //        self.ProfileImage.image = [UIImage imageWithData:self.ProfileImageData];
        TileImage.layer.borderColor = [UIColor grayColor].CGColor;
        TileImage.layer.borderWidth = 1.0f;
        [self.contentView addSubview:TileImage];
        
        
        TileCaption = [[UILabel alloc] initWithFrame:CGRectMake(40, 220, 240, 20)];
        TileCaption.backgroundColor = [UIColor blackColor];
        TileCaption.textColor = [UIColor whiteColor];
        TileCaption.textAlignment = NSTextAlignmentCenter;
        TileCaption.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:13.0];
        TileCaption.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:TileCaption];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

@end
