//
//  TileGrid.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 05/02/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "TileGrid.h"

@implementation TileGrid

//@synthesize TileImage;
@synthesize TileName;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        // Initialization code
        
        self.backgroundColor = [UIColor whiteColor];
        
//        TileImage = [[UIImageView alloc]initWithFrame:CGRectMake(0, 0, 135, 135)];
//        TileImage.image = [UIImage imageNamed:@"profile"];
//        TileImage.layer.borderColor = [UIColor grayColor].CGColor;
//        TileImage.layer.borderWidth = 1.0f;
//        TileImage.contentMode = UIViewContentModeScaleAspectFit;
//        [self addSubview:TileImage];
        
        
        
    }
    return self;
}

- (void)setTileImage:(NSString*)URL {
//     NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"http://finaonation.com/images/tiles",URL];
//    [TileImage setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"profile"]];
}

/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
