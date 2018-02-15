<?php
	// Message Var
	$msg = '';
	$msgClass = '';

	// Check for submit
	if(filter_has_var(INPUT_POST, 'submit')){
		// Get form data
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		// Check required fields
		if(!empty($email) && !empty($name) && !empty($message)) {
			// Passed
			// Check email
			if((filter_var($email, FILTER_VALIDATE_EMAIL) === false) || (IsInjected($email))) {
				// Failed
				$msg = 'Please use a valid email';
				$msgClass = 'alert-danger';
			} else {
				// Passed
				$officeEmail = 'amarellapudi@gmail.com';
				$subject = 'Message from: '.$name;
				$body = '<h3>Apollomedserives.com Wesbite Email Submission</h2>
						<h4>Name</h4><p>'.$name.'</p>
						<h4>Email</h4><p>'.$email.'</p>
						<h4>Message</h4><p>'.$message.'</p>
				';

				// Email headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

				// Additional Headers
				$headers .= "From: Apollo Medical Website <admin@apollomedicalservices.com> \r\n";
				$headers .= "Reply-To: $email \r\n";
				$headers .= "Return-Path: $officeEmail \r\n";

				if(mail($officeEmail, $subject, $body, $headers)) {
					// Email sent
					$msg = 'Your email has been sent';
					$msgClass = 'alert-success';
				} else {
					$msg = 'Your email was not sent';
					$msgClass = 'alert-danger';
				}
			}

		} else {
			// Failed
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger';
		}
	}

	// Function to validate against any email injection attempts
  	function IsInjected($str) {
    $injections = array('(\n+)',
                '(\r+)',
                '(\t+)',
                '(%0A+)',
                '(%0D+)',
                '(%08+)',
                '(%09+)'
                );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if(preg_match($inject,$str)) {
     	return true;
    } else {
     	return false;
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<meta name="description" content="Apollo Medical Services">
		<meta name="keywords" content="internal medicine">
		<meta name="author" content="Aniruddh Marellapudi">
		<meta name="format-detection" content="telephone=no">
		<title>Apollo Med Services</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="./img/logo_temp.png"/>
	</head>

	<body>	
		<header>
			<div class="container_large">
				<div id="branding">
					<h1><span class="highlight">Apollo</span> Medical <span class="highlight2">Services</span></h1>
				</div>
				<nav>
					<ul>
						<li><a href="index.html">Home</a></li>
						<li ><a href="locations.html">Locations</a></li>
						<li><a href="services_insurances.html">Services & Insurances</a></li>
						<li class="current"><a href="about_us.php">About & Contact</a></li>
					</ul>
				</nav>
			</div>
		</header>
		
		<section id="main">
			<div class="container_row" id="profiles">
				<div class="col-edge"></div>
				<div class="profile">
					<div class="pic_name">
						<img src="img\dr_srinivas_ravi.png">
						<h1><b>Srinivas M. Ravi, MD</b><br>
							Founder and Business Leader
						</h1>
					</div>
					<div class="info">
						<p><b>Education:</b> Armed Forces Medical College, Pune, Maharashtra, India</p>
						<p><b>Board Certified in Internal Medicine</b> and in practice for <b>over 15 years</b></p>
						<p><b>Affiliated With:</b> Montifiore Medicial Center North Division</p>
					</div>
				</div>
				<div class="col-sep"></div>
				<div class="profile">
					<div class="pic_name">
						<img src="img\dr_ramasita_pisipati.png">
						<h1><b>Ramasita Pispati, MD</b></h1>
					</div>
					<div class="info">
						<p><b>Education:</b> Government Medical College, Nagpur, Maharashtra, India</p>
						<p><b>Board Certified in Internal Medicine & Nephrology</b> and in practice for over <b>10 years</b></p>
						<p><b>Membership:</b> American College of Physicians, American Society of Nephrology</p>
						<p><b>Affiliated With:</b> Montifiore Medical Center North Division</p>
					</div>
				</div>
			</div>

			<div class="container_email">
				<div class="email_form">
					<div class="dark">
					<h3>
						If you are unable to reach our offices at (718) 231-2300 or (718) 708-6756, please contact us via email
					</h3>
					<p>We will get back to you as soon as possible!</p>
					<?php if($msg != ''): ?>
							<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
					<?php endif; ?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
							<label>Name</label>
							<br>
							<input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>" placeholder="First Last">
						</div>
						<div class="form-group">
							<label>Email</label>
							<br>
							<input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" placeholder="example@email.com">
						</div>
						<div class="form-group">
							<label>Message</label>
							<br>
							<textarea name="message" class="form-control" placeholder="Please enter message and please include your phone number"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Submit">
						</div>
						<br>
					</form>
					</div>
				</div>
			</div>
		</section>

		<footer>
			<p>Apollo Medical Services &copy; 2017</p>
		</footer>
	</body>
</html>
