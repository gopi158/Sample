//
//  MySegmentControl.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 22/11/13.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "MySegmentControl.h"

@implementation MySegmentControl

-(id)initWithItems:(NSArray *)items offColor:(UIColor*)offcolor onColor:(UIColor*)oncolor {
    if (self = [super initWithItems:items]) {
        hasSetSelectedIndexOnce = NO;
        [self setInitialMode];
        [self setSelectedSegmentIndex:0];  // default to first button, or the coloring gets all whacked out :(
    }
    return self;
}

-(void)setInitialMode
{
    // set essential properties
    [self setBackgroundColor:[UIColor clearColor]];
    // loop through children and set initial tint
    for( int i = 0; i < [self.subviews count]; i++ )
    {
        [[self.subviews objectAtIndex:i] setTintColor:nil];
        [[self.subviews objectAtIndex:i] setTintColor:offColor];
    }
    
    // listen for updates
    [self addTarget:self action:@selector(setToggleHiliteColors) forControlEvents:UIControlEventValueChanged];
}

-(void)setToggleHiliteColors
{
    // get current toggle nav index
    int index = (int)self.selectedSegmentIndex;
    int numSegments = (int)[self.subviews count];
    
    for( int i = 0; i < numSegments; i++ )
    {
        // reset color
        [[self.subviews objectAtIndex:i] setTintColor:nil];
        [[self.subviews objectAtIndex:i] setTintColor:offColor];
    }
    
    if( hasSetSelectedIndexOnce )
    {
        [[self.subviews objectAtIndex: numSegments - 1 - index] setTintColor:onColor];
    }
    else
    {
        [[self.subviews objectAtIndex: index] setTintColor:onColor];
        hasSetSelectedIndexOnce = YES;
    }
    
}

@end
