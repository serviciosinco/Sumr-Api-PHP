<?php
	
	//-------- Filtros Basicos --------//

		if(_ChckMd('ls_are_all','ok')){ $_all = 'ok'; }else{ $_all = 'no'; }
		
		$this->c_flt .= LsClAre([
									'cnx'=>$_c_r,
									'id'=>'_mdlfl_are'.$this->id_rnd, 
									'v'=>'id_clare', 
									'va'=>$this->_gpj('id_clare'), 
									'rq'=> 2, 
									'mlt'=>'ok', 
									'attr'=> ['send-id'=>'id_clare', 'send-fk'=>'ok'],
									'flt' => 'ok',
									'all' => $_all
								]); 
									
		$this->c_flt .= LsMdl('_mdlfl_mdl'.$this->id_rnd, 'mdl_enc', $this->_gpj('mdl_enc'), _MdlTx(TX_SLCMDL) , 2, 'ok', ['attr'=>['send-id'=>'mdl_enc'], 'tp_k'=>$this->gt->tsb, 'flt_are'=>'ok' ] );

		
		$l = __Ls([ 'k'=>'sx', 'id'=>'_mdlfl_sx'.$this->id_rnd, 'va'=>$this->_gpj('cnt_sx'), 'ph'=>FM_LS_SISSX, 'mlt'=>'ok', 'attr'=>['send-id'=>'cnt_sx'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;

		$this->c_flt .= LsCntEst([ 'id'=>'_mdlfl_est'.$this->id_rnd, 'v'=>'siscntest_enc', 'va'=>$this->_gpj('siscntest_enc'), 'v_go'=>'enc', 'lbl'=>TX_SLCEST, 'rq'=>2, 'mlt'=>'ok', 'mdlstp'=>$this->mdlstp->id, 'attr'=>['send-id'=>'siscntest_enc'], 'cnx'=>$this->c_r ]);
		
		$this->c_flt .= LsCntEstTp('_mdlfl_esttp'.$this->id_rnd, 'siscntesttp_enc', $this->_gpj('siscntesttp_enc'), TX_SLCETP,  2,  'ok', ['mdlstp'=>$this->mdlstp->id, 'attr'=>['send-id'=>'siscntesttp_enc'] ] );

		
		$this->c_flt .= LsSis_Noi('_mdlfl_siscntnoi'.$this->id_rnd, 'siscntnoi_enc', $this->_gpj('siscntnoi_enc'), TX_NINTRS,  2, 'ok', ['attr'=>['send-id'=>'siscntnoi_enc']] );
		$this->c_flt .= LsSis_Md('_mdlfl_md'.$this->id_rnd,'sismd_enc', $this->_gpj('sismd_enc'),FM_LS_MD, 2, 'ok', ['attr'=>['send-id'=>'sismd_enc']] );
		$this->c_flt .= LsCntFnt('_mdlfl_fnt'.$this->id_rnd,'sisfnt_enc', $this->_gpj('sisfnt_enc'),FM_LS_CNTFNT, 2, 'ok', ['attr'=>['send-id'=>'sisfnt_enc']] );
		$this->c_flt .= LsCntTp('_mdlfl_siscnttp'.$this->id_rnd, 'siscnttp_enc', $this->_gpj('siscnttp_enc'), FM_LS_VNCU, 2, 'ok', ['attr'=>['send-id'=>'siscnttp_enc']] );
		$this->c_flt .= LsUs('_mdlfl_us'.$this->id_rnd,'us_enc', $this->_gpj('us_enc'), 'Usuarios', 2, 'ok', ['attr'=>['send-id'=>'us_enc','send-fk'=>'ok'] ] ); 
		$l = __Ls([ 'k'=>'sis_eml_est', 'id'=>'cnteml_est'.$this->id_rnd, 'va'=>$this->_gpj('cnteml_est'), 'ph'=>'- seleccione estado email -', 'mlt'=>'ok', 'attr'=>['send-id'=>'cnteml_est'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;
		/*$this->c_flt .= LsCdOld([ 'id'=>'_mdlfl_cd'.$this->id_rnd, 'v'=>'siscd_enc', 'mlt'=>'ok', 'va'=>$this->_gpj('siscd_enc'), 'ph'=>'Ciudad', 'rq'=>2, 'attr'=>['send-id'=>'siscd_enc', 'send-fk'=>'ok'], 'cnx'=>$this->c_r ]);*/
	
		$l = __Ls([ 'k'=>'num', 'id'=>'_mdlfl_cnt_tot_mdlcnt'.$this->id_rnd, 'va'=>$this->_gpj('cnt_tot_mdlcnt'), 'ph'=>'Numero de Interes', 'mlt'=>'no', 'attr'=>['send-id'=>'cnt_tot_mdlcnt','send-fk'=>'ok'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;
        
		//-------- Ciudades --------//
		$this->c_flt .= h2("Ciudad"); 
		$this->c_flt .= LsCdOld([ 'id'=>'_mdlfl_cd_nco'.$this->id_rnd, 'v'=>'siscd_enc', 'mlt'=>'ok', 'va'=>$this->_gpj('_mdlfl_cd_nco'), 'ph'=>'Nació', 'rq'=>2, 'attr'=>['send-id'=>'_mdlfl_cd_nco', 'send-fk'=>'ok'], 'cnx'=>$this->c_r ]);
		$this->c_flt .= LsCdOld([ 'id'=>'_mdlfl_cd_vvo'.$this->id_rnd, 'v'=>'siscd_enc', 'mlt'=>'ok', 'va'=>$this->_gpj('_mdlfl_cd_vvo'), 'ph'=>'Vivió', 'rq'=>2, 'attr'=>['send-id'=>'_mdlfl_cd_vvo', 'send-fk'=>'ok'], 'cnx'=>$this->c_r ]);
		$this->c_flt .= LsCdOld([ 'id'=>'_mdlfl_cd_vve'.$this->id_rnd, 'v'=>'siscd_enc', 'mlt'=>'ok', 'va'=>$this->_gpj('_mdlfl_cd_vve'), 'ph'=>'Vive', 'rq'=>2, 'attr'=>['send-id'=>'_mdlfl_cd_vve', 'send-fk'=>'ok'], 'cnx'=>$this->c_r ]);
			
		//-------- Pais --------//
		$this->c_flt .= h2("País (Datos Relacionados)");
		$this->c_flt .= LsPs([ 'id'=>'_mdlfl_ps_rltd'.$this->id_rnd, 'v'=>'sisps_enc', 'mlt'=>'ok', 'va'=>$this->_gpj('_mdlfl_ps_rltd'), 'ph'=>'Relacionado', 'rq'=>2, 'attr'=>['send-id'=>'_mdlfl_ps_rltd', 'send-fk'=>'ok'] ]);

		
		
	//-------- Organizaciones --------//
		
		
		$__org_tp = __LsDt([ 'k'=>'org_tp', 'cl'=>DB_CL_ID ]);
		
		if(!isN($__org_tp->ls->org_tp)){

			$this->c_flt .= h2("Organizaciones (Relacionadas)");

			foreach($__org_tp->ls->org_tp as $_k=>$_v){
				
				$_gtvl = $this->_gpj('org');
				
				if(!isN($_gtvl->{$_v->key->vl})){ 
					if(is_array($_gtvl)){
						$_gtvl_v = $_gtvl[$_v->key->vl];
					}else{	
						$_gtvl_v = $_gtvl->{$_v->key->vl}; 
					}
				}
				
				$_key = $_v->key->vl.'_'.$this->id_rnd;
				$this->c_flt .= LsOrg('_mdlfl_'.$_key, 'org_enc', $_gtvl_v, '', '', $_v->key->vl, 'orgsdscnt_org_'.$___Ls->gt->tsb, 'ok', ['attr'=>['send-id'=>$_v->key->vl, 'send-grp'=>'org' ]]); 
				$this->js .= JQ_Ls('_mdlfl_'.$_key, _Cns('TX_SLC_'.strtoupper($_v->key->vl)));
			}

		}
	
		
	
	//-------- Periodos --------//	

		$this->c_flt .= h2(TX_PRDO); 
		$this->c_flt .= LsMdlSPrd('mdlcnt_prd_i'.$this->id_rnd,'mdlsprd_enc', $this->_gpj('mdlcnt_prd_i'), TX_PRDING, 2, 'ok', ['attr'=>['send-id'=>'mdlcnt_prd_i', 'send-fk'=>'ok','tp'=>$___Ls->mdlstp->tp], 'tp_mdl' => $this->gt->tsb ] ); 
	
		$this->c_flt .= LsMdlSPrd('mdlcnt_prd_wnt'.$this->id_rnd,'mdlsprd_enc', $this->_gpj('mdlcnt_prd_wnt'), TX_PRD_A, 2, 'ok', ['attr'=>['send-id'=>'mdlcnt_prd_wnt', 'send-fk'=>'ok','tp'=>$___Ls->mdlstp->tp], 'tp_mdl' => $this->gt->tsb ] );

	//-------- Pushmail --------//	

	$this->c_flt .= h2(TX_PSHML); 
	$this->c_flt .= LsEc('mdlcnt_ec'.$this->id_rnd,'ec_enc', $this->_gpj('mdlcnt_ec'), '', '', '' , ['tp'=>$this->gt->tsb, 'attr'=>['send-id'=>'mdlcnt_ec','send-fk'=>'ok'] ]); 

	$this->c_flt .= LsSis_SiNo('mdlcntec_snd'.$this->id_rnd, 'id_sissino', $this->_gpj('mdlcntec_snd'), 'Enviados', 2, 'ok', '', ['attr'=>['send-id'=>'mdlcntec_snd','send-fk'=>'ok'] ]);
	$this->js .= JQ_Ls('mdlcntec_snd'.$this->id_rnd);
	$this->c_flt .= LsSis_SiNo('mdlcntec_op'.$this->id_rnd, 'id_sissino', $this->_gpj('mdlcntec_op'), 'Abierto', 2, 'ok', '', ['attr'=>['send-id'=>'mdlcntec_op','send-fk'=>'ok'] ]);
	$this->js .= JQ_Ls('mdlcntec_op'.$this->id_rnd);
	$this->c_flt .= LsSis_SiNo('mdlcntec_clk'.$this->id_rnd, 'id_sissino', $this->_gpj('mdlcntec_clk'), 'Click', 2, 'ok', '', ['attr'=>['send-id'=>'mdlcntec_clk','send-fk'=>'ok'] ] );
	$this->js .= JQ_Ls('mdlcntec_clk'.$this->id_rnd);
	//-------- horarios --------//	

	

		$this->c_flt .= h2(TX_PSG_HRA);
		
		$this->c_flt .= LsMdlSHrs('mdl_s_hro'.$this->id_rnd,'mdlssch_enc', $this->_gpj('mdl_s_hro'), TX_PSG_HRA, '', '', ['attr'=>['send-id'=>'mdl_s_hro','send-fk'=>'ok','tp'=>$___Ls->mdlstp->tp]] ); 

		
	//-------- Checklist --------//
	
		$this->c_flt .= h2('Checklist');
		
		$Ls_Chk = __LsDt(['k'=>'sis_chk', 'cl'=>DB_CL_ID ]); 
										
		foreach($Ls_Chk->ls->sis_chk as $chk_k => $chk_v){
			$chkf = $this->_gpj('chk');
			if(is_array($chkf)){ $chkf_v = $chkf[$chk_v->cns]; }elseif(is_object($chkf)){ $chkf_v = $chkf->{$chk_v->cns}; }
			$this->c_flt .= LsSis_SiNo('_mdlcntfl_chk_'.$chk_v->cns.$this->id_rnd, 'id_sissino', $chkf_v, $chk_v->tt, 2, 'ok', '', ['attr'=>['send-id'=>$chk_v->cns, 'send-grp'=>'chk' ]] ); 	
			$this->js .= JQ_Ls('_mdlcntfl_chk_'.$chk_v->cns.$this->id_rnd, $chk_v->tt);
		}

		$this->c_flt .= HTML_inp_tx('_mdlcnt_cg'.$this->id_rnd, TX_GSTN, $this->_gpj('mdlcnt_cg'), FMRQD_NMR, ['attr'=>['send-id'=>'mdlcnt_chknct']] );
		
		
		$this->js .= JQ_Ls('_mdlfl_act'.$this->id_rnd, FM_LS_ASGNTRS);
		$this->js .= JQ_Ls('_mdlfl_are'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);
		$this->js .= JQ_Ls('_mdlfl_est'.$this->id_rnd, FM_LS_EST); 
		$this->js .= JQ_Ls('_mdlfl_esttp'.$this->id_rnd, TX_ETP);
		$this->js .= JQ_Ls('_mdlfl_siscntnoi'.$this->id_rnd,FM_LS_NOI);				
		$this->js .= JQ_Ls('_mdlfl_md'.$this->id_rnd,FM_LS_MD);
		$this->js .= JQ_Ls('_mdlfl_fnt'.$this->id_rnd,FM_LS_CNTFNT);
		$this->js .= JQ_Ls('_mdlfl_mdl'.$this->id_rnd,TX_MDLO);
		$this->js .= JQ_Ls('_mdlfl_siscnttp'.$this->id_rnd,FM_LS_VNCU);
		$this->js .= JQ_Ls('_mdlfl_us'.$this->id_rnd,'Usuarios');
		
		$this->js .= JQ_Ls('mdlcnt_prd'.$this->id_rnd, 'ingreso');
		$this->js .= JQ_Ls('mdlcnt_prd_wnt'.$this->id_rnd, TX_NTRS);
		$this->js .= JQ_Ls('mdlcnt_prd_i'.$this->id_rnd, TX_NTRS);
		$this->js .= JQ_Ls('mdl_s_hro'.$this->id_rnd, TX_PSG_HRA);
		$this->js .= JQ_Ls('mdlcnt_ec'.$this->id_rnd, TX_PSHML);
		
		if(SISUS_ID == 181){
			$this->js .= JQ_Ls('_mdlfl_mds'.$this->id_rnd,'prueba');
		}
		
		//$this->js .= JQ_Ls('_mdlfl_cd'.$this->id_rnd, 'Ciudad');
		
		$this->js .= JQ_Ls('_mdlfl_cd_nco'.$this->id_rnd, 'Nació');
		$this->js .= JQ_Ls('_mdlfl_cd_vvo'.$this->id_rnd, 'Vivió');
		$this->js .= JQ_Ls('_mdlfl_cd_vve'.$this->id_rnd, 'Vive');
		
		$this->js .= JQ_Ls('_mdlfl_ps_rltd'.$this->id_rnd, 'País Relacionado');
				
?>