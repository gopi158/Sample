//
//  NotificationTableVuewCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface NotificationTableVuewCell : UITableViewCell{
    
    UIImageView* NotificationImage;
    UILabel* NotificationMessage;
    UILabel* UpdateDate;
    UIActivityIndicatorView *activityIndicatorView;
    
}
@property(nonatomic,retain)UIImageView* NotificationImage;
@property(nonatomic,retain)UILabel* NotificationMessage;
@property(nonatomic,retain)UILabel* UpdateDate;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

@end

