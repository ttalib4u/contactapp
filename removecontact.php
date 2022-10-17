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
					$foundcontact = "yes"; break; 
				}
			}
			fclose($file);
			if ($foundcontact == 'yes'){
				$thecontact = $_GET['contact'];
				
				$file = fopen(MY_STORAGE_FILE, "r+");
				$filesize = filesize(MY_STORAGE_FILE);
				if ($filesize == 0){
					$filetext = "";
				}else{
					$filetext = fread($file, $filesize);
				}
				$contactlist = @explode(PHP_EOL, $filetext);
				$collectcomtact = "";
								
				for ($i=0; $i<count($contactlist); $i++){
					$contctdetail = @explode(',', $contactlist[$i]);
									
					if ($contctdetail[0] != base64_decode($_GET['contact'])){
						if (!$collectcomtact){ $collectcomtact = $contactlist[$i]; }else{ $collectcomtact .= PHP_EOL.$contactlist[$i]; }
					}
				}
				fclose($file);
								
				$file = fopen(MY_STORAGE_FILE, "w");
				fwrite($file, $collectcomtact);
				fclose($file);
				echo "<div style='background: #10880d; color: white; padding: 10px;'><font size=4>Contact <b>".base64_decode($_GET['contact'])."</b> removed successfully</font></div><hr>";
								
			
			}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>Contact selected do not exist, please go back and select a contact</font></div><hr>"; }
		}else{ echo "<div style='background: #fe8288; color: white; padding: 10px;'><font size=4>No contact selected, please go back and select a contact</font></div><hr>"; }
		?>
	</div>
   </body>
</html>