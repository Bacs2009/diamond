<?
header("Expires: Mon, 25 Jan 1970 05:00:00 GMT");   
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$uploads_dir = '/Users/pashab/work/stdiamond/bin';
//$uploads_dir = '/Users/pashab/work/fileLoader/bin/';

if(isset($_POST['network'])){
	$network = $_POST['network'];
	$gid = $_POST['gid'];
	$id = $_POST['id'];
    // 400 x 400
    print '{"status": "ok", "network":"' . $network . '", "gid":"' . $gid . '", "id":"' . $id . '"}';
}

?>
