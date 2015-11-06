//
//  SlideNoteViewController.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 18/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SlideNoteViewController : UIViewController<UITableViewDelegate,UITableViewDataSource,UITextFieldDelegate>
{
    NSArray* arr;
    UITextField* UserNameTxtfld;
    
    UITableView* table;
}

@end
