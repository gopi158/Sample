//
//  ApplicationConstants.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNation on 01/04/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "ApplicationConstants.h"

@implementation ApplicationConstants



+(BOOL)checkNull :(id)objectToBeChecked{
    
    if (objectToBeChecked == NULL || objectToBeChecked == Nil || objectToBeChecked == nil ||[ objectToBeChecked isKindOfClass:[NSNull class]]) {
        
        return  TRUE;
        
    }
    
    return FALSE;
    
}



@end
