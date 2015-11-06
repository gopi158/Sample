//
//  igViewController.m
//  ScanBarCodes
//
//  Created by FINAO
//  Copyright (c) 2013-14 FINAO Nation
//

#import <AVFoundation/AVFoundation.h>
#import "FinaoQRScanViewController.h"
#import "QRWebViewController.h"

@interface FinaoQRScanViewController () <AVCaptureMetadataOutputObjectsDelegate>
{
    AVCaptureSession *_session;
    AVCaptureDevice *_device;
    AVCaptureDeviceInput *_input;
    AVCaptureMetadataOutput *_output;
    AVCaptureVideoPreviewLayer *_prevLayer;

    UIView *_highlightView;
    UILabel *_label;
}
@end

@implementation FinaoQRScanViewController

//static dispatch_once_t once;

#pragma mark - View lifecycle
- (void)didMoveToParentViewController:(UIViewController *)parent
{

}

- (void)willMoveToParentViewController:(UIViewController *)parent
{

}

- (void)didLeaveParentViewController:(UIViewController *)parent
{
    [self deallocSession];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self StartScanningQR];
}

-(void) StartScanningQR{

    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Stop" style:UIBarButtonItemStylePlain target:self action:@selector(stopScanning)];
    
    _highlightView = [[UIView alloc] init];
    _highlightView.autoresizingMask = UIViewAutoresizingFlexibleTopMargin|UIViewAutoresizingFlexibleLeftMargin|UIViewAutoresizingFlexibleRightMargin|UIViewAutoresizingFlexibleBottomMargin;
    _highlightView.layer.borderColor = [UIColor greenColor].CGColor;
    _highlightView.layer.borderWidth = 3;
    [self.view addSubview:_highlightView];
    
    _label = [[UILabel alloc] init];
    if (NSFoundationVersionNumber > NSFoundationVersionNumber_iOS_6_1) {
        _label.frame = CGRectMake(0, self.view.bounds.size.height - 80, self.view.bounds.size.width, 40);
    }
    else{
        _label.frame = CGRectMake(0, self.view.bounds.size.height - 40, self.view.bounds.size.width, 40);
    }
    _label.autoresizingMask = UIViewAutoresizingFlexibleTopMargin;
    _label.backgroundColor = [UIColor colorWithWhite:0.15 alpha:0.65];
    _label.textColor = [UIColor whiteColor];
    _label.textAlignment = NSTextAlignmentCenter;
    _label.hidden = YES;
    _label.text = @"(Please point to a QR and hold)";
    [self.view addSubview:_label];
    
    _session = [[AVCaptureSession alloc] init];
    _device = [AVCaptureDevice defaultDeviceWithMediaType:AVMediaTypeVideo];
    NSError *error = nil;
    
    _input = [AVCaptureDeviceInput deviceInputWithDevice:_device error:&error];
    if (_input) {
        [_session addInput:_input];
    } else {
        //NSLog(@"Error: %@", error);
    }
    
    _output = [[AVCaptureMetadataOutput alloc] init];
    [_output setMetadataObjectsDelegate:self queue:dispatch_get_main_queue()];
    [_session addOutput:_output];
    
    _output.metadataObjectTypes = [_output availableMetadataObjectTypes];
    
    _prevLayer = [AVCaptureVideoPreviewLayer layerWithSession:_session];
    _prevLayer.frame = self.view.bounds;
    _prevLayer.videoGravity = AVLayerVideoGravityResizeAspectFill;
    [self.view.layer addSublayer:_prevLayer];
    
    [_session startRunning];
    
    [self.view bringSubviewToFront:_highlightView];
    [self.view bringSubviewToFront:_label];
}

-(void) stopScanning{
    [_session stopRunning];
    [_session removeOutput:_output];
    [_session removeInput:_input];
    [_session stopRunning];
    _label.text = @"(Please point to a QR and hold)";
    [self deallocSession];
    
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Start" style:UIBarButtonItemStylePlain target:self action:@selector(StartScanningQR)];


}
- (void)captureOutput:(AVCaptureOutput *)captureOutput didOutputMetadataObjects:(NSArray *)metadataObjects fromConnection:(AVCaptureConnection *)connection
{
    CGRect highlightViewRect = CGRectZero;
    AVMetadataMachineReadableCodeObject *barCodeObject;
    NSString *detectionString = nil;
    NSArray *barCodeTypes = @[AVMetadataObjectTypeUPCECode, AVMetadataObjectTypeCode39Code, AVMetadataObjectTypeCode39Mod43Code,
            AVMetadataObjectTypeEAN13Code, AVMetadataObjectTypeEAN8Code, AVMetadataObjectTypeCode93Code, AVMetadataObjectTypeCode128Code,
            AVMetadataObjectTypePDF417Code, AVMetadataObjectTypeQRCode, AVMetadataObjectTypeAztecCode];

    for (AVMetadataObject *metadata in metadataObjects) {
        for (NSString *type in barCodeTypes) {
            if ([metadata.type isEqualToString:type])
            {
                barCodeObject = (AVMetadataMachineReadableCodeObject *)[_prevLayer transformedMetadataObjectForMetadataObject:(AVMetadataMachineReadableCodeObject *)metadata];
                highlightViewRect = barCodeObject.bounds;
                detectionString = [(AVMetadataMachineReadableCodeObject *)metadata stringValue];
                break;
            }
        }

        if (detectionString != nil)
        {
            _label.text = detectionString;
            
//            UIAlertView* alert = [[UIAlertView alloc]initWithTitle:@"FINAO" message:[NSString stringWithFormat:@"QR code scanned is %@",_label.text] delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
//            [alert show];
//
            
//            _highlightView.frame = highlightViewRect;
//            [_session stopRunning];
            [self deallocSession];
            [self stopScanning];
            [[UIApplication sharedApplication] openURL:[NSURL URLWithString:detectionString]];

            [self StartScanningQR];
            
            
//            static dispatch_once_t once;
//           dispatch_once(&once, ^
//                          {
//                              QRWebViewController* qRWebViewController = [[QRWebViewController alloc]init];
//                              qRWebViewController.urlAddress = detectionString;
//                              [self.navigationController pushViewController:qRWebViewController animated:YES];
//                          });

            
//            return;
        }
        else
            _label.text = @"(Please point to a QR and hold)";
    }

    
//    _highlightView.frame = highlightViewRect;
    


}
-(void)deallocSession
{
    [_prevLayer removeFromSuperlayer];
    for(AVCaptureInput *input1 in _session.inputs) {
        [_session removeInput:input1];
    }
    
    for(AVCaptureOutput *output1 in _session.outputs) {
        [_session removeOutput:output1];
    }
    [_session stopRunning];
    _session=nil;
    _output=nil;
    _device=nil;
    _input=nil;
    _prevLayer=nil;
    
}
@end