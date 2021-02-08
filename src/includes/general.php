<?php

//-----------------	SISTEMA VARIABLES -----------------//

if(!isN($__dt_cl->id)){
	$__sis_cl = dirname(__FILE__).'/system/_sis_'.$__dt_cl->enc.'.php';
	if(file_exists($__sis_cl)){ include_once($__sis_cl); }else{ echo 'File '.$__sis_cl.' Menu No Exists'; exit(); }
}

//-----------------	SISTEMA VARIABLES -----------------//

define('NWRP', 'nowrap="nowrap"');
define('GRPH_F', 'SUMR_Grph.f.g');

define('MDL_SIS','Sistema');
define('MDL_SIS_BD', 'sis');
define('MDL_SIS_LS', 'sis.php');

define('ADM_LNK_DT','&Pr=Dt&_i=');
define('ADM_LNK_DTVW','&DtV=ok');
define('ADM_LNK_NTF','&_ntf=');
define('ADM_LNK_SB','&__i=');
define('ADM_LNK_OP','&_op=ok');

define('ADM_LNK_SCH','&sch=');
define('ADM_LNK_TB','&Tb=');
define('ADM_LNK_CRM','&crm=ok');
define('LNK_RND','&Rnd=');
define('LNK_DEL','delete');
define('LNK_UPD','update');



define('BTN_INRG','_INRG');
define('BTN_SCH','_SCH');
define('BTN_SCHCLN','_SCHCLN');
define('BTN_INF','_INF');
define('BTN_XLS','_XLS');
define('BTN_UPL','_UPLD');
define('BTN_IMG','_IMG');

define('TXGN_UPL','_t=upl_img&');
define('TXGN_UPLTH','_t=upl_imgth&');
define('TXGN_UPLBN','_t=upl_imgbn&');
define('TXGN_UPLNW','_t=upl_nw&');

define('TXGN_UPLFLE','_t=upl_fle&');
define('TXGN_UPLFLE_LS','_t=upl_fle_ls&');
define('TXGN_UPLDB','_t=upl_db&');

define('TXGN_UPLANX','_t=upl_anx&');

define('TXGN_ING','&Pr=Ing');
define('TXGN_LS','&Pr=Ls');
define('TXGN_POP','&_pop=ok'); // Link PopUp
define('TXGN_PNL','&_pnl[e]=ok'); // Link Panel
define('TXGN_BX','&_bx=');
define('TXGN_E','&__e=');
define('JS_SCR_POPCLS', '$.colorbox.close();');

define('CLS_RW_IM','Td_R1');
define('CLS_RW_PR','Td_R2');

define('DV_GNR_FM','FmDiv');
define('DV_GNR_FM_CMP','FmDivCmps');
define('DV_GNR_FM_BX','FmDivBx');


define('FMRQ_SMB','<span class=\'fm_rq\'>* </span>');

define('FMRQD','required');
define('FMRQD_NM','required digits');
define('FMRQD_EM','required email');
define('FMRQD_PSS','required password');
define('FMRQD_URL','url');
define('FMRQD_URLS','required url');
define('FMRQD_EML','email');
define('FMRQD_NMR','number');
define('SIS_SCHWBS', serialize ([ 'google.com.co', 'google.com', 'bing.com', 'r.search.yahoo.com', 'ask.com' ]));

define('HTML_SLCT', 'selected="selected"');
define('QRY_RGTOT', '__rgtot');


define('DV_IMG','ImgDiv');
define('CLSCLRBX','ImTh');
define('ID_LDR_PRC','Ldr_Lgin');

define('GRPH_CLR', '"#8CDEE8", "#BFCFFF", "#09C", "#C9C", "#96C", "#C69", "#966", "var(--main-bg-color)", ""');

define('HGHC_LBLDT', 'dataLabels: { enabled: true, style: { fontWeight: \'light\', fontSize: \'9px\' } }');
define('HGHC_LBLDT_PIE', ' format: \'<b>{point.name}</b>: {point.percentage:.1f} %\', ');
define('HGHC_LBLDT_PRC', ' dataLabels: { enabled: true, style: { fontWeight: \'light\', fontSize: \'9px\' }, format: \'{point.y} %\', overflow:\'justify\', padding: 3, borderRadius: 5, borderColor: \'#CCC\', borderWidth: 1, y: -6 } ');

define('DMN_EC_C','&_c=ok'); // Link a Form
define('DMN_EC_TLL','&_tll=ok'); // Link a Form
define('DMN_EC_UPD','&_upd=ok'); // Link a Form
define('DMN_EC_DEL','&_del=ok'); // Link a Form



define('CODNM_EC', 'PEM-');
define('CODNM_EC_CMPG', 'CMPG-');


define('SUMR_IDUS', '3');


//Genera Label Strong
function Strn($Cn, $Clss='', $Pto=NULL, $Sty=''){ if($Pto){ $__pto = ': '; } if($Cn != ''){if($Clss != ''){$Cl = 'class="'.$Clss.'"';} if($Sty != ''){$_Sty = 'style="'.$Sty.'"';} return '<strong '.$Cl.' '.$_Sty.'>'.$Cn.$__pto.'</strong>';}}
//Genera Label Span
function Spn($Cn=NULL, $Prnts='', $Clss='', $Sty='', $Id='', $Tt=NULL){ if($Prnts == 'ok'){$P1=' (';$P2=') ';}else{$P1='';$P2='';} if($Clss != ''){$Cl = 'class="'.$Clss.'"';} if($Sty != ''){$_Sty = 'style="'.$Sty.'"';} if($Tt != ''){$_Tt = ' title="'.strip_tags($Tt).'" ';} if($Id != ''){$_Id = '	id="'.$Id.'" ';} return '<span '.$_Id.' '.$Cl.' '.$_Sty . $_Tt .'>'.$P1.$Cn.$P2.'</span>'; }
//Genera Label Formulario
function Lb($Cn){if($Cn != ''){return '<label class="_anm">'.$Cn.'</label>';}}


function ctjMlt($p=NULL, $op=NULL){
	if(is_array($p) && $p != '' && $p!=NULL){
		if($op['s']=='ok'){
			foreach($p as $_p_k=>$_p_v){
				$_new_p[$_p_k] = '"'.$_p_v.'"';
			}
			$p = $_new_p;
		}
		$_r = implode(',', $p);
	}else{
		$_r = $p;
	}
	return($_r);
}

function _NoNll($v){
	if($v == NULL){ return ' '; }else{ return($v); }
}

//
function GtQtsAll($_p=NULL){

	global $__cnx;

	if(!isN($_p['lmt'])){ $_lmt=' LIMIT '.$_p['lmt']; }

	$query_DtRgGrp = sprintf("	SELECT *, "._QrySisSlcF()."
								FROM "._BdStr(DBM).TB_SIS_SLC."
								WHERE sisslc_tp = '32'
								ORDER BY RAND()
								{$_lmt}
							");
	$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

	if($DtRgGrp){

		$row_DtRgGrp = $DtRgGrp->fetch_assoc();
		$Tot_DtRgGrp = $DtRgGrp->num_rows;

		if($Tot_DtRgGrp > 0){

			do {

				$___col = CG_Array(['f'=>$row_DtRgGrp['___fld'], 'k'=>'key' ]);
				$__vle[] = ctjTx($row_DtRgGrp['sisslc_tt'],'in');
				$rsp[] = ['id'=> $row_DtRgGrp['id_sisslc'], 'qte'=> ctjTx($row_DtRgGrp['sisslc_tt'],'in'), 'own'=> ctjTx($___col->own->vl,'in')];

			}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

		}

	}
	return $rsp;

}

// Obtengo Datos de BD Usuario Admin
if (defined('DB_CL_ENC_SES') && (isset($_SESSION[DB_CL_ENC_SES.MM_ADM])) && $_SESSION[DB_CL_ENC_SES.MM_ADM] != '') {

	if(defined('DB_CL_ENC_SES')){
		if(Php_Ls_Cln($_GET['_frst']) == 'ok'){ $_ses_bsc='ok'; }
		$_GtSesDt = $___ses->GtSesDt([ 'i'=>$_SESSION[DB_CL_ENC_SES.MM_ADM_SES_ID]/*, 'bsc'=>$_ses_bsc*/ ]);
	}


	if(!isN($_GtSesDt->id) && $_GtSesDt->est == 'ok'){

		define('SISUS_SES', $_GtSesDt->id);
		define('SISUS_SES_ID', $_GtSesDt->enc);

		define('SISUS_PRM', $_GtSesDt->us->prm->mdl);
		define('SISUS_PRM_N', $_GtSesDt->us->prm->mdl_n);

		define('SISUS_MDL', $_GtSesDt->us->mdl->mdl);
		define('SISUS_MDL_N', $_GtSesDt->us->mdl->mdl_n);
		define('SISUS_CNTEST', $_GtSesDt->us->cnt_est->vld);

		define('SIS_TPUS', $_GtSesDt->us->nivel );
		define('SISUS_ID', $_GtSesDt->us->id );
		define('SISUS_USER', $_GtSesDt->us->user );
		define('SISUS_ARE', $_GtSesDt->us->are );
		define('SISUS_PLCY', $_GtSesDt->us->plcy );
		define('SISUS_ENC', $_GtSesDt->us->enc );
		define('SISUS_NTF', $_GtSesDt->us->ntf );

		define('SISUS_CRG', $_GtSesDt->us->crg );


		define('SISUS_NM', $_GtSesDt->us->nm );
		define('SISUS_AP', $_GtSesDt->us->ap );
		define('SISUS_FN', $_GtSesDt->us->fn );
		define('SISUS_NMFLL', $_GtSesDt->us->fll );
		define('SISUS_IMG', $_GtSesDt->us->img );
		//define('SISUS_PRO', $_GtSesDt->us->mdl_inc );
		define('SISUS_AGE', $_GtSesDt->us->age );
		//define('SISUS_PRO_EXC', $_GtSesDt->us->mdl_exc );

		define('SISUS_GNR', $_GtSesDt->us->gnr );

		define('SISUS_CNTEST_EXC', $_GtSesDt->us->cntest_exc );
		define('SISUS_PSS', $_GtSesDt->us->pass);
		define('SISUS_PSSCHN', $_GtSesDt->us->pass_chn );

		define('SISUS_LNG_FLG', $_GtSesDt->us->lng->flg );

		define('SISUS_MSV_USER', $_GtSesDt->us->msv_usr);

	}else{

		//echo '<h1 style="color:white;">No SES DT '.print_r($_SESSION, true).'</h1>';

		if(!isN($_GtSesDt->id) && $__chksess != 'no'){
			/*if($_GtSesDt->est == 'no' && isN($__inc)){ $___ses->__ck_cln(); }*/
		}

	}


}elseif( defined('DB_CL_ENC_SES') && isset($_SESSION[DB_CL_ENC_SES.MM_BEM]) && $_SESSION[DB_CL_ENC_SES.MM_BEM] != '') {

	define('SIS_TPUS', 'bolsaempleo');

}else{

	//echo '<h1>NO NOTHING</h1>';

}



define('DV_CLSS_SLCT','styled-select');

if(isMobile()){
	define('DV_CLSS_SLCT_BX','styled-select');
}else{
	define('DV_CLSS_SLCT_BX','styled-select-bx');
}

define('DV_CLSS_SLCT_MLT','styled-select-mlt');



define('DMN_EC_C','&_c=ok');
define('DMN_EC_TLL','&_tll=ok');
define('DMN_EC_UPD','&_upd=ok');
define('DMN_EC_DEL','&_del=ok');

?>