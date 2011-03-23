<?
include_once('class.phpmailer.php');
function send_mail($mailto, $from, $reply, $subject, $mailcontent, $attachment) {
	
	$mail = new PHPMailer();


	
	
	if (!is_array($mailto)) {
		$mail->AddAddress($mailto);
	} else {
		foreach($mailto as $m) {
			$mail->AddAddress($m);
		}
	}
	
	$from = split('->',$from);
	
	$reply = split('->',$reply);
	
	$mail->SetFrom($from[0],$from[1]);
	$mail->AddReplyTo($replay[0],$replay[1]);
	$mail->Subject = $subject;
	$mail->MsgHTML($mailcontent);
	if(file_exists($attachment)) {
		$mail->AddAttachment($attachment);
	}
	
	
	if(!$mail->Send()) {
		return false;
	} else {
		return true;
	}
							
}
?>