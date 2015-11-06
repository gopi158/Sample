<?php
define('host', 'http://shop.finaonationqa.com/api/soap/?wsdl');
define('username', 'apiintegrator');
define('password', 'ap11ntegrator');

define('INVALID_USERNAME_PWD','Invalid username and password');
define('UNUTHORISED_USER','Unauthorized User');
define('NO_RESULT','0 result found.');
define('USER_LOGGED_IN','User succesfully logged in');
define('USER_REGISTERED','User succesfully registered');
define('USER_ALREADY_REGISTERED','User already registered');
define('ACCOUNTS_MAPPED','Both the accounts are mapped');
define('FINAO_FACEBOOK_USER_CREATED','User registered with Facebook Plugin');

define('DOCUMENT_ROOT', realpath(dirname(__FILE__) . '/../'));
define('UPLOAD_PATH', DOCUMENT_ROOT.DIRECTORY_SEPARATOR.'images/uploads/');
define('PROFILE_IMG_PATH', UPLOAD_PATH.'profileimages/');


define('FINAO_STATUS_UPDATE', 'Finao Status Updated');
define('FINAO_DATA_UPLOAD', 'Data uploaded successfully');
define('NONE', 1000);
define('GENERIC', 1001);
define('PARAMETERIZED', 1002);
define('SQL', 1003);
define('DATA', 1004);
define('WRONG_DATA', 'Wrong data entered.');
define('SQL_ERROR', 'Database error');



function getErrorMessage($code){
	$result = "";
	switch($code){
		case 2001:
			$result = 'User does not exist!';
			break;
		case 2002:
			$result = 'New password and confirm password are not same!';
			break;
		case 2003:
			$result = 'Old password does not match';
		case 2004:
			$result = 'Not a valid input!';
			break;
		case 2005:
			$result = 'This post does not exists!';
			break;
		case 2006:
			$result = 'This post has already been deleted!';
			break;
		case 2007:
			$result = 'You have already marked this post inappropriate!';
			break;
		case 2008:
			$result = 'You are already inspired by this post!';
			break;
		case 2009:
			$result = 'This finao does not exist!';
			break;
		case 2010:
			$result = 'This tile does not exist!';
			break;
		case 2011:
			$result = 'You are already following this !';
				break;
		case 1000:
			$result = 'success';
			break;
		default :
			$result = '';
			break;
	}

	return $result;
}



?>