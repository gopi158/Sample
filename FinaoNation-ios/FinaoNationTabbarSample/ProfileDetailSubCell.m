//
//  ProfileDetailSubCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 11/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileDetailSubCell.h"

@implementation ProfileDetailSubCell

@synthesize FinaoProfileImage;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        
        self.backgroundColor = [UIColor whiteColor];
        
        FinaoProfileImage = [[UIImageView alloc]initWithFrame:CGRectMake(-3, 3, 290, 290)];
        FinaoProfileImage.layer.borderColor = [UIColor grayColor].CGColor;
        FinaoProfileImage.layer.borderWidth = 1.0f;
        FinaoProfileImage.backgroundColor = [UIColor blackColor];
        FinaoProfileImage.contentMode = UIViewContentModeScaleAspectFill;
        FinaoProfileImage.clipsToBounds = YES;
        [self.contentView addSubview:FinaoProfileImage];
        FinaoProfileImage.transform = CGAffineTransformMakeRotation(M_PI_2);
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];
}

@end
