//
//  QREncodeViewController.h
//  QREncoderProject
//
//  Created by Daniel Beard on 5/03/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "qrencode.h"

@interface QREncodeViewController : UIViewController
{
    UIImage *image;
}
@property (retain, nonatomic) IBOutlet UIImageView *imageView;
@property (retain, nonatomic) NSString *encodeURL;
- (UIImage *)quickResponseImageForString:(NSString *)dataString withDimension:(int)imageWidth;
- (void)didLeaveParentViewController:(UIViewController *)parent;

@end
