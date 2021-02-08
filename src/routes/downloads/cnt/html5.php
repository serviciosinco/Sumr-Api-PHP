<?php
		Hdr_HTML(); ob_start("compress_code");


		$Dir = DMN_BN.'fl/'.$__dtfl->dir.'/';
		$Dir_Swf = 'fl/'.$__dtfl->dir.'/src.swf?Rnd='.Gn_Rnd(20);
		$Dir_Html = DMN_BN.'fl/'.$__dtfl->dir.'/src.html';


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Dir_Html);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
		$result = curl_exec($ch);


		if($__dtfl->url_abs != NULL){
			$__sch = ["edge_includes/", '/edge', '<!--Adobe Edge Runtime-->', '<!--Adobe Edge Runtime End-->'];
			$__cng = [$__dtfl->url_abs, '/edge_includes/edge', ''];
		}else{
			$__sch = ["edge_includes/", '.6.0.0.min.js', '<!--Adobe Edge Runtime-->', '<!--Adobe Edge Runtime End-->'];
			$__cng = [DMN_BN.'_js/', '.js?__b='.$__dtfl->enc, '', ''];
		}

		$__rsl = str_replace($__sch, $__cng, $result);

		curl_close($ch); unset($ch);
		echo $__rsl;

		ob_end_flush();
?>