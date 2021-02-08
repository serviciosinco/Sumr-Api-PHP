<?php

define('DEMO_CLSS', false);
define('BUGS_EST', true);

class CRM_Cnt_Up extends CRM_Up{

	function __construct($p=NULL) {

		global $__cnx;
        $this->c_r = $__cnx->c_r;
		$this->c_p = $__cnx->c_p;

		$this->hb_w = array();

        if(!isN($p['cl'])){ $this->cl = GtClDt($p['cl'],'',['cnx'=>$this->c_r]); }
    }

	function __destruct() {
		parent::__destruct();
   	}


	public function Run(){

		if( isN($this->mdlcnt_enc) ){
			$this->C_NmAp();
		}

		$this->C_HtmlBad();

		if(	$this->up_tp != 'snd_ec_lsts_up' &&
			$this->up_tp != 'ec_lsts_up' &&
			$this->up_tp != 'sms_cmpg_up' &&
			$this->up_tp != 'cnt' &&
			$this->up_tp != 'lsts_auto' &&
			isN($this->mdlcnt_enc) ){
			$this->C_MdlId();
		}

		$this->C_DcTp();
		$this->C_Md();
		$this->C_CntEst();
		$this->C_CntFnt();
		$this->C_His();

		if( $this->up_tp != 'sms_cmpg_up' && isN($this->mdlcnt_enc) ){ $this->C_DcOrEml(); }

		$this->C_DcFrmt();
		$this->C_EmlFrmt();
		$this->C_TelFrmt();
		$this->C_Org();
		$this->C_Cd();
		$this->C_CntTp();
		$this->C_DteFrmt();
		$this->C_EcLsts();
		$this->C_SmsCmpg();
		$this->C_NoiOtu();
		$this->C_AttrExt();
		$this->C_Act();
		$this->C_Tra();
		$this->C_Plcy();

		if(is_array( $this->hb_w )){ $this->hb_w_all = str_replace(HTML_S, '', implode(' | ', $this->hb_w) ); }

	}


	//-------------- Verificación de Integralidad de Datos - Start --------------//


	private function C_NmAp(){

		$__nm_fx = __NmFx($this->cnt_nm);

		if(isN($this->cnt_ap)){
			$this->cnt_nm = trim($__nm_fx->nm);
			$this->cnt_ap = trim($__nm_fx->ap);
		}elseif(isN($this->cnt_nm) && !isN($this->cnt_ap)){
			$__nm_fx = __NmFx($this->cnt_ap);
			$this->cnt_nm = trim($__nm_fx->nm);
			$this->cnt_ap = trim($__nm_fx->ap);
		}else{
			$this->cnt_nm = trim($this->cnt_nm);
			$this->cnt_ap = trim($this->cnt_ap);
		}

		//echo 'Name:'.$this->cnt_nm.PHP_EOL;
		//echo 'LastName:'.$this->cnt_ap.PHP_EOL;

		if(isN($this->cnt_nm)){
			if($this->cnt_nm_disallow != 'ok'){
				$this->hb = 'no';
				$this->hb_w['nm'] .= TX_NMINGRSBD.HTML_S;
			}
		}

	}

	private function C_MdlId($p=NULL){

		if( !isN($this->mdl_cdc) ){

			$mdl_dt = GtMdlDt([ 'id'=>$this->mdl_cdc, 'prd'=>$this->mdl_cdc_prd, 't'=>'cdc', 'prx'=>'ok' ]);

			if(!isN($mdl_dt->prx_id)){
				$this->gt_mdl_id = $mdl_dt->prx_id;
				$this->gt_mdl_tp = $mdl_dt->tp;
			}else{
				$this->gt_mdl_id = NULL; $this->hb = 'no'; $this->hb_w['aprid'] = TX_NXTOPN.' '.$this->mdl_cdc.HTML_S;
			}

			$this->mdl_prd_l = $mdl_dt->apr->prd;

		}elseif( !isN($this->mdl_id) ){

			$mdl_dt = GtMdlDt([ 'id'=>$this->mdl_id, 'bd'=>$this->cl->bd ]);
			$this->mdl_prd_l = $mdl_dt->apr->prd;

			if(!isN($mdl_dt->id)){
				$this->gt_mdl_id = $mdl_dt->id;
				$this->gt_mdl_tp = $mdl_dt->tp;
			}else{
				$this->gt_mdl_id = NULL; $this->hb = 'no'; $this->hb_w['aprid'] = TX_NXTOPN.' '.$this->mdl_id.HTML_S;
			}

		}else{

			$this->hb_w['mdlid'] = TX_NINDRLCMD.HTML_S;
			$this->w_cod = 402;

		}
	}

	private function C_DcOrEml(){
		if(	$this->cnt_dc != NULL ||
			$this->cnt_eml != NULL ||
			$this->cnt_eml_2 != NULL ||
			$this->cnt_eml_3 != NULL ||
			$this->cnt_tel != NULL ||
			$this->cnt_tel_2 != NULL
		){
			return true;
		}else{
			$this->hb_w['dcoreml'] = TX_NCDLNML.HTML_S;
		}
	}

	private function C_DcFrmt(){
		if($this->cnt_dctp != 180){
			if (!isN($this->cnt_dc) && !filter_var($this->cnt_dc, FILTER_VALIDATE_INT)){
				$this->hb = 'no'; $this->hb_w['frmtdc'] = 'Documento '.$this->cnt_dc.' '.TX_FRMTINVLD.HTML_S;
			}
		}
	}


	private function C_EmlFrmt(){
		if ($this->cnt_eml != NULL && !filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL)){ $this->hb = 'no'; $this->hb_w['frmteml'] = 'Correo '.$this->cnt_eml.' '.TX_FRMTINVLD.HTML_S;}
		if ($this->cnt_eml_2 != NULL && !filter_var($this->cnt_eml_2, FILTER_VALIDATE_EMAIL)){  $this->hb = 'no'; $this->hb_w['frmteml2'] = 'Correo '.$this->cnt_eml_2.' '.TX_FRMTINVLD.HTML_S; }
		if ($this->cnt_eml_3 != NULL && !filter_var($this->cnt_eml_3, FILTER_VALIDATE_EMAIL)) {  $this->hb = 'no'; $this->hb_w['frmteml3'] = 'Correo '.$this->cnt_eml_3.' '.TX_FRMTINVLD.HTML_S;  }


		$__chk_eml = ChkEml_Rle([ 'e'=>$this->cnt_eml ]);
		if($__chk_eml->e == 'ok'){  $this->hb_w['frmteml'] = $__chk_eml->tx.TX_NTRGHTML; }

		$__chk_eml_2 = ChkEml_Rle([ 'e'=>$this->cnt_eml_2 ]);
		if($__chk_eml_2->e == 'ok'){  $this->hb_w['frmteml'] = $__chk_eml_2->tx.TX_NTRGHTML; }

		$__chk_eml_3 = ChkEml_Rle([ 'e'=>$this->cnt_eml_3 ]);
		if($__chk_eml_3->e == 'ok'){  $this->hb_w['frmteml'] = $__chk_eml_3->tx.TX_NTRGHTML; }

	}

	private function C_TelFrmt(){

		if(
			!isN($this->cnt_tel) || !isN($this->cnt_tel_2) || !isN($this->cnt_tel_3) || !isN($this->cnt_tel_4) || !isN($this->cnt_tel_5) ||
			!isN($this->cnt_cel) || !isN($this->cnt_cel_2)
		){

			//Guardar telefonos en un arreglo
			$_all_tel = [
							'cnt_tel'=>[ 'v'=>$this->cnt_tel['no'], 'p'=>$this->cnt_tel['ps'] ],
							'cnt_tel_2'=>[ 'v'=>$this->cnt_tel_2['no'], 'p'=>$this->cnt_tel_2['ps'] ],
							'cnt_tel_3'=>[ 'v'=>$this->cnt_tel_3['no'], 'p'=>$this->cnt_tel_3['ps'] ],
							'cnt_tel_4'=>[ 'v'=>$this->cnt_tel_4['no'], 'p'=>$this->cnt_tel_4['ps'] ],
							'cnt_tel_5'=>[ 'v'=>$this->cnt_tel_5['no'], 'p'=>$this->cnt_tel_5['ps'] ],
							'cnt_cel'=>[ 'v'=>$this->cnt_cel['no'], 'p'=>$this->cnt_cel['ps'] ],
							'cnt_cel_2'=>[ 'v'=>$this->cnt_cel_2['no'], 'p'=>$this->cnt_cel_2['ps'] ]
						];

		}

		if(!isN($_all_tel)){

			if(!isN($this->plcy_id)){
				//Valida formato de telefono
				foreach($_all_tel as $_all_tel_k=>$_all_tel_v){

					if(!isN($_all_tel_v['v'])){

						$_vld_tel = vld_tel([ 'no'=>$_all_tel_v['v'], 'ps'=>$_all_tel_v['p'] ]);

						if($_vld_tel->e == 'no' && $this->cnt_tel_disallow != 'ok' ){
							$this->hb = 'no';
							$this->hb_w['frmttel'] .= TX_PHNCLL.' '.( !isN($_all_tel_v['p']) ? '+'.$_all_tel_v['p']:'' ).$_all_tel_v['v'].' '.TX_FRMNTVLD.' '.print_r($_vld_tel->w, true).HTML_S;
						}else{
							if($_vld_tel->spr == 'ok'){
								$this->{$_all_tel_k} = [
													'no'=>$_vld_tel->new->no,
													'ps'=>$_vld_tel->new->ps
												];
							}
						}

					}
				}

			}else{

				$this->hb_w['frmttel'] .= TX_PHNCLL.' Policy id not attached';

			}

		}

	}


	private function C_Org(){

		//Valida datos de organizaciones

		for ($i=1; $i <= 3; $i++) {

			if(!isN( $this->{'cnt_org_'.$i} )){

				$_dt = GtOrgDt([ 'i'=>$this->{'cnt_org_'.$i} ]);

				if(!isN($_dt->id)){

					$_all_org[] = [	'id'=>$_dt->enc,
									'tpr'=>$this->{'cnt_org_tpr_'.$i},
									'crg'=>$this->{'cnt_org_crg_'.$i},
									'are'=>$this->{'cnt_org_are_'.$i},
									'crs'=>$this->{'cnt_org_crs_'.$i},
									'smst'=>$this->{'cnt_org_smst_'.$i}
								];

				}else{

					$this->hb = 'no'; $this->hb_w['org'] .= 'No existe ID de organizacion'.HTML_S;

				}

			}

		}
	}

	private function C_Cd(){

		//Valida datos de Ciudad Relacional

		for ($i=1; $i <= 2; $i++) {

			if(!isN( $this->{'cnt_cd_'.$i} )){

				$_dt = GtCdDt([ 'id'=>$this->{'cnt_cd_'.$i} ]);

				if(!isN($_dt->id)){

					$_all_cd[] = [
								'id'=>$_dt->id,
								'rel'=>$this->{'cnt_cd_tpr_'.$i}
							];

				}else{

					$this->hb = 'no'; $this->hb_w['cd'] .= $i.' - No existe ID de Ciudad '.HTML_S;

				}

			}

		}

		if(!isN($_all_cd)){
			foreach($_all_cd as $v){
				if(!isN($v)){
					if(isN($v['rel'])){
						$this->hb = 'no'; $this->hb_w['frmtorg'] .= 'Debe existir un tipo de relación con la ciudad'.HTML_S;
					}else{
						$this->cnt_cd_all = $_all_cd;
					}
				}
			}
		}
	}


	private function C_DcTp(){

		if(isN($this->cnt_dctp)){ $this->cnt_dctp=_CId('ID_CNTDC_CC'); }

		if($this->cnt_dctp != NULL /*&& $this->cnt_dctp == $this->v*/){
			$_dt = __LsDt([ 'k'=>'cnt_dc', 'id'=>$this->cnt_dctp ]);
			if(isN($_dt->d->id)){ $this->hb = 'no'; $this->hb_w['dctp'] = TX_NEXTDCM.HTML_S; }
		}
	}
	private function C_Md(){
		if(!isN($this->mdlcnt_md) /*&& $this->mdlcnt_md == $this->v*/){
			$_dt = GtSisMdDt([ 'id'=>$this->mdlcnt_md ]);
			if(isN($this->cnt_sndi) && $_dt->sndi == 'ok'){ $this->cnt_sndi=1; }
			if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['md'] = TX_NEXTMD.HTML_S; }
		}
	}
	private function C_CntTp(){
		if($this->cnt_tp != NULL /*&& $this->cnt_tp == $this->v*/){
			$_dt = GtCntTpDt(['id'=>$this->cnt_tp]); if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['md'] = $this->cnt_tp.' '.TX_NEXSTID.' 1 '.HTML_S; }
		}
		if($this->cnt_tp_2 != NULL /*&& $this->cnt_tp_2 == $this->v*/){
			$_dt = GtCntTpDt(['id'=>$this->cnt_tp_2]); if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['md'] = TX_NEXSTID.' 2 '.HTML_S; }
		}
		if($this->cnt_tp_3 != NULL /*&& $this->cnt_tp_3 == $this->v*/){
			$_dt = GtCntTpDt(['id'=>$this->cnt_tp_3]); if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['md'] = TX_NEXSTID.' 3 '.HTML_S; }
		}
	}

	private function C_NoiOtu(){
		if($this->mdlcnt_noi_otc != NULL){
			$_dt = GtUniDt(['id'=>$this->mdlcnt_noi_otc]); if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['mdlcntnoi'] = TX_NEXTUNVSD.HTML_S; }
		}
	}


	private function C_AttrExt(){


		if(!isN($this->ext->mdl_cnt)){
			$__attr = __LsDt([ 'k'=>'mdl_cnt_attr' ])->ls->mdl_cnt_attr;
			foreach($this->ext->mdl_cnt as $_ext_k=>$ext_v){
				foreach($__attr as $__attr_k=>$__attr_v){
					if(!isN($__attr_v->get->vl)){
		            	if($__attr_v->get->vl == $_ext_k){
			            	$this->ext_out->mdl_cnt->{$__attr_v->get->vl}->id = $__attr_v->id;
			            	$this->ext_out->mdl_cnt->{$__attr_v->get->vl}->vl = $ext_v;
		            	}
	            	}
	            }
			}
		}


		if(!isN($this->ext->cnt)){
			$__attr = __LsDt([ 'k'=>'cnt_attr' ])->ls->cnt_attr;
			foreach($this->ext->cnt as $_ext_k=>$ext_v){
				foreach($__attr as $__attr_k=>$__attr_v){
	            	if($__attr_v->get->vl == $_ext_k){
		            	$this->ext_out->cnt->{$__attr_v->get->vl}->id = $__attr_v->id;
		            	$this->ext_out->cnt->{$__attr_v->get->vl}->vl = $ext_v;
	            	}
	            }
			}
		}


	}

	private function C_CntEst(){
		if($this->mdlcnt_est != NULL && !isN($this->mdlcnt_gst_1) && !isN($this->mdlcnt_gst_2) ){
			if($this->mdlcnt_gst_us == NULL){ $this->hb = 'no'; $this->hb_w['mdlcntest'] = TX_USRGSTN.HTML_S; }
			$_dt = GtCntEstDt([ 'id'=>$this->mdlcnt_est ]);

			if($_dt->id == NULL){
				$this->hb = 'no'; $this->hb_w['mdlcntest'] = TX_NEXTSTCNT.HTML_S;
			}
		}
	}

	private function C_CntFnt(){
		if($this->cnt_fnt != NULL /*&& $this->cnt_fnt == $this->v*/){
			$_dt = GtSisFntDt([ 'id' => $this->cnt_fnt ]); if($_dt->id == NULL){ $this->hb = 'no'; $this->hb_w['mdlcntfnt'] = TX_EXTFNTCNT.HTML_S; }
		}
	}

	private function C_His(){
		if($this->mdlcnt_gst_1 != NULL){
			if($this->mdlcnt_gst_1_f == NULL || $this->mdlcnt_gst_us == NULL){ $this->hb = 'no'; $this->hb_w['mdlcnthis'] = TX_DTUSRGST.HTML_S; }
		}

		if($this->mdlcnt_gst_2 != NULL){
			if($this->mdlcnt_gst_2_f == NULL || $this->mdlcnt_gst_2_us == NULL){ $this->hb = 'no'; $this->hb_w['mdlcnthis'] = TX_DTUSRGST.HTML_S; }
		}
	}

	private function C_HtmlBad(){
		if($this->v != NULL){  if($this->v != strip_tags($this->v)){ $this->hb = 'no'; $this->hb_w['htmlbad'] = 'Hay codigos en '.$this->c.HTML_S; }  }
	}

	private function C_DteFrmt(){
		$mdlcnt_fi = DateTime::createFromFormat('Y-m-d', $this->mdlcnt_fi);
		if ($this->mdlcnt_fi != NULL && ($mdlcnt_fi == '' || $mdlcnt_fi == NULL) ){ $this->hb = 'no'; $this->hb_w['frmtdte'] = TX_DTCFRTVLD. $this->mdlcnt_fi . HTML_S;  }

		$cnt_fn = DateTime::createFromFormat('Y-m-d', $this->cnt_fn);
		if ($this->cnt_fn != NULL && ($cnt_fn == '' || $cnt_fn == NULL) ){ $this->hb = 'no'; $this->hb_w['frmtdte'] = TX_DTCFRTVLD. $this->cnt_fn . HTML_S;  }
	}

	private function C_EcLsts(){

		if(!isN($this->ec_lsts_id)){

			if(isN($this->cnt_eml) && isN($this->cnt_eml_2) && isN($this->cnt_eml_3)){
				$this->hb = 'no';
				$this->hb_w['rqreml'] .= TX_DNMLASCD.HTML_S;
			}

			if(!isN($this->cnt_eml)){
				$__eml_1 = $this->Chk_EcLstsEmlD([ 'c'=>'0', 'lsts'=>$this->ec_lsts_id, 'eml'=>$this->cnt_eml ]);
				if($__eml_1->e == 'ok'){ $__emllsts_no = 'ok'; }
			}
			if(!isN($this->cnt_eml_2)){
				$__eml_2 = $this->Chk_EcLstsEmlD([ 'c'=>'0', 'lsts'=>$this->ec_lsts_id, 'eml'=>$this->cnt_eml_2 ]);
				if($__eml_2->e == 'ok'){ $__emllsts_no = 'ok'; }
			}
			if(!isN($this->cnt_eml_3)){
				$__eml_3 = $this->Chk_EcLstsEmlD([ 'c'=>'0', 'lsts'=>$this->ec_lsts_id, 'eml'=>$this->cnt_eml_3 ]);
				if($__eml_3->e == 'ok'){ $__emllsts_no = 'ok'; }
			}

			if($__emllsts_no == 'ok'){
				$this->hb = 'no';
				$this->hb_w['eclsts'] .= TX_MLDUPLILST.HTML_S;
			}

			if(isN($this->cnt_nm) && isN($this->cnt_ap)){

				if($this->cnt_nm_disallow != 'ok'){
					$this->hb = 'no';
					$this->hb_w['eclsts'] .= TX_NMINGRSBD.HTML_S;
				}

			}

			if(!isN($this->ec_lsts_sgm)){

				$_sgm_dt = GtEcLstsSgmDt([ 'id'=>$this->ec_lsts_sgm ]);

				if(isN($_sgm_dt->id)){
					$this->hb = 'no';
					$this->hb_w['eclstssgm'] .= TX_SGMNEXST.HTML_S;
				}

				if(!isN($_sgm_dt->lsts->id) && $_sgm_dt->lsts->id != $this->ec_lsts_id){
					$this->hb = 'no';
					$this->hb_w['eclstssgm'] .= TX_SGMNNEQL.HTML_S;
				}

			}

		}
	}


	private function C_SmsCmpg(){
		if($this->sms_cmpg_msj != NULL || $this->smssnd_msj != NULL){

			if($this->smssnd_msj != NULL && $this->smssnd_msj != ''){ $_msj = $this->smssnd_msj; }
			elseif($this->sms_cmpg_msj != NULL && $this->sms_cmpg_msj != ''){ $_msj = $this->sms_cmpg_msj; }

			//$__prg = '#^[a-zA-Z0-9 ]+$#';

			if($_msj != '' && $_msj != NULL){
				$_msj = trim($_msj);
				$this->smssnd_msj = str_replace($this->sms_cmpg_msj_k, $this->sms_cmpg_msj_r, $_msj);
				$_msj = str_replace($this->sms_cmpg_msj_k, $this->sms_cmpg_msj_r, $_msj);
			}

			$__prg = '/^[a-zA-Z0-9 :!\[\]@#¿!<>&"()$%{}*+,.;=\/?-]+$/';
			if($this->smssnd_c != NULL && strlen($this->smssnd_cel) == 10){ $__snd_c = $this->smssnd_c; }else{ $__snd_c = 57; }

			$this->nw_smssnd_cel = $__snd_c.$this->smssnd_cel;

			if($_msj != NULL && $_msj != ''){

				if(!preg_match($__prg, $_msj)){
					$this->hb = 'no';
					$this->hb_w['smscmpg'] .= TX_MSNCNTACNT.HTML_S;
				}

				if(strlen($_msj) > 160){
					$this->hb = 'no';
					$this->hb_w['smscmpg'] .= TX_MSNS.'['.$_msj.'] '.TX_DMSDXTNS.' ('.strlen($_msj).')'.HTML_S;
				}

			}

			if(strlen($this->smssnd_cel) != 10 || $this->smssnd_cel == NULL || !is_numeric($this->smssnd_cel) ){
				$this->hb = 'no';
				$this->hb_w['smscmpg'] .= TX_PRBNMRDTN.HTML_S;
			}

			if($this->Chk_SmsSndD([ 'c'=>'0', 'cmpg'=>$this->sms_cmpg_id, 'cel'=>$this->nw_smssnd_cel ])->e == 'ok'){
				$this->hb = 'no';
				$this->hb_w['smscmpg'] .= TX_NMDPLCD.HTML_S;
			}

		}
	}

	//-------------- Verificación de Integralidad de Datos - End --------------//

	public function Upd_Rw($p=NULL){

		global $__cnx;

		if($p['w'] != 'ok'){

			$updateSQL = sprintf("UPDATE ".DBP.".up_col SET upcol_est=%s, upcol_w=%s WHERE id_upcol=%s",
							   GtSQLVlStr(_CId('ID_UPEST_ON'), "int"),
							   GtSQLVlStr(NULL, "text"),
							   GtSQLVlStr($this->id_upcol, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD || $this->demo){
				$_r['e'] = 'ok';
			}else{
				$_r['e'] = 'no';
			}
			$rtrn = _jEnc($_r);
			if(!isN($rtrn)){ return($rtrn); }
		}

	}

	public function Upd_Rw_W($w=NULL){

		global $__cnx;

		if(!isN($this->hb_w)){

			$__w_go = implode(' | ', $this->hb_w);

			$updateSQL = sprintf("UPDATE ".DBP.".up_col SET upcol_est=%s, upcol_w=%s WHERE id_upcol=%s",
							   GtSQLVlStr(_CId('ID_UPEST_W'), "int"),
							   GtSQLVlStr(ctjTx($__w_go,'out'), "text"),
							   GtSQLVlStr($this->id_upcol, "int")); //echo $updateSQL;

			$Result_UPD = $__cnx->_prc($updateSQL);

		}

		if($Result_UPD || $this->demo){
			$_r['e'] = 'ok';
		}else{
			$_r['e'] = 'no';
		}

		if(!isN($_r)){ return _jEnc($_r);  }
	}



	private function Chk_SmsSndD($_p=NULL){

		global $__cnx;

		if($_p['cmpg'] != NULL && $_p['cel'] != NULL && $_p['c'] != NULL){

			$Qry = "SELECT *
						FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND."
						WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = '".$_p['cmpg']."' AND smssnd_cel = '".$_p['cel']."'
						GROUP BY smssnd_cel
					    ORDER BY id_smssndcmpg";
			$DtRg = $__cnx->_qry($Qry); $row_DtRg = $DtRg->fetch_assoc(); $Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > $_p['c']){
				$_v['e'] = 'ok';
			}else{
				$_v['e'] = 'no';
			}

			$__cnx->_clsr($DtRg);

		}


		return _jEnc($_v);

	}

	private function Chk_EcLstsEmlD($_p=NULL){

		global $__cnx;

		if(!isN($_p['lsts']) && !isN($_p['eml']) && !isN($_p['c'])){

			$Qry = "SELECT id_eclstseml
					FROM ".TB_EC_LSTS_EML."
							INNER JOIN ".VW_CNT_EML." ON eclstseml_eml = id_cnteml
					WHERE eclstseml_lsts = ".GtSQLVlStr($_p['lsts'], "int")." AND cnteml_eml = ".GtSQLVlStr( strtolower($_p['eml']), "text")."
					GROUP BY cnteml_eml
					ORDER BY id_cnteml";

			$DtRg = $__cnx->_qry($Qry, ['cmps'=>'ok']);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > $_p['c']){
					$_v['e'] = 'ok';
				}else{
					$_v['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_v);

	}


	private function C_Act(){
		if(!isN($this->id_act)){

			$_dt = GtActDt([ 'id'=>$this->id_act ]);

			if(isN($_dt->id)){
				$this->hb = 'no'; $this->hb_w['mdlcntest'] = 'No existe actividad relacionada'.HTML_S;
			}
		}
	}

	private function C_Tra(){

		if(!isN($this->tra_col)){

			$_dt = GtTraColDt(['id'=>$this->tra_col ]);

			if(isN($_dt->id)){
				$this->hb = 'no'; $this->hb_w['tracol'] = 'No existe columna relacionada'.HTML_S;
			}

		}

	}

	private function C_Plcy($p=NULL){

		if( !isN($this->plcy_id) ){

			$___plcydt = GtClPlcyDt([ 'id'=>$this->plcy_id ]);

			if(!isN($___plcydt->id) && !isN($this->cl->id)){
				if($___plcydt->cl->id != $this->cl->id){
					$this->hb = 'no'; $this->hb_w['plcyid'] = 'Not id policy for same account'.HTML_S;
				}
			}

		}

	}

}



?>