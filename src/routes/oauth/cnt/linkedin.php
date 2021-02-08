<?php

	$GtClDt = GtClDt($__cl, 'enc');

	$__lnkin_oauth_code = Php_Ls_Cln($_GET['code']);
	$__lnkin_succcess = Php_Ls_Cln($_GET['success']);


	if($__lnkin_succcess == 'ok'){

		$CntJV .= 'setTimeout(function(){ this.close(); }, 3000);';

	}elseif($__lnkin_oauth_code != ''){

		$__Rdrct = DMN_OAUTH.'linkedin/?_scl='.Php_Ls_Cln($_GET['_scl']).'&_us='.Php_Ls_Cln($_GET['_us']).'&_cl='.Php_Ls_Cln($_GET['_cl']);

		$__Tkn = Lnkin_Tkn(['code'=>$__lnkin_oauth_code,'cll'=>$__Rdrct]);
		$data = json_decode($__Tkn); print_r($data->access_token); exit();
		$__usdt = Lnkin_Us([ 'tkn'=>$data->access_token ]);


		if(!isN($data->access_token)){

			$__us = GtUsDt($__us, 'enc');

			$__SclBd = new CRM_Thrd();
			$__SclBd->__t = 'scl';
			$__SclBd->cl = $__cl;
			$__SclBd->us = $__us->id;
			$__SclBd->_scl_nm = $__usdt->formattedName;
			$__SclBd->_scl_prf = $__usdt->id;
			$__SclBd->scl_attr = [
				'access_token'=>$data->access_token,
				'headline'=>$__usdt->headline,
				'profile_picture'=>$__usdt->pictureUrls->values[0]
			];

			$__SclBd->scl = Php_Ls_Cln($_GET['_scl']);
			$__Prc = $__SclBd->In();


			echo 'Here'; echo h1('$__usdt->id:'.$__usdt->id); echo h2('$__usdt:'.print_r($__usdt, true)); print_r($data); print_r($__Prc); exit();


			if($__Prc->e == 'ok'){
				$CntJV .= 'var _new_url = location.href + "&success=ok"; window.location.href = _new_url;';
			}else{
				echo 'Error Request, close it please';
			}

		}


	}

?>