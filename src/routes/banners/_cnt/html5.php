<?php


		Hdr_HTML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Dir_Html);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
		$result = curl_exec($ch);



		$__sch = ["edge_includes/", '.6.0.0.min', '<!--Adobe Edge Runtime-->', '<!--Adobe Edge Runtime End-->', 'edge.js'];
		$__cng = [DMN_BN.'_js/', '', '', '', 'edge2.js'];
		$__rsl = str_replace($__sch, $__cng, $result);


		if (strpos($__rsl, 'ad.size') == '') {

			$__sch = ['<div id="Stage"'];
			$__cng = ['<div class="__w" style="background-color: #cb0000; color: #ffffff; text-align:center; padding-top:10px; padding-bottom:10px; font-family:Arial; font-size:11px; z-index:99999999; margin-bottom:20px; width:100%; position:absolute; top:0; left:0; ">Falta la etiqueta <strong>"ad.size"<strong> </div><div style="background-color: rgba(255, 255, 255, 0.7); width:100%; height:100%; position:absolute; top:0; left:0; z-index:555555; "></div><div id="Stage" style=" margin-top: 100px; "'];
			$__rsl = str_replace($__sch, $__cng, $__rsl);


			$__est_w_bn = 2;

		}else{

			$__est_w_bn = 1;

		}


		if($__dtbn->tp_id == 7){

			$__sch = ['source="'];
			$__cng = ['source="'.DMN_BN.'fl/'.$__dtbn->dir.'/'];
			$__rsl = str_replace($__sch, $__cng, $__rsl);

		}


		curl_close($ch); unset($ch);

		if($__dtbn->tp_id != 7){ ob_start("compress_code"); }

		echo $__rsl;

		if($__dtbn->tp_id != 7){ ob_end_flush(); }
?>