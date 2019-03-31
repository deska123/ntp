<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer-master/src/Exception.php';
	require 'PHPMailer-master/src/PHPMailer.php';
	require 'PHPMailer-master/src/SMTP.php';

	date_default_timezone_set("Asia/Jakarta");
	$dateTimeNow = date("l d-m-Y H:i:s");

	//Taken from https://www.virendrachandak.com/techtalk/getting-real-client-ip-address-in-php-2/
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'Unknown';
    }

	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = test_input($_POST['nameInput']);
			$email = test_input($_POST['emailInput']);
			$comments = test_input($_POST['commentsInput']);

			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer(true);
			$mail2 = new PHPMailer(true);

			try {
			    //Server settings
				$mail->SMTPOptions = array(
				    'ssl' => array(
				    'verify_peer' => false,
				    'verify_peer_name' => false,
				    'allow_self_signed' => true
					)
				);
			    $mail->isSMTP();                                            // Set mailer to use SMTP
			    $mail->Host       = '';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = '';                     // SMTP username
			    $mail->Password   = '';                               // SMTP password
			    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			    $mail->Port       = 80;                                    // TCP port to connect to
			    $mail2->SMTPOptions = array(
				    'ssl' => array(
				    'verify_peer' => false,
				    'verify_peer_name' => false,
				    'allow_self_signed' => true
					)
				);
			    $mail2->isSMTP();                                            // Set mailer to use SMTP
			    $mail2->Host       = '';  // Specify main and backup SMTP servers
			    $mail2->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail2->Username   = '';                     // SMTP username
			    $mail2->Password   = '';                               // SMTP password
			    $mail2->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			    $mail2->Port       = 80;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom('', '');
			    $mail->addAddress($email);     // Add a recipient
			    $mail2->setFrom('', '');
			    $mail2->addAddress('');     // Add a recipient

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Your Comments on NTP Website';
			    $mail2->isHTML(true);                                  // Set email format to HTML
			    $mail2->Subject = 'Comments sent on ' . $dateTimeNow;

  				$confirmEmailBody = "
	  				<h2>Here is detail of your comment sent to NTP Website</h2>
					<img src=\"\" alt=\"Email Image\" style=\"width:100%\">
					<h2>Nariska Tresnandy Pratama</h2>
					<ul>
						<li>
							<p><u>Your Name</u></p>
							<p>" . $name . "</p>
						</li>
						<li>
							<p><u>Your Email</u></p>
							<p>" . $email . "</p>
						</li>
						<li>
							<p><u>Your IP Address</u></p>
							<p>" . $ipaddress . "</p>
						</li>
						<li>
							<p><u>Your Comment</u></p>
							<p>" . $comments . "</p>
						</li>
					</ul>
					<div>Sent on " . $dateTimeNow . "</div>
  				";

  				$sentEmailBody = "
	  				<h2>Here is detail of comment sent to NTP Website</h2>
					<img src=\"\" alt=\"Email Image\" style=\"width:100%\">
					<h2>Nariska Tresnandy Pratama</h2>
					<ul>
						<li>
							<p><u>Name</u></p>
							<p>" . $name . "</p>
						</li>
						<li>
							<p><u>Email</u></p>
							<p>" . $email . "</p>
						</li>
						<li>
							<p><u>IP Address</u></p>
							<p>" . $ipaddress . "</p>
						</li>
						<li>
							<p><u>Comment</u></p>
							<p>" . $comments . "</p>
						</li>
					</ul>
					<div>Sent on " . $dateTimeNow . "</div>
  				";

			    $mail->Body    = $confirmEmailBody;
			    $mail2->Body    = $sentEmailBody;

			    $mail->AltBody = 'Here is detail of your comment : [Name] ' . $name . ' ; [Email] ' . $email . ' ; [IP Address] ' . $ipaddress . ' ; [Comments] ' . $comments;
			    $mail2->AltBody = 'Here is detail of comment sent to NTP Website : [Name] ' . $name . ' ; [Email] ' . $email . ' ; [IP Address] ' . $ipaddress . ' ; [Comments] ' . $comments;

			    $mail->send();
			    $mail2->send();

			    echo 'Success';
			} catch (Exception $e) {
			    echo "Failed";
			}
		}
	} else {
		header("Location: index.html");
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>