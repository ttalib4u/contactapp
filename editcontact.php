<?php
	define("MY_STORAGE_FILE", "contact.txt");
?>

<html> 
   <head>
      <title>Edit Contact - <?php echo base64_decode($_GET['contact']); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="script.js"></script>
   </head> 
   <body> 
   
	<div style='width: 30%'>
		<a href='index.php'> < Back </a>
		<?php 
		if (isset($_GET['contact'])){
			$file = fopen(MY_STORAGE_FILE, "r+");
			$filesize = filesize(MY_STORAGE_FILE);
			$filetext = fread($file, $filesize);
			$contactlist = @explode(PHP_EOL, $filetext); $foundcontact = "no";
			for ($i=0; $i<count($contactlist); $i++){
				$contctdetail = @explode(',', $contactlist[$i]);
				if ($contctdetail[0] == base64_decode($_GET['contact'])){
					$contactphone = $contctdetail[0];
					$contactfirstname = $contctdetail[1];
					$contactlastname = $contctdetail[2];
					$contactemail = $contctdetail[3];
					
					$foundcontact = "yes"; break; 
				}
			}
			fclose($file);
			if ($foundcontact == 'yes'){
				$thecontact = $_GET['contact'];
		?>
			<h2>Edit Contact <font color=blue><?php echo base64_decode($_GET['contact']); ?></font><hr></h2>
			<?php
			
				if (isset($_POST['submit'])){
					if ($_POST['phone']){
						if ($_POST['firstname']){
							if ($_POST['lastname']){
								$file = fopen(MY_STORAGE_FILE, "r+");
								$filesize = filesize(MY_STORAGE_FILE);
								if ($filesize == 0){
									$filetext = "";
								}else{
									$filetext = fread($file, $filesize);
								}
								$contactlist = @explode(PHP_EOL, $filetext);
								$collectcomtact = ""; $alrexist = "no";
								
								for ($i=0; $i<count($contactlist); $i++){
									$contctdetail = @explode(',', $contactlist[$i]);
									
									if ($contctdetail[0] == $_POST['phone'] and $contctdetail[0] != base64_decode($_GET['contact'])){
										$alrexist = "yes"; break; 
									}
									
									if ($contctdetail[0] == $contactphone){
										if (!$collectcomtact){ $collectcomtact = $_POST['phone'].",".$_POST['firstname'].",".$_POST['lastname'].",".$_POST['email']; }
										else{ $collectcomtact .= PHP_EOL.$_POST['phone'].",".$_POST['firstname'].",".$_POST['lastname'].",".$_POST['email']; }
									}else{
										if (!$collectcomtact){ $collectcomtact = $contactlist[$i]; }else{ $collectcomtact .= PHP_EOL.$contactlist[$i]; }
									}
								}
								fclose($file);
								
								if ($alrexist == 'no'){
									$file = fopen(MY_STORAGE_FILE, "w");
									fwrite($file, $collectcomtact);
									fclose($file);
									
									$contactphone = $_POST['phone'];
									$contactfirstname = $_POST['firstname'];
									$contactlastname = $_POST['lastname'];
									$contactemail = $_POST['email'];
									$thecontact = base64_encode($_POST['phone']);
									
									echo "<div style='background: #10880d; color: white; padding: 10px;'><font size=4>Contact updated successfully</font></div><hr>";
								}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Contact exist with this phone number already</font></div><hr>"; }
								
							}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact last name</font></div><hr>"; }
						}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact first name</font></div><hr>"; }
					}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact phone number</font></div><hr>"; }
				}
			?>
			<form action='?contact=<?php echo $thecontact; ?>' method='POST'>
				<label><font size=5>Phone Number <font color=red>*</font></font></label><br>
				<input type='text' name='phone' id='myInputx' placeholder='Phone Number: +234 800 000 0000' required value='<?php echo $contactphone; ?>'>
				
				<br><label><font size=5>First Name <font color=red>*</font></font></label><br>
				<input type='text' name='firstname' id='myInputx' placeholder='First Name' required value='<?php echo $contactfirstname; ?>'>
				
				<br><label><font size=5>Last Name <font color=red>*</font></font></label><br>
				<input type='text' name='lastname' id='myInputx' placeholder='Last Name' required value='<?php echo $contactlastname; ?>'>
				
				<br><label><font size=5>Email Address</font></label><br>
				<input type='text' name='email' id='myInputx' placeholder='Email Address: name@domain.com' value='<?php echo $contactemail; ?>'>
			
				<hr><input type='submit' name='submit' value='SAVE CONTACT' id='mysubmit'>
			</form>
		<?php 
			}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Contact selected do not exist, please go back and select a contact</font></div><hr>"; }
		}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>No contact selected, please go back and select a contact</font></div><hr>"; }
		?>
	</div>
   </body>
</html>