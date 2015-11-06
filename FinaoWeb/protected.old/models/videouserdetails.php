<link href="<?php echo $this->cdnurl;?>/css/hbcu.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/oswald/stylesheet.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/barkentina/stylesheet.css" type="text/css" media="screen" />

<div style="background-color:#fff; padding:10px;" class="">

<form id="form1" name="form1" method="post" action="<?php echo Yii::app()->createUrl('finao/Contestuserdetails'); ?>">
  <table style="" align="center" width="400" border="1">
    <tr>
      <td colspan="2">One Step to Video Contest</td>
    </tr>
    <tr>
      <td><label for="school">School</label>*</td>
      <td>
      <input style="border:1px!important;" type="text" name="school" id="school" /></td>
    </tr>
    <tr>
      <td><label for="gyear">Graduation Year</label>*</td>
      <td>
        
        <input style="border:1px!important;" type="text" name="gyear" id="gyear" />
      </td>
    </tr>
    <tr>
      <td><label for="gyear">Major</label>*</td>
      <td><input style="border:1px!important;;" type="text" name="major" id="major" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="submit" /></td>
    </tr>
  </table>
  
  </form>
</div>