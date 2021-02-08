<?php

	$Rt='../../includes/'; $__https_off='off'; $__dmn_dns=''; $__bdfrnt = 'ok'; include($Rt.'inc.php');


	//---------------- Get Parameters ----------------//

		$__s = Php_Ls_Cln($_GET['_sz']);
		$__mdl = Php_Ls_Cln($_GET["_mdl"]);
		$__lnd = Php_Ls_Cln($_GET["_lnd"]);
		$__mod = Php_Ls_Cln($_GET["_mod"]);
		$__tab = Php_Ls_Cln($_GET["_tab"]);

		$__whtsp = Php_Ls_Cln($_GET["whtsp"]);
		$__whtsp_txt = urlencode( Php_Ls_Cln($_GET["whtsp_text"]) );

	//---------------- Get Permalinks ----------------//

		$__f = substr($_SERVER['REQUEST_URI'], 1);

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');


	//---------------- Start Process ----------------//

	$__dt_cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);

	if(isN($__dt_cl->id)){
		$__dt_cl = __Cl([ 't'=>'dmn', 'id'=>$_SERVER['HTTP_HOST'] ]);
		if(!isN($__dt_cl->id)){ $__owndmn='ok'; }
	}

	$__c_lnd = new CRM_Lnd([ 'cl'=>$__dt_cl ]);

	if(!isN($__lnd)){
		$__c_lnd->lnd->id = $__lnd;
		$__c_lnd->lnd->t = 'enc';
	}


	if($__mod=='ok'){ $__c_lnd->mod->e = 'ok'; }
	if(!isN($__tab)){ $__c_lnd->mod->tab = $__tab; }

	if(!isN($__dt_cl->sbd)){ _StDbCl([ 'sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl ]); }


	_Cl_Lb([ 'sb'=>$__dt_cl->sbd ]);



	if(!isN($__pm_1)){


		if($__pm_1 == 'css'){

			include(DIR_CNT.'css.php'); $__nohtml = 'ok';

		}elseif($__pm_1 == 'js'){

			include(DIR_CNT.'js.php'); $__nohtml = 'ok';

		}elseif(!isN($__lnd) && !isN($__mdl)){

			$GtLnd = GtLndTabUsLs([ "lnd_tp"=>"enc", "lnd"=>$__lnd, "mdl_tp"=>"enc", "mdl"=>$__mdl, 'bd'=>$__dt_cl->bd ]);
			$__html = $GtLnd->ls['0']->html;

		}else{

			if($__pm_2 == 'g' || ($__owndmn == 'ok' && $__pm_1 == 'g')){

				if($__pm_1 == 'g'){ $id_go=$__pm_2; }else{ $id_go=$__pm_3; }
				$__c_lnd->mdl_gen->id = $id_go;

			}else{

				if($__owndmn == 'ok'){
					$__c_lnd->mdl->id = $__pm_1;
				}else{
					$__c_lnd->mdl->id = $__pm_2;
				}

			}

		}

		if($__nohtml != 'ok'){
			include(DIR_CNT.'html.php');
		}

	}else{

		echo "No especificado";

	}



?>