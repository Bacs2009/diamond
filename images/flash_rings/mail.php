<?
header("Expires: Mon, 25 Jan 1970 05:00:00 GMT");   
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$uploads_dir = '/Users/pashab/work/stdiamond/bin';
//$uploads_dir = '/Users/pashab/work/fileLoader/bin/';

if(isset($_POST['mail'])){
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

    foreach ($_FILES as $key => $value) {
        
        $old_name = $value['tmp_name'];
        $new_name = $uploads_dir . $value['name'];
        echo $old_name . ' ' . $new_name . "\n";

            move_uploaded_file( $old_name, $new_name);

    };


    print "{'status': 'ok', 'log':' mail=" .$mail . ", name=" . $name . ", subject=" . $subject . ", message=" . $message . "'}";
}

?>
