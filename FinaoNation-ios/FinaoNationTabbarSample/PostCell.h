//
//  PostCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 08/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface PostCell : UITableViewCell
{
    UIImageView* PostImage;
    UITextField* txtfld;
    UIButton* delbtn;
}
@property(nonatomic,retain)UITextField* txtfld;
@property(nonatomic,retain)UIImageView* PostImage;
@property(nonatomic,retain)UIButton* delbtn;

@end
