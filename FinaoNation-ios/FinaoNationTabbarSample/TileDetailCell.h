//
//  TileDetailCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 11/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TileDetailCell : UITableViewCell{
    UIImageView * TileDetailImageview;
    UILabel* TileDetailName;
//    UILabel* TileDetailStory;
    UILabel* TileDetailStatus;
    UILabel* TileDetailPri_pub;
    UILabel* TileDetailDate;
}
@property(nonatomic,retain)UIImageView * TileDetailImageview;
@property(nonatomic,retain)UILabel* TileDetailName;
//@property(nonatomic,retain)UILabel* TileDetailStory;
@property(nonatomic,retain)UILabel* TileDetailStatus;
@property(nonatomic,retain)UILabel* TileDetailPri_pub;
@property(nonatomic,retain)UILabel* TileDetailDate;

@end
