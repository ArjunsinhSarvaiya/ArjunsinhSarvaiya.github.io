<?php

$n=3;
for($i_main=0; $i_main<$n; $i_main++){ 
	$value=""; 
	for($i=($n*($n-$i_main)); $i>0; $i--){ 
		if($i_main%2!=0){ 
			$value=$i." ".$value; 
		}else{ 
			$value=$value." ".$i; 
		} 
		if((($i-1)%$n)==0){ 
			break; 
		}
	} 
	echo $value."<br>";
}

$n=10;
$count=1;
$i=0;
while($i<$n){
	$check_value=0;
	for($i=2; $i<$count; $i++){

	    if ($count <= 1){
	        $check_value++;
	    }

		echo $count." === ".$check_value;die();
		if($count%$i==0){
			$check_value++;
		}
	}
	echo $count." = ".$check_value;die();
	if($check_value==0){
		echo $count;
		$i++;
	}
	$count++;
}
?>