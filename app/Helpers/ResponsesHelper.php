<?php

function error($code, $message, $err_code = '')
{
	if(is_array($message)){
		if($code != 200){
			$message['err_code'] = $err_code;
			$message['err_msg'] = error_msg($err_code);
		}
		return response($message, $code);
	}

    $msg = [];
    if($code != 200){
        $msg['err_code'] = $err_code;
        $msg['err_msg'] = error_msg($err_code);
    }
    $msg['message'] = $message;
    return response($msg, $code);
}

function error_msg($code = '01'){
	$err_msg = '';
	switch ($code) {
		case '01':
			$err_msg = 'Login failed';
			break;
		
		case '02':
			$err_msg = 'Login user not active';
			break;
		
		case '03':
			$err_msg = 'Login user banned';
			break;
		
		case '04':
			$err_msg = 'Token not created';
			break;
		
		case '05':
			$err_msg = 'User not found';
			break;
		
		case '06':
			$err_msg = 'Invalid Parameters';
			break;
		
		case '07':
			$err_msg = 'User already active';
			break;
		
		case '08':
			$err_msg = 'SMS failed to send';
			break;
		
		case '09':
			$err_msg = 'Verification code not match';
			break;
		
		default:
			break;
	}

	return $err_msg;
}