<?php
function shuff(){

	$cpack=array("SA","SK","SQ","SJ","S07","S08","S09","S10","DA","DK","DQ","DJ","D07","D08","D09","D10","CA","CK","CQ","CJ","C07","C08","C09","C10","HA","HK","HQ","HJ","H07","H08","H09","H10");
	shuffle($cpack);

	return $cpack;
}

$cpack=shuff();

foreach ($cpack as $key ) {
	# code...
	echo $key."   ";
}

?>
