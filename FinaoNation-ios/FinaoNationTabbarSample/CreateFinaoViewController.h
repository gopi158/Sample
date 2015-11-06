//
//  CreateFinaoViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 07/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Servermanager.h"
#import "CreateFinaoPost.h"
#import "UploadFinaoImageCreateFinao.h"

@interface CreateFinaoViewController : UIViewController<UITableViewDataSource,UITableViewDelegate,WebServiceDelegate,UITextViewDelegate,UIActionSheetDelegate,UIImagePickerControllerDelegate,UINavigationControllerDelegate>
{
    UIImageView* Finaoimgview;
    UITextView* txtview;
    NSIndexPath* lastIndexPath;
    UILabel* Pub_Priv_Lbl;
    UITableView* TileTable;
    NSMutableArray* TilesArray;
    BOOL isTablecellSelected;
    CreateFinaoPost* createFinao;
    UploadFinaoImageCreateFinao* uploadImage;
    NSString* TileIDStr;
    NSString* TileIDnameStr;
    NSString* CreatedFinaID;
    int kAdjust;
}
@property(nonatomic)int kAdjust;
@end
