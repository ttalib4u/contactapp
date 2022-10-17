<?php
	define("MY_STORAGE_FILE", "contact.txt");
?>

<html> 
   <head>
      <title>Add Contact - CSA</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="script.js"></script>
   </head> 
   <body> 
   
	<div style='width: 30%'>
		<a href='index.php'> < Back</a>
		<h2>Add New Contact<hr></h2>
		<?php
		
			if (isset($_POST['submit'])){
				if ($_POST['phone']){
					if ($_POST['firstname']){
						if ($_POST['lastname']){
							$file = fopen(MY_STORAGE_FILE, "r+");
							if( $file == false ){
								$file = fopen(MY_STORAGE_FILE, "r+");
								fwrite($file, "");
							}
							$filesize = filesize(MY_STORAGE_FILE);
							if ($filesize == 0){
								$filetext = "";
							}else{
								$filetext = fread($file, $filesize);
							}
							$contactlist = @explode(PHP_EOL, $filetext); $alrexist = "no";
							for ($i=0; $i<count($contactlist); $i++){
								$contctdetail = @explode(',', $contactlist[$i]);
								if ($contctdetail[0] == $_POST['phone']){ $alrexist = "yes"; break; }
							}
							fclose($file);
							
							if ($alrexist == 'no'){
								$joininfo = $_POST['phone'].",".$_POST['firstname'].",".$_POST['lastname'].",".$_POST['email'];
								$jointofile = $filetext.PHP_EOL.$joininfo;
								
								$file = fopen(MY_STORAGE_FILE, "w");
								fwrite($file, $jointofile);
								fclose($file);
								
								echo "<div style='background: #10880d; color: white; padding: 10px;'><font size=4>Contact added successfully</font></div><hr>";
							}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Contact exist with this phone number already</font></div><hr>"; }
							
						}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact last name</font></div><hr>"; }
					}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact first name</font></div><hr>"; }
				}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Please enter contact phone number</font></div><hr>"; }
			}
		?>
		<form action='' method='POST'>
			<label><font size=5>Phone Number <font color=red>*</font></font></label><br>
			<input type='text' name='phone' id='myInputx' placeholder='Phone Number: +234 800 000 0000' required>
			
			<br><label><font size=5>First Name <font color=red>*</font></font></label><br>
			<input type='text' name='firstname' id='myInputx' placeholder='First Name' required>
			
			<br><label><font size=5>Last Name <font color=red>*</font></font></label><br>
			<input type='text' name='lastname' id='myInputx' placeholder='Last Name' required>
			
			<br><label><font size=5>Email Address</font></label><br>
			<input type='text' name='email' id='myInputx' placeholder='Email Address: name@domain.com'>
		
			<hr><input type='submit' name='submit' value='SAVE CONTACT' id='mysubmit'>
		</form>
	</div>
   </body>
</html>