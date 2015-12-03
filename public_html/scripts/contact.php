<?php

if(!$_POST) exit;

$address = "kontakt@moveman.pl";

function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

$name     = $_POST['name'];
$email    = $_POST['email'];
$subject  = $_POST['subject'];
$msg      = $_POST['msg'];

if(trim($name) == '') {
	echo '<div class="error_message">Proszę podać imię.</div>';
	exit();
} else if(trim($email) == '') {
	echo '<div class="error_message">Proszę podać poprawny adres e-mail.</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">Podano niepoprawny adres e-mail.</div>';
	exit();
} else if(trim($msg) == '') {
	echo '<div class="error_message">Proszę wpisać wiadomość.</div>';
	exit();
} 

if(get_magic_quotes_gpc()) {
	$msg = stripslashes($msg);
}

$e_subject = 'Skontaktował się z Tobą ' . $name . '.';
$e_body = "Skontaktował się z Tobą $name. W swojej wiadomości napisał:\r\n";
$e_content = "\"" . trim($msg) . "\"\r\n";
$e_reply = "$name zostawił swój adres e-mail: $email";
$msg = $e_body . $e_content . $e_reply;

$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/plain; charset=utf-8";
$headers[] = "Content-Transfer-Encoding: 8bit";
$headers[] = "From: $email";
$headers[] = "Reply-To: $email";

if(mail($address, '=?utf-8?B?'.base64_encode($e_subject).'?=', $msg, implode("\r\n", $headers))){;
    echo "<div class='success_message'>Dzięki <strong>$name</strong>, Twoja wiadomość została wysłana.</div>";
} else {
	echo 'Błąd!';
}