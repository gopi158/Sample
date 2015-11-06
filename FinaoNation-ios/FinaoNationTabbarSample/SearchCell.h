//
//  SearchCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 12/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SearchCell : UITableViewCell{
    UIImageView * SearchImageview;
    UILabel* SearchName;
    UILabel* SearchStory;
    UIActivityIndicatorView *activityIndicatorView;

}
@property(nonatomic,retain)UIImageView * SearchImageview;
@property(nonatomic,retain)UILabel* SearchName;
@property(nonatomic,retain)UILabel* SearchStory;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

@end
