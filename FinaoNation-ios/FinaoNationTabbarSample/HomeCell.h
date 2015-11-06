//
//  HomeCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 17/12/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AsyncImageView.h"
#import "iCarousel.h"
#import "UIImageView+AFNetworking.h"
#import "HomeDetailSubCell.h"
#import "ProfileDetailTableCell.h"

@interface HomeCell : UITableViewCell<UITableViewDataSource,UITableViewDelegate>
{
    
    UILabel* Pri_Public;
    UIActivityIndicatorView *activityIndicatorView;
    UIButton* spamBtn;
    UIButton* profileImageBtn;

    UIImageView* VideoImageview;
    UIButton* ProfileImage;
    
    UILabel* ProfileName;
    UILabel* UpdatedDate;
    UILabel* Finao_msg, *Finao_msg2;
    UILabel* Upload_text;
    UIImageView *Finao_Symbol;
    NSMutableArray* Images_arr;
    UITableView* Finao_detail_table;
    
    BOOL VideoORImage;
    NSString* VideoImageStr;
    NSString* VideoCaptionText;
    UIButton* playbtn;
    UIButton *shareBtn;
    UIButton *inspireStatus;
    UILabel* finao_status; //From status
    MPMoviePlayerController *moviePlayer;
    MPMoviePlayerViewController *moviePlayerViewController;
    NSString* videoSource;
    UIWebView *videoView;
    UILabel* FinaoVideoCaption;
    
    UIImageView *postImageView;

}
@property(nonatomic,retain)UIButton* spamBtn;
@property(nonatomic,retain)UILabel* Pri_Public;
@property(nonatomic,retain)UILabel* finao_status;
@property(nonatomic,retain)UIButton* inspireStatus;
@property(nonatomic,retain)NSString* videoSource;
@property(nonatomic,retain)UIButton* playbtn;
@property(nonatomic,retain)UIButton* shareBtn;
@property(nonatomic,retain)UITableView* Finao_detail_table;
@property(nonatomic,retain)NSString* VideoCaptionText;
@property(nonatomic,retain)NSString* VideoImageStr;
@property(nonatomic,assign)BOOL VideoORImage;
@property(nonatomic,retain)NSMutableArray* Images_arr;
@property(nonatomic,retain)UIImageView *Finao_Symbol;
@property(nonatomic,retain)UILabel* Upload_text;
@property(nonatomic,retain)UILabel* UpdatedDate;
@property(nonatomic,retain)UILabel* Finao_msg;
@property(nonatomic,retain)UILabel* Finao_msg2;
@property(nonatomic,retain)UILabel* ProfileName;
@property(nonatomic,retain)UILabel* FinaoVideoCaption;
@property(nonatomic,retain)UIImageView* VideoImageview;
@property(nonatomic,retain)UIButton* ProfileImage;

@property (strong, nonatomic) MPMoviePlayerViewController *moviePlayerViewController;
@property (strong, nonatomic) MPMoviePlayerController *moviePlayer;
@property (strong ,nonatomic)UIImageView *postImageView;
@property(nonatomic,retain)UIActivityIndicatorView *activityIndicatorView;

-(void)ChangeFramesHomecell;
-(void)ChangeToVideoFrames;
-(void)ChangeFrameShare;

@end

