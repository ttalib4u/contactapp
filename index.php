<?php
	define("MY_STORAGE_FILE", "contact.txt");
?>

<html> 
   <head>
      <title>Contact Storing Application</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="script.js"></script>
   </head> 
   <body> 
     <?php
	 
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
		fclose($file);

		echo "<div style='width: 45%'>".
		"<h2>My Phonebook</h2><a href='addcontact.php'>+ ADD NEW CONTACT</a>".
		"<input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search for names..' title='Type in a name'>";
		echo "<ul id='myUL'>";
		if ($filetext){
			$contactlist = @explode(PHP_EOL, $filetext);
			for ($i=0; $i<count($contactlist); $i++){
				$contctdetail = @explode(',', $contactlist[$i]);
				
				echo "<li><a><table width='100%'><tr>".
				"<td width='80%'><font size=5>".$contctdetail[0]."</font>".
				"<br><font size=3>Names: <b>".$contctdetail[1]." ".$contctdetail[2]."</b> Email: <b>".$contctdetail[3]."</b></font></span></td>".
				"<td width='10%'><a href='editcontact.php?contact=".base64_encode($contctdetail[0])."'>EDIT</a></td>".
				"<td><a href='removecontact.php?contact=".base64_encode($contctdetail[0])."'>REMOVE</a></td>".
				"</tr></table></a></li>";
				
			}
		}
		echo "</ul></div>";
	?> 
   </body>
   
	
</html>