//
//  FinaoTableCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 26/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "FinaoTableCell.h"


@implementation FinaoTableCell

@synthesize ProfileImage;
@synthesize ProfileName;
@synthesize UpdatedDate;
@synthesize FinaoImage;
@synthesize FinaoCaption;
@synthesize FinaoMsg;
@synthesize UploadText;
@synthesize ShowCaption;
@synthesize HasVideo;
@synthesize VideoUrl;
@synthesize moviePlayer;
@synthesize moviePlayerViewController;
@synthesize playbtn;
@synthesize Finao_msg;
@synthesize Upload_text;
@synthesize Pri_Public;
@synthesize finao_status;
@synthesize NO_IMGVIEW;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        
//        ProfileImageData = [[NSData alloc]init];
        
        [self AddObjectstoCell];
    }
    return self;
}

-(void)AddObjectstoCell{

    
    ProfileImage = [[UIImageView alloc]initWithFrame:CGRectMake(10, 10, 40, 40)];
    ProfileImage.layer.borderColor = [UIColor grayColor].CGColor;
    ProfileImage.layer.borderWidth = 1.0f;
    [self.contentView addSubview:ProfileImage];
    
    
    ProfileName = [[UILabel alloc] initWithFrame:CGRectMake(45, 12, 160, 27)];
    ProfileName.textColor = [UIColor orangeColor];
    ProfileName.textAlignment = NSTextAlignmentCenter;
    ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:13.0];
    ProfileName.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:ProfileName];
    
    
    UpdatedDate = [[UILabel alloc] initWithFrame:CGRectMake(250, 12, 50, 27)];
    UpdatedDate.textColor = [UIColor blackColor];
    UpdatedDate.textAlignment = NSTextAlignmentCenter;
    UpdatedDate.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    UpdatedDate.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:UpdatedDate];
    
    
    FinaoImage = [[UIImageView alloc]initWithFrame:CGRectMake(40, 60, 240, 180)];
    FinaoImage.layer.borderColor = [UIColor grayColor].CGColor;
    FinaoImage.layer.borderWidth = 1.0f;
    [self.contentView addSubview:FinaoImage];
    
    
    FinaoCaption = [[UILabel alloc] init ];
    FinaoCaption.frame=CGRectMake(40, 220, 240, 20);
    FinaoCaption.backgroundColor = [UIColor blackColor];
    FinaoCaption.textColor = [UIColor whiteColor];
    FinaoCaption.textAlignment = NSTextAlignmentCenter;
    FinaoCaption.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:13.0];
    FinaoCaption.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:FinaoCaption];
    
    
    Finao_msg = [[UILabel alloc] init ];
    Finao_msg.frame = CGRectMake(45, 240, 150, 40);
    Finao_msg.textColor = [UIColor blackColor];
    Finao_msg.backgroundColor = [UIColor clearColor];
    Finao_msg.numberOfLines = 3;
    Finao_msg.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11.0];
    Finao_msg.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:Finao_msg];
    
    Upload_text = [[UILabel alloc] init ];
    Upload_text.frame = CGRectMake(45, 285, 180, 35);
    Upload_text.numberOfLines = 2;
    Upload_text.textColor = [UIColor blackColor];
    Upload_text.backgroundColor = [UIColor clearColor];
    Upload_text.textAlignment = NSTextAlignmentLeft;
    Upload_text.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    Upload_text.minimumScaleFactor = 6.0f/[UIFont labelFontSize];
    Upload_text.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:Upload_text];
    
    finao_status = [[UILabel alloc] init ];
    finao_status.frame = CGRectMake(235, 250, 50, 27);
    finao_status.textColor = [UIColor whiteColor];
    finao_status.backgroundColor = [UIColor clearColor];
    finao_status.textAlignment = NSTextAlignmentCenter;
    finao_status.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    finao_status.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:finao_status];
    
    
    
    Pri_Public = [[UILabel alloc] init ];
    Pri_Public.frame = CGRectMake(235, 290, 50, 27);
    Pri_Public.textColor = [UIColor orangeColor];
    Pri_Public.backgroundColor = [UIColor clearColor];
    Pri_Public.textAlignment = NSTextAlignmentCenter;
    Pri_Public.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
    Pri_Public.adjustsFontSizeToFitWidth = YES;
    [self.contentView addSubview:Pri_Public];
    
    
    
    playbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    playbtn.frame = CGRectMake(140, 140, 50, 50);
    [playbtn setImage:[UIImage imageNamed:@"play_button"] forState:UIControlStateNormal];
    playbtn.backgroundColor = [UIColor clearColor];
//    [playbtn addTarget:self action:@selector(PlaybtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [self.contentView addSubview:playbtn];
    
    VideoUrl = [[NSString alloc] init];
    

}


-(void)ChangeFrames{

    [FinaoImage removeFromSuperview];
    Pri_Public.frame = CGRectMake(235, 120, 50, 27);
    finao_status.frame = CGRectMake(235, 80, 50, 27);
    Upload_text.frame = CGRectMake(45, 120, 180, 35);
    Finao_msg.frame = CGRectMake(45, 70, 150, 40);
    FinaoCaption.frame=CGRectMake(40, 80, 240, 20);

}

-(void)PlaybtnClicked
{
    
    NSURL *mediaURL = [NSURL URLWithString:@"http://www.viddler.com/file/30a31f19/718b04594528d1dc77a0032529838af8"];
    
    moviePlayerViewController = [[MPMoviePlayerViewController alloc] initWithContentURL:mediaURL];
    if (moviePlayerViewController) {
        
        [self.contentView addSubview:moviePlayerViewController.view];
        
        [moviePlayerViewController.moviePlayer setShouldAutoplay:YES];
        [moviePlayerViewController.moviePlayer setControlStyle:MPMovieControlStyleEmbedded];
        moviePlayerViewController.moviePlayer.controlStyle = MPMediaTypeMusicVideo;
        moviePlayerViewController.moviePlayer.movieSourceType = MPMovieSourceTypeUnknown;
        moviePlayerViewController.moviePlayer.view.frame = CGRectMake(10, 60, 300, 200);
        
        
        [[NSNotificationCenter defaultCenter] addObserver:self
                                                 selector:@selector(playbackStateChanged:)
                                                     name:MPMoviePlayerPlaybackDidFinishNotification
                                                   object:moviePlayerViewController.moviePlayer];
        
        [moviePlayerViewController.moviePlayer play];
    }
    
    
}
-(void)playbackStateChanged:(NSNotification*)notification
{
    int reason = [[[notification userInfo] valueForKey:MPMoviePlayerPlaybackDidFinishReasonUserInfoKey] intValue];
    if (reason == MPMovieFinishReasonPlaybackEnded) {
        //NSLog(@"MOVIE ENDED");
        //movie finished playin
    }else if (reason == MPMovieFinishReasonUserExited) {
        //NSLog(@"MOVIE WAS EXITED");
        //user hit the done button
    }else if (reason == MPMovieFinishReasonPlaybackError) {
        //error
        //NSLog(@"MOVIE HAS ERROR");
    }
    
    [moviePlayerViewController.moviePlayer.view removeFromSuperview];
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:MPMoviePlayerPlaybackDidFinishNotification
                                                  object:moviePlayerViewController.moviePlayer];
    
}


- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

@end
