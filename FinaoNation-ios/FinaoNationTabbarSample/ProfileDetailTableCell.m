//
//  ProfileDetailTableCell.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 10/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ProfileDetailTableCell.h"
#import "UIImageView+AFNetworking.h"
#import "ProfileDetailSubCell.h"

@implementation ProfileDetailTableCell
@synthesize finao_status, inspireStatus;
@synthesize activityIndicatorView;
@synthesize ProfileImage;
@synthesize ProfileName;
@synthesize UpdatedDate;
@synthesize Finao_msg2;
@synthesize Finao_msg;
@synthesize Upload_text;
@synthesize Finao_Symbol;
@synthesize Images_arr;
@synthesize VideoImageStr;
@synthesize VideoORImage;
@synthesize VideoCaptionText;
@synthesize Finao_detail_table;
@synthesize VideoImageview;
@synthesize playbtn;
@synthesize videoSource;
@synthesize moviePlayer;
@synthesize moviePlayerViewController;
@synthesize FinaoVideoCaption;
@synthesize shareBtn;
@synthesize postImageView;


- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        
        videoSource = [[NSString alloc]init];
        VideoImageStr = [[NSString alloc]init];
        Images_arr = [[NSMutableArray alloc]init ];
        
        ProfileImage = [[UIImageView alloc]initWithFrame:CGRectMake(15, 5, 40, 40)];
        ProfileImage.layer.borderColor = [UIColor grayColor].CGColor;
        ProfileImage.layer.borderWidth = 1.0f;
        [self.contentView addSubview:ProfileImage];
        
        ProfileName = [[UILabel alloc] initWithFrame:CGRectMake(35, 10, 160, 27)];
        ProfileName.textColor = [UIColor orangeColor];
        ProfileName.textAlignment = NSTextAlignmentCenter;
        ProfileName.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:13.0];
        ProfileName.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:ProfileName];
        
        UpdatedDate = [[UILabel alloc] initWithFrame:CGRectMake(253, 11, 50, 27)];
        UpdatedDate.textColor = [UIColor blackColor];
        UpdatedDate.textAlignment = NSTextAlignmentCenter;
        UpdatedDate.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
        UpdatedDate.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:UpdatedDate];
        
        Finao_Symbol = [[UIImageView alloc]initWithFrame:CGRectMake(14, 50, 10, 10)];
        Finao_Symbol.image = [UIImage imageNamed:@"logo_finao"];
        Finao_Symbol.contentMode = UIViewContentModeScaleAspectFit;
        [self.contentView addSubview:Finao_Symbol];
        
        postImageView = [[UIImageView alloc]initWithFrame:CGRectMake(20, 100, 280, 320)];
        [self.contentView addSubview:postImageView];
        
        
        Upload_text = [[UILabel alloc] initWithFrame:CGRectMake(32, 55, 230, 35)];
        Upload_text.numberOfLines = 2;
        Upload_text.textColor = [UIColor blackColor];
        Upload_text.backgroundColor = [UIColor clearColor];
        Upload_text.textAlignment = NSTextAlignmentLeft;
        Upload_text.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:14.0];
        Upload_text.adjustsFontSizeToFitWidth = YES;
        Upload_text.minimumScaleFactor = 8.0f;
        [self.contentView addSubview:Upload_text];
        
        Finao_msg = [[UILabel alloc] initWithFrame:CGRectMake(70, 10, 192, 50)];
        Finao_msg.lineBreakMode = NSLineBreakByWordWrapping;
        Finao_msg.numberOfLines = 3;
        Finao_msg.textColor = [UIColor blackColor];
        Finao_msg.backgroundColor = [UIColor clearColor];
        Finao_msg.textAlignment = NSTextAlignmentLeft;
        Finao_msg.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:13.0];
        Finao_msg.adjustsFontSizeToFitWidth = YES;
        Finao_msg.minimumScaleFactor = 8.0f;
        //[self.contentView addSubview:Finao_msg];
        
        Finao_msg2 = [[UILabel alloc] init ];
        Finao_msg2.frame = CGRectMake(16, 370, 270, 30);
        Finao_msg2.textColor = [UIColor blackColor];
        Finao_msg2.backgroundColor = [UIColor clearColor];
        Finao_msg2.font = [UIFont fontWithName:@"HelveticaNeue-light" size:13.0];
        Finao_msg2.adjustsFontSizeToFitWidth = YES;
        Finao_msg2.minimumScaleFactor = 5.0f/[UIFont labelFontSize];
        Finao_msg2.numberOfLines = 3;
        [self.contentView addSubview:Finao_msg2];
        
        VideoImageview = [[UIImageView alloc]initWithFrame:CGRectMake(20, 100, 280, 180)];
        VideoImageview.layer.borderColor = [UIColor grayColor].CGColor;
        VideoImageview.layer.borderWidth = 1.0f;
        VideoImageview.contentMode = UIViewContentModeScaleAspectFit;
        //[self.contentView addSubview:VideoImageview];
        
        
        Finao_detail_table = [[UITableView alloc]initWithFrame:CGRectMake(30, 70, 280, 315) style:UITableViewStylePlain];
        Finao_detail_table.delegate = self;
        Finao_detail_table.dataSource = self;
        Finao_detail_table.backgroundColor = [UIColor whiteColor];
        [self.contentView addSubview:Finao_detail_table];
        Finao_detail_table.bounces = NO;
        Finao_detail_table.transform = CGAffineTransformMakeRotation(-M_PI_2);
        [Finao_detail_table setSeparatorStyle:UITableViewCellSeparatorStyleNone];
        
        playbtn = [UIButton buttonWithType:UIButtonTypeCustom];
        playbtn.frame = CGRectMake(140, 140, 50, 50);
        [playbtn setImage:[UIImage imageNamed:@"play_button"] forState:UIControlStateNormal];
        playbtn.backgroundColor = [UIColor clearColor];
        [playbtn addTarget:self action:@selector(PlaybtnClicked) forControlEvents:UIControlEventTouchUpInside];
        [self.contentView addSubview:playbtn];
        
        shareBtn = [UIButton buttonWithType:UIButtonTypeCustom];
        shareBtn.frame = CGRectMake(170, 395, 30, 20);
        [shareBtn setImage:[UIImage imageNamed:@"spam_btn"] forState:UIControlStateNormal];
        shareBtn.backgroundColor = [UIColor clearColor];
        [self addSubview:shareBtn];
        
        
        // Home
        
        
        activityIndicatorView = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
        activityIndicatorView.frame =CGRectMake(20, 100, 20, 20);
        activityIndicatorView.center =self.Finao_detail_table.center;
        //[self.contentView addSubview:activityIndicatorView];
        //[activityIndicatorView startAnimating];
        //[activityIndicatorView setHidden:NO];
        
        finao_status = [[UILabel alloc] init ];
        finao_status.frame = CGRectMake(16, 395, 50, 20);
        finao_status.textColor = [UIColor whiteColor];
        finao_status.backgroundColor = [UIColor clearColor];
        finao_status.textAlignment = NSTextAlignmentCenter;
        finao_status.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11.0];
        finao_status.adjustsFontSizeToFitWidth = YES;
        [self.contentView addSubview:finao_status];
        
        
        inspireStatus = [[UILabel alloc] init ];
        inspireStatus.frame = CGRectMake(220, 395, 50, 25);
        inspireStatus.textColor = [UIColor whiteColor];
        inspireStatus.backgroundColor = [UIColor clearColor];
        inspireStatus.textAlignment = NSTextAlignmentCenter;
        inspireStatus.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:11.0];
        inspireStatus.adjustsFontSizeToFitWidth = YES;
        inspireStatus.layer.borderColor = [UIColor redColor].CGColor;
        inspireStatus.layer.borderWidth = 1.0f;
        [self.contentView addSubview:inspireStatus];
        
    }
    return self;
}

-(void)PlaybtnClicked
{
    
    //NSLog(@"VideoSource:%@",videoSource);
    NSURL *mediaURL = [NSURL URLWithString:videoSource];
    
    moviePlayerViewController = [[MPMoviePlayerViewController alloc] initWithContentURL:mediaURL];
    
    [moviePlayerViewController.moviePlayer stop];
    if (moviePlayerViewController) {
        
        [self.contentView addSubview:moviePlayerViewController.view];
        //      [moviePlayerViewController.moviePlayer setShouldAutoplay:YES];
        [moviePlayerViewController.moviePlayer setControlStyle:MPMovieControlStyleEmbedded];
        moviePlayerViewController.moviePlayer.controlStyle = MPMediaTypeMusicVideo;
        moviePlayerViewController.moviePlayer.movieSourceType = MPMovieSourceTypeUnknown;
        //        moviePlayerViewController.moviePlayer.fullscreen = YES;
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
        
        videoView = [[UIWebView alloc]initWithFrame:CGRectMake(10, 60, 300, 200)];
        videoView.backgroundColor = [UIColor blackColor];
        videoView.opaque = NO;
        [self.contentView addSubview:videoView];
        
        [self embedYouTube];
    }
    
    [moviePlayerViewController.moviePlayer stop];
    [moviePlayerViewController.view removeFromSuperview];
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:MPMoviePlayerPlaybackDidFinishNotification
                                                  object:moviePlayerViewController.moviePlayer];
    
}
- (void)embedYouTube {
    
    
    NSString *videoHTML = [NSString stringWithFormat:@"<html>\
                           <head>\
                           <style type=\"text/css\">\
                           iframe {position:absolute; top:50%%; margin-top:-130px;}\
                           body {background-color:#000; margin:0;}\
                           </style>\
                           </head>\
                           <body>\
                           <iframe width=\"100%%\" height=\"240px\" src=\"%@\" frameborder=\"0\" allowfullscreen></iframe>\
                           </body>\
                           </html>",videoSource];
    [videoView loadHTMLString:videoHTML baseURL:nil];
}
#pragma Image Carousel table viewe
- (void)tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
    //    [cell setBackgroundColor:[UIColor lightGrayColor]];
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    return 260.0f;
}
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    
    return [Images_arr count];
}
- (UITableViewCell *)tableView:(UITableView *)tableView
         cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    
    NSDictionary *tempDict = [Images_arr objectAtIndex:indexPath.row];
    
    ProfileDetailSubCell *cell = (ProfileDetailSubCell *)[tableView dequeueReusableCellWithIdentifier:@"ProfileDetailSubCell"];
    
    if(cell == nil)
        cell = [[ProfileDetailSubCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"ProfileDetailSubCell"];
    
    dispatch_async(dispatch_get_main_queue(), ^{
        if (!VideoORImage)
        {

            NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[[tempDict objectForKey:@"image_url"]stringByReplacingOccurrencesOfString:@" " withString:@"%20"]];
            [cell.FinaoProfileImage setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"No_Image@2x"]];
        }
        else
        {
            [cell.FinaoProfileImage setImageWithURL:[NSURL URLWithString:VideoImageStr] placeholderImage:[UIImage imageNamed:@"No_Image@2x"]];
            
        }
    });
    cell.selectionStyle = UITableViewCellSelectionStyleNone;
    tableView.showsVerticalScrollIndicator = NO;
    [activityIndicatorView stopAnimating];
    [activityIndicatorView setHidden:YES];
    return cell;
}

-(void)ChangeFramesHomecell{
    
    [VideoImageview removeFromSuperview];
    Finao_Symbol.frame = CGRectMake(14, 55, 12, 12);
    Upload_text.frame = CGRectMake(32, 43, 230, 35);
    Finao_detail_table.hidden = NO;
    postImageView.hidden = YES;
    shareBtn.frame = CGRectMake(276, 395, 30, 20);
    finao_status.frame = CGRectMake(16, 395, 50, 20);
    inspireStatus.frame = CGRectMake(220, 395, 50, 20);
}

-(void)ChangeFrameShare{
    shareBtn.frame = CGRectMake(276, 90, 30, 20);
    finao_status.frame = CGRectMake(16, 90, 50, 20);
    inspireStatus.frame = CGRectMake(220, 90, 50, 20);
}

-(void)ChangeToVideoFrames{
    Finao_Symbol.frame = CGRectMake(14, 260, 12, 12);
    Upload_text.frame = CGRectMake(50, 260, 230, 35);
    Finao_detail_table.hidden = YES;
    shareBtn.frame = CGRectMake(276, 260, 30, 20);
    finao_status.frame = CGRectMake(16, 395, 50, 20);
    inspireStatus.frame = CGRectMake(220, 395, 50, 20);
}


- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];
}

@end
