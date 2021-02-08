<?php 
		//ob_start("cmpr_js");
		
		if($__d == 'ok'){
			header("Status: 200");
			header("Content-Type: application/force-download");
			header("Content-Transfer-Encoding: binary");
		}else{
			Hdr_JS(); 
		}
		
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Dir.$__p2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
		$result = curl_exec($ch);
		
		
		$__sch = ["images/", 'compId).load("'];
		$__cng = [$Dir."images/", 'compId).load("'.$Dir_JS];
		$__rsl = str_replace($__sch, $__cng, $result);
		curl_close($ch); unset($ch);
		
		
		echo $__rsl;
		
		//ob_end_flush();
?>