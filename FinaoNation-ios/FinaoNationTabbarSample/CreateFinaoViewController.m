//
//  CreateFinaoViewController.m
//  FinaoNationTabbarSample
//
//  Created by FinaoNationon 07/01/14.
//  Copyright (c) 2013-14 FinaoNation. All rights reserved.
//

#import "CreateFinaoViewController.h"
#import "AppDelegate.h"
#import "AppConstants.h"
#import "GetTiles.h"
#import "SearchCell.h"
#import "UIImageView+AFNetworking.h"


@interface CreateFinaoViewController ()
{
    GetTiles* gettiles;
    BOOL NOTiles;
}
@end

@implementation CreateFinaoViewController
@synthesize kAdjust;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Create a new FINAO";
    }
    return self;
}

-(void)viewWillAppear:(BOOL)animated
{
    
    [super viewWillAppear:animated];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(GetFinaoID:)
                                                 name:@"GETFINAOID"
                                               object:nil];
    
    //FOR GETTING FINAO LIST
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(PostImageToServer:)
                                                 name:@"POSTIMAGETOSERVERDONE"
                                               object:nil];
    
}

-(void)viewWillDisappear:(BOOL)animated
{
    
    [super viewWillDisappear:animated];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:@"GETFINAOID"
                                                  object:nil];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:@"POSTIMAGETOSERVERDONE"
                                                  object:nil];
    
}
-(void)PostImageToServer:(NSNotification *) notification{
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"POSTIMAGETOSERVERDONE" object:nil];
    
    [self.navigationController popToRootViewControllerAnimated:YES];
}

-(void)PostImageForWhileFinaoCreate{
    
    NSData* imgdata = [[NSData alloc]initWithData:UIImageJPEGRepresentation(Finaoimgview.image,0)];
    NSDate *now = [[NSDate alloc] init];
    NSDateFormatter *format = [[NSDateFormatter alloc] init];
    [format setDateFormat:@"MMddHHmmss"];
    NSString* fileName =[NSString stringWithFormat:@"%@.jpg",[format stringFromDate:now]];
    
    //NSLog(@"Filename:%@",fileName);
    
    uploadImage = [[UploadFinaoImageCreateFinao alloc]init];
    [uploadImage PostImageForCreateFinao:[USERDEFAULTS valueForKey:@"userid"] ImgData:imgdata ImgName:fileName Finaoid:[NSString stringWithFormat:@"%@",CreatedFinaID] CaptionData:@"" upload_text:@""];
}

-(void)GetFinaoID:(NSNotification *) notification{
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETFINAOID" object:nil];
    
    CreatedFinaID = [createFinao.ListDic objectForKey:@"finao_id"];
    //NSLog(@"CreatedFinaID:%@",CreatedFinaID);
    if (Finaoimgview.image != nil) {
        //NSLog(@"IMAGE PRESENT");
        [self PostImageForWhileFinaoCreate];
    }
    else{
        //NSLog(@"IMAGE NOT PRESENT");
    }
    //;
    [self.navigationController popToRootViewControllerAnimated:YES];
    [APPDELEGATE gotoProfile];
}

-(void)getTilesList{
    [APPDELEGATE showHToastCenter:@"Loading..."];
    dispatch_async(dispatch_get_main_queue(), ^ {
        [[NSNotificationCenter defaultCenter] addObserver:self
                                                 selector:@selector(GotTiLesListinDictionary:)
                                                     name:@"GETTILESLIST"
                                                   object:nil];
        gettiles = [[GetTiles alloc]init];
        [gettiles GetTilesListFromServer];
    } );
}

-(void)GotTiLesListinDictionary:(NSNotification *) notification
{
    TilesArray = gettiles.TilesListDic;
    NSLog(@"TilesArray:%@",TilesArray);
    
    [[NSNotificationCenter defaultCenter] removeObserver:self name:@"GETTILESLIST" object:nil];
    if ([TilesArray count] == 0) {
        [TilesArray addObject:@"No Items Found."];
        [APPDELEGATE showHToast:@"No Items Found."];
        NOTiles = YES;
    }
    else if ([TilesArray count] > 0){
        NOTiles = NO;
        [TileTable reloadData];
    }
}

-(void)PostFinaoCreate{
    
    BOOL IsPublic;
    if ([Pub_Priv_Lbl.text isEqualToString:@"Public"])
        IsPublic = NO;
    else
        IsPublic = YES;
    [APPDELEGATE showHToastCenter:@"Creating Finao..."];
    createFinao = [[CreateFinaoPost alloc]init];
    [createFinao GetFinaoID:[USERDEFAULTS valueForKey:@"userid"] Public:IsPublic FinaoText:txtview.text TileID:TileIDStr TileName:TileIDnameStr CaptionTxt:@""];
}

-(void)BackClicked{
    [self.navigationController popViewControllerAnimated:YES];
}

-(void)DoneClicked{
    [txtview resignFirstResponder];
    if (isTablecellSelected) {
        if (![txtview.text isEqualToString:@"I will..."]){
            [self PostFinaoCreate];
        }
        else{
            [APPDELEGATE showHToastBottom:@"Please Enter Finao title."];
        }
        
    }
    else{
                    [APPDELEGATE showHToastBottom:@"Please Choose a Tile"];

    }
}

-(void)FinaoImgbtnClicked{
    
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Select Photos from"
                                                             delegate:self cancelButtonTitle:nil destructiveButtonTitle:nil
                                                    otherButtonTitles:@"Take Photo With Camera", @"Select Photo From Library", @"Cancel", nil];
    actionSheet.actionSheetStyle = UIActionSheetStyleAutomatic;
    actionSheet.destructiveButtonIndex = 1;
    [actionSheet showInView:self.view];
}

- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex == 0)
    {
        [self takeNewPhotoFromCamera];
    }
    else if (buttonIndex == 1)
    {
        [self choosePhotoFromExistingImages];
    }
    
    else if (buttonIndex == 2)
    {
        //NSLog(@"cancel");
    }
}

- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    
	[picker dismissViewControllerAnimated:YES completion:nil];
    
    Finaoimgview.image = [info objectForKey:@"UIImagePickerControllerOriginalImage"];
    
    
}
- (void)takeNewPhotoFromCamera
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypeCamera])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypeCamera;
        controller.allowsEditing = NO;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypeCamera];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }else{
        [APPDELEGATE showHToastBottom:@"Camera not available"];
    }
}
-(void)choosePhotoFromExistingImages
{
    if ([UIImagePickerController isSourceTypeAvailable: UIImagePickerControllerSourceTypePhotoLibrary])
    {
        UIImagePickerController *controller = [[UIImagePickerController alloc] init];
        controller.sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        controller.allowsEditing = NO;
        controller.mediaTypes = [UIImagePickerController availableMediaTypesForSourceType: UIImagePickerControllerSourceTypePhotoLibrary];
        controller.delegate = self;
        [self.navigationController presentViewController: controller animated: YES completion: nil];
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Create" style:UIBarButtonItemStyleBordered target:self action:@selector(DoneClicked)];
        self.navigationItem.leftBarButtonItem = [[UIBarButtonItem alloc]initWithTitle:@"Cancel" style:UIBarButtonItemStyleBordered target:self action:@selector(BackClicked)];
    
    [self.navigationItem.rightBarButtonItem setTitleTextAttributes:
     [NSDictionary dictionaryWithObjectsAndKeys:
      [UIColor orangeColor], NSForegroundColorAttributeName,nil]
                                                          forState:UIControlStateNormal];
    [self.navigationItem.leftBarButtonItem setTitleTextAttributes:
     [NSDictionary dictionaryWithObjectsAndKeys:
      [UIColor orangeColor], NSForegroundColorAttributeName,nil]
                                                          forState:UIControlStateNormal];
    TileIDStr = [[NSString alloc]init];
    TileIDnameStr = [[NSString alloc]init];
    CreatedFinaID = [[NSString alloc]init];
    
    Finaoimgview = [[UIImageView alloc]init ];
    Finaoimgview.frame = CGRectMake(10, 10 + kAdjust, 90, 90);
    Finaoimgview.layer.borderColor = [UIColor grayColor].CGColor;
    Finaoimgview.layer.borderWidth = 1.0f;
    Finaoimgview.layer.cornerRadius = 2.0f;
    [self.view addSubview:Finaoimgview];
    
    UIButton* FinaoImgBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    FinaoImgBtn.frame = CGRectMake(10, 10 + kAdjust, 90, 90);
    [FinaoImgBtn addTarget:self action:@selector(FinaoImgbtnClicked) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:FinaoImgBtn];
    
    txtview = [[UITextView alloc]init ];
    txtview.frame = CGRectMake(120, 30 + kAdjust, 180, 40);
    txtview.text = @"I will...";
    txtview.textColor = [UIColor lightGrayColor];
    txtview.delegate = self;
    [self.view addSubview:txtview];
    
    UILabel* PictureLbl = [[UILabel alloc]initWithFrame:CGRectMake(10, 80 + kAdjust, 90, 20)];
    PictureLbl.text = @"Choose a picture";
    PictureLbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:8.0f];
    PictureLbl.textColor = [UIColor whiteColor];
    PictureLbl.layer.cornerRadius = 2.0f;
    PictureLbl.textAlignment = NSTextAlignmentCenter;
    PictureLbl.backgroundColor = [UIColor blackColor];
    [self.view addSubview:PictureLbl];
    
    Pub_Priv_Lbl = [[UILabel alloc]initWithFrame:CGRectMake(100, 80 + kAdjust, 90, 20)];
    Pub_Priv_Lbl.text = @"Public";
    Pub_Priv_Lbl.font = [UIFont fontWithName:@"HelveticaNeue-Light" size:15.0f];
    Pub_Priv_Lbl.textColor = [UIColor orangeColor];
    Pub_Priv_Lbl.textAlignment = NSTextAlignmentCenter;
    [self.view addSubview:Pub_Priv_Lbl];
    
    UISwitch *onoff = [[UISwitch alloc] initWithFrame: CGRectMake(220, 75 + kAdjust, 50, 20)];
    [onoff addTarget: self action: @selector(Switchflipped) forControlEvents:UIControlEventValueChanged];
    onoff.onTintColor = [UIColor orangeColor];
    [self.view addSubview: onoff];
    
    TileTable = [[UITableView alloc]initWithFrame:CGRectMake(0, 130 + kAdjust, 320, self.view.frame.size.height-180) style:UITableViewStylePlain];
    TileTable.delegate = self;
    TileTable.dataSource = self;
    [self.view addSubview:TileTable];
    TileTable.tableFooterView = [[UIView alloc]init];
    
    UILabel* ChooseTileLbl = [[UILabel alloc]initWithFrame:CGRectMake(0, 110 + kAdjust, 320, 20)];
    ChooseTileLbl.text = @"Choose a Tile";
    ChooseTileLbl.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:14.0f];
    ChooseTileLbl.textColor = [UIColor whiteColor];
    ChooseTileLbl.textAlignment = NSTextAlignmentCenter;
    ChooseTileLbl.backgroundColor = [UIColor lightGrayColor];
    [self.view addSubview:ChooseTileLbl];
    
    TilesArray = [[NSMutableArray alloc]init];
    [APPDELEGATE showHToastCenter:@"Loading..."];
    //[self GetTypeofTiles];
    [self getTilesList];
}
-(void)GetTypeofTiles{
    Servermanager* webservice = [[Servermanager alloc]init];
    webservice.delegate = self;
    [webservice GetDefaultTile:[USERDEFAULTS valueForKey:@"userid"]];
}

#pragma mark WEBservice delegate
-(void) webServiceFinishWithDictionary:(NSMutableDictionary *)data withError:(NSError *) error
{
    //NSLog(@"DATA : %@ ",data);
    
    if ([[data objectForKey:@"item"] isKindOfClass:[NSString class]]) {
        //NSLog(@"NSSTRING TYPE");
        
    }
    else
        if ([[data objectForKey:@"item"] isKindOfClass:[NSArray class]]) {
            //NSLog(@"NSARRAY TYPE");
            TilesArray = [data objectForKey:@"item"];
        }
    
    [TileTable reloadData];
}
-(void) webServiceFinishedWithcode:(NSInteger)statusCode withMessage:(NSString *)message
{
    
}

-(void)Switchflipped{
    
    if ([Pub_Priv_Lbl.text isEqualToString:@"Public"]) {
        Pub_Priv_Lbl.text = @"Private";
    }else
    {
        Pub_Priv_Lbl.text = @"Public";
    }
}
- (void)textViewDidBeginEditing:(UITextView *)textView
{
    if ([textView.text isEqualToString:@"I will..."]) {
        txtview.text = @"";
        txtview.textColor = [UIColor blackColor];
    }
    [txtview becomeFirstResponder];
}


- (void)textViewDidEndEditing:(UITextView *)textView
{
    if ([textView.text isEqualToString:@""]) {
        textView.text = @"I will...";
        textView.textColor = [UIColor lightGrayColor];
    }
    [textView resignFirstResponder];
}

- (BOOL)textView:(UITextView *)textView shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text {
    
    if([text isEqualToString:@"\n"]) {
        [textView resignFirstResponder];
        return NO;
    }
    
    return YES;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [TilesArray count];
}

-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 55.0f;
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    NSDictionary *tempDict = [TilesArray objectAtIndex:indexPath.row];
    SearchCell* cell = (SearchCell *)[tableView dequeueReusableCellWithIdentifier:@"Cell"];
    if(cell == nil)
        cell = [[SearchCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"Cell"];
    
    //NSLog(@"tempDict:%@",tempDict);
    cell.SearchName.text = [NSString stringWithFormat:@"%@",[tempDict objectForKey:@"tile_name"]];
    if ([tempDict objectForKey:@"tile_image"] == nil || [tempDict objectForKey:@"tile_image"] == NULL || [tempDict objectForKey:@"image"]  == [NSNull null]) {
        cell.SearchImageview.image  = [UIImage imageNamed:@"No_Image@2x"];
    }
    else{
        NSString* imageUrl = [NSString stringWithFormat:@"%@%@",@"",[tempDict objectForKey:@"tile_image"]];
        [cell.SearchImageview setImageWithURL:[NSURL URLWithString:imageUrl] placeholderImage:[UIImage imageNamed:@"profile"]];
    }
    cell.SearchName.font = [UIFont systemFontOfSize:20.0f];
    cell.selectionStyle = UITableViewCellSelectionStyleNone;
    cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    
    NSDictionary *tempDict = [TilesArray objectAtIndex:indexPath.row];
    
    UITableViewCell* newCell = [tableView cellForRowAtIndexPath:indexPath];
    int newRow = (int)[indexPath row];
    int oldRow = (int)(lastIndexPath != nil) ? (int)[lastIndexPath row] : -1;
    
    if(newRow != oldRow)
    {
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
        UITableViewCell* oldCell = [tableView cellForRowAtIndexPath:lastIndexPath];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        lastIndexPath = indexPath;
        //NSLog(@"INDEX SELECTED:%ld",(long)indexPath.row);
        isTablecellSelected = YES;
    }else if(newRow == oldRow){
        newCell.accessoryType = UITableViewCellAccessoryNone;
        UITableViewCell* oldCell = [tableView cellForRowAtIndexPath:lastIndexPath];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        lastIndexPath = 0;
        isTablecellSelected = NO;
        
    }
    
    if (isTablecellSelected) {
        //NSLog(@"Tablecell selected");
        TileIDnameStr = [tempDict objectForKey:@"tile_name"];
        TileIDStr = [tempDict objectForKey:@"tile_id"];
        [self DoneClicked];
        
    }
    else{
        //NSLog(@"Tablecell NOT SELECTED");
        
    }
    
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
