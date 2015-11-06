//
//  FinaoFollowersCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoFollowersCell.h"

@implementation FinaoFollowersCell
@synthesize FollowersImage;
@synthesize FollowersName;
@synthesize activityIndicatorView;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        FollowersImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 40, 40)];
        FollowersImage.layer.borderColor = [UIColor lightGrayColor].CGColor;
        FollowersImage.layer.borderWidth = 1.0f;
        [self.contentView addSubview:FollowersImage];
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.center =self.FollowersImage.center;
        //[self.contentView addSubview:activityIndicatorView];
        //[activityIndicatorView startAnimating];
        //[activityIndicatorView setHidden:NO];
        
        FollowersName = [[UILabel alloc] initWithFrame:CGRectMake(70, 15, 160, 27)];
        FollowersName.textColor = [UIColor darkGrayColor];
        FollowersName.textAlignment = NSTextAlignmentLeft;
        FollowersName.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:20.0];
        FollowersName.minimumScaleFactor = 5.0f/[UIFont labelFontSize];
        FollowersName.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:FollowersName];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];
    
}

@end
