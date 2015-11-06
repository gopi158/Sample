//
//  TLTransitionAnimator.h
//  FinaoNationTabbarSample
//
//  Created by Fred Amirfaiz on 1/14/14.
//  Copyright (c) 2014 FINAO  Nation
//

#import <Foundation/Foundation.h>

@interface TLTransitionAnimator : NSObject <UIViewControllerAnimatedTransitioning>

@property (nonatomic, assign, getter = isPresenting) BOOL presenting;

@end
