//
//  APPViewController.m
//  VideoApp
//
//  Created by Rafael Garcia Leiva on 29/04/13.
//  Copyright (c) 2013 Appcoda. All rights reserved.
//

#import "APPViewController.h"
#define isiPhone5  ([[UIScreen mainScreen] bounds].size.height == 568)?TRUE:FALSE

@interface APPViewController ()

@end

@implementation APPViewController

- (void)viewDidLoad {
    
    [super viewDidLoad];
    
}

- (void)viewDidAppear:(BOOL)animated {
    
    self.movieController = [[MPMoviePlayerController alloc] init];
    [self.movieController setContentURL:self.movieURL];
    //self.movieController.useApplicationAudioSession = NO;
    if (isiPhone5) {
            [self.movieController.view setFrame:CGRectMake ( 0, 0, 320, 448)];
    }else{
            [self.movieController.view setFrame:CGRectMake ( 0, 0, 320, 360)];
    }

    
    [self.view addSubview:self.movieController.view];

    [[NSNotificationCenter defaultCenter] addObserver:self
                                          selector:@selector(moviePlayBackDidFinish:)
                                          name:MPMoviePlayerPlaybackDidFinishNotification
                                          object:self.movieController];
    
    [self.movieController play];
    
}

-(NSUInteger)supportedInterfaceOrientations {
    return UIInterfaceOrientationMaskLandscape;
}

-(BOOL)shouldAutorotate {
    return YES;
}


- (IBAction)takeVideo:(UIButton *)sender {
    
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    picker.delegate = self;
    picker.allowsEditing = YES;
    picker.sourceType = UIImagePickerControllerSourceTypeCamera;
    picker.mediaTypes = [[NSArray alloc] initWithObjects: (NSString *) kUTTypeMovie, nil];
    
    [self presentViewController:picker animated:YES completion:NULL];
    
}

- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info {
    
    self.movieURL = info[UIImagePickerControllerMediaURL];
    
    [picker dismissViewControllerAnimated:YES completion:NULL];
    
}

- (void)imagePickerControllerDidCancel:(UIImagePickerController *)picker {
    
    [picker dismissViewControllerAnimated:YES completion:NULL];
    
}

- (void)moviePlayBackDidFinish:(NSNotification *)notification {
    
    [[NSNotificationCenter defaultCenter]removeObserver:self name:MPMoviePlayerPlaybackDidFinishNotification object:nil];
    
    [self.movieController stop];
    [self.movieController.view removeFromSuperview];
    self.movieController = nil;
    [self.navigationController popViewControllerAnimated:YES];
}

@end
