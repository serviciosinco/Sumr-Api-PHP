<?php 

	$__cl = __Cl([ 'id'=> Php_Ls_Cln($_POST['____cl']) , 't'=>'enc' ]);
	$__Forms = new CRM_Forms();
	$__Forms->data = Php_Ls_Cln($_POST);
	$__r = $__Forms->_pdata();
 
	if(	 !isN($__r->cnt_nm) && !isN($__r->cnt_eml) )
	{

		$__CntIn = new CRM_Cnt([ 'cl'=> $__cl->id ]);

		$__CntIn->cnt_nm = $__r->cnt_nm;
		$__CntIn->cnt_ap = '';
		$__CntIn->cnt_eml = $__r->cnt_eml;

		$__cnt1 = $__CntIn->_Cnt();

		$__CntIn->cnt_nm = Php_Ls_Cln($_POST['ussnd_nm']);
		$__CntIn->cnt_ap = '';
		$__CntIn->cnt_eml = Php_Ls_Cln($_POST['ussnd_em']);

		$Cnt_Eml_1 = $__r->cnt_eml;	
		$Cnt_Eml_2 = $__CntIn->cnt_eml;

		$__cnt2 = $__CntIn->_Cnt();

		if(!isN($__cnt1->i) && !isN($__cnt2->i)) {

			$__ec = new API_CRM_ec();
			$__ec->snd_f = SIS_F;
			$__ec->snd_h = SIS_H2;
			$__ec->snd_ec = Php_Ls_Cln($_POST['____ec']);
			$__ec->snd_eml = $Cnt_Eml_2;
			$__ec->snd_cnt = $__cnt2->i;
			$__ec->snd_us = 1;
			$__ec->snd_tll = $__cnt1->i;
			
			$__snd = $__ec->_SndEc([ 't'=>'mdl', 'auto'=>'ok', 'bd' => $__cl->bd ]);	
			
			if(!isN($__snd->i)){
				$rsp['e'] = 'ok';	
			}

		}

	}else{
		$rsp['e'] = 'no_data';
	}
?>