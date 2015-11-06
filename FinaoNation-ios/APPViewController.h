//
//  APPViewController.h
//  VideoApp
//
//  Created by Rafael Garcia Leiva on 29/04/13.
//  Copyright (c) 2013 Appcoda. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MediaPlayer/MediaPlayer.h>
#import <MobileCoreServices/MobileCoreServices.h>

@interface APPViewController : UIViewController <UIImagePickerControllerDelegate, UINavigationControllerDelegate>

@property (copy,   nonatomic) NSURL *movieURL;
@property (strong, nonatomic) MPMoviePlayerController *movieController;

- (IBAction)takeVideo:(UIButton *)sender;

@end
