<style type="text/css">

div.flash-error, div.flash-notice, div.flash-success
{
	padding:.8em;
	margin-bottom:1em;
	border:2px solid #ddd;
}

div.flash-error
{
	background:#FBE3E4;
	color:#8a1f11;
	border-color:#FBC2C4;
}

div.flash-notice
{
	background:#FFF6BF;
	color:#514721;
	border-color:#FFD324;
}

div.flash-success
{
	background:#E6EFC2;
	color:#264409;
	border-color:#C6D880;
}

div.flash-error a
{
	color:#8a1f11;
}

div.flash-notice a
{
	color:#514721;
}

div.flash-success a
{
	color:#264409;
}
div.form .errorMessage
{
	color: red;
	font-size: 0.9em;
}

div.form .errorSummary p
{
	margin: 0;
	padding: 5px;
}

div.form .errorSummary ul
{
	margin: 0;
	padding: 0 0 0 20px;
}

</style>
<?php
$this->breadcrumbs=array(
	ucfirst($this->module->id)=>array('mailbox/inbox'),
	'Message',
);

$this->renderPartial('_menu'); 

$subject = ($conv->subject)? $conv->subject : $this->module->defaultSubject;

if(strlen($subject) > 100)
{
	$subject = substr($subject,0,100);
}

?>
<div class="mailbox-message-list">


<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="mailbox-message-subject  mailbox-ellipsis"><?php echo $subject; ?></div>

<br />
<?php
$first_message=1;
foreach($conv->messages as $msg): 
	
	$sender = $this->module->getUserName($msg->sender_id);
	if(!$sender)
		$sender = $this->module->deletedUser;
	?>

	<div class="mailbox-message-header">
		<div class="message-sender">
<?php	echo ($msg->sender_id == Yii::app()->session['login']['id'])? 'You' : ucfirst($sender);
	echo ($first_message)? ' said' : ' replied'; ?></div>
		<div class="message-date"><?php echo date("d-M-Y H:i a",$msg->created); ?></div>
		<br />
	</div>
	<div class="mailbox-message-text"><?php echo $msg->text; ?></div>
	<br />
<?php $first_message=0;
endforeach; 

if($this->module->authManager)
	$authReply = Yii::app()->user->checkAccess("Mailbox.Message.Reply");
else
	$authReply = $this->module->sendMsgs;

if($authReply)
{

$form=$this->beginWidget('CActiveForm', array(
    'action'=>$this->createUrl('message/reply',array('id'=>$_GET['id'])),
    'id'=>'message-reply-form',
    'enableAjaxValidation'=>false,
)); ?>
	<div class="mailbox-message-reply ui-helper-clearfix">
	<?php /* echo $form->errorSummary(array($reply,$conv));*/ ?>
	<?php echo $form->error($reply,'text'); ?>
		<div class="mailbox-textarea-wrap ui-helper-clearfix">
			<textarea name="text" cols="50" rows="7" placeholder="Reply here..."></textarea>
		</div>
	<input type="submit" class="btn btn-large mailbox-input" value="Send Reply" />
	</div>



<?php $this->endWidget(); 
}
?>
</div>

