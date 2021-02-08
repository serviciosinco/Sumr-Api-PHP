<?php

	$__input = _HtmlCln([
				'pst'=>'ok',
	'cod'=>Php_Ls_Cln( /*compress_code(*/$_POST['html_input']/*)*/ ),
				'tag'=>['div', 'img']
			]);

	if(!isN($__input->cod)){
		$rsp['e'] = 'ok';
		//$rsp['html_c'] = $__input->cod;
		$rsp['html_b'] = ctjTx($__input->cod,'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']);
		$rsp['html_g'] = /*compress_code(*/$_POST['html_input']/*)*/;
	}else{
		$rsp['e'] = 'no';
	}

	$__cmprss = 'no';

?>