//
//  PostViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 15/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ELCImagePickerController.h"
#import <MobileCoreServices/UTCoreTypes.h>

@interface PostViewController : UIViewController<UITextViewDelegate,UITableViewDataSource,UITableViewDelegate,ELCImagePickerControllerDelegate,UIImagePickerControllerDelegate,UITextFieldDelegate>
{
    UITextView* txtview;
    //    NSArray* uploadtextarr;
    UIToolbar *toolbar;
    UITableView* Upload_pic_table;
    
    NSMutableArray* chosenImagesNames;
    NSMutableArray* ChosenImageData;
    NSMutableArray* choosenImageCaption;
    
    NSString * FinaoIDStr;
}
@property(nonatomic, strong) NSString * FinaoIDStr;
@end
