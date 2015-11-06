//
//  SearchCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "SearchCell.h"

@implementation SearchCell
@synthesize SearchImageview;
@synthesize SearchName;
@synthesize SearchStory;
@synthesize activityIndicatorView;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        
        
        SearchImageview = [[UIImageView alloc]initWithFrame:CGRectMake(10, 8, 40, 40)];
        SearchImageview.layer.borderColor = [UIColor lightGrayColor].CGColor;
        SearchImageview.layer.borderWidth = 1.0f;
        [self.contentView addSubview:SearchImageview];
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.center =self.SearchImageview.center;
        [self.contentView addSubview:activityIndicatorView];
//        [activityIndicatorView startAnimating];
//        [activityIndicatorView setHidden:NO];
        
        SearchName = [[UILabel alloc] initWithFrame:CGRectMake(70, 20, 200, 20)];
        SearchName.textColor = [UIColor darkGrayColor];
        SearchName.textAlignment = NSTextAlignmentLeft;
        SearchName.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:SearchName];


    }
    return self;
}
- (void) layoutSubviews
{
    [super layoutSubviews];

}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

}

@end
