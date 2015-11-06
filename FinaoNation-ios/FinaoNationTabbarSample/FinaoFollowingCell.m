//
//  FinaoFollowingCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoFollowingCell.h"

@implementation FinaoFollowingCell
@synthesize FollowingImage;
@synthesize FollowingName;
@synthesize activityIndicatorView;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {

        FollowingImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 40, 40)];
        FollowingImage.layer.borderColor = [UIColor lightGrayColor].CGColor;
        FollowingImage.layer.borderWidth = 1.0f;
        [self.contentView addSubview:FollowingImage];
        
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.center =self.FollowingImage.center;
        //[self.contentView addSubview:activityIndicatorView];

        FollowingName = [[UILabel alloc] initWithFrame:CGRectMake(70, 15, 160, 27)];
        FollowingName.textColor = [UIColor darkGrayColor];
        FollowingName.textAlignment = NSTextAlignmentLeft;
        FollowingName.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:18.0];
        FollowingName.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:FollowingName];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

}

@end
