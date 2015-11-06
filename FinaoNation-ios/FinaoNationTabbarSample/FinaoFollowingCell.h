//
//  FinaoFollowingCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface FinaoFollowingCell : UITableViewCell{

    UIImageView* FollowingImage;
    UILabel* FollowingName;
    UIActivityIndicatorView *activityIndicatorView;

}
@property(nonatomic,retain)UIImageView* FollowingImage;
@property(nonatomic,retain)UILabel* FollowingName;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

@end
