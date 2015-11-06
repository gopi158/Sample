//
//  PostCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "PostCell.h"

@implementation PostCell

@synthesize PostImage;
@synthesize txtfld;
@synthesize delbtn;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        
        PostImage = [[UIImageView alloc]initWithFrame:CGRectMake(40, 30, 60, 60)];
        PostImage.layer.borderColor = [UIColor grayColor].CGColor;
        PostImage.layer.borderWidth = 1.0f;
        PostImage.contentMode = UIViewContentModeScaleAspectFit;
        PostImage.transform = CGAffineTransformMakeRotation(M_PI/2);
        [self.contentView addSubview:PostImage];
        
//        txtfld = [[UITextField alloc]initWithFrame:CGRectMake(-20, 50, 90, 20)];
//        txtfld.placeholder = @"Caption";
//        txtfld.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
//        txtfld.layer.borderColor = [UIColor grayColor].CGColor;
//        txtfld.layer.borderWidth = 1.0f;
//        txtfld.textAlignment = NSTextAlignmentCenter;
//        txtfld.autocorrectionType = UITextAutocorrectionTypeNo;
//        txtfld.transform = CGAffineTransformMakeRotation(M_PI/2);
//        [self.contentView addSubview:txtfld];
        
        delbtn = [UIButton buttonWithType:UIButtonTypeCustom];
        delbtn.frame = CGRectMake(80, 80, 20, 20);
        [delbtn setImage:[UIImage imageNamed:@"Delete_Post"] forState:UIControlStateNormal];
//        [delbtn setTitle:@"-" forState:UIControlStateNormal];
//        delbtn.backgroundColor = [UIColor orangeColor];
        delbtn.transform = CGAffineTransformMakeRotation(M_PI/2);
        [self.contentView addSubview:delbtn];
        
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];
    
    // Configure the view for the selected state
}

@end
