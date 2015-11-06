//
//  FinaoFollowersCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface FinaoFollowersCell : UITableViewCell
{
    UIImageView* FollowersImage;
    UILabel* FollowersName;
    UIActivityIndicatorView *activityIndicatorView;
}
@property(nonatomic,retain)UIImageView* FollowersImage;
@property(nonatomic,retain)UILabel* FollowersName;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

@end
