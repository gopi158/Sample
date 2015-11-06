//
//  NotificationTableVuewCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "NotificationTableVuewCell.h"

@implementation NotificationTableVuewCell

@synthesize NotificationImage;
@synthesize NotificationMessage;
@synthesize activityIndicatorView;
@synthesize UpdateDate;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {

        NotificationImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 40, 40)];
        NotificationImage.layer.borderColor = [UIColor lightGrayColor].CGColor;
        NotificationImage.layer.borderWidth = 1.0f;
        [self.contentView addSubview:NotificationImage];
        
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.center =self.NotificationImage.center;
        [self.contentView addSubview:activityIndicatorView];
        
        NotificationMessage = [[UILabel alloc] initWithFrame:CGRectMake(70, 7, 160, 45)];
        NotificationMessage.textColor = [UIColor blackColor];
        NotificationMessage.textAlignment = NSTextAlignmentLeft;
        NotificationMessage.numberOfLines = 0;
        NotificationMessage.lineBreakMode = NSLineBreakByWordWrapping;
        NotificationMessage.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:15.0];
        [self.contentView addSubview:NotificationMessage];
        
        UpdateDate = [[UILabel alloc] initWithFrame:CGRectMake(252, 7, 60, 45)];
        UpdateDate.textColor = [UIColor blackColor];
        UpdateDate.numberOfLines = 0;
        UpdateDate.lineBreakMode = NSLineBreakByWordWrapping;
        UpdateDate.textAlignment = NSTextAlignmentLeft;
        UpdateDate.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15.0];
        [self.contentView addSubview:UpdateDate];
        
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

}

@end
