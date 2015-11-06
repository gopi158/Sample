//
//  FinaoTableCell.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MediaPlayer/MediaPlayer.h>

@interface FinaoTableCell : UITableViewCell
{

    UIImageView* ProfileImage;
    UILabel* ProfileName;
    UILabel* UpdatedDate;
    UIImageView* FinaoImage;
    UILabel* FinaoCaption;
    BOOL ShowCaption;
    UILabel* FinaoMsg;
    UILabel* UploadText;
    UILabel* Finao_msg;
    UILabel* Upload_text;
    UILabel* Pri_Public;
    UILabel* finao_status;
    UIButton* playbtn;
    
    BOOL HasVideo;
    BOOL NO_IMGVIEW;
    
    NSString* VideoUrl;
    MPMoviePlayerController *moviePlayer;
    MPMoviePlayerViewController *moviePlayerViewController;
//    NSData* ProfileImageData;
}
@property(nonatomic,assign)BOOL NO_IMGVIEW;
@property (strong, nonatomic) MPMoviePlayerViewController *moviePlayerViewController;

@property (strong, nonatomic) MPMoviePlayerController *moviePlayer;
@property(nonatomic,retain)UIButton* playbtn;
@property(nonatomic,retain)UIImageView* ProfileImage;
@property(nonatomic,retain)UILabel* ProfileName;
@property(nonatomic,retain)UILabel* UpdatedDate;
@property(nonatomic,retain)UIImageView* FinaoImage;
@property(nonatomic,retain)UILabel* FinaoCaption;
@property(nonatomic,assign)BOOL ShowCaption;
@property(nonatomic,retain)UILabel* FinaoMsg;
@property(nonatomic,retain)UILabel* UploadText;
@property(nonatomic,retain)UILabel* Finao_msg;
@property(nonatomic,retain)UILabel* Upload_text;
@property(nonatomic,retain)UILabel* Pri_Public;
@property(nonatomic,retain)UILabel* finao_status;
@property(nonatomic,assign)BOOL HasVideo;
@property(nonatomic,retain)NSString* VideoUrl;

//@property(nonatomic,retain)NSData* ProfileImageData;
//-(void)AddObjectstoCell;
-(void)ChangeFrames;
@end
