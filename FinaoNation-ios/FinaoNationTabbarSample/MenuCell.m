//
//  MenuCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 25/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.

#import "MenuCell.h"

@implementation MenuCell


- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {

    }
    return self;
}
- (void) layoutSubviews
{
    [super layoutSubviews];
    
    self.backgroundColor = [UIColor clearColor];
    self.textLabel.frame = CGRectMake(10, 15, 70, 20);
    self.accessoryView.frame = CGRectMake(260, 22, 12, 20);
    self.imageView.frame = CGRectMake(90, 8, 30, 30);
}
- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

}

@end
