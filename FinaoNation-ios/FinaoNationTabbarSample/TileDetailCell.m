//
//  TileDetailCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 11/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TileDetailCell.h"

@implementation TileDetailCell

@synthesize TileDetailImageview;
@synthesize TileDetailName;
//@synthesize TileDetailStory;
@synthesize TileDetailStatus;
@synthesize TileDetailPri_pub;
@synthesize TileDetailDate;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        TileDetailImageview = [[UIImageView alloc]initWithFrame:CGRectMake(10, 8, 60, 60)];
        TileDetailImageview.layer.borderColor = [UIColor lightGrayColor].CGColor;
        TileDetailImageview.layer.borderWidth = 1.0f;
        TileDetailImageview.backgroundColor = [UIColor blackColor];
        TileDetailImageview.contentMode = UIViewContentModeScaleAspectFit;
        [self.contentView addSubview:TileDetailImageview];
        
        
        TileDetailName = [[UILabel alloc] initWithFrame:CGRectMake(90, 10, 220, 30)];
        TileDetailName.textColor = [UIColor lightGrayColor];
        TileDetailName.textAlignment = NSTextAlignmentLeft;
        TileDetailName.adjustsFontSizeToFitWidth = YES;
        TileDetailName.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
        TileDetailName.minimumScaleFactor = 9.0f;
        TileDetailName.numberOfLines = 2;
        [self.contentView addSubview:TileDetailName];
        
        
        TileDetailStatus = [[UILabel alloc] initWithFrame:CGRectMake(90, 50, 60, 20)];
//        TileDetailStatus.textColor = [UIColor grayColor];
        TileDetailStatus.textAlignment = NSTextAlignmentCenter;
        TileDetailStatus.adjustsFontSizeToFitWidth = YES;
//        TileDetailStatus.minimumFontSize = 9.0f;
        TileDetailStatus.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
        [self.contentView addSubview:TileDetailStatus];
        
        TileDetailPri_pub = [[UILabel alloc] initWithFrame:CGRectMake(160, 50, 70, 20)];
        TileDetailPri_pub.textColor = [UIColor orangeColor];
        TileDetailPri_pub.textAlignment = NSTextAlignmentLeft;
        TileDetailPri_pub.adjustsFontSizeToFitWidth = YES;
//        TileDetailPri_pub.minimumFontSize = 9.0f;
        TileDetailPri_pub.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
        [self.contentView addSubview:TileDetailPri_pub];
        
        TileDetailDate = [[UILabel alloc] initWithFrame:CGRectMake(240, 50, 70, 20)];
        TileDetailDate.textColor = [UIColor blackColor];
        TileDetailDate.textAlignment = NSTextAlignmentLeft;
        TileDetailDate.adjustsFontSizeToFitWidth = YES;
        TileDetailDate.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
//        TileDetailDate.minimumFontSize = 9.0f;
        [self.contentView addSubview:TileDetailDate];
    
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

@end
