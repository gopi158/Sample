//
//  MySegmentControl.h
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 22/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface MySegmentControl : UISegmentedControl{

UIColor *offColor;
UIColor *onColor;

BOOL hasSetSelectedIndexOnce;
}

-(id)initWithItems:(NSArray *)items offColor:(UIColor*)offcolor onColor:(UIColor*)oncolor;
-(void)setInitialMode;
-(void)setToggleHiliteColors;
@end
