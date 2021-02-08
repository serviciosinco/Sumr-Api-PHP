<?php

class CRM_Cnt extends CRM_Main{

    function __construct($p=NULL) {

        global $__cnx;
        global $__dt_cl;

		$this->n_try = 20;
		$this->snd->eml->adm = 'ok';
		$this->snd->eml->us = 'ok';

		if(!isN($__dt_cl) && !isN($__dt_cl->id)){
			$this->cl = $__dt_cl;
		}elseif(!isN($p['cl'])){
			$this->cl = GtClDt($p['cl']);
		}

		if(!isN($this->cl->bd)){ $this->bd=_BdStr($this->cl->bd); }else{ $this->bd=''; }

        $this->cnt_eml_all = array();

        // Todo sobre el navegador
        $browser = new Browser();
        $_dvc['Plataforma'] = $browser->getPlatform();
        $_dvc['Navegador'] = $browser->getBrowser();
        $_dvc['Version'] = $browser->getVersion();
        $_dvc['Ip'] = KnIp('on');
        $_dvc_j = json_encode($_dvc);

        // Todo sobre la referencia
        $_rfr = _Gt_Srv_Ref();
        $_ref['srv'] = $_rfr->srv;
        $_ref['pag'] = $_rfr->pag;
        $_ref_j = json_encode($_ref);


		//Instancia en relacion a Organizaciones

		$this->_org = new CRM_Org();
		$this->_vtex = new CRM_VTex([ 'cl' => $this->cl ]);

		$this->_org->bd = $this->bd;

        $this->dvc = $_dvc_j;
        $this->ref = $_ref_j;

    }

    function __destruct() {

		parent::__destruct();

   	}

    public function _Cnt(){

		$_r['e'] = 'no';

		$__dtcnt = $this->_CntChkByKey();

		if(($__dtcnt->e != 'ok' || isN($__dtcnt->id)) && ( !isN($this->cnt_tel) || !isN($this->cnt_dc) || !isN($this->cnt_eml) )){

			$__dtcnt_in = $this->InCnt();

			$_r['_r'] = $__dtcnt_in;
			$_r['_p'] = $__dtcnt_in->e;
			$_r['_q'] = $__dtcnt_in->q;

			if($__dtcnt_in->e == 'ok'){
				$__dtcnt = $this->Chck([ 'id'=>$__dtcnt_in->i, 'tp'=>$this->cnt_dc_tp, 'chk'=>'id' ]);
			}else{
				$__dtcnt = NULL;
				$_r['e'] = 'no';
				$_r['w'] = $__dtcnt_in->w;
			}
		}

		if(!isN($__dtcnt->id)){

			$_r['i'] = $__dtcnt->id;
			$_r['enc'] = $__dtcnt->enc;

			$_r['in']['dc_all'] = $this->InCntDcAll($__dtcnt->id);
			$_r['in']['eml_all'] = $this->InCntEmlAll($__dtcnt->id);
			$_r['in']['tel_all'] = $this->InCntTelAll($__dtcnt->id);
			$_r['in']['bd_all'] = $this->InCntBdAll($__dtcnt->id);
			$_r['in']['cnttp_all'] = $this->InCntTpAll($__dtcnt->id);
			$_r['in']['org_all'] = $this->CntOrgAll($__dtcnt->id);
			$_r['in']['cd_all'] = $this->CntCdAll($__dtcnt->id);
			$_r['in']['cd_all_rel'] = $this->CntCdAllRel($__dtcnt->id);
			$_r['in']['extall'] = $this->ExtAll();
			$_r['in']['cref'] = $this->_Cnt_Cref();
			$_r['in']['plcy'] = $this->InCntPlcyAll($__dtcnt->id);
			$_r['in']['vtex_all'] = $this->InCntVtexAll($__dtcnt->id);

			$_r['upd'] = $this->CmpCnt();

		}else{

			$_r['w'] = 'Not found';
			//$_r['tmp__cnt_id'] = $this->cnt_id;
			//$_r['u_all'] = $this->u_all;

		}

		if($__dtcnt->e == 'ok'){ $_r['e'] = 'ok'; $_r['d'] = $__dtcnt; }

		return _jEnc($_r);

	}


	public function _CntChkByKey(){

		if(!isN($this->cnt_dc)){
			$__dtcnt = $this->Chck([ 'id'=>$this->cnt_dc, 'tp'=>$this->cnt_dc_tp ]);
			if($__dtcnt->e == 'ok'){
				$this->u_all .= print_r($__dtcnt, true).'Found it with doc -> '.$this->cnt_dc.HTML_BR;
			}
		}

		if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
			$__dtcnt = $this->Chck([ 'id'=>filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL), 'chk'=>'eml' ]);
			if($__dtcnt->e == 'ok'){
				$this->u_all .= 'Found it with email? -> '.$this->cnt_eml.HTML_BR;
			}
		}

		if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
			$__dtcnt = $this->Chck([ 'id'=>filter_var($this->cnt_tel, FILTER_VALIDATE_INT), 'chk'=>'tel' ]);
			if($__dtcnt->e == 'ok'){
				$this->u_all .= 'Found it with tel? -> '.$this->cnt_eml.HTML_BR;
			}
		}

		if($__dtcnt->e != 'ok' || isN($__dtcnt->id) ){
			$__dtcnt = $this->Chck([ 'id'=>$this->cnt_id, 'chk'=>'enc' ]);
			if($__dtcnt->e == 'ok'){
				$this->u_all .= 'Found it with id -> '.$this->cnt_id.HTML_BR;
			}
		}

		return $__dtcnt;

	}

    public function InEncCnt(){

        $__dtcnt = $this->Chck([ 'id'=>$this->cnt_dc, 'tp'=>$this->cnt_dc_tp ]);

        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
            $__dtcnt = $this->Chck([ 'id'=>filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL), 'chk'=>'eml' ]);
        }
        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
            $__dtcnt = $this->Chck([ 'id'=>$this->cnt_id, 'chk'=>'enc' ]);
        }

        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){

            $__dtcnt_in = $this->InCnt();

            $_r['_p'] = $__dtcnt_in->e;
            $_r['_q'] = $__dtcnt_in->q;

            if($__dtcnt_in->e == 'ok'){
                $__dtcnt = $this->Chck([ 'id'=>$__dtcnt_in->i, 'tp'=>$this->cnt_dc_tp, 'chk'=>'id' ]);
            }else{
                $__dtcnt = NULL;
                $_r['e'] = 'no';
                $_r['w'] = $__dtcnt_in->w;
            }
        }

        if(!isN($__dtcnt->id)){

            if(!isN($this->enc_id)){

                $__dtenc_in = $this->MdlEncCntIn( [   'enc'=>$this->enc_id,
                                                      'cnt'=>$__dtcnt->id]);
                $this->u_all .= $__dtenc_in->s;

                if(!isN($__dtenc_in->id)){

                    $__dtcntdts_in = $this->InEncCntDtsAll( ['enccnt'=>$__dtenc_in->id]);

                    $this->u_all .= $__dtcntdts_in->s;

                    if($__dtcntdts_in->e == 'ok'){
                        $_r['e'] = 'ok';
                    }else{
                        $_r['e'] = 'no';
                    }

                }

            }

        }

        $_r['i'] = $__dtenc_in->id;

        $this->InCntDcAll($__dtcnt->id);
        $this->InCntEmlAll($__dtcnt->id);
        $this->InCntTelAll($__dtcnt->id);
        $this->InCntTpAll($__dtcnt->id);
        $this->CntOrgAll($__dtcnt->id);
        $this->CntCdAll($__dtcnt->id);
        $this->CntCdAllRel($__dtcnt->id);
        $this->InCntPlcyAll($__dtcnt->id);

        $_r['u_all'] = $this->u_all;

        return _jEnc($_r);

    }

    public function MdlExt(){


    }

    public function MdlCnt(){

        //-------------- Check Not Exists --------------//

            $__dtcnt = $this->Chck([ 'id'=>$this->cnt_dc, 'tp'=>$this->cnt_dc_tp ]);

            if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
	            $__dtcnt = $this->Chck([ 'id'=>filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL), 'chk'=>'eml' ]);
	        }

            if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
	            $__dtcnt = $this->Chck([ 'id'=>$this->cnt_id, 'chk'=>'enc' ]);
	        }

	        if( ($__dtcnt->e != 'ok' || isN($__dtcnt->id)) && !isN($this->mdlcnt_enc) ){
	            $__dtcnt = $this->Chck([ 'id'=>$this->mdlcnt_enc, 'chk'=>'mdlcnt_enc' ]);
			}

		//-------------- If Not Exists - Process --------------//

            if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){

				$_r['log'][] = 'Hast to insert cnt';

                /*$_r['tmp_InCnt'] =*/ $__dtcnt_in = $this->InCnt();

                if($__dtcnt_in->e == 'ok'){
					/*$_r['tmp']['detailcnt'] =*/ $__dtcnt_in;

					$_r['log'][] = 'Cnt inserted success';

					$__dtcnt = $this->Chck([ 'id'=>$__dtcnt_in->i, 'tp'=>$this->cnt_dc_tp, 'chk'=>'id' ]);

					if($__dtcnt->e == 'ok' && !isN($__dtcnt)){
						/*$_r['tmp']['create_cnt_b'] = */$__dtcnt;
					}else{
						/*$_r['tmp']['create_cnt_b']['w'] = */$__dtcnt;
					}

                }else{

					$_r['log'][] = 'Cnt was not inserted success';
                    $__dtcnt = NULL;
                    $_r['e'] = 'no';
                    $_r['w'][] = 'Problem on InCnt:'.print_r($__dtcnt_in, true);
				}

            }else{

				$_r['cnt_t'] = $__dtcnt;

			}

			if(isN($__dtcnt->id)){

				$_r['w'][] = 'No $__dtcnt->id PROBLEM';
				$_r['w'][] = $__dtcnt;

			}else{

				//-------------- Save Documents All --------------//

					$_in_cnt_all_dc = $this->InCntDcAll($__dtcnt->id);

					if($_in_cnt_all_dc->e == 'ok'){
						$_r['cnt_all_dc'] = $_in_cnt_all_dc;
					}else{
						$_r['w'][] = 'Problems on save ids';
						$_r['w'][] = $_in_cnt_all_dc->w;
					}

				//-------------- Save Email All --------------//

					$_in_cnt_all_eml = $this->InCntEmlAll($__dtcnt->id);

					if($_in_cnt_all_eml->e != 'ok'){
						$_r['w'][] = 'Problems on save emails';
					}

				//-------------- Save Phones All --------------//

					$_in_cnt_all_tel = $this->InCntTelAll($__dtcnt->id);

					if($_in_cnt_all_tel->e != 'ok'){
						$_r['w'][] = 'Problems on save phones';
						$_r['w'][] = $_in_cnt_all_tel->w;
					}

				//-------------- Save Types All --------------//

					$_in_cnt_all_tp = $this->InCntTpAll($__dtcnt->id);

					if($_in_cnt_all_tp->e != 'ok'){
						$_r['w'][] = 'Problems on save lead types';
					}

				//-------------- Save Type Modules All --------------//

					$_in_cnt_all_tpmdl = $this->InCntTpMdlAll($__dtcnt->id);

					if($_in_cnt_all_tpmdl->e != 'ok'){
						$_r['w'][] = 'Problems on save type module';
					}

				//-------------- Save Databases All --------------//

					$_in_cnt_all_bd = $this->InCntBdAll($__dtcnt->id);

					if($_in_cnt_all_bd->e != 'ok'){
						$_r['w'][] = 'Problems on save database relationed';
					}

				//-------------- Save Organizations All --------------//

					$_in_cnt_all_org = $this->CntOrgAll($__dtcnt->id);

					if($_in_cnt_all_org->e != 'ok'){
						$_r['w'][] = 'Problems on save lead organizations';
						$_r['w'][] = $_in_cnt_all_org->w;
					}else{
						$_r['org'] = $_in_cnt_all_org;
					}

				//-------------- Save Cities All --------------//

					$_in_cnt_all_cd = $this->CntCdAll($__dtcnt->id);

					if($_in_cnt_all_cd->e != 'ok'){
						$_r['w'][] = 'Problems on save lead cities';
						$_r['w']['cdall'] = $_in_cnt_all_cd;
					}else{
						$_r['cdall'] = $_in_cnt_all_cd;
					}

				//-------------- Save Cd Related All --------------//

					$_in_cnt_all_cd_rel = $this->CntCdAllRel($__dtcnt->id);

					if($_in_cnt_all_cd_rel->e != 'ok'){
						$_r['w'][] = 'Problems on save rel cities ';
					}else{
						$_r['cdrel'] = $_in_cnt_all_cd_rel;
					}

				//-------------- Save Policy All --------------//

					$_in_cnt_all_plcy = $this->InCntPlcyAll($__dtcnt->id);

					if($_in_cnt_all_plcy->e != 'ok'){
						$_r['w'][] = 'Problems on save policies data';
						/*if(Dvlpr()){*/ $_r['w'][] = $_in_cnt_all_plcy; /*}*/
					}else{
						$_r['plcy'] = $_in_cnt_all_plcy;
					}

				//-------------- Save Phones All --------------//

					if(!$this->api && $this->ck_in != 'no' && !isN($__dtcnt->id)){

						$_in_cnt_ck = $this->CntCk_In($__dtcnt->id);

						if($_in_cnt_ck->e != 'ok'){
							$_r['w'][] = 'Problems on save cookie data';
							$_r['w'][] = $_in_cnt_ck;
						}
					}

					$this->_mdldt = GtMdlDt([ 'bd'=>$this->cl->bd, 'id'=>$this->gt_mdl_id ]);
					/*$_r['tmp']['create_cnt_a'] = $__dtcnt;
					/*$_r['tmp']['hst'] = HST;*/

					//$_r['tmp___mdldt'] = $this->_mdldt;

					if($this->_mdldt->tp->unq == 'ok'){
						if(!isN($this->gt_mdl_id)){
							$__dtmdlcnt = $this->ChckMdlCnt([ 'cnt'=>$__dtcnt->id, 'mdl'=>$this->gt_mdl_id ]);
						}elseif(!isN($this->mdlcnt_enc)){
							$__dtmdlcnt = $this->ChckMdlCnt([ 'enc'=>$this->mdlcnt_enc ]);
						}
					}else{
						$_r['status'][] = 'Not unique module, so, can create new';
					}

					if((($__dtmdlcnt->e == 'ok' || isN($__dtmdlcnt)) && isN($__dtmdlcnt->id)) && !isN($__dtcnt->id)){

						//$_r['tmp___mdlcnt'] = $__dtmdlcnt;

						$__prd = !isN($this->mdl_prd)?$this->mdl_prd:$this->_mdldt->prd->id;

						$__mdlcnt_in = $this->MdlCnt_In([
														'tp'=>$this->mdlstp->id,
														'fi'=>$this->mdlcnt_fi,
														'm'=>$this->mdlcnt_md,
														'm_k'=>$this->mdlcnt_md_k,
														'm_adg'=>$this->mdlcnt_md_adg,
														'est'=>$this->cnt_est,
														'fnt'=>$this->cnt_fnt,
														'bd'=>$this->mdlcnt_bd,
														'cnt'=>$__dtcnt->id,
														'mdl'=>$this->gt_mdl_id,
														'prd'=>$__prd,
														'gen'=>$this->mdlcnt_gen,
														'mdl_tx'=>$this->mdl_tx,
														'noi'=>$this->noi,
														'noi_otu'=>$this->noi_otu,
														'noi_otp'=>$this->noi_otp,
														'chk_vll'=>$this->chk_vll,
														'chk_ner'=>$this->chk_ner,
														'chk_pss'=>$this->chk_pss,
														'fr'=>$this->mdlcnt_fr,
														'cl_sds'=>$this->cnt_clsds
													]);

						$_r['dtmdlcnt'] = $__mdlcnt_in;

						if($__mdlcnt_in->e == 'ok'){

							$_r['e'] = 'ok';

							$__dtmdlcnt = $this->ChckMdlCnt([ 'enc'=>$__mdlcnt_in->enc ]);

							if( !isN($this->cnt_prd) ){

								$_in_mdlcnt_prdin = $this->MdlCntPrdIn([ 'mdlcnt'=>$__dtmdlcnt->id, "prd"=>$this->cnt_prd ]);

								if($_in_mdlcnt_prdin->e != 'ok'){
									$_r['w'][] = 'Problems on save period';
									if(Dvlpr()){ $_r['w'][] = $_in_mdlcnt_prdin; }
								}

							}elseif( !isN($this->_mdldt->prd->id) ){

								$_in_mdlcnt_prdin = $this->MdlCntPrdIn([ 'mdlcnt'=>$__dtmdlcnt->id, "prd"=>$this->_mdldt->prd->id ]);

								if($_in_mdlcnt_prdin->e != 'ok'){
									$_r['w'][] = 'Problems on save period';
									if(Dvlpr()){ $_r['w'][] = $_in_mdlcnt_prdin; }
								}

							}

							$_r['enc'] = $__dtmdlcnt->enc;

							if($this->invk->by == _CId('ID_SISINVK_FORM')){
								$__Cl = new CRM_Cl();
								$__Cl->clflj_t = 'mdl_cnt_new';
								$__Cl->clflj_mre->mdlcnt_enc = $__dtmdlcnt->enc;
								$__flj = $__Cl->__flj();
								//$_r['tmp_flj'] = $__flj;
							}

						}else{
							$__dtmdlcnt = NULL;
							$_r['e'] = 'no';
							$_r['s_apr_in'] = $__mdlcnt_in->s;
							$_r['w_apr_in'] = $__mdlcnt_in->w;
							$this->w_all .= $_r['w'][] = 'MdlCnt:'.$__mdlcnt_in->s.$__mdlcnt_in->w;
						}

					}else{

						$_r['e'] = 'ok';
						if($__dtmdlcnt->e == 'ok' && !isN($__dtmdlcnt->id)){ $_r['m'] = 'MdlCnt exists so dont have to process'; }
						if(isN($__dtcnt->id)){ $_r['w'][] = 'NO CNT Datas'; }

						//$_r['w']['m2-mdlcnt'] = $__dtmdlcnt;

						if($__dtmdlcnt->e != 'ok'){ $_r['w'][] = '$__dtmdlcnt->e is '.$__dtmdlcnt->e; }
						if(isN($__dtmdlcnt->id)){ $_r['w'][] = '$__dtmdlcnt->id is '.$__dtmdlcnt->id; $_r['w'][] = $__dtmdlcnt; }
						$this->nw_id_mdlcnt = $__dtmdlcnt->id;

						//$_r['m2'] = $__dtmdlcnt;

					}

					if( !isN($this->cnt_sch) ){

						$_in_mdlcnt_schin = $this->MdlCntSchIn([ 'mdlcnt'=>$__dtmdlcnt->id, "sch"=>$this->cnt_sch ]);

						if($_in_mdlcnt_schin->e != 'ok'){
							$_r['w'][] = 'Problems on save schedule';
						}
					}

					if( !isN($this->cnt_hcntc) ){
						$_in_cnt_h_cntc = $_r['cnt_h_cntc'] = $this->CntHCntcIn([ 'cnt'=>$__dtcnt->id, "cntc"=>$this->cnt_hcntc ]);

						if($_in_cnt_h_cntc->e != 'ok'){
							$_r['w'][] = 'Problems on save CntHCntcIn';
						}

					}

					if( !isN($this->cnt_tpcntc) ){

						foreach($this->cnt_tpcntc as $_k => $_v){
							if(!isN($_v)){

								$_sve_cnt_tpcntc = $this->CntTpCntcIn([ 'cnt'=>$__dtcnt->id, "tp"=>$_v ]);

								if($_sve_cnt_tpcntc->e != 'ok'){
									$_r['wssss'][] = $_sve_cnt_tpcntc;
									$_r['w'][] = 'Problems on save CntTpCntcIn';
									break;
								}

							}
						}

					}

					$_r['i'] = $__dtmdlcnt->id;
					$_r['i_pc'] = $__dtmdlcnt->id;
					$_r['enc'] = $__dtmdlcnt->enc;
					$_r['i_pc_e'] = $__dtmdlcnt->e;
					$_r['cnt'] = $__dtcnt_in;

					$this->nw_id_mdlcnt = $__dtmdlcnt->id;
					$this->nw_id_mdlcnt_enc = $__dtmdlcnt->enc;

					//-------------- Save CmpCnt --------------//

						$_sve_cmpcnt = $this->CmpCnt();

						if($_sve_cmpcnt->e != 'ok'){
							$_r['w'][] = 'Problems on save CmpCnt';
						}else{
							$_r['upd'] = $_sve_cmpcnt;
						}

					//-------------- Save Comments --------------//

						if(!isN($this->cnt_cmn)){

							$_sve_mdlcnt_msj = $this->CmntIn();

							if($_sve_mdlcnt_msj->e != 'ok'){
								$_r['w'][] = 'Problems on save module message';
								$_r['w'][] = $_sve_mdlcnt_msj->w;
							}
						}

					//-------------- Save Medium --------------//

						if(!isN($this->mdlcnt_md)){

							$_sve_mdin = $this->MdIn([ 'tp'=>'mdl', 'mdlcnt'=>$__dtmdlcnt->id ]);

							if($_sve_mdin->e != 'ok'){
								$_r['w'][] = 'Problems on save MdIn';
								$_r['w'][] = $_sve_mdin->w;
							}else{
								$_r['mdin'] = $_sve_mdin;
							}

						}

					//-------------- Save All Extension Data --------------//

						$_sve_mdlcnt_extall = $this->ExtAll();

						if($_sve_mdlcnt_extall->e != 'ok'){
							$_r['w'][] = 'Problems on save extension data';
							$_r['extall'] = $_sve_mdlcnt_extall;
						}else{
							$_r['extall'] = $_sve_mdlcnt_extall;
						}

					//-------------- Save All Activities Data --------------//

						if(!isN($this->gt_act_id)){
							$_sve_mdlcnt_act = $this->MdlCntActIn();

							if($_sve_mdlcnt_act->e != 'ok'){
								$_r['w'][] = 'Problems on save activities data';
							}else{
								$_r['act'] = $_sve_mdlcnt_act;
							}
						}

					//-------------- Save All Activities Data --------------//

						$_sve_mdlcnt_attch = $this->MdlCntAttch();

						if($_sve_mdlcnt_attch->e != 'ok'){
							$_r['w'][] = 'Problems on save attachments';
							$_r['w'][] = $_sve_mdlcnt_attch;
						}

					//-------------- Save All Conversations Data --------------//

						if(!isN($this->maincnv_enc)){

							$_sve_mdlcnt_cnv = $this->MdlCntCnv();

							if($_sve_mdlcnt_cnv->e != 'ok'){
								$_r['w'][] = 'Problems on save conversation match';
								$_r['w'][] = $_sve_mdlcnt_cnv;
							}

						}

					//-------------- Get UALL --------------//

						$_r['u_all'] = $this->u_all;

					//-------------- Return Result --------------//

			}

			return _jEnc($_r);

    }



    public function Chck($p=NULL){

        global $__cnx;

        $Vl['e'] = 'no';

        if(!isN($p['id'])){

			if($p['chk'] == 'mdlcnt_enc'){
				$_q_slc = 'id_mdlcnt, mdlcnt_enc';
			}else{
				$_q_slc = 'id_cnt, cnt_enc';
			}


            if($p['chk'] == 'eml'){
                $__qry = sprintf('SELECT '.$_q_slc.' FROM '.$this->bd.TB_CNT.' WHERE id_cnt IN (SELECT cnteml_cnt FROM '.$this->bd.TB_CNT_EML.' WHERE cnteml_eml = %s) LIMIT 1', GtSQLVlStr($p['id'], 'text') );
            }elseif($p['chk'] == 'enc'){
                $__qry = sprintf('SELECT '.$_q_slc.' FROM '.$this->bd.TB_CNT.' WHERE cnt_enc = %s LIMIT 1', GtSQLVlStr($p['id'], 'text'));
            }elseif($p['chk'] == 'mdlcnt_enc'){
                $__qry = sprintf('SELECT '.$_q_slc.' FROM '.$this->bd.TB_MDL_CNT.' WHERE mdlcnt_enc = %s LIMIT 1', GtSQLVlStr($p['id'], 'text'));
            }elseif($p['chk'] == 'id'){
                $__qry = sprintf('SELECT '.$_q_slc.' FROM '.$this->bd.TB_CNT.' WHERE id_cnt = %s LIMIT 1', GtSQLVlStr($p['id'], 'int'));
            }else{
                $__qry = sprintf('SELECT '.$_q_slc.' FROM '.$this->bd.TB_CNT.' WHERE id_cnt IN (SELECT cntdc_cnt FROM '.$this->bd.TB_CNT_DC.' WHERE cntdc_dc = %s) LIMIT 1', GtSQLVlStr($p['id'], 'text'));
            }

            $query_DtRg = $__qry;
            $DtRg = $__cnx->_prc($query_DtRg);

            //$Vl['tmp_q'] = $__qry;

            if($DtRg){

                $row_DtRg = $DtRg->fetch_assoc();
                $Tot_DtRg = $DtRg->num_rows;

                //$Vl['q_e'] = 'Chck:'.$__cnx->c_p->error;
                //$Vl['q_e'] = 'Chck:'.$__cnx->c_p->error;
                $this->w_all .= 'Chck:'.$__cnx->c_p->error;

                if($Tot_DtRg == 1){

                    $Vl['e'] = 'ok';

                    if($p['chk'] == 'mdlcnt_enc'){
	                    $Vl['id'] = $row_DtRg['id_mdlcnt'];
	                    $Vl['enc'] = $row_DtRg['mdlcnt_enc'];
	                    $this->nw_id_mdlcnt = $row_DtRg['id_mdlcnt'];
	                    $this->nw_id_cnt = $row_DtRg['mdlcnt_cnt'];
                    }else{
	                    $Vl['id'] = $row_DtRg['id_cnt'];
	                    $Vl['enc'] = $row_DtRg['cnt_enc'];
	                    $this->nw_id_cnt = $row_DtRg['id_cnt'];
	                }

                }else{

                    $Vl['e'] = 'no';
                    $Vl['w'] = 'No records on '.$query_DtRg;

				}

            }else{

				$Vl['w'] = 'Error on query:'.$__cnx->c_p->error;

			}

            $__cnx->_clsr($DtRg);


        }else{

            $Vl['r'] = 'no';
            $Vl['w'] = '->Chck: no data on $p[id]';

        }

        return _jEnc($Vl);
    }

    public function ChckMdlCnt($p=NULL){

        global $__cnx;

        $Vl['e'] = 'no';

        if( (!isN($p['cnt']) && !isN($p['mdl'])) || !isN($p['enc'])){

            if(!isN($p['cnt'])){ $_f .= sprintf(' AND mdlcnt_cnt=%s ', $p['cnt']); }
            if(!isN($p['mdl'])){ $_f .= sprintf(' AND mdlcnt_mdl=%s ', $p['mdl']); }
            if(!isN($p['enc'])){ $_f .= sprintf(' AND mdlcnt_enc=%s ', GtSQLVlStr($p['enc'], 'text')); }

            $query_DtRg = sprintf("SELECT * FROM ".$this->bd.TB_MDL_CNT." WHERE id_mdlcnt != '' {$_f} LIMIT 1");
            $DtRg = $__cnx->_prc($query_DtRg);

			$Vl['q'] = $query_DtRg;

            if($DtRg){

				$Vl['e'] = 'ok';
	            $row_DtRg = $DtRg->fetch_assoc();
	            $Tot_DtRg = $DtRg->num_rows;

	            if($Tot_DtRg == 1){
	                $Vl['id'] = $row_DtRg['id_mdlcnt'];
	                $Vl['enc'] = $row_DtRg['mdlcnt_enc'];
	                $Vl['est'] = $row_DtRg['mdlcnt_est'];
	            }else{
	                $Vl['w'] = 'ChckMdlCnt:'.$__cnx->c_p->error;
				}

            }else{
				$Vl['w'] = 'ChckMdlCnt:'.$__cnx->c_p->error;
			}

            $__cnx->_clsr($DtRg);

        }

        return(_jEnc($Vl));
    }

    public function ChckHisLst($p=NULL){

	    global $__cnx;

        if( $p['apr'] != NULL ){

            $a_DtRg = "-1"; if ($p['apr'] != NULL){$a_DtRg = $p['apr'];}

            $query_DtRg = sprintf('SELECT * FROM '.$this->bd.TB_MDL_CNT_HIS.' WHERE mdlcnthis_mdlcnt = %s', GtSQLVlStr($a_DtRg, 'int'));
            $_prfx = 'mdl';

            $DtRg = $__cnx->_prc($query_DtRg);

            if($DtRg){

	            $row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

            	if($Tot_DtRg == 1){
	                $Vl['r'] = 'ok';
	                $Vl['id'] = $row_DtRg['id_'.$_prfx.'cnthis'];
	                $Vl['us'] = $row_DtRg[$_prfx.'cnthis_us'];
	            }else{
	                $Vl['r'] = 'no';
	                $Vl['w'] = 'ChckHisLst:'.$__cnx->c_p->error;
	            }
            }

            $__cnx->_clsr($DtRg);

        }else{
            $Vl['r'] = 'no';
        }


        return _jEnc($Vl);
    }

    public function InEcLstsCnt(){

		$__c = $this->_Cnt();
		$__dtus = $__c->d;
		$_p_eml = $__c->in->eml_all;

		$_r['cnt_in'] = $__c;
		$_r['i'] = $__dtus->id;
		$_r['u_all'] = $this->u_all;

		if(!isN($_p_eml)){ $_r['eml_all'] = $_p_eml; }
		if($_p_eml->e == 'no'){ $_r['w'] = 'ok'; }

		return _jEnc($_r);

	}

    public function InCntDcAll($_id){

		$_r['e']='ok';

		if(!isN($this->cnt_dc)){

			$_cnt_dc1 = $this->InCntDc([ 'dc'=>$this->cnt_dc, 'tp'=>$this->cnt_dc_tp, 'exp'=>$this->cnt_dc_exp, 'cnt'=>$_id, 'cmmt'=>'ok' ]);

			if($_cnt_dc1->e=='ok'){
				$_r['cnt_dc1'] = $_cnt_dc1;
			}else{
				$_r['e']='no';
				$_r['w']['cnt_dc1'][] = $_cnt_dc1->w;
				$_r['w']['cnt_dc1'][] = $_cnt_dc1;
			}

		}

		if(!isN($this->cnt_dc_2)){

			$_cnt_dc2 = $this->InCntDc([ 'dc'=>$this->cnt_dc_2, 'tp'=>$this->cnt_dc_tp_2, 'exp'=>$this->cnt_dc_2_exp, 'cnt'=>$_id, 'cmmt'=>'ok' ]);

			if($_cnt_dc2->e=='ok'){
				$_r['cnt_dc2'] = $_cnt_dc2;
			}else{
				$_r['e']='no';
				$_r['w']['cnt_dc2'][] = $_cnt_dc2->w;
				$_r['w']['cnt_dc2'][] = $_cnt_dc2;
			}
		}

		if(!isN($this->cnt_dc_3)){
			$_cnt_dc3 = $this->InCntDc([ 'dc'=>$this->cnt_dc_3, 'tp'=>$this->cnt_dc_tp_3, 'exp'=>$this->cnt_dc_3_exp, 'cnt'=>$_id, 'cmmt'=>'ok' ]);
			if($_cnt_dc3->e=='ok'){
				$_r['cnt_dc3'] = $_cnt_dc3;
			}else{
				$_r['e']='no';
				$_r['w']['cnt_dc3'][] = $_cnt_dc3->w;
			}
		}

		return _jEnc($_r);
    }

    public function InCntDc($p=NULL){

	    global $__cnx;

        if(!isN($p['dc'])){

            if($p['tp'] != '' && $p['tp'] != NULL){ $__qry_doctp = $p['tp']; }else{ $__qry_doctp = _CId('ID_CNTDC_CC'); }

            $__dtdc = _ChckCntDc([ 'id'=>$p['dc'], /*'tp'=>$__qry_doctp,*/ 'cmmt'=>$p['cmmt'], 'bd'=>$this->bd ]);

			$rsp['dtdc'] = $__dtdc;

            if($__dtdc->e == 'ok' && isN($__dtdc->id)){

				$rsp['wm'][] = 'Not exists so have to insert';

                $__enc = Enc_Rnd($p['dc'].'-'.$p['cnt']);

                $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_DC." (cntdc_enc, cntdc_dc, cntdc_cnt, cntdc_exp, cntdc_tp) VALUES (%s, %s, %s, %s, %s)",
                               GtSQLVlStr( $__enc, "text"),
                               GtSQLVlStr( trim($p['dc']), "text"),
                               GtSQLVlStr( $p['cnt'], "int"),
                               GtSQLVlStr( $p['exp'], "date"),
                               GtSQLVlStr( $__qry_doctp, "int"));

                $Result = $__cnx->_prc($insertSQL);

                if($Result){

                    $rsp['e'] = 'ok';
                    $rsp['m'] = 1;
                    $this->UpdCntFA([ 'id'=>$p['cnt'] ]);

                }else{
                    $rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['ms'] = $insertSQL;
                    $this->w_all .= $rsp['w'] = 'doc ->'.$__cnx->c_p->error;
				}

            }else{

				if($__dtdc->e == 'ok'){
					$rsp['e'] = 'ok';
				}else{
					$this->w_all .= $rsp['w'] = TX_DOCASOCD .$__dtdc->cnt->id.' '.$__dtdc->cnt->nm.' '.$__dtdc->cnt->ap;
				}

			}

        }else{
            $rsp['m'] = 8;

        }

        $rtrn = _jEnc($rsp);
        if(!isN($rtrn)){ return($rtrn); }
    }

    public function InCntEmlAll($_id){

        $rsp['e'] = 'ok';

        $rsp['e1'] = $this->InCntEml([ 'eml'=>$this->cnt_eml, 'cnt'=>$_id ]);
        $rsp['e2'] = $this->InCntEml([ 'eml'=>$this->cnt_eml_2, 'cnt'=>$_id ]);
        $rsp['e3'] = $this->InCntEml([ 'eml'=>$this->cnt_eml_3, 'cnt'=>$_id ]);

        if($_r['cnt_e1']->e == 'no'){ $rsp['e'] = 'no'; }
        if($_r['cnt_e2']->e == 'no'){ $rsp['e'] = 'no'; }
        if($_r['cnt_e3']->e == 'no'){ $rsp['e'] = 'no'; }

        return _jEnc($rsp);
    }

    public function InCntEml($p=NULL){

        global $__cnx;

        if (filter_var( $p['eml'] , FILTER_VALIDATE_EMAIL)) {

            $__dteml = _ChckCntEml([ 'id'=>$p['eml'], 'bd'=>$this->cl->bd ]);

            if($__dteml->e == 'no'){

                $__eml_sntz = ctjTx(filter_var( trim($p['eml']) , FILTER_SANITIZE_EMAIL),'out');
                $__enc = Enc_Rnd($__eml_sntz.'-'.$__dteml->chk->tp.'-'.$p['cnt']);
                if(!isN($this->cnt_prty)){ $_prty = $this->cnt_prty; }else{ $_prty=2; }

                $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_EML." (cnteml_enc, cnteml_eml, cnteml_tp, cnteml_cld, cnteml_cnt, cnteml_est, cnteml_prty) VALUES ( %s, LOWER(%s), %s, %s, %s, %s, %s)",
                               GtSQLVlStr( $__enc, "text"),
                               GtSQLVlStr( strtolower($__eml_sntz), "text"),
                               GtSQLVlStr( $__dteml->chk->tp, "int"),
                               GtSQLVlStr( _CId('ID_CLD_RGLR'), "int"),
                               GtSQLVlStr( $p['cnt'], "int"),
                               GtSQLVlStr(_CId('ID_SISEMLEST_NOCHCK'), "int"),
                               GtSQLVlStr($_prty, "int"));

                $Result = $__cnx->_prc($insertSQL);

                if($Result){

	                $rsp['i'] = $__cnx->c_p->insert_id;
                    $rsp['plcy']['in'] = $this->InCntEml_Plcy([ 'cnteml'=>$rsp['i'] ]);

                    $__Fll = new CRM_Fll();
					$__Fll->c_eml = $__eml_sntz;
					$__Sve = $__Fll->sve();


                    $rsp['e'] = 'ok';
                    $rsp['m'] = 1;

                    $this->UpdCntFA([ 'id'=>$p['cnt'] ]);

                    if(!isN($this->ec_lsts_id)){

                        $__eml_lst = $this->InCntLsts(['e'=>$rsp['i']]);

                        if($__eml_lst->e != 'ok'){
                            $rsp['e'] = 'no';
                            $rsp['m'] = 2;
                        }
                    }

                }else{

                    $rsp['e'] = 'no';
                    $rsp['m'] = 2;
                    $this->w_all .= $rsp['w'] = 'InCntEml:'.$__cnx->c_p->error;

                }

            }else{

	            $__chk = $this->CntEmlPlcyChk([ 'cnteml'=>$__dteml->id, 'plcy'=>$this->plcy_id ]);

		        $rsp['plcy']['chk___'] = $__chk;

		        if(!isN($__chk->id)){
		        	$rsp['plcy']['upd'] = $this->UpdCntEml_Plcy([ 'id'=>$__chk->id, 'sndi'=>'1' ]);
				}else{
					$rsp['plcy']['in'] = $this->InCntEml_Plcy([ 'cnteml'=>$__dteml->id ]);
				}

	            $rsp['exst'] = 'ok';

                $this->w_all .= TX_MLASCUSR.$__dteml->cnt->id.' '.$__dteml->cnt->nm.' '.$__dteml->cnt->ap;
                $this->InCntLsts([ 'e'=>$__dteml->id ]);
            }

        }else{

            $rsp['m'] = 8;
        }

        return _jEnc($rsp);
    }

    public function UpdCntEml($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

           	if(!isN($_p['sndi'])){ $_upd[] = sprintf('cnteml_sndi=%s', GtSQLVlStr($_p['sndi'], "int")); }
           	if(!isN($_p['est'])){ $_upd[] = sprintf('cnteml_est=%s', GtSQLVlStr($_p['est'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_EML." SET ".implode(',', $_upd)." WHERE cnteml_enc=%s LIMIT 1",
				                               GtSQLVlStr($_p['id'], "text"));

	            if(!isN($updateSQL)){
		            $Result = $__cnx->_prc($updateSQL);
		        }

				if($Result){
		            $_r['e'] = 'ok';
		            $this->UpdCntFA([ 'id'=>$__id_cnt_upd ]);
		        }else{
		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;
		        }

            }

        }

        return _jEnc($_r);

    }

    public function EliCntEml($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

            $deleteSQL = sprintf('DELETE FROM '.$this->bd.TB_CNT_EML.' WHERE cnteml_enc=%s LIMIT 1',GtSQLVlStr( $_p['id'], 'text'));
            if(!isN($deleteSQL)){ $Result = $__cnx->_prc($deleteSQL); }

			if($Result){
	            $_r['e'] = 'ok';
	        }else{
	            $this->w_all .= $_r['w'] = $__cnx->c_p->error;
	        }

        }

        return _jEnc($_r);

    }

    public function CntEmlPlcyChk($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['cnteml']) && !isN($p['plcy'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_CNT_EML_PLCY.'
									WHERE cntemlplcy_plcy=%s AND cntemlplcy_cnteml=%s',
											GtSQLVlStr($p['plcy'], 'int'),
											GtSQLVlStr($p['cnteml'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['e']='ok';
				$_r['tot']=$Tot_DtRg;

				if($Tot_DtRg==1){
					$_r['id']=$row_DtRg['id_cntemlplcy'];
					$_r['enc']=$row_DtRg['cntemlplcy_enc'];
				}

			}else{

				$_r['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$_r['w']='no data';

		}

		return _jEnc($_r);

	}

    public function InCntEml_Plcy($p=NULL){

	    global $__cnx;

	    //$_r['p'] = $p;

        if( !isN($this->plcy_id) && !isN($p['cnteml']) ){

            if(!isN($this->cnteml_sndi)){ $__qry_sndi= $this->cnteml_sndi; }else{ $__qry_sndi = 1; }

            $__enc = Enc_Rnd($this->plcy_id.'-'.$p['cnteml']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_EML_PLCY." (cntemlplcy_enc, cntemlplcy_plcy, cntemlplcy_cnteml, cntemlplcy_sndi) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->plcy_id, "int"),
                       GtSQLVlStr($p['cnteml'], "int"),
                       GtSQLVlStr($__qry_sndi, "int"));

            if(!isN($insertSQL)){
	            $_ntry = 0;
				do{ $Result = $__cnx->_prc($insertSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
	        }

            if($Result){
                $_r['e'] = 'ok';
                $_r['enc'] = $__enc;
            }else{
	            $_r['w'] = $__cnx->c_p->error;
            }

        }else{

	        $_r['data'] = 'no';

        }

        return _jEnc($_r);
    }

	public function UpdCntEml_Plcy($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

           	if(!isN($_p['sndi'])){ $_upd[] = sprintf('cntemlplcy_sndi=%s', GtSQLVlStr($_p['sndi'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_EML_PLCY." SET ".implode(',', $_upd)." WHERE id_cntemlplcy=%s",
				                               GtSQLVlStr($_p['id'], "int"));

	            if(!isN($updateSQL)){
		            $_ntry = 0;
					do{ $Result = $__cnx->_prc($updateSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
		        }

				if($Result){

		            $_r['e'] = 'ok';

		            $_r['his'] =  $this->_data_his([
		                			'bd'=>$this->bd,
					            	'tp'=>'cnteml_plcy',
					            	'id'=>$_p['id'],
					            	'f'=>'cntemlplcy_sndi',
					            	'v'=>$_p['sndi']
				                ]);
		        }else{

		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;

		        }

            }

        }

        return _jEnc($_r);

    }


	public function ChkCntLsts($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['lsts']) && !isN($p['eml'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_EC_LSTS_EML.'
									WHERE eclstseml_lsts=%s AND eclstseml_eml=%s',
											GtSQLVlStr($p['lsts'], 'int'),
											GtSQLVlStr($p['eml'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$_r['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot'] = $Tot_DtRg;

				if($Tot_DtRg==1){
					$_r['id']=$row_DtRg['id_eclstseml'];
					$_r['enc']=$row_DtRg['eclstseml_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}else{

			$_r['w']='no data';

		}

		return _jEnc($_r);

	}


    public function InCntLsts($p){

	    global $__cnx;

	    $rsp['e'] = 'ok';

        if($this->ec_lsts_id && !isN($p['e']) ){

			$_chk = $this->ChkCntLsts([ 'lsts'=>$this->ec_lsts_id, 'eml'=>$p['e'] ]);

			if(!isN($_chk) && $_chk->e == 'ok'){

				if(isN($_chk->id)){

					$__enc = Enc_Rnd($this->ec_lsts_id.'-'.$p['e'].'-'.$this->ec_lsts_up);

					$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_EC_LSTS_EML." (eclstseml_enc, eclstseml_lsts, eclstseml_eml, eclstseml_up, eclstseml_up_col, eclstseml_bdt, eclstseml_bdt_2, eclstseml_tp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
								GtSQLVlStr( $__enc, "text"),
								GtSQLVlStr( $this->ec_lsts_id, "int"),
								GtSQLVlStr( $p['e'] , "int"),
								GtSQLVlStr( $this->ec_lsts_up, "int"),
								GtSQLVlStr( $this->ec_lsts_up_col, "int"),
								GtSQLVlStr( ctjTx($this->ec_lsts_bdt, 'out') , "text"),
								GtSQLVlStr( ctjTx($this->ec_lsts_bdt_2, 'out') , "text"),
								GtSQLVlStr( ( (!isN($this->eclstseml_tp))? $this->eclstseml_tp : _CId('ID_TPRELLSTSEML_UP') ), "int"));

					$Result = $__cnx->_prc($insertSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['q'] = $__cnx->c_p->error;
					}

				}else{

					$rsp['e'] = 'ok';

				}

			}

		}

		if($rsp['e'] == 'ok' && !isN($this->ec_lsts_sgm_id)){

			$this->ec_lstssgm_id = $this->ec_lsts_sgm_id;
			$this->ec_lstssgm_eml = $p['e'];
			$this->InEcLstsEmlSgm();

		}

        return _jEnc($rsp);
    }




	public function ChkEcLstsEmlSgm($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['sgm']) && !isN($p['eml'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_EC_LSTS_EML_SGM.'
									WHERE eclstsemlsgm_lstssgm=%s AND eclstsemlsgm_eml=%s',
											GtSQLVlStr($p['sgm'], 'int'),
											GtSQLVlStr($p['eml'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$_r['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot'] = $Tot_DtRg;

				if($Tot_DtRg==1){
					$_r['id']=$row_DtRg['id_eclstsemlsgm'];
					$_r['enc']=$row_DtRg['eclstsemlsgm_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}else{

			$_r['w']='no data';

		}

		return _jEnc($_r);

	}


	public function InEcLstsEmlSgm($p=NULL){

	    global $__cnx;

		$_chk = $this->ChkEcLstsEmlSgm([ 'sgm'=>$this->ec_lstssgm_id, 'eml'=>$this->ec_lstssgm_eml ]);

		if(!isN($_chk) && $_chk->e == 'ok'){

			if(isN($_chk->id)){

				$rsp['e'] = 'ok';

				if(!isN($this->ec_lstssgm_id) && !isN($this->ec_lstssgm_eml)){

					$__enc = Enc_Rnd($this->ec_lstssgm_id.'-'.$this->ec_lstssgm_eml);

					$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_EC_LSTS_EML_SGM." (eclstsemlsgm_enc, eclstsemlsgm_lstssgm, eclstsemlsgm_eml) VALUES (%s, %s, %s)",
								GtSQLVlStr( $__enc, "text"),
								GtSQLVlStr( $this->ec_lstssgm_id, "int"),
								GtSQLVlStr( $this->ec_lstssgm_eml, "int"));

					$Result = $__cnx->_prc($insertSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['q'] = $__cnx->c_p->error;
					}
				}

			}else{

				$rsp['e'] = 'ok';

			}

		}

		return _jEnc($rsp);

    }


    public function CntPlcyChk($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['cnt']) && !isN($p['plcy'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_CNT_PLCY.'
									WHERE cntplcy_plcy=%s AND cntplcy_cnt=%s',
											GtSQLVlStr($p['plcy'], 'int'),
											GtSQLVlStr($p['cnt'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg); $_r['q']=$query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg==1){
					$_r['e']='ok';
					$_r['id']=$row_DtRg['id_cntplcy'];
					$_r['enc']=$row_DtRg['cntplcy_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);

	}

   	public function InCntPlcyAll($_id){

		$_r['e'] = 'ok';

        if(!isN($_id) && !isN($this->plcy_id)){

        	$_chk = $this->CntPlcyChk([ 'cnt'=>$_id, 'plcy'=>$this->plcy_id ]);

            if($_chk->e != 'ok'){
				$_sve_in = $this->InCnt_Plcy([ 'cnt'=>$_id ]);
				if($_sve_in->e == 'ok'){
					$_r['plcy']['in'] = $_sve_in;
				}else{
					$_r['e'] = 'no';
					if(Dvlpr()){ $_r['w']['in'] = $_sve_in; }
				}
            }else{
				$_sve_upd = $this->UpdCnt_Plcy([ 'id'=>$_chk->id, 'sndi'=>'1' ]);
			  	if($_sve_upd->e == 'ok'){
					  $_r['plcy']['upd'] = $_sve_upd;
				}else{
					$_r['e'] = 'no';
					if(Dvlpr()){ $_r['w']['upd'] = $_sve_upd; }
				}
            }

		}else{

			if(isN($_id)){ $_r['w'][] = 'No id value'; }
			if(isN($this->plcy_id)){ $_r['w'][] = 'No id value'; }

		}

		return _jEnc($_r);

	}

    public function InCntTelAll($_id){

		$_r['e'] = 'ok';

		if(!isN($this->cnt_tel['no'])){

			$_cnt_tel1 = $this->InCntTel([
							'tel'=>$this->cnt_tel['no'],
							'ps'=>$this->cnt_tel['ps'],
							'ext'=>$this->cnt_tel['ext'],
							'tp'=>$this->cnt_tel['tp'],
							'cnt'=>$_id,
							'getc'=>$this->cnt_tel_getc
						]);

			if($_cnt_tel1->e == 'ok'){
				$_r['cnt_tel1'] = $_cnt_tel1;
			}else{
				$_r['e'] = 'no';
				$_r['w']['tel'][] = $_cnt_tel1->w;
			}

		}

		if(!isN($this->cnt_cel['no'])){

			$_cnt_cel1 = $this->InCntTel([
							'tel'=>$this->cnt_cel['no'],
							'ps'=>$this->cnt_cel['ps'],
							'ext'=>$this->cnt_cel['ext'],
							'tp'=>$this->cnt_cel['tp'],
							'cnt'=>$_id,
							'getc'=>$this->cnt_tel_getc
						]);

			if($_cnt_cel1->e == 'ok'){
				$_r['cnt_cel1'] = $_cnt_cel1;
			}else{
				$_r['e'] = 'no';
				$_r['w']['cel'][] = $_cnt_cel1->w;
			}

		}

		return _jEnc($_r);
    }

    public function InCntTel($p=NULL){

        global $__cnx;

        if(!isN($p['tel'])) {

			$p['tel'] = preg_replace('/[^0-9+]+/', '', $p['tel']);

			if(!is_array($p['tel'])){

				if(!isN($p['tp'])){
					$__qry_teltp = $p['tp'];
				}else{
					if(!is_cel($p['tel'])){
						$__qry_teltp = 2;
					}else{
						$__qry_teltp = 3;
					}
				}

				if(!isN($p['ps'])){

					$__qry_telps = $p['ps'];

				}else{

					if($p['getc']!='no'){
						$__Geo = KnGEO();
						$__ps = GtSisPsDt([ 'id'=>$__Geo->country_code, 't'=>'iso2' ]);
					}

					if(!isN($__ps->id)){
						$__qry_telps = $__ps->id;
					}else{

						$_telpssch = _ChckCntTelPs([ 'no'=>$p['tel'] ]);

						if(!isN($_telpssch->id) && !isN($_telpssch->no)){
							$__qry_telps = $_telpssch->id;
							$p['tel'] = $_telpssch->no;
						}else{
							$__qry_telps = '1111';
						}

					}

				}

				if(!isN($this->cl->bd)){ $_bd=$this->cl->bd; }else{ $_bd=$this->bd; }
				if(!isN($p['est'])){ $__qry_telest = $p['est']; }else{ $__qry_telest = _CId('ID_SISTELEST_ACTV'); }

				$__dttel = _ChckCntTel([ 'id'=>$p['tel'], 'cnt'=>$p['cnt'], 'bd'=>$_bd, 'cmmt'=>'ok' ]);

				if($__dttel->e == 'ok'){ //------- Can check on bd -------//

					$__dttel_oth = _ChckCntTel([ 'id'=>$p['tel'], 'bd'=>$_bd, 'cmmt'=>'ok' ]);

					$rsp['oth'] = $__dttel_oth;

					if($__dttel_oth->e == 'ok' && $__dttel_oth->tot > 0 && $__dttel_oth->cnt->id != $p['cnt']){
						$p['tel'] = '(FC_'.Gn_Rnd(3).')'.$p['tel'];
						$rsp['cntsame'] = $__dttel_oth->cnt->id.' != '.$p['cnt'];
					}

					if($__dttel->e == 'ok' && isN($__dttel->id) && $__dttel_oth->cnt->id != $p['cnt']){

						$__enc = Enc_Rnd($__qry_teltp.'-'.$p['tel'].'-'.$p['cnt']);

						$insertSQL = sprintf("INSERT INTO "._BdStr($_bd).TB_CNT_TEL." (cnttel_enc, cnttel_tel, cnttel_cnt, cnttel_tp, cnttel_ps, cnttel_ext, cnttel_est) VALUES (%s, %s, %s, %s, %s, %s, %s)",
									GtSQLVlStr( $__enc, "text"),
									GtSQLVlStr( $p['tel'], "text"),
									GtSQLVlStr( $p['cnt'], "int"),
									GtSQLVlStr( $__qry_teltp, "int"),
									GtSQLVlStr( $__qry_telps, "int"),
									GtSQLVlStr( ctjTx($p['ext'], 'out') , "text"),
									GtSQLVlStr( $__qry_telest, "int"));

						$Result = $__cnx->_prc($insertSQL);

						if($Result){

							$rsp['i'] = $__cnx->c_p->insert_id;
							$rsp['plcy']['in'] = $this->InCntTel_Plcy([ 'cnttel'=>$rsp['i'] ]);

							$this->UpdCntFA([ 'id'=>$p['cnt'] ]);
							$rsp['e'] = 'ok';
							$rsp['m'] = 1;

						}else{
							$rsp['e'] = 'no';
							$rsp['m'] = 2;
							$this->w_all .= 'InCntTel:'.$__cnx->c_p->error.' on '.compress_code($insertSQL);
							$rsp['w'][] = $__cnx->c_p->error.' on '.compress_code($insertSQL);
						}

					}else{

						$__chk = $this->CntTelPlcyChk([ 'cnttel'=>$__dttel->id, 'plcy'=>$this->plcy_id ]);
						$rsp['plcy']['chk'] = $__chk;

						if(!isN($__chk->id)){
							$rsp['plcy']['upd'] = $this->UpdCntTel_Plcy([ 'id'=>$__chk->id, 'sndi'=>'1' ]);
						}else{
							$rsp['plcy']['in'] = $this->InCntTel_Plcy([ 'cnttel'=>$__dttel->id ]);
						}

						if($__chk->e == 'ok'){
							$rsp['e'] = 'ok';
							$rsp['i'] = $__chk->id;
						}else{
							if(!isN($__chk->w)){ $rsp['w'][] = 'CntTelPlcyChk:'.print_r($__chk->w, true); }
						}

						if($__dttel_oth->cnt->id != $p['cnt']){
							$this->w_all .= $rsp['w'][] = TX_PHNASCUSR.$__dttel->cnt->id.' '.$__dttel->cnt->nm.' '.$__dttel->cnt->ap;
							//$rsp['w'][] = $__dttel;
						}

					}

				}else{

					$this->w_all .= $rsp['w'][] = 'Cant check if lead '. $p['cnt']. ' has number '. $p['tel'].' associated' ;
					$rsp['w']['tmp__dttel'] = $__dttel;

				}

			}else{
				$this->w_all .= $rsp['w'][] = 'Number is an array can not process, check code' ;
			}

        }else{
			$rsp['m'] = 8;
			$rsp['w'] = 'No data for process';
        }

        if(!isN($rsp)){ return _jEnc($rsp); }

    }

    public function UpdCntTel($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

			if(!isN($_p['est'])){ $_upd[] = sprintf('cnttel_est=%s', GtSQLVlStr($_p['est'], "int")); }
           	if(!isN($_p['sms'])){ $_upd[] = sprintf('cnttel_sms=%s', GtSQLVlStr($_p['sms'], "int")); }
           	if(!isN($_p['whtsp'])){ $_upd[] = sprintf('cnttel_whtsp=%s', GtSQLVlStr($_p['whtsp'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_TEL." SET ".implode(',', $_upd)." WHERE cnttel_enc=%s",
				                               GtSQLVlStr($_p['id'], "text"));

	            if(!isN($updateSQL)){
		            $Result = $__cnx->_prc($updateSQL);
		        }

				if($Result){

		            $_r['e'] = 'ok';
		            $this->UpdCntFA([ 'id'=>$__id_cnt_upd ]);

		            if(!isN($_p['sndi'])){
			            //$_upd[] = sprintf('cnttel_sndi=%s', GtSQLVlStr($_p['sndi'], "int"));
			            // Work to update all policy
			        }

		        }else{
		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;
		        }

            }else{

				$_r['w'] = 'no fields to update';

            }

        }else{

	        $_r['w'] = 'no data';

        }

        return _jEnc($_r);

    }

    public function EliCntTel($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

            $deleteSQL = sprintf('DELETE FROM '.$this->bd.TB_CNT_TEL.' WHERE cnttel_enc=%s LIMIT 1',GtSQLVlStr( $_p['id'], 'text'));
            if(!isN($deleteSQL)){ $Result = $__cnx->_prc($deleteSQL); }

			if($Result){
	            $_r['e'] = 'ok';
	        }else{
	            $this->w_all .= $_r['w'] = $__cnx->c_p->error;
	        }

        }

        return _jEnc($_r);

    }

    public function CntTelPlcyChk($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['cnttel']) && !isN($p['plcy'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_CNT_TEL_PLCY.'
									WHERE cnttelplcy_plcy=%s AND cnttelplcy_cnttel=%s',
											GtSQLVlStr($p['plcy'], 'int'),
											GtSQLVlStr($p['cnttel'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$_r['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot'] = $Tot_DtRg;

				if($Tot_DtRg==1){
					$_r['id']=$row_DtRg['id_cnttelplcy'];
					$_r['enc']=$row_DtRg['cnttelplcy_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}else{

			$_r['w']='no data';

		}

		return _jEnc($_r);

	}

    public function InCntTel_Plcy($p=NULL){

	    global $__cnx;

	    $_r['p'] = $p;

        if( !isN($this->plcy_id) && !isN($p['cnttel']) ){

            if(!isN($this->cnttel_sndi)){ $__qry_sndi= $this->cnttel_sndi; }else{ $__qry_sndi = 1; }
            if(!isN($this->cnttel_sms)){ $__qry_sms= $this->cnttel_sms; }else{ $__qry_sms = 1; }
            if(!isN($this->cnttel_whtsp)){ $__qry_whtsp= $this->cnttel_whtsp; }else{ $__qry_whtsp = 1; }

            $__enc = Enc_Rnd($this->plcy_id.'-'.$p['cnttel']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_TEL_PLCY." (cnttelplcy_enc, cnttelplcy_plcy, cnttelplcy_cnttel, cnttelplcy_sndi, cnttelplcy_sms, cnttelplcy_whtsp) VALUES (%s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->plcy_id, "int"),
                       GtSQLVlStr($p['cnttel'], "int"),
                       GtSQLVlStr($__qry_sndi, "int"),
                       GtSQLVlStr($__qry_sms, "int"),
                       GtSQLVlStr($__qry_whtsp, "int"));

            if(!isN($insertSQL)){
	            $_ntry = 0;
				do{ $Result = $__cnx->_prc($insertSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
	        }

            if($Result){
                $_r['e'] = 'ok';
                $_r['enc'] = $__enc;
            }else{
	            $_r['w'] = $__cnx->c_p->error;
            }

        }else{

	        $_r['data'] = 'no';

        }

        return _jEnc($_r);
    }

	public function UpdCntTel_Plcy($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

           	if(!isN($_p['sndi'])){ $_upd[] = sprintf('cnttelplcy_sndi=%s', GtSQLVlStr($_p['sndi'], "int")); }
           	if(!isN($_p['sms'])){ $_upd[] = sprintf('cnttelplcy_sms=%s', GtSQLVlStr($_p['sms'], "int")); }
           	if(!isN($_p['whtsp'])){ $_upd[] = sprintf('cnttelplcy_whtsp=%s', GtSQLVlStr($_p['whtsp'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_TEL_PLCY." SET ".implode(',', $_upd)." WHERE id_cnttelplcy=%s",
				                               GtSQLVlStr($_p['id'], "int"));

	            if(!isN($updateSQL)){
		            $_ntry = 0;
					do{ $Result = $__cnx->_prc($updateSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
		        }

				if($Result){

		            $_r['e'] = 'ok';

		            $_r['his'] =  $this->_data_his([
		                			'bd'=>$this->bd,
					            	'tp'=>'cnttel_plcy',
					            	'id'=>$_p['id'],
					            	'f'=>'cnttelplcy_sndi',
					            	'v'=>$_p['sndi']
				                ]);
		        }else{

		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;

		        }

            }

        }

        return _jEnc($_r);

    }

    public function InCntTpAll($_id){

		$_r['e'] = 'ok';

       	if(is_array($this->cnt_tp)){
		 	foreach($this->cnt_tp as $k){
				$_sve = $this->InCntTp(['tp'=>$k, 'cnt'=>$_id ]);
				if($_sve->e=='ok'){ $_r['cnt_tp1'][] = $_sve; }else{ $_r['e'] = 'no'; break; }
		 	}
	    }else{
			if(!isN($this->cnt_tp)){
				$_r['cnt_tp1'] = $this->InCntTp(['tp'=>$this->cnt_tp, 'cnt'=>$_id ]);
				if($_r['cnt_tp1']->e != 'ok'){ $_r['e'] = 'no'; }
			}
			if(!isN($this->cnt_tp_2)){
				$_r['cnt_tp2'] = $this->InCntTp(['tp'=>$this->cnt_tp_2, 'cnt'=>$_id ]);
				if($_r['cnt_tp2']->e != 'ok'){ $_r['e'] = 'no'; }
			}
			if(!isN($this->cnt_tp_3)){
				$_r['cnt_tp3'] = $this->InCntTp(['tp'=>$this->cnt_tp_3, 'cnt'=>$_id ]);
				if($_r['cnt_tp3']->e != 'ok'){ $_r['e'] = 'no'; }
			}

		}

		return _jEnc($_r);

	}


	public function InCntTpMdlAll($_id){

		$_r['e'] = 'ok';

		if(!isN($this->cnt_tp_mdl)){
			foreach($this->cnt_tp_mdl as $k => $v){
				$_sve = $this->InCntTpMdl( [ 'tp' => $v->tp , 'cnt' => $_id, 'mdl' => $v->mdl, 'grd' => $v->grd, 'pro' => $v->pro ] );
				if($_sve->e == 'ok'){ $_r['cnt_tp_mdl'][] = $_sve; }else{ $_r['e'] = 'no'; break; }
			}
		}

		return _jEnc($_r);

	}

    public function InCntTpMdl($p=NULL){

		global $__cnx;

		if (filter_var( $p['tp'] , FILTER_VALIDATE_INT)) {

                $__dttp = _ChckCntTpMdl([ 'bd'=>$this->bd, 'id'=>$p['tp'], 'cnt'=>$p['cnt'], 'mdl'=>$p['mdl'] ]);

                if($__dttp->e == 'no'){

	                $__enc = Enc_Rnd($p['tp'].'-'.$p['cnt']);

                    $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_TP." (cnttp_enc, cnttp_tp , cnttp_cnt, cnttp_mdl, cnttp_y_prm, cnttp_y_grd) VALUES (%s, %s, %s, (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s), %s, %s)",
                    				GtSQLVlStr($__enc, "text"),
									GtSQLVlStr( $p['tp'], "int"),
									GtSQLVlStr( $p['cnt'], "int"),
									GtSQLVlStr( $p['mdl'], "text"),
									GtSQLVlStr( $p['pro'], "text"),
									GtSQLVlStr( $p['grd'], "text"));

                    $Result = $__cnx->_prc($insertSQL);

                    if($Result){
                        $rsp['e'] = 'ok';
                        $rsp['m'] = 1;
                    }else{
                        $rsp['e'] = 'no';
                        $rsp['m'] = 2;
                        $this->w_all .= 'InCntTp:'.$__cnx->c_p->error;
                    }
                }else{
                    $this->w_all .= TX_LNKACSUSR.$__dttp->cnt->id.' '.$__dttp->cnt->nm.' '.$__dttp->cnt->ap;
                }
        }else{
            $rsp['m'] = 8;
        }

        $rtrn = _jEnc($rsp);
        if(!isN($rtrn)){ return($rtrn); }
    }


    public function InCntTp($p=NULL){

	    global $__cnx;

        if (filter_var( $p['tp'] , FILTER_VALIDATE_INT)) {

                $__dttp = _ChckCntTp([ 'bd'=>$this->bd, 'id'=>$p['tp'], 'cnt'=>$p['cnt'] ]);

                if($__dttp->e == 'no'){

	                $__enc = Enc_Rnd($p['tp'].'-'.$p['cnt']);

                    $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_TP." (cnttp_enc, cnttp_tp , cnttp_cnt) VALUES (%s, %s, %s)",
                    				GtSQLVlStr($__enc, "text"),
									GtSQLVlStr( $p['tp'], "int"),
									GtSQLVlStr( $p['cnt'], "int"));

                    $Result = $__cnx->_prc($insertSQL);

                    if($Result){
                        $rsp['e'] = 'ok';
                        $rsp['m'] = 1;
                    }else{
                        $rsp['e'] = 'no';
                        $rsp['m'] = 2;
                        $this->w_all .= 'InCntTp:'.$__cnx->c_p->error;
                    }
                }else{
                    $this->w_all .= TX_LNKACSUSR.$__dttp->cnt->id.' '.$__dttp->cnt->nm.' '.$__dttp->cnt->ap;
                }
        }else{
            $rsp['m'] = 8;
        }

        $rtrn = _jEnc($rsp);
        if(!isN($rtrn)){ return($rtrn); }
    }




    private function CntOrgAll($_id=NULL){

		$_r['e'] = 'ok';

	    if( !isN($this->cnt_org) && is_array($this->cnt_org) ){

		    $org_tpr1 = $_cnt_org_v['tpr'];
			$org_id1 = $_cnt_org_v['id'];

			foreach($this->cnt_org as $_cnt_org_k=>$_cnt_org_v){

				if(!isN($_cnt_org_v->tpr) && !isN($_cnt_org_v->id)){
					$org_tpr = $_cnt_org_v->tpr;
					$org_tpr_o = $_cnt_org_v->tpr_o;
					$org_id = $_cnt_org_v->id;
					$org_crs = $_cnt_org_v->crs;
					$org_crg = $_cnt_org_v->crg;
					$org_are = $_cnt_org_v->are;
					$org_fs = $_cnt_org_v->fs;
					$org_smst = $_cnt_org_v->smst;
				}else{
					$org_tpr = $_cnt_org_v['tpr'];
					$org_tpr_o = $_cnt_org_v['tpr_o'];
					$org_id = $_cnt_org_v['id'];
					$org_crs = $_cnt_org_v['crs'];
					$org_crg = $_cnt_org_v['crg'];
					$org_are = $_cnt_org_v['are'];
					$org_fs = $_cnt_org_v['fs'];
					$org_smst = $_cnt_org_v['smst'];
				}

				$this->_org->orgsdscnt_tpr = $org_tpr;
				$this->_org->orgsdscnt_tpr_o = $org_tpr_o;
				$this->_org->orgsdscnt_orgsds = $org_id;
				$this->_org->orgsdscnt_cnt = $_id;

				$this->_org->orgsdscnt_crs = $org_crs;
				$this->_org->orgsdscnt_are = $org_are;
				$this->_org->orgsdscnt_fs = $org_fs;
				$this->_org->orgsdscnt_smst = $org_smst;

				$_sve = $this->_org->OrgSdsCnt();

				if($_sve->e == 'ok'){ $_r['sve'][] = $_sve; }else{ $_r['e'] = 'no'; $_r['w'] = $_sve->w; break; }

			}

		}

		return _jEnc($_r);
    }

    private function CntCdAllRel($_id=NULL){

		$_r['e'] = 'ok';

	    if( !isN($this->cnt_cd_all) && is_array($this->cnt_cd_all) ){

			foreach($this->cnt_cd_all as $_cnt_cd_k=>$_cnt_cd_v){

				if(!isN($_cnt_cd_v->rel) && !isN($_cnt_cd_v->id)){
					$cd_tpr = $_cnt_cd_v->rel;
					$cd_id = $_cnt_cd_v->id;
				}else{
					$cd_tpr = $_cnt_cd_v['rel'];
					$cd_id = $_cnt_cd_v['id'];
				}

				$this->cntcd_rel = $cd_tpr;
				$this->cntcd_cd = $cd_id;
				$this->cntcd_cnt = $_id;


				$_sve = $this->CntCdIn();
				if($_sve->e == 'ok'){ $_r['sve'][] = $_sve; }else{ $_r['e'] = 'no'; break; }

			}
		}

		return _jEnc($_r);
    }

    function CntCdChk($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

	    if(!isN($p['rel'])){
		    $__rl = $p['rel'];
	    }elseif(!isN( $this->cntcd_rel )){
		    $__rl = $this->cntcd_rel;
	    }


		if(!isN($this->cntcd_cnt) && !isN($this->cntcd_cd) && !isN($__rl)){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_CNT_CD.'
									WHERE cntcd_cnt=%s AND cntcd_cd=%s AND cntcd_rel=%s',
											GtSQLVlStr($this->cntcd_cnt, 'int'),
											GtSQLVlStr($this->cntcd_cd, 'int'),
											GtSQLVlStr($__rl, 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

			}

			if($Tot_DtRg==1){
				$this->UpdCntFA([ 'id'=>$this->cntcd_cnt ]);
				$_r['e']='ok';
				$_r['id']=$row_DtRg['id_cntcd'];
				$_r['enc']=$row_DtRg['cntcd_enc'];
			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);
	}

	public function CntCdUpd($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($this->cntcd_cnt) || !isN($this->cnt_enc)){

			if(!isN($this->cnt_enc)){
				$__id_cnt_upd = GtCntDt([  'id'=>$this->cnt_enc, 't'=>'enc' ]);
				$_r['w']['UpdCnt']['idu'] = $__id_cnt_upd;
				$__id_cnt_upd = $__id_cnt_upd->id;
			}else{
				$__id_cnt_upd = $this->cntcd_cnt;
			}

           	if($_p['to_vvo'] == 'ok'){

	           	if(!isN($_p['enc'])){
		           	$_where .= sprintf(' AND cntcd_enc != %s ', GtSQLVlStr($_p['enc'], "text"));
		        }

		        $_where .= sprintf(' AND cntcd_rel=%s', GtSQLVlStr(_CId('ID_TPRLCC_VVE'), "int"));

           	}else{

           		if(!isN($_p['enc'])){ $_where .= sprintf(' AND cntcd_enc = %s', GtSQLVlStr($_p['enc'], "text")); }

           	}

           	if(!isN($_p['rel'])){ $_upd[] = sprintf('cntcd_rel=%s', GtSQLVlStr($_p['rel'], "int")); }

			if(!isN($_p['excpt'])){ $_where .= sprintf(' AND id_cntcd != %s', GtSQLVlStr($_p['excpt'], "text")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_CD." SET ".implode(',', $_upd)." WHERE cntcd_cnt=%s {$_where}",
				                               GtSQLVlStr($__id_cnt_upd, "int"));

	            if(!isN($__id_cnt_upd)){
		            $Result = $__cnx->_prc($updateSQL);
		        }

            }

        }

        if($Result){
            $_r['e'] = 'ok';
            $this->UpdCntFA([ 'id'=>$__id_cnt_upd ]);
        }else{
            $this->w_all .= $_r['w'] = $__cnx->c_p->error;
        }



        return _jEnc($_r);



    }

	public function CntCdIn($_p=NULL){

		global $__cnx;

		if(!isN($this->cntcd_cnt) && !isN($this->cntcd_cd)){

			if($this->cntcd_rel == _CId('ID_TPRLCC_VVE')){
				$__chk_vvo = $this->CntCdChk([ 'rel'=>_CId('ID_TPRLCC_VVO') ]);
				$__enc = $__chk_vvo->enc;
				$__upd = 'ok';
			}

			$__chk = $this->CntCdChk();

			if($__chk->e == 'ok' && !isN($__chk->id)){

				$rsp['e'] = 'ok';
				$__idexcpt = $__chk->id;
				$rsp['i'] = $__chk->id;

			}elseif($__upd == 'ok' && !isN($__chk_vvo->enc)){

				$__upd_bfr = $this->CntCdUpd([ 'enc'=>$__chk_vvo->enc, 'rel'=>_CId('ID_TPRLCC_VVE') ]);
				$rsp['upd'] = $__upd_bfr;

				if($__upd_bfr->e == 'ok'){
					$rsp['e'] = 'ok';
				}else{
					$rsp['w'][] = $__upd_bfr;
				}

			}else{

				$__enc = Enc_Rnd($this->cntcd_cnt.'-'.$this->cntcd_cd);

				$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_CD." (cntcd_enc, cntcd_cnt, cntcd_cd, cntcd_rel) VALUES (%s, %s, %s, %s)",
								   GtSQLVlStr($__enc, "text"),
								   GtSQLVlStr($this->cntcd_cnt, "int"),
								   GtSQLVlStr($this->cntcd_cd, "int"),
								   GtSQLVlStr($this->cntcd_rel, "int"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){

					$rsp['e'] = 'ok';

					if(!isN( $__cnx->c_p->insert_id )){
						$rsp['i'] = $__idexcpt = $__cnx->c_p->insert_id;
					}

					$this->UpdCntFA([ 'id'=>$this->cntcd_cnt ]);

					if($this->cntcd_rel == _CId('ID_TPRLCC_VVE')){
						$__upd_all = $this->CntCdUpd([ 'enc'=>$__enc, 'rel'=>_CId('ID_TPRLCC_VVO'), 'to_vvo'=>'ok', 'excpt'=>$__idexcpt ]);
						if($__upd_all->e != 'ok'){ $rsp['e'] = 'no'; }
					}

				}else{

					$rsp['e'] = 'no';
					$rsp['w'][] = $rsp['s_msj'] = $__cnx->c_p->error.' on '.$insertSQL;

				}


			}

		}else{

			$rsp['w'][] = 'No all data for process';
			if(isN($this->cntcd_cnt)){ $rsp['w'][] = '$this->cntcd_cnt empty'; }
			if(isN($this->cntcd_cd)){ $rsp['w'][] = '$this->cntcd_cd empty'; }

		}

		return _jEnc($rsp);

	}

    private function CntCdAll($_id=NULL){

		$_r['e'] = 'ok';

	    if( !isN($this->cnt_cd) && is_array($this->cnt_cd) ){

			foreach($this->cnt_cd as $_cnt_cd_k=>$_cnt_cd_v){

				if(!isN($_cnt_cd_v['id']) && !isN($_cnt_cd_v['rel'])){

					$this->cntcd_cnt = $this->nw_id_cnt;
					$this->cntcd_cd = $_cnt_cd_v['id'];
					$this->cntcd_rel = $_cnt_cd_v['rel'];
					$_sve = $this->CntCdIn();

					if($_sve->e == 'ok'){ $_r['sve'][] = $_sve; }else{ $_r['e'] = 'no'; $_r['w'][] = $_sve->w; break; }

				}

			}
		}

		return _jEnc($_r);
    }

    function MdlCntActChk($p=NULL){

	    global $__cnx;

		if(!isN($this->nw_id_mdlcnt) && !isN($this->gt_act_id)){

			$query_DtRg = sprintf('SELECT * FROM '.$this->bd.TB_MDL_CNT_ACT.' WHERE mdlcntact_mdlcnt=%s AND mdlcntact_act=%s', GtSQLVlStr($this->nw_id_mdlcnt, 'int'), GtSQLVlStr($this->gt_act_id, 'int'));
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

			}

			$__cnx->_clsr($DtRg);

			if($Tot_DtRg==1){$_r =true;}else{$_r=false;}
			return($_r);
		}
	}

    public function MdlCntActIn($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->nw_id_mdlcnt) && !isN($this->gt_act_id)){

			if(defined('SISUS_ID')){ $_us = SISUS_ID; }
			elseif(!isN($this->up_us)){ $_us = $this->up_us; }
			else{ $_us = 3; }

			$__chk = $this->MdlCntActChk();

			if($__chk){

				$Result=true;
				$rsp['chk'] = 'ok';

			}else{

				$__enc = Enc_Rnd($this->nw_id_mdlcnt.$this->gt_act_id);

				$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_ACT." (mdlcntact_enc, mdlcntact_mdlcnt, mdlcntact_act, mdlcntact_us, mdlcntact_tpi) VALUES (%s, %s, %s, %s, %s)",
								   GtSQLVlStr($__enc, "text"),
								   GtSQLVlStr($this->nw_id_mdlcnt, "int"),
								   GtSQLVlStr($this->gt_act_id, "int"),
								   GtSQLVlStr($_us, "int"),
								   GtSQLVlStr(_CId('ID_MDLCNTACTTP_DGT'), "int"));

				$Result = $__cnx->_prc($insertSQL);

				//$rsp['tmp_q'] = $insertSQL;
			}


			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['s_msj'] = $__cnx->c_p->error;
			}


		}

		return _jEnc($rsp);

	}

    private function CntBdIn($_p=NULL){

	    global $__cnx;

		if(!isN($this->nw_id_cnt) && !isN($_p['bd'])){

			$__enc = Enc_Rnd($this->nw_id_cnt.$_p['bd']);

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_BD." (cntbd_enc, cntbd_bd, cntbd_cnt) VALUES (%s, %s, %s)",
							   GtSQLVlStr($__enc, "text"),
							   GtSQLVlStr($_p['bd'], "int"),
							   GtSQLVlStr($this->nw_id_cnt, "int"));

			$Result = $__cnx->_prc($insertSQL);
			if($Result){ $rsp['e'] = 'ok'; }else{ $rsp['s_cntbd'] = $__cnx->c_p->error; }

		}

	}

	public function CntAttr_In($_p=NULL){

	    global $__cnx;

		if(!isN($this->cnt_id) && !isN($this->cl_bd)){

			$__enc = Enc_Rnd($this->cnt_id.$this->cl_bd.$this->attr);

			$insertSQL = sprintf("INSERT INTO ".$this->cl_bd.'.'.TB_CNT_ATTR." (cntattr_enc, cntattr_attr, cntattr_cnt) VALUES (%s, %s, (SELECT id_cnt FROM ".$this->cl_bd.'.'.TB_CNT." WHERE cnt_enc = %s))",
							   GtSQLVlStr($__enc, "text"),
							   GtSQLVlStr($this->attr, "int"),
							   GtSQLVlStr($this->cnt_id, "text"));

			$Result = $__cnx->_prc($insertSQL);
			if($Result){ $rsp['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $rsp['error'] = $__cnx->c_p->error; }

		}

		return _jEnc($rsp);

	}

	public function CntAttr_Del($_p=NULL){

	    global $__cnx;

		if(!isN($this->cnt_id) && !isN($this->cl_bd)){

			$deleteSQL = sprintf("DELETE FROM ".$this->cl_bd.'.'.TB_CNT_ATTR." WHERE cntattr_attr=%s AND cntattr_cnt = (SELECT id_cnt FROM ".$this->cl_bd.'.'.TB_CNT." WHERE cnt_enc = %s) ",GtSQLVlStr( $this->attr, 'int'), GtSQLVlStr($this->cnt_id, "text"));

            $Result = $__cnx->_prc($deleteSQL);
            if($Result){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $rsp['error'] = $__cnx->c_p->error; }
            return _jEnc($Vl);

		}

	}

	private function InCntBdAll($_p=NULL){

		$_r['e'] = 'ok';

		if(!isN($this->cnt_bd)){
			if(is_array($this->cnt_bd)){
				for ($i = 1; $i <= count($this->cnt_bd); $i++) {

					$__dtcntbd = _ChkCntBdIn([ 'cnt'=>$__dtcnt->id, 'id'=>$this->cnt_bd[$i], 'bd'=>$this->cl->bd, 'cmmt'=>'ok' ]);

					if($__dtcntbd->e == 'ok' && isN($__dtcntbd->id)){

						$_sve = $this->CntBdIn([ 'bd'=>$this->cnt_bd ]);

						if($_sve->e == 'ok' && !isN($_sve->id) ){
							$rsp['e'] = 'ok';
							$rsp['m'] = 1;
						}else{
							$rsp['e'] = 'no';
						}

					}elseif($__dtcntbd->e == 'ok' && !isN($__dtcntbd->id)){
						$rsp['e'] = 'ok';
					}else{
						$this->w_all .= 'CntBd:' .$this->cnt_bd.' '.$__dtcnt->id;
					}

				}
			}else{

				$__dtcntbd = _ChkCntBdIn([ 'cnt'=>$__dtcnt->id, 'id'=>$this->cnt_bd, 'bd'=>$this->cl->bd, 'cmmt'=>'ok' ]);

				if($__dtcntbd->e == 'ok' && isN($__dtcntbd->id)){

					$_sve = $this->CntBdIn([ 'bd'=>$this->cnt_bd ]);

					if($_sve->e == 'ok' && !isN($_sve->id) ){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['e'] = 'no';
					}

				}elseif($__dtcntbd->e == 'ok' && !isN($__dtcntbd->id)){
					$rsp['e'] = 'ok';
				}else{
					$this->w_all .= 'CntBd:' .$this->cnt_bd.' '.$__dtcnt->id;
				}
			}
		}

		return _jEnc($_r);
	}


	private function InCntVtexAll($_id=NULL){

		// ------ Insert de Vtex Campaña con el Cnt ---- //

		if(!isN($this->gt_vtexcmpg_id)){

			$__dtcmpgcnt = $this->_vtex->CmpgInsDt([ 'cnt'=>$_id, 'cmpg'=>$this->gt_vtexcmpg_id ]);

			if(($__dtcmpgcnt->e != 'ok' || isN($__dtcmpgcnt->id)) && !isN($_id)){

				$_r['hsin'] = 'ok';
				$__vtexcmpg_in = $this->_vtex->CmpgIns_In([
															'cnt'=>$_id,
															'cmpg'=>$this->gt_vtexcmpg_id,
															'rfd'=>!isN($this->gt_vtexcmpg_rfd)?$this->gt_vtexcmpg_rfd:NULL
														]);

				$_r['tmp_vtexcmpg_in'] = $__vtexcmpg_in;

				if($__vtexcmpg_in->e == 'ok'){
					$_r['e'] = 'ok';
					$__dtcmpgcnt = $this->_vtex->CmpgInsDt([ 'cnt'=>$_id, 'cmpg'=>$this->gt_vtexcmpg_id ]);
					$_r['ins']['id'] = $__dtcmpgcnt->id;
				}else{
					$_r['w'][] = $__vtexcmpg_in->w;
				}

			}else if($__dtcmpgcnt->e == 'ok'){

				$_r['e'] = 'ok';
				$_r['exst'] = 'ok';
				$__dtcmpgcnt = $this->_vtex->CmpgInsDt([ 'cnt'=>$_id, 'cmpg'=>$this->gt_vtexcmpg_id ]);
				$_r['ins']['id'] = $__dtcmpgcnt->id;

			}

		}else{

			$_r['w'][] = 'No gt_vtexcmpg_id empty';

		}

		return _jEnc($_r);
	}

    public function InCnt(){

	    global $__cnx;

	    //$_r['w']['InCnt']['get'] = print_r($this->cnt_nm, true)." <-> ".print_r($this->cnt_dc, true)." <-> ".print_r($this->cnt_eml, true)." <-> ".print_r($this->cnt_tel, true);

		if(
			(
				(
					( !isN($this->cnt_dc) ) || //------- IF HAS DOCUMENT -------//
					( !isN($this->cnt_eml) && filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL) ) || //------- IF HAS EMAIL AND IS VALID -------//
					( !isN($this->cnt_tel) && filter_var($this->cnt_tel, FILTER_SANITIZE_NUMBER_INT) ) //------- IF HAS TEL AND IS VALID -------//
				) ||
				$this->tp_enc == '_enc'
			) &&
			!isN($this->cnt_nm) &&//------- ALWAYS SHOULD TO HAVE NAME -------//
			strlen($this->cnt_nm) >= 3
		){

            if(!isN($this->mdlcnt_fi)){ $_fi = $this->mdlcnt_fi; }elseif(!isN($this->cnt_fi)){ $_fi = $this->cnt_fi; }else{ $_fi = SIS_F; }
            if(!isN($this->cnt_sx)){ $__qry_sx = $this->cnt_sx; }else{ $__qry_sx = _CId('ID_SX_N_DF'); }
            //if(!isN($this->cnt_sndi)){ $__qry_sndi= $this->cnt_sndi; }else{ $__qry_sndi = 2; }
            if(!isN($this->cnt_cld)){ $__qry_cld= $this->cnt_cld; }else{ $__qry_cld = _CId('ID_CLD_RGLR'); }

            $this->NmAp();

            $__enc = Enc_Rnd($this->cnt_nm.'-'.$this->cnt_ap.'-'.$__qry_sx);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT." (cnt_enc, cnt_nm, cnt_ap, cnt_dir, cnt_cld, cnt_sx, cnt_fn) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx( $this->cnt_nm ,'out'), "text"),
					   GtSQLVlStr(strlen( $this->cnt_ap ) > 3 ? ctjTx( $this->cnt_ap, 'out'):'', "text"),
					   GtSQLVlStr(ctjTx( $this->cnt_dir, 'out'), "text"),
                       GtSQLVlStr($__qry_cld, "int"),
                       GtSQLVlStr($__qry_sx, "int"),
                       GtSQLVlStr($this->cnt_fn, "date"));


			$_r['w']['InCnt']['qry'] = $insertSQL;

            $Result = $__cnx->_prc($insertSQL);

            $this->hb_u_all = $insertSQL;

            if($Result){
                $_r['e'] = 'ok';
                $_r['enc'] = $__enc;
            }else{
				$_r['w'] = $__cnx->c_p->error;
			}

        }else{

			if(isN($this->cnt_dc)){ $_r['w'][] = '$this->cnt_dc is empty ->'.$this->cnt_dc; }
			if(isN($this->cnt_eml)){ $_r['w'][] = '$this->cnt_eml is empty ->'.$this->cnt_eml; }
			if(!filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL)){ $_r['w'][] = '$this->cnt_eml is empty ->'.$this->cnt_eml.' problem filter validate'; }
			if(isN($this->cnt_tel)){ $_r['w'][] = '$this->cnt_tel is empty ->'.print_r($this->cnt_tel, true); }

	        $_r['data'] = 'no';

        }

        if($Result){

            $_r['e'] = 'ok';
            $_r['i'] = $__cnx->c_p->insert_id;

        }else{

            $__dtcnt = $this->Chck([ 'id'=>$this->cnt_eml, 'chk'=>'eml' ]);

            if(!isN($__dtcnt->id)){
                $_r['e'] = 'ok';
                $_r['i'] = $__dtcnt->id;
            }else{
                $_r['e'] = 'no';
                $_r['w']['InCnt']['dsc'] = 'Proceso de Insert Lead -> '.$__cnx->c_p->error.' '.print_r($__dtcnt, true);
                $this->w_all .= 'InCnt:'.$__cnx->c_p->error;
            }
        }

        return _jEnc($_r);
    }

    public function InCnt_Plcy($p=NULL){

	    global $__cnx;

        if( !isN($this->plcy_id) && !isN($p['cnt']) ){

            if(!isN($this->cnt_sndi)){ $__qry_sndi= $this->cnt_sndi; }else{ $__qry_sndi = 1; }

            $__enc = Enc_Rnd($this->plcy_id.'-'.$p['cnt']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_PLCY." (cntplcy_enc, cntplcy_plcy, cntplcy_cnt, cntplcy_sndi) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->plcy_id, "int"),
                       GtSQLVlStr($p['cnt'], "int"),
                       GtSQLVlStr($__qry_sndi, "int"));

            if(!isN($insertSQL)){
	            $_ntry = 0;
				do{ $Result = $__cnx->_prc($insertSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
	        }

            if($Result){
                $_r['e'] = 'ok';
                $_r['enc'] = $__enc;
            }else{
	            $_r['w'][] = $__cnx->c_p->error;
            }

        }else{

			$_r['data'] = 'no';
			if(Dvlpr() && isN($this->plcy_id)){ $_r['w'][] = '$this->plcy_id empty'; }
			if(Dvlpr() && isN($p['cnt'])){ $_r['w'][] = '$p[cnt] empty'; }

        }

        return _jEnc($_r);
    }

	public function UpdCnt_Plcy($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

           	if(!isN($_p['sndi'])){ $_upd[] = sprintf('cntplcy_sndi=%s', GtSQLVlStr($_p['sndi'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_PLCY." SET ".implode(',', $_upd)." WHERE id_cntplcy=%s",
				                               GtSQLVlStr($_p['id'], "int"));

	            if(!isN($updateSQL)){
		            $_ntry = 0;
					do{ $Result = $__cnx->_prc($updateSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
		        }

				if($Result){

		            $_r['e'] = 'ok';

		            $_r['his'] =  $this->_data_his([
		                			'bd'=>$this->bd,
					            	'tp'=>'cnt_plcy',
					            	'id'=>$_p['id'],
					            	'f'=>'cntplcy_sndi',
					            	'v'=>$_p['sndi']
				                ]);
		        }else{

		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;

		        }

            }

        }

        return _jEnc($_r);

    }

    public function UpdCntFld($p){

		global $__cnx;

		$_r['get'] = $p;

        if( !isN($p['id']) && !isN($p['f']) && !isN($p['v_n']) && !isN($p['t']) && !isN($p['tp'])){

        	if($p['tp'] == 'mdl_cnt'){
	        	$_bd = TB_MDL_CNT; $_bd_i = 'id_mdlcnt';
	        }elseif($p['tp'] == 'cnt'){
		        $_bd = TB_CNT; $_bd_i = 'id_cnt';
		    }

            $updateSQL = sprintf("UPDATE ".$this->bd."{$_bd} SET ".$p['f']."=%s WHERE {$_bd_i}=%s",
                       GtSQLVlStr($p['v_n'], $p['t']),
                       GtSQLVlStr($p['id'], "int"));

            $Result_UPD = $__cnx->_prc($updateSQL);

            //if(!$this->api){ $this->u_all .= TX_INACTLZR. $updateSQL . HTML_BR; }

            if($Result_UPD){

                $_r['e'] = 'ok';

                if(!$this->api){ $this->u_all .= TX_ACTLZD.HTML_BR; }

                $_r['his'] =  $this->_data_his([
	                			'bd'=>$this->bd,
				            	'tp'=>$p['tp'],
				            	'id'=>$p['id'],
				            	'f'=>$p['f'],
				            	'v'=>$p['v_n']
			                ]);

            }else{
                $_r['e'] = 'no';
                $this->w_all .= $_r['w'] = 'UpdCntFld:'.$__cnx->c_p->error;
                if(!$this->api){ $this->u_all .= TX_NACTLZD.HTML_BR; }
            }

        }

        return _jEnc($_r);
    }

    public function UpdCntFA($p){

		global $__cnx;

        if( !isN($p['id'])){

			if(!isN($p['f'])){ $__f = $p['f']; }else{ $__f = SIS_F_D2; }

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT." SET cnt_fa=%s WHERE id_cnt=%s",
                       GtSQLVlStr($__f, 'date'),
                       GtSQLVlStr($p['id'], "int"));

            $Result_UPD = $__cnx->_prc($updateSQL);

            if(!$this->api){
				//$this->u_all .= TX_INACTLZR. $updateSQL . HTML_BR;
			}

            if($Result_UPD){
                $_r['e'] = 'ok';
                //if(!$this->api){ $this->u_all .= TX_ACTLZD.HTML_BR; }
            }else{
                $_r['e'] = 'no';
                $this->w_all .= $_r['w'] = 'UpdCntFA:'.$__cnx->c_p->error;
                //if(!$this->api){ $this->u_all .= TX_NACTLZD.HTML_BR; }
            }

        }

        return _jEnc($_r);
    }

    public function __in_mdlcntest($_p=NULL){

		global $__cnx;

		if(!isN($_p['c']) && !isN($_p['e'])){

			if(!isN($_p['us'])){ $_q_us = $_p['us']; }
			elseif(defined('SISUS_ID')){ $_q_us = SISUS_ID; }
			elseif(!isN($this->up_us)){ $_q_us = $this->up_us; }
			elseif(!isN($this->up_us)){ $_q_us = 3; }

			$__enc = Enc_Rnd($_p['c'].'-'.$_p['e']);

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_EST ." (mdlcntest_enc, mdlcntest_mdlcnt, mdlcntest_est, mdlcntest_us) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($_p['c'], "int"),
						GtSQLVlStr($_p['e'], "int"),
						GtSQLVlStr($_q_us, "int"));

			$Result_IN = $__cnx->_prc($insertSQL);

			if($Result_IN){
				$r['e'] = 'ok';
			}else{
				$r['e'] = 'no'; $r['w'] = $__cnx->c_p->error;
			}

			$_r = _jEnc($r); return($_r);
		}
	}

    public function __upd_mdlcntest($_p=NULL){

		global $__cnx;

		if(!isN($_p['c']) && !isN($_p['e'])){

			if(!isN($_p['us'])){ $_q_us = $_p['us']; }
			elseif(defined('SISUS_ID')){ $_q_us = SISUS_ID; }
			elseif(!isN($this->up_us)){ $_q_us = $this->up_us; }

			$updateSQL_UPD = sprintf("UPDATE ".$this->bd.TB_MDL_CNT." SET mdlcnt_est=%s WHERE id_mdlcnt=%s",
								   GtSQLVlStr($_p['e'], "int"),
								   GtSQLVlStr($_p['c'], "int"));

			$Result_UPD = $__cnx->_prc($updateSQL_UPD);

			if($Result_UPD && $_p['no_upd'] != 'ok'){

				$r['his'] = $this->__in_mdlcntest($_p);

			}else{
				$r['p'] = 'No actualiza';
				$r['e'] = 'no';
				$r['w'] = $insertSQL.' -> '.$__cnx->c_p->error;
			}


			$_r = _jEnc($r); return($_r);
		}
	}

    public function CmpCnt($p=NULL){

		$r['e'] = 'ok';

        if(!isN($this->nw_id_cnt)){

            $this->__dt_cnt = GtCntDt([  'bd'=>$this->bd, 'id'=>$this->nw_id_cnt ]);

            if(!isN($_fi) && ($_fi < $this->__dt_cnt->fi)){
                $r['cnt']['fi'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_fi', 'v_n'=>$_fi, 'v_a'=>$this->__dt_cnt->fi, 't'=>'date' ]);
            }

            if(!isN($this->cnt_sndi) && $this->cnt_sndi != $this->__dt_cnt->sndi){
	            $r['cnt']['sndi'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_sndi', 'v_n'=>$this->cnt_sndi, 'v_a'=>$this->__dt_cnt->fi, 't'=>'int' ]);
	            $r['cnt']['sndi_rmv'] = $this->CntEmlSndRmv();
	        }

            if(!isN($this->cnt_fn) && $this->cnt_fn != $this->__dt_cnt->fn){
                $r['cnt']['fn'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_fn', 'v_n'=>$this->cnt_fn, 'v_a'=>$this->__dt_cnt->fn, 't'=>'date' ]);
            }

            if(!isN($this->cnt_sx) && $this->cnt_sx != $this->__dt_cnt->sx->id){
                $r['cnt']['sx'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_sx', 'v_n'=>$this->cnt_sx, 'v_a'=>$this->__dt_cnt->sx->id, 't'=>'date' ]);
			}

            if(!isN($this->cnt_nm) && $this->cnt_nm != $this->__dt_cnt->nm && $this->__dt_cnt->chk->nm != 'ok'){
                $r['cnt']['nm'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_nm', 'v_n'=>$this->cnt_nm, 'v_a'=>$this->__dt_cnt->nm, 't'=>'text' ]);
            }

            if(!isN($this->cnt_ap) && $this->cnt_ap != $this->__dt_cnt->ap && $this->__dt_cnt->chk->ap != 'ok'){
                $r['cnt']['ap'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_ap', 'v_n'=>$this->cnt_ap, 'v_a'=>$this->__dt_cnt->ap, 't'=>'text' ]);
			}

			if(!isN($this->cnt_dir) && $this->cnt_dir != $this->__dt_cnt->dir){
                $r['cnt']['dir'] = $this->UpdCntFld([ 'tp'=>'cnt', 'id'=>$this->__dt_cnt->id, 'f'=>'cnt_dir', 'v_n'=>$this->cnt_dir, 'v_a'=>$this->__dt_cnt->dir, 't'=>'text' ]);
            }

            /* Actualizar todo relativo a Modulos */

            $this->__dt_mdlcnt = GtMdlCntDt([ 'id'=>$this->nw_id_mdlcnt ]);

            if($this->noi != $this->__dt_mdlcnt->noi){
	            $r['mdl_cnt']['noi'] = $this->UpdCntFld([ 'tp'=>'mdl_cnt', 'id'=>$this->__dt_mdlcnt->id, 'f'=>'mdlcnt_noi', 'v_n'=>$this->noi, 'v_a'=>$this->__dt_mdlcnt->noi, 't'=>'int' ]);
	        }

            if($this->mdlcnt_fnt != $this->__dt_mdlcnt->fnt->id){
	            $r['mdl_cnt']['fnt'] = $this->UpdCntFld([ 'tp'=>'mdl_cnt', 'id'=>$this->__dt_mdlcnt->id, 'f'=>'mdlcnt_fnt', 'v_n'=>$this->mdlcnt_fnt, 'v_a'=>$this->__dt_mdlcnt->fnt->id, 't'=>'int' ]);
	        }

            if(!isN($this->mdlcnt_fi)){
	            $r['mdl_cnt']['fi'] = $this->UpdCntFld([ 'tp'=>'mdl_cnt', 'id'=>$this->__dt_mdlcnt->id, 'f'=>'mdlcnt_fi', 'v_n'=>$this->mdlcnt_fi, 'v_a'=>$this->__dt_mdlcnt->fi, 't'=>'date' ]);
	        }

        }

        if(!isN($this->cnt_est) && !isN($this->nw_id_mdlcnt)){

            $__est_lst = GtMdlCntEst_Lst([ 'id'=>$this->nw_id_mdlcnt, 'bd'=>$this->cl->bd, 'nw'=>$this->cnt_est, 'bug'=>$this->bugs ]);
            $__hislst = $this->ChckHisLst([ 'apr'=>$this->nw_id_mdlcnt, 'bd'=>$this->cl->bd, 't'=>$p['t'] ]);

            if(!$this->api){
	            $this->u_all .= HTML_BR.'('.print_r($__est_lst, true).TX_INTCMBSTD.$this->cnt_est.' a :'.$this->nw_id_mdlcnt.' ->R: ('. print_r($__hislst, true) .') '.$__hislst->r .HTML_BR;
	        }

            if(($__est_lst->df == 'ok')){  //OJO CONSTRUIR REGLAS DE PONDERACIÓN

                if($this->cnt_nw != 'ok'){
                    $_cnt_est = $this->__upd_mdlcntest([ 'c'=>$this->nw_id_mdlcnt, 'e'=>$this->cnt_est, 'us'=>$this->gst_us, 'bug'=>$this->bugs ]);
                }

                if(!$this->api){ $this->u_all .= '('.print_r($_cnt_est, true).TX_CMBRSTD.$this->cnt_est.': '.$_cnt_est->w; }
                UPDCnt_Cld([ 'bd'=>$this->bd, 'id'=>$this->__dt_cnt->enc, 'e'=>$this->cnt_est, 'c_a'=>$this->__dt_cnt->cld ]);
            }
        }

        return _jEnc($r);

    }

    public function UpdCnt(){

	    global $__cnx;

        if(!isN($this->id_cnt) || !isN($this->cnt_enc)){

			if(!isN($this->cnt_enc)){
				$__id_cnt_upd = GtCntDt([  'id'=>$this->cnt_enc, 't'=>'enc' ]);
				$_r['w']['UpdCnt']['idu'] = $__id_cnt_upd;
				$__id_cnt_upd = $__id_cnt_upd->id;
			}else{
				$__id_cnt_upd = $this->id_cnt;
			}

			if(!isN($this->cnt_fn)){ $_upd[] = sprintf('cnt_fn=%s', GtSQLVlStr($this->cnt_fn, "date")); }
			if(!isN($this->cnt_nm)){ $_upd[] = sprintf('cnt_nm=%s', GtSQLVlStr(ctjTx($this->cnt_nm,'out'), "text")); }
			if(!isN($this->cnt_ap)){ $_upd[] = sprintf('cnt_ap=%s', GtSQLVlStr(ctjTx($this->cnt_ap,'out'), "text")); }
			if(!isN($this->cnt_dir)){ $_upd[] = sprintf('cnt_dir=%s', GtSQLVlStr(ctjTx($this->cnt_dir,'out'), "text")); }
			if(!isN($this->cnt_sx)){ $_upd[] = sprintf('cnt_sx=%s', GtSQLVlStr($this->cnt_sx, "int")); }

			if(!isN($_upd)){

				$updateSQL = sprintf("	UPDATE ".$this->bd.TB_CNT." SET
											".implode(',', $_upd)."
										WHERE id_cnt=%s",
								GtSQLVlStr($__id_cnt_upd, "int"));

			}

            if(!isN($__id_cnt_upd)){ $Result = $__cnx->_prc($updateSQL); }

        }

        if($Result){
            $_r['e'] = 'ok';
        }else{
            $_r['e'] = 'no';
            $this->w_all .= $__cnx->c_p->error;
        }

        return _jEnc($_r);
    }

    public function MdlCnt_In($p=NULL){

        global $__cnx;

        if(count($p) > 0 && is_array($p)){

            //-------------- DEFAULT VALUE --------------//

            	$_d_est = GtCntEstDt([ 'dfl'=>$this->_mdldt->tp->id, 'cl'=>$this->gt_cl_id ]);
				$_r['d_cnt_est'] = $this->gt_cl_id;

            //-------------- DEFAULT VALUE --------------//

            if(!isN($p['fi'])){ $_fi = $p['fi']; }else{ $_fi = SIS_F_D2; }
            if(!isN($p['fr'])){ $_fr = $p['fr']; }else{ $_fr = NULL; }
            if(!isN($p['m'])){ $_m = $p['m']; }else{ $_m = 3; }
            if(!isN($p['m_k'])){ $_m_k = $p['m_k']; }else{ $_m_k = NULL; }
            if(!isN($p['noi'])){ $_noi = $p['noi']; }else{ $_noi = 1; }
            if(!isN($p['chk_spp'])){ $_chk_spp = $p['chk_spp']; }else{ $_chk_spp = 2; }
            if(!isN($p['est'])){ $_est = $p['est']; }else{ $_est = $_d_est->id; }
            if(!isN($p['bd'])){ $_bd = $p['bd']; }else{ $_bd = 5; }
			if(!isN($p['prd'])){ $_prd = $p['prd']; }else{ $_prd = ''; }
			if(!isN($p['cl_sds'])){ $_cl_sds = $p['cl_sds']; }else{ $_cl_sds = ''; }

            if($this->_mdldt->tp->unq == 'ok'){ $_unq = 'N'; }else{ $_unq = Gn_Rnd(20); }

            if(!isN($this->invk->by)){ $_invk = $this->invk->by; }else{ $_invk = _CId('ID_SISINVK_ND'); }

            if(!isN($p['fnt'])){
	            $_fnt = $p['fnt'];
            }else{
	            if($this->api){
		            $_fnt = 38;
		        }else{
	            	$_fnt = 1;
	            }
	        }


            if(!isN($p['enc_us'])){ $_enc_us = $p['enc_us']; }else{ $_enc_us = 3; }

            if(!isN($p['us'])){ $_us = $p['us']; }
            elseif(defined('SISUS_ID')){ $_us = SISUS_ID; }
            elseif(!isN($this->up_us)){ $_us = $this->up_us; }
            else{ $_us = NULL; }


            $__enc = Enc_Rnd($p['mdl'].'-'.$p['cnt']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT." (mdlcnt_enc, mdlcnt_m, mdlcnt_m_k, mdlcnt_noi, mdlcnt_chk_vll, mdlcnt_chk_ner, mdlcnt_chk_spp, mdlcnt_cnt, mdlcnt_mdl, mdlcnt_unq, mdlcnt_est, mdlcnt_dsp, mdlcnt_ref, mdlcnt_gen, mdlcnt_ldg, mdlcnt_fnt, mdlcnt_bd, mdlcnt_fr, mdlcnt_us, mdlcnt_invk, mdlcnt_fi, mdlcnt_prd, mdlcnt_cl_sds) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($_m, "int"),
                       GtSQLVlStr($_m_k, "text"),
                       GtSQLVlStr($_noi, "text"),
                       GtSQLVlStr(_NoNll($p['chk_vll']), "int"),
                       GtSQLVlStr(_NoNll($p['chk_ner']), "int"),
                       GtSQLVlStr(_NoNll($_chk_spp), "int"),
                       GtSQLVlStr($p['cnt'], "int"),
                       GtSQLVlStr($this->_mdldt->id, "int"),
                       GtSQLVlStr($_unq, "text"),
                       GtSQLVlStr($_est, "int"),
                       GtSQLVlStr($p['dvc'], "text"),
                       GtSQLVlStr($p['ref'], "text"),
                       GtSQLVlStr($p['gen'], "text"),
                       GtSQLVlStr($p['ldg'], "text"),
                       GtSQLVlStr($_fnt, "int"),
                       GtSQLVlStr(_NoNll($_bd), "int"),
                       GtSQLVlStr($_fr, "date"),
                       GtSQLVlStr($_us, "int"),
                       GtSQLVlStr($_invk, "int"),
                       GtSQLVlStr($_fi, "date"),
					   GtSQLVlStr($_prd, "int"),
					   GtSQLVlStr($_cl_sds, "int"));

            $Result = $__cnx->_prc($insertSQL);

            //$_r['q'] = $insertSQL;
        }


        if($Result && !isN($__cnx->c_p->insert_id)){

			$_r['id'] = $__cnx->c_p->insert_id;
			$_r['enc'] = $__enc;
            $_r['e'] = 'ok';
            $this->CmntIn();
            $_r['est_his'] = $this->__in_mdlcntest([ 'c'=>$_r['id'], 'e'=>$_est, 'us'=>$_us ]);

        }else{
            $_r['e'] = 'no';
            $_r['w'] = $__cnx->c_p->error;
            $this->w_all .= $__cnx->c_p->error;
        }

        return _jEnc($_r);
	}

    public function MdlEncCntIn($p=NULL){

     	global $__cnx;

        if(($p['enc'] != '' || $p['enc'] != NULL) && ($p['cnt'] != '' || $p['cnt'] != NULL)){
            $insertSQL = sprintf("INSERT INTO ".$this->bd."_enc_cnt (enccnt_enc, enccnt_cnt) VALUES (%s, %s)",
                       GtSQLVlStr($p['enc'], "int"),
                       GtSQLVlStr($p['cnt'], "int"));

            $Result = $__cnx->_prc($insertSQL);
            $this->w_all .= 'MdlEncCntIn:'.$__cnx->c_p->error;

            if($Result){
                $_r['id'] = $__cnx->c_p->insert_id;
                $_r['e'] = 'ok';
            }else{
                $_r['e'] = 'no';
                $this->w_all .= $__cnx->c_p->error;
            }

            $rtrn = _jEnc($_r);
            if(!isN($rtrn)){ return($rtrn); }

        }
    }

    public function InEncCntDtsAll($_p=NULL){
        if($_p['enccnt'] != '' || $_p['enccnt'] != NULL){
            foreach($this->dts as $_k){
                $_flds = explode('-|-',$_k);
                $_enccnt = $this->InEncCntDts(['fld'=>$_flds[0], 'dts'=>$_flds[1], 'enccnt'=>$_p['enccnt']]);
            }
            if($_enccnt->e = 'ok'){
                $rsp['e'] = 'ok';
            }else{
                $rsp['e'] = 'no';
            }
            $rtrn = _jEnc($rsp);
            if(!isN($rtrn)){ return($rtrn); }
        }
    }

    public function InEncCntDts($p=NULL){

        global $__cnx;

        if ($p['enccnt']) {

                $insertSQL = sprintf("INSERT INTO ".$this->bd."_enc_dts (encdts_enccnt, encdts_fld, encdts_dts) VALUES (%s, %s, %s)",
                               GtSQLVlStr( $p['enccnt'], "int"),
                               GtSQLVlStr( $p['fld'], "int"),
                               GtSQLVlStr(ctjTx($p['dts'], 'out') , "text"));

                $Result = $__cnx->_prc($insertSQL);

                if($Result){
                    $rsp['i'] = $__cnx->c_p->insert_id;
                    $rsp['e'] = 'ok';
                    $rsp['m'] = 1;
                }else{
                    $rsp['e'] = 'no';
                    $rsp['m'] = 2;
                    $this->w_all .= 'InEncCntDts:'.$__cnx->c_p->error;
                }
        }else{
            $rsp['m'] = 8;
        }
        $rtrn = _jEnc($rsp);
        if(!isN($rtrn)){ return($rtrn); }
    }

    public function HisIn($_p=NULL){

        global $__cnx;

        //$_r['cnx_start'] = $this->c_p;

		$_r['e'] = 'no';

        if($_p['t'] == 'mdl'){
            $__his_prfx = 'mdl';
            $__his_bd = $this->bd.TB_MDL_CNT_HIS;
            $__his_fi = $this->mdlcnthis_fi;
            $__his_hi = $this->mdlcnthis_hi;
            $__his_c = $this->mdlcnthis_mdlcnt;
            $__his_dsc = $this->mdlcnthis_dsc;
            $__his_tp = !isN($this->mdlcnthis_tp)?$this->mdlcnthis_tp:_CId('ID_HISTP_CALL');
            $__his_us = $this->mdlcnthis_us;
        }

        $__f_his = DateTime::createFromFormat('Y-m-d', $__his_fi);

        if(!isN($__his_fi) && ($__f_his == '' || $__f_his == NULL) ){
            $this->hb = 'no'; $this->w .= TX_DTGSTFRNT. $__his_fi . HTML_S;
        }

        if(!isN($__his_c) && !isN($__his_dsc) && $this->hb != 'no'){

            if(!isN($__his_dsc)){

                if(!isN($__his_fi)){ $_fi = $__his_fi; }else{ $_fi = SIS_F; }
                if(!isN($__his_hi)){ $_hi = $__his_hi; }else{ $_hi = SIS_H2; }

                $__enc = Enc_Rnd($__his_c.'-'.$__his_tp.'-'.$__his_dsc);

                $insertSQL = sprintf("INSERT INTO ".$__his_bd." (".$__his_prfx."cnthis_enc, ".$__his_prfx."cnthis_".$__his_prfx."cnt, ".$__his_prfx."cnthis_tp, ".$__his_prfx."cnthis_dsc, ".$__his_prfx."cnthis_us, ".$__his_prfx."cnthis_fi, ".$__his_prfx."cnthis_hi) VALUES (%s, (SELECT id_".$__his_prfx."cnt FROM ".$this->bd."_".$__his_prfx."_cnt WHERE ".$__his_prfx."cnt_enc = %s) , %s, %s, %s, %s, %s)",
                               GtSQLVlStr($__enc, "text"),
                               GtSQLVlStr($__his_c, "text"),
                               GtSQLVlStr($__his_tp, "int"),
                               GtSQLVlStr(ctjTx($__his_dsc,'out'), "text"),
                               GtSQLVlStr($__his_us, "int"),
                               GtSQLVlStr($_fi, "date"),
                               GtSQLVlStr($_hi, "date"));
            }


            $Result = $__cnx->_prc($insertSQL);

            $this->w_all .= 'HisIn:'.$__cnx->c_p->error;

            if(($Result) /*&& !isN($this->cnt_est)*/){

                //$His_Sum = ChckCntAprHis_Sum(array('id'=>$__his_c));
                if($His_Sum > 0){
                    /*
                    if($this->demo != true){
                        $__est_lst = GtMdlCntEst_Lst(array( 'id'=>$this->nw_id_mdlcnt, 'nw'=>3 ));
                        if($__est_lst->df == 'ok'){ $_cnt_est = __MdlCntEst(array('u'=>false, 'c'=>$this->nw_id_mdlcnt, 'e'=>3, 'us'=>$this->gst_us )); }
                    }*/
                }

                $_r['i'] = $__cnx->c_p->insert_id;
                $_r['e'] = 'ok';

            }else{

	            //$_r['q'] = $insertSQL;
				$_r['w'] = $__cnx->c_p->error;

            }

        }


        return _jEnc($_r);
    }

    public function CmntIn($_p=NULL){

        global $__cnx;

        if(!isN($this->nw_id_mdlcnt) && !isN($this->cnt_cmn)){

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_MSJ." (mdlcntmsj_mdlcnt, mdlcntmsj_msj, mdlcntmsj_dsp, mdlcntmsj_ref) VALUES (%s, %s, %s, %s)",
                               GtSQLVlStr($this->nw_id_mdlcnt, "int"),
                               GtSQLVlStr(ctjTx($this->cnt_cmn,'out'), "text"),
                               GtSQLVlStr($this->dvc, "text"),
                               GtSQLVlStr($this->ref, "text"));

            $Result = $__cnx->_prc($insertSQL);

            if($Result){
                $rsp['e'] = 'ok';
                $rsp['s_msj'] = 'ok';
            }else{
				$rsp['w'] = $__cnx->c_p->error;
                $rsp['s_msj'] = 'CmntIn:'.$__cnx->c_p->error;
            }

		}

		return _jEnc($rsp);

    }

    public function MdlCntPrdIn($p=NULL){

	    global $__cnx;

	    if( !isN($p["prd"]) ){

            $__enc = Enc_Rnd($p["prd"].'-'.$p["mdlcnt"]);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_PRD." (mdlcntprd_enc, mdlcntprd_mdlsprd, mdlcntprd_mdlcnt, mdlcntprd_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p["prd"], "int"),
							GtSQLVlStr($p["mdlcnt"], "int"),
							GtSQLVlStr(1, "int"));

            $Result = $__cnx->_prc($insertSQL);

            if($Result){
                $rsp['e'] = 'ok';
            }else{
				$rsp['e'] = 'no';
				if(Dvlpr()){
					$rsp['q'] = compress_code($insertSQL);
					$rsp['w'] = $__cnx->c_p->error;
				}
            }

        }else{

			if(Dvlpr()){ $rsp['w'] = '$p["prd"] empty'; }

		}

		return _jEnc($rsp);

    }

    public function MdlCntSchIn($p=NULL){

	    global $__cnx;

	    if( !isN($p["sch"]) ){


            $__enc = Enc_Rnd($p["sch"].'-'.$p["mdlcnt"]);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_SCH." (mdlcntsch_enc, mdlcntsch_mdlssch, mdlcntsch_mdlcnt, mdlcntsch_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p["sch"], "int"),
							GtSQLVlStr($p["mdlcnt"], "int"),
							GtSQLVlStr(1, "int"));

            $Result = $__cnx->_prc($insertSQL);


            if($Result){
                $rsp['e'] = 'ok';
            }else{
                $rsp['e'] = 'no';
            }


        }

        return _jEnc($rsp);

    }

    public function ExtChk($p=NULL){

	    global $__cnx;

		if(!isN($p) && !isN($p['t'])){

			$Vl['e'] = 'no';

			if($p['t'] == 'mdl_cnt'){

				$prfx='mdlcnt';
				if(!isN($this->nw_id_mdlcnt)){ $__f .= sprintf(' AND mdlcntattr_mdlcnt=%s ', GtSQLVlStr($this->nw_id_mdlcnt, 'int')); }
				if(!isN($p['v']->id)){ $__f .= sprintf(' AND mdlcntattr_attr=%s ', GtSQLVlStr($p['v']->id, 'int')); }
				$tb = $this->bd.TB_MDL_CNT_ATTR;

			}elseif($p['t'] == 'cnt'){

				$prfx='cnt';
				if(!isN($this->nw_id_cnt)){ $__f .= sprintf(' AND cntattr_cnt=%s ', GtSQLVlStr($this->nw_id_cnt, 'int')); }
				if(!isN($p['v']->id)){ $__f .= sprintf(' AND cntattr_attr=%s ', GtSQLVlStr($p['v']->id, 'int')); }
				$tb = $this->bd.TB_CNT_ATTR;
			}

			$query_DtRg = '	SELECT * FROM '.$tb.' WHERE id_'.$prfx.'attr != "" '.$__f;
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_'.$prfx.'attr'];
					$Vl['enc'] = $row_DtRg[$prfx.'attr_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

    public function ExtIn($p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

	    foreach($p['v'] as $_v_k=>$_v_v){

	    	$chk = $this->ExtChk([ 't'=>$p['t'], 'v'=>$_v_v ]);

	    	if($p['t'] == 'mdl_cnt'){
				$prfx = 'mdlcnt';
				$relmain = $this->nw_id_mdlcnt;
				$tb = $this->bd.TB_MDL_CNT_ATTR;
			}elseif($p['t'] == 'cnt'){
				$prfx = 'cnt';
				$relmain = $this->nw_id_cnt;
				$tb = $this->bd.TB_CNT_ATTR;
			}

			if($chk->e == 'ok' && !isN($chk->enc)){

		    	$query = sprintf("UPDATE ".$tb." SET ".$prfx."attr_attr=%s, ".$prfx."attr_".$prfx."=%s, ".$prfx."attr_vl=%s WHERE ".$prfx."attr_enc=%s",
                               	GtSQLVlStr($_v_v->id, "int"),
	                            GtSQLVlStr($relmain, "int"),
	                            GtSQLVlStr(ctjTx($_v_v->vl,'out'), "text"),
	                            GtSQLVlStr($chk->enc, "text")
	                         );

		    }else{

			    $__enc = Enc_Rnd($_v_v->id.'-'.$relmain);

	            $query = sprintf("INSERT INTO ".$tb." (".$prfx."attr_enc, ".$prfx."attr_attr, ".$prfx."attr_".$prfx.", ".$prfx."attr_vl) VALUES (%s, %s, %s, %s)",
	                               GtSQLVlStr($__enc, "text"),
	                               GtSQLVlStr($_v_v->id, "int"),
	                               GtSQLVlStr($relmain, "int"),
	                               GtSQLVlStr(ctjTx($_v_v->vl,'out'), "text"));

	        }


	        if(!isN($query)){

		        $Result = $__cnx->_prc($query);
		        $_r['q'] = $query;
		        if($Result){
			        $_r['e'] = 'ok';

			    }else{
			     	$_r['w'] = $__cnx->c_p->error;
		        }

	        }else{

		     	$_r['w'] = 'No query string'.$query;

	        }

	    }


        return _jEnc($_r);

    }

    public function ExtAll($_p=NULL){

        $_r['e'] = 'ok';

        if(!isN($this->nw_id_cnt) && (!isN($this->ext_all->mdl_cnt) || !isN($this->ext_all->cnt))){

            foreach($this->ext_all as $ext_k=>$ext_v){

				$_pr = $this->ExtIn([
				        	't'=>$ext_k,
				        	'v'=>$ext_v
			        	]);

			    $_r['v'][] = $ext_v;

				if(!isN($_pr->q)){ $_r['q'][] = $_pr->q; }
	        	if(!isN($_pr->w)){ $_r['w'][] = $_pr->w; $_r['e'] = 'no'; break; }
				if($_pr->e != 'ok'){ $_r['q'][] = $_pr->w; $_r['e'] = 'no'; break; }

            }

        }

        return _jEnc($_r);
    }

    public function AllHisIn($_p=NULL){
            if($_p['dsc'] != NULL){
                $this->mdlcnthis_mdlcnt = $this->nw_id_mdlcnt_enc;
                $this->mdlcnthis_tp = $_p['tp'];
                $this->mdlcnthis_dsc = $_p['dsc'];
                $this->mdlcnthis_us = $_p['us'];
                $this->mdlcnthis_fi = $_p['fi'];
                $this->mdlcnthis_hi = $_p['hi'];
                return( $this->HisIn([ 't'=>'mdl' ]) );
            }
    }

    public function MdlCntEstUPD($_p=NULL){

            $__est_lst = GtMdlCntEst_Lst([ 'id'=>$_p['mdlcnt'], 'nw'=>$_p['est'] ]);
            if($__est_lst->df == 'ok'){ $_cnt_est = $this->__upd_mdlcntest([ 'c'=>$_p['mdlcnt'], 'e'=>$_p['est'] ]); }

            $__est_lst = GtMdlCntEst_Lst([ 'id'=>$_p['mdlcnt'], 'nw'=>$_p['est'], 'bug'=>$this->bugs ]);

            if($__est_lst->df == 'ok'){
                $_cnt_est = $this->__upd_mdlcntest([ 'c'=>$_p['mdlcnt'], 'e'=>$_p['est'], 'us'=>$_p['us'], 'bug'=>$this->bugs ]);
                if(!$this->api){  $this->u_all .= $_p['mdlcnt'].TX_CMBRSTD.$_p['est']; }
                $_r['upd'] = 'ok';
            }else{
                $_r['upd'] = 'no';
            }

        return _jEnc($_r);
    }

    public function MrgCnt(){
        $_r['e'] = 'no';

        $this->__cnt_m = GtCntDt([  'id'=>$this->cnt_m, 'count'=>'ok' ]);
        $this->__cnt_d = GtCntDt([  'id'=>$this->cnt_d, 'count'=>'ok' ]);
        $this->__mrg_g = $this->MrgCnt_Chk(['m'=>$this->__cnt_m, 'd'=>$this->__cnt_d]);



            if($this->__cnt_d->id != NULL && $this->__cnt_d->id != NULL){

                $_r['mdlcnt_tpu'] = $this->MrgCnt_CntTp();
                $_r['mdlcnt_e'] = $this->MrgCnt_MdlCnt();
                $_r['mrgfld_e'] = $this->MrgCnt_Flds();

                $this->__cnt_m = GtCntDt([ 'id'=>$this->cnt_m, 'count'=>'ok' ]);
                $this->__cnt_d = GtCntDt([ 'id'=>$this->cnt_d, 'count'=>'ok' ]);

                if($this->__cnt_d->l1 == 0){

                    $_r['emlcnt_e'] = $this->MrgCnt_Eml();

                    if($this->__mrg_g == 'ok'){
                        $_r['dccnt_e'] = $this->MrgCnt_Dc();
                    }else{
                        $this->mrg_w[] = TX_DOCEXIT;
                    }


                    $_r['sndcnt_e'] = $this->MrgCnt_Snd();
                    $_r['telcnt_e'] = $this->MrgCnt_Tel();
                    $_r['clgcnt_e'] = $this->MrgCnt_Clg();
                    $_r['paycnt_e'] = $this->MrgCnt_Pay();

                    $_r['fllorgcnt_e'] = $this->MrgCnt_Fll_Org();
                    $_r['fllphtcnt_e'] = $this->MrgCnt_Fll_Pht();
                    $_r['fllsclcnt_e'] = $this->MrgCnt_Fll_Scl();
                    $_r['flltpccnt_e'] = $this->MrgCnt_Fll_Tpc();


                    $_r_del = $this->MrgCnt_Del();
                    $_r['e'] = $_r_del->e;

                }
            }


        $_r['w'] = _jEnc($this->mrg_w);
        return _jEnc($_r);

    }

    private function MrgCnt_Chk($p=NULL){
        $_v = array_intersect($p['m']->dc_t, $p['d']->dc_t);
        $_v = count($_v); $_r = 'no';
        if($_v == 0){ $_r = 'ok'; }
        return($_r);
    }

    private function MrgCnt_CntTp(){

       	global $__cnx;

        if($this->__cnt_d->count->cnttp > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_TP." SET cnttp_cnt=%s WHERE cnttp_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));

            $ResultUPD = $__cnx->_prc($updateSQL);

            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'CntTp->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_MdlCnt(){

        global $__cnx;

        $__t_a_d = $this->MrgCnt_Chck_Dp();

        if($__t_a_d->e == 'ok'){
            for ($i = 1; $i <= count($__t_a_d->d); $i++) {


                if($this->__cnt_d->count->l2 == 0){
                    $_r_del = $this->MrgCnt_MdlCnt_Del(['cnt'=>$this->__cnt_d->id, 'apr'=>$__t_a_d->d->{$i}->apr_id]);
                }else{

                    $_apr_n = $this->MrgCnt_Chck_Apr(['t'=>'m', 'apr'=>$__t_a_d->d->{$i}->apr_id]);
                    $_apr_d = $this->MrgCnt_Chck_Apr(['t'=>'d', 'apr'=>$__t_a_d->d->{$i}->apr_id]);

                    if($_apr_n->e == 'ok' && $_apr_n->id != NULL){
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'cdgc', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'ec', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'ent', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'est', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'his', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'msj', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'prd', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                        $this->MrgCnt_MdlCnt_Rlc(['t'=>'vst', 'apr_m'=>$_apr_n->id, 'apr_d'=>$_apr_d->id ]);
                    }



                }

            }

        }

        if($this->__cnt_d->count->mdl > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_CNT." SET mdlcnt_cnt=%s WHERE mdlcnt_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'MdlCnt->'.$__cnx->c_p->error; }
            return _jEnc($Vl);

        }
    }

    private function MrgCnt_Eml(){

	    global $__cnx;

        if($this->__cnt_d->count->eml > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_EML." SET cnteml_cnt=%s WHERE cnteml_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'Eml->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Dc(){

	    global $__cnx;

        if($this->__cnt_d->count->dc > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_DC." SET cntdc_cnt=%s WHERE cntdc_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'Dc->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Snd(){

	    global $__cnx;

        if($this->__cnt_d->count->snd > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_EC_SND." SET ecsnd_cnt=%s WHERE ecsnd_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'Snd->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Tel(){

	    global $__cnx;

        if($this->__cnt_d->count->tel > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_TEL." SET cnttel_cnt=%s WHERE cnttel_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'Tel->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Pay(){

	    global $__cnx;

        if($this->__cnt_d->count->mdl_pay > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_CNT_PAY_BD." SET mdlcntpay_cnt=%s WHERE mdlcntpay_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'MdlPay->'.$$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Fll_Org(){

	    global $__cnx;

        if($this->__cnt_d->count->fll_org > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".MDL_CNT_FLL_ORG_BD." SET cntfllorg_cnt=%s WHERE cntfllorg_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FllOrg->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Fll_Pht(){

	    global $__cnx;

        if($this->__cnt_d->count->fll_org > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){
            $updateSQL = sprintf("UPDATE ".MDL_CNT_FLL_PHT_BD." SET cntfllpht_cnt=%s WHERE cntfllpht_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FllPht->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Fll_Scl(){

	    global $__cnx;

        if($this->__cnt_d->count->fll_scl > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){
            $updateSQL = sprintf("UPDATE ".MDL_CNT_FLL_SCL_BD." SET cntfllscl_cnt=%s WHERE cntfllscl_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FllScl->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Fll_Tpc(){

	    global $__cnx;

        if($this->__cnt_d->count->fll_tpc > 0 && $this->__cnt_d->id != NULL && $this->__cnt_m->id != NULL){

            $updateSQL = sprintf("UPDATE ".MDL_CNT_FLL_TPC_BD." SET cntflltpc_cnt=%s WHERE cntflltpc_cnt=%s",
                               GtSQLVlStr( $this->__cnt_m->id, "int"),
                               GtSQLVlStr( $this->__cnt_d->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FllTpc->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Flds(){

        global $__cnx;

        $Ls_Qr = 'SHOW COLUMNS FROM '.TB_MDL_CNT;
        $Ls_Rg = $__cnx->_prc($Ls_Qr); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

        if($Tot_Ls_Rg > 0){

            do {

                $_r_cm = $this->MrgCnt_Flds_Gt([ 'id'=>$this->__cnt_m->id, 'f'=>$row_Ls_Rg['Field'] ]);
                $_r_cd = $this->MrgCnt_Flds_Gt([ 'id'=>$this->__cnt_d->id, 'f'=>$row_Ls_Rg['Field'] ]);
                if($_r_cd->e == 'ok' && $_r_cm->e != 'ok'){
                    $__upd = $this->MrgCnt_Flds_Upd(['f'=>$row_Ls_Rg['Field'], 'v'=>$_r_cd->v]);
                }

            } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
        }

    }

    private function MrgCnt_Flds_Gt($p=NULL){

        global $__cnx;

        if(!isN($p['id'])){

            $query_DtRg = sprintf('SELECT * FROM '.TB_CNT.' WHERE id_cnt = %s LIMIT 1', GtSQLVlStr($p['id'],'int'));
            $DtRg = $__cnx->_prc($query_DtRg);
            $row_DtRg = $DtRg->fetch_assoc();
            $Tot_DtRg = $DtRg->num_rows;

            if($Tot_DtRg > 0){
                if($row_DtRg[$p['f']] != ''){
                    $Vl['e'] = 'ok';
                    $Vl['v'] = $row_DtRg[$p['f']];
                }
            }

            $__cnx->_clsr($DtRg);

            return _jEnc($Vl);
        }
    }

    private function MrgCnt_Flds_Upd($p=NULL){

	    global $__cnx;

        if($p['f'] != NULL && $p['v'] != NULL){
            $updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT." SET ".$p['f']."=%s WHERE id_cnt=%s",
                               GtSQLVlStr( $p['v'], "text"),
                               GtSQLVlStr( $this->__cnt_m->id, "int"));
            $ResultUPD = $__cnx->_prc($updateSQL);
            if($ResultUPD){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FldUpd->'.$__cnx->c_p->error; }
        }
        return _jEnc($Vl);

    }

    private function MrgCnt_Del(){

	    global $__cnx;

        if($this->__cnt_d->id != NULL){
            $deleteSQL = sprintf('DELETE FROM '.$this->bd.TB_CNT.' WHERE id_cnt=%s LIMIT 1',GtSQLVlStr( $this->__cnt_d->id, 'int'));
            $ResultDEL = $__cnx->_prc($deleteSQL);
            if($ResultDEL){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'FldsDel->'. $__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    private function MrgCnt_MdlCnt_Rlc($p=NULL){

        global $__cnx;


        if($this->__cnt_d->count->mdl > 0 && $p['apr_m'] != NULL && $p['apr_d'] != NULL && $p['t'] != NULL){


            if($p['t'] == 'cdgc'){
                $_bd = TB_MDL_CNT_CDGC_BD;
                $_id_r = 'mdlcntcdgc_cnt';
                $_id_b = 'id_mdlcntcdgc';
            }elseif($p['t'] == 'ec'){
                $_bd = TB_MDL_CNT_SND_BD;
                $_id_r = 'mdlcntsnd_mdlcnt';
                $_id_b = 'id_mdlcntsnd';
                $query_LsRg = sprintf('SELECT * FROM '.TB_MDL_EC_SND.' WHERE id_ecsnd IN ( SELECT mdlcntsnd_snd FROM '.TB_MDL_CNT_SND_BD.' WHERE '.$_id_r.' = %s LIMIT 1) ', GtSQLVlStr( $p['apr_d'],'int'));
            }elseif($p['t'] == 'ent'){
                $_bd = TB_MDL_CNT_ENT_BD;
                $_id_r = 'mdlcntent_cnt';
                $_id_b = 'id_mdlcntent';
            }elseif($p['t'] == 'est'){
                $_bd = TB_MDL_CNT_EST_BD;
                $_id_r = 'mdlcntest_mdlcnt';
                $_id_b = 'id_mdlcntest';
            }elseif($p['t'] == 'his'){
                $_bd = TB_MDL_CNT_HIS;
                $_id_r = 'mdlcnthis_mdlcnt';
                $_id_b = 'id_mdlcnthis';
            }elseif($p['t'] == 'msj'){
                $_bd = TB_MDL_CNT_MSJ;
                $_id_r = 'mdlcntmsj_mdlcnt';
                $_id_b = 'id_mdlcntmsj';
            }elseif($p['t'] == 'prd'){
                $_bd = TB_MDL_CNT_PRD_BD;
                $_id_r = 'mdlcntprd_mdlcnt';
                $_id_b = 'id_mdlcntprd';
            }elseif($p['t'] == 'vst'){
                $_bd = TB_MDL_CNT_VST_BD;
                $_id_r = 'mdlcntvst_mdlcnt';
                $_id_b = 'id_mdlcntvst';
            }

            try {

                if($_bd != '' && $_id_r != ''){

                    if($query_LsRg == ''){
                        $query_LsRg = sprintf('SELECT * FROM '.$_bd.' WHERE '.$_id_r.' = %s', GtSQLVlStr( $p['apr_d'],'int'));
                    }
                    $LsRg = $__cnx->_prc($query_LsRg);
                    $row_LsRg = $LsRg->fetch_assoc();
                    $Tot_LsRg = $LsRg->num_rows;

                    if($Tot_LsRg > 0){

                        do {

                            if($row_LsRg[$_id_b] != ''){

                                    $updateSQL = sprintf("UPDATE ".$this->bd.$_bd." SET {$_id_r}=%s WHERE {$_id_b}=%s",
                                                       GtSQLVlStr( $p['apr_m'], "int"),
                                                       GtSQLVlStr( $row_LsRg[$_id_b], "int"));
                                    $ResultUPD = $__cnx->_prc($updateSQL);

                                    if($ResultUPD){
                                        $Vl['e'] = 'ok';
                                    }else{
                                        $Vl['e'] = 'no';
                                        if($__cnx->c_p->errno == 1062){

                                            $deleteSQL = sprintf('DELETE FROM '.$_bd.' WHERE '.$_id_b.'=%s LIMIT 1',GtSQLVlStr( $row_LsRg[$_id_b], 'int'));
                                            $ResultDEL = $__cnx->_prc($deleteSQL);
                                            $this->mrg_w[] = $__cnx->c_p->error;

                                        }else{
                                            $this->mrg_w[] = 'MdlCntRlc'.$p['t'].' -> NoERROR: ->'.$__cnx->c_p->errno.'->'.$__cnx->c_p->error.'->'.$updateSQL;
                                        }
                                    }
                            }
                        } while ($row_LsRg = $LsRg->fetch_assoc());

                    }

                    $__cnx->_clsr($LsRg);

                    return _jEnc($Vl);

                }

            } catch (Exception $e) {

                $this->mrg_w[] = $e->getMessage();

            }
        }
    }

    private function MrgCnt_Chck_Dp(){

        global $__cnx;

        $query_DtRg = sprintf('SELECT COUNT(mdlcnt_cnt) AS ___apr_tot, mdlcnt_cnt, mdlcnt_cnt AS ___apr_id
                               FROM '.TB_MDL_CNT.'
                               WHERE mdlcnt_cnt IN ('.$this->__cnt_m->id.', '.$this->__cnt_d->id.')
                               GROUP BY mdlcnt_cnt HAVING ___apr_tot > 1');

        $DtRg = $__cnx->_prc($query_DtRg);
        $row_DtRg = $DtRg->fetch_assoc();
        $Tot_DtRg = $DtRg->num_rows;

        if($Tot_DtRg > 0){

            $Vl['e'] = 'ok';

            $i = 1;

            do {

                $Vl['d'][ $i ]['apr_tot'] = $row_DtRg['___apr_tot'];
                $Vl['d'][ $i ]['apr_id'] = $row_DtRg['___apr_id'];
                $i++;

            } while ($row_DtRg = $DtRg->fetch_assoc());


        }else{

            $Vl['e'] = 'no';

        }

        $__cnx->_clsr($DtRg);

        return _jEnc($Vl);
    }

    private function MrgCnt_Chck_Apr($p=NULL){

        global $__cnx;

        if($p['apr'] != NULL && $p['t'] != NULL){

            if($p['t'] == 'm'){ $__cnt_f = $this->__cnt_m->id; }elseif($p['t'] == 'd'){ $__cnt_f = $this->__cnt_d->id; }

            $query_DtRg = sprintf('SELECT * FROM '.TB_MDL_CNT.' WHERE mdlcnt_cnt = '.GtSQLVlStr( $__cnt_f, 'int').' AND mdlcnt_cnt = '.GtSQLVlStr( $p['apr'], 'int').' LIMIT 1');
            $DtRg = $__cnx->_prc($query_DtRg);
            $row_DtRg = $DtRg->fetch_assoc();
            $Tot_DtRg = $DtRg->num_rows;

            if($Tot_DtRg > 0){
                $Vl['e'] = 'ok';
                $Vl['id'] = $row_DtRg['id_mdlcnt'];
            }else{
                $Vl['e'] = 'no';
            }

            $__cnx->_clsr($DtRg);
        }

        return _jEnc($Vl);
    }

    private function MrgCnt_MdlCnt_Del($p=NULL){

	    global $__cnx;

        if($p['apr'] != NULL && $p['cnt'] != NULL){

            $deleteSQL = sprintf('DELETE FROM '.$this->bd.TB_MDL_CNT.' WHERE mdlcnt_cnt=%s AND mdlcnt_cnt=%s LIMIT 1',GtSQLVlStr( $p['cnt'], 'int'),GtSQLVlStr( $p['apr'], 'int'));
            $ResultDEL = $__cnx->_prc($deleteSQL);
            if($ResultDEL){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; $this->mrg_w[] = 'MdlCntDel->'.$__cnx->c_p->error; }
            return _jEnc($Vl);
        }
    }

    public function NmAp(){

        $this->cnt_nm = MyMn($this->cnt_nm);
        $this->cnt_ap = MyMn($this->cnt_ap);

        $__nm_fx = __NmFx($this->cnt_nm);

        if(isN($this->cnt_ap) && !isN( $__nm_fx->nm )){
            $this->cnt_nm = trim($__nm_fx->nm);
            $this->cnt_ap = trim($__nm_fx->ap);
        }else{
            $this->cnt_nm = trim($this->cnt_nm);
            $this->cnt_ap = trim($this->cnt_ap);
		}

		//echo 'Name:'.$this->cnt_nm.PHP_EOL;
		//echo 'LastName:'.$this->cnt_ap.PHP_EOL.PHP_EOL;

    }

    public function CntCk_Chck($p=NULL){

        global $__cnx;

        if(!isN($p['cnt'])){

            $__qry = sprintf('	SELECT *
            					FROM '.$this->bd.TB_CNT_CK.'
								WHERE cntck_ck = %s AND cntck_cnt = %s
								LIMIT 1', GtSQLVlStr($p['ck'], 'text'), GtSQLVlStr($p['cnt'], 'text') );

            $query_DtRg = $__qry;
            $DtRg = $__cnx->_prc($query_DtRg);

            if($DtRg){

                $row_DtRg = $DtRg->fetch_assoc();
                $Tot_DtRg = $DtRg->num_rows;

                $this->w_all .= 'CntCk_Chck:'.$__cnx->c_p->error;

                if($Tot_DtRg == 1){
                    $Vl['e'] = 'ok';
                    $Vl['id'] = $row_DtRg['id_cntck'];
                }else{
					$Vl['e'] = 'no';
                }
            }else{
	            $Vl['q_e'] = 'CntCk_Chck:'.$__cnx->c_p->error;
            }

            $__cnx->_clsr($DtRg);

        }else{
            $Vl['r'] = 'no';
        }

        return _jEnc($Vl);
    }

    public function CntCk_In($id=NULL){

		global $__cnx;

		$_r['e'] = 'ok';

		if(!isN($id) && !isN($_COOKIE[CKTRCK_SES])){

			$__chk = $this->CntCk_Chck([ 'ck'=>$_COOKIE[CKTRCK_SES], 'cnt'=>$id ]);

			//$_r['tmp_chk'] = $__chk;

			if($__chk->e != 'ok'){

				$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_CK." (cntck_ck, cntck_cnt) VALUES (%s, %s)",
							GtSQLVlStr($_COOKIE[CKTRCK_SES], "text"),
							GtSQLVlStr($id, "int"));
				$Result = $__cnx->_prc($insertSQL);

				if($Result || $this->demo){
					$_r['e'] = 'ok';
				}else{
					$_r['e'] = 'no';
					$_r['w'] = $__cnx->c_p->error;
				}

			}else{

				$_r['e'] = 'ok';

			}
		}

		return _jEnc($_r);
	}




    public function InLstsCnt(){

        //-------------- Check Not Exists --------------//

	        $__dtcnt = $this->Chck([ 'id'=>$this->cnt_dc ]);

	        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
	            $__dtcnt = $this->Chck([ 'id'=>filter_var($this->cnt_eml, FILTER_VALIDATE_EMAIL), 'chk'=>'eml' ]);
	        }
	        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){
	            $__dtcnt = $this->Chck([ 'id'=>$this->cnt_id, 'chk'=>'enc' ]);
	        }

		//-------------- If Not Exists - Process --------------//

	        if($__dtcnt->e != 'ok' || isN($__dtcnt->id)){

	            $__dtcnt_in = $this->InCnt();

	            $_r['_p'] = $__dtcnt_in->e;
	            $_r['_q'] = $__dtcnt_in->q;

	            if($__dtcnt_in->e == 'ok'){
	                $__dtcnt = $this->Chck([ 'id'=>$__dtcnt_in->i, 'chk'=>'id' ]);
	            }else{
	                $__dtcnt = NULL;
	                $_r['e'] = 'no';
	                $_r['w'] = $__dtcnt_in->w;
	            }
	        }

        //-------------- Process More Data Related --------------//

	        $this->InCntDcAll($__dtcnt->id);
	        $_p_eml = $this->InCntEmlAll($__dtcnt->id);


	        $this->InCntTelAll($__dtcnt->id);
	        $this->InCntTpAll($__dtcnt->id);
	        $this->CntOrgAll($__dtcnt->id);
	        $this->CntCdAll($__dtcnt->id);
	        $this->CntCdAllRel($__dtcnt->id);
	        $this->InCntPlcyAll($__dtcnt->id);


	        $_r['i'] = $__dtcnt->id;
	        $_r['u_all'] = $this->u_all;

	        if($_p_eml->e == 'no'){ $_r['w'] = 'ok'; }

	        return _jEnc($_r);
    }








    public function Run_Wrk_Cnt($w=NULL){

	    global $__cnx;

        $updateSQL = sprintf("INSERT INTO wrk_cnt (wrkcnt_nm, wrkcnt_cel, wrkcnt_eml, wrkcnt_fld, wrkcnt_crg) VALUES (%s, %s, %s, %s, %s)",
                           GtSQLVlStr(ctjTx($this->cnt_nm, 'out'), "text"),
                           GtSQLVlStr(ctjTx($this->cnt_cel, 'out'), "text"),
                           GtSQLVlStr(ctjTx($this->cnt_eml, 'out'), "text"),
                           GtSQLVlStr(ctjTx($this->fld, 'out'), "text"),
                           GtSQLVlStr(ctjTx($this->crg, 'out'), "text"));

        $Result_UPD = $__cnx->_prc($updateSQL);
        if($Result_UPD || $this->demo){  $_r['e'] = 'ok'; $_r['i'] = $__cnx->c_p->insert_id;  }else{  $_r['e'] = 'no';  }
        return _jEnc($_r);

    }

    public function InSmsCmpg(){

		$__dtcnt = $this->_Cnt()->d;

		$__SndSMS = new API_CRM_sms();
		$__SndSMS->snd_cel = $this->smssnd_cel;

		if($this->smssnd_msj != NULL && $this->smssnd_msj != ''){
			$__SndSMS->snd_msj = $this->smssnd_msj;
		}else{
			$__SndSMS->snd_msj = $this->sms_cmpg_msj;
		}


		$__SndSMS->snd_us = $this->sms_cmpg_us;
		$__SndSMS->snd_f = $this->sms_cmpg_f;
		$__SndSMS->snd_h = $this->sms_cmpg_h;



		$__SndSMS_r = $__SndSMS->_SndSMS();

		$_r = $__SndSMS_r;
		$_r_rlc = $this->InSmsSndCmpg([ 'snd'=>$_r->i ]);

		if($_r->e == 'ok' && $_r_rlc->e == 'ok'){
			return $_r;
		}else{
			return $_r_rlc;
		}

	}

	// Listado de vinculos

	public function GtCntTpLs($p=NULL){

		global $__cnx;
		global $__dt_cl;

	    //$this->mdlstp_tp;
	    $Vl['e'] = 'no';

	    //if(!isN($this->cnt_enc)){

		    //Valida el cliente
		    if( !isN($p['cl']) ){
			    $_id_cl = $p['cl'];
		    }else{
				if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }
			    $_id_cl = $__dt_cl->id;
		    }

		    if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		    if( !isN($p['mdl_gen']) ){
				//$__fl .= " AND id_siscnttp IN( SELECT mdlgentpv_tpv FROM {$__bdprfx}".TB_MDL_GEN_TP_V." WHERE mdlgentpv_mdlgen = ".$p['mdl_gen']." ) ";
				$__fl .= " AND id_siscnttp IN(
												SELECT mdlstpfmcnttp_siscnttp FROM "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP."
												WHERE mdlstpfmcnttp_mdlstpfm  IN (
																				SELECT mdlfmgen_mdlstpfm FROM {$__bdprfx}".TB_MDL_GEN_FM." WHERE mdlfmgen_mdlgen = ".$p['mdl_gen']."
																			)
											) ";
		    }

		    if( !isN($p['mdl']) ){
				//$__fl .= " AND id_siscnttp IN( SELECT mdltpv_tpv FROM {$__bdprfx}".TB_MDL_TP_V." WHERE mdltpv_mdl = ".$p['mdl']." ) ";
				$__fl .= " AND id_siscnttp IN(
												SELECT mdlstpfmcnttp_siscnttp FROM "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP."
												WHERE mdlstpfmcnttp_mdlstpfm  IN (
																				SELECT mdlfm_mdlstpfm FROM {$__bdprfx}".TB_MDL_FM." WHERE mdlfm_mdl = ".$p['mdl']."
																			)
											) ";
		    }

		    $query_DtRg = "
						SELECT siscnttp_enc, siscnttp_nm, siscnttp_clr,

					(	SELECT COUNT(*)
						FROM ".$this->bd.TB_CNT_TP."
						WHERE cnttp_tp = id_siscnttp AND cnttp_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = '".$this->cnt_enc."')
					) AS tot

					FROM "._BdStr(DBM).TB_SIS_CNT_TP."
					WHERE id_siscnttp != ''
					AND siscnttp_cl = ".$_id_cl." $__fl
					ORDER BY siscnttp_nm ASC

			";

			$DtRg = $__cnx->_prc($query_DtRg);


			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';

					do{

						$Vl['ls'][$row_DtRg['siscnttp_enc']]['enc'] = $row_DtRg['siscnttp_enc'];
						$Vl['ls'][$row_DtRg['siscnttp_enc']]['nm'] = ctjTx($row_DtRg['siscnttp_nm'],'in');
						$Vl['ls'][$row_DtRg['siscnttp_enc']]['tot'] = $row_DtRg['tot'];
						$Vl['ls'][$row_DtRg['siscnttp_enc']]['clr'] = $row_DtRg['siscnttp_clr'];

						if($row_DtRg['tot'] > 0){
							$_r_li .= li( Spn(ctjTx($row_DtRg['siscnttp_nm'],'in'),'', '__e', 'font-weight:bolder; background-color:'.$row_DtRg['siscnttp_clr'].'; color:#fff;')  );
						}

					}while($row_DtRg = $DtRg->fetch_assoc());


					if($_r_li != ''){ $Vl['html'] = ul($_r_li, '_anm ls_tag'); }
				}

			}else{
				$Vl['w'] = $__cnx->c_p->error;
			}

		//}
			$__cnx->_clsr($DtRg);


		return(_jEnc($Vl));

    }

	public function _Cnt_Tp_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->cnt_enc.'-'.$this->sisbd_enc);

		$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_CNT_TP." (
															cnttp_enc,
															cnttp_cnt,
															cnttp_tp
														  )
														  VALUES
														  (
														  	%s,
														  	(SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s),
														  	(SELECT id_siscnttp FROM "._BdStr(DBM).TB_SIS_CNT_TP." WHERE siscnttp_enc = %s)
														  )
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->sisbd_enc, 'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}

	public function _Sis_Cnt_Tp_In($p=NULL){

		global $__cnx;
		global $__dt_cl;

		if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		$__enc = Enc_Rnd($this->cnttp_nm.'-'.$this->cnttp_clr);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_TP." (
															siscnttp_enc,
															siscnttp_cl,
															siscnttp_nm,
															siscnttp_clr
														  )
														  VALUES
														  (
														  	%s, %s, %s, %s
														  )
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr($__dt_cl->id, "int"),
							GtSQLVlStr(ctjTx($this->cnttp_nm, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cnttp_clr, 'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function _Cnt_Tp_Eli($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_CNT_TP." WHERE
															cnttp_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s) AND
															cnttp_tp = (SELECT id_siscnttp FROM "._BdStr(DBM).TB_SIS_CNT_TP." WHERE siscnttp_enc = %s)
							",
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->sisbd_enc, 'out'), "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}

	//Lista las sis_bd
	public function GtCntBdLs($p=NULL){

		global $__cnx;
		global $__dt_cl;

	    //$this->mdlstp_tp;
	    $Vl['e'] = 'no';

	    if(!isN($this->cnt_enc)){

		    if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		    $query_DtRg = "
					SELECT *,
					(	SELECT COUNT(*)
						FROM ".$this->bd.TB_CNT_BD."
						WHERE cntbd_bd = id_sisbd AND cntbd_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = '".$this->cnt_enc."')
					) AS tot
			FROM "._BdStr(DBM).TB_SIS_BD."
			WHERE id_sisbd != ''
			AND sisbd_cl = ".$__dt_cl->id."
			ORDER BY sisbd_nm ASC";


			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['sisbd_enc']]['enc'] = $row_DtRg['sisbd_enc'];
						$Vl['ls'][$row_DtRg['sisbd_enc']]['nm'] = ctjTx($row_DtRg['sisbd_nm'],'in');
						$Vl['ls'][$row_DtRg['sisbd_enc']]['tot'] = $row_DtRg['tot'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}

			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));

    }

    public function _Sis_Bd_In($p=NULL){

		global $__cnx;
		global $__dt_cl;

		if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		$__enc = Enc_Rnd($this->cnttp_nm.'-'.$this->cnttp_clr);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_BD." (
															sisbd_enc,
															sisbd_cl,
															sisbd_nm
														  )
														  VALUES
														  (
														  	%s, %s, %s
														  )
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr($__dt_cl->id, "int"),
							GtSQLVlStr(ctjTx($this->sisbd_nm, 'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

     // Contactos - Base de datos Ingresar
	public function _Cnt_Bd_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->cnt_enc.'-'.$this->sisbd_enc);

		$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_CNT_BD." (
															cntbd_enc,
															cntbd_cnt,
															cntbd_bd
														  )
														  VALUES
														  (
														  	%s,
														  	(SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s),
														  	(SELECT id_sisbd FROM "._BdStr(DBM).TB_SIS_BD." WHERE sisbd_enc = %s)
														  )
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->sisbd_enc, 'out'), "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}

	// Contactos - Base de datos Eliminar
	public function _Cnt_Bd_Eli($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_CNT_BD." WHERE
															cntbd_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s) AND
															cntbd_bd = (SELECT id_sisbd FROM "._BdStr(DBM).TB_SIS_BD." WHERE sisbd_enc = %s)
							",
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->sisbd_enc, 'out'), "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}

	//----------------- Contacto Tipo Contactabilidad --------------------//
	public function GtCntHCntc($p=NULL){

		global $__cnx;
		global $__dt_cl;

	    $Vl['e'] = 'no';

	    if(!isN($this->cnt_enc)){

		    if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		    $query_DtRg = "
					SELECT *,
					(	SELECT COUNT(*)
						FROM ".$this->bd.TB_CNT_H_CNTC."
						WHERE cnthcntc_clhcntc = id_clhcntc AND cnthcntc_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = '".$this->cnt_enc."')
					) AS tot
			FROM "._BdStr(DBM).TB_CL_H_CNTC."
			WHERE id_clhcntc != ''
			AND clhcntc_cl = ".$__dt_cl->id."
			ORDER BY clhcntc_nm ASC";


			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['clhcntc_enc']]['enc'] = $row_DtRg['clhcntc_enc'];
						$Vl['ls'][$row_DtRg['clhcntc_enc']]['nm'] = ctjTx($row_DtRg['clhcntc_nm'],'in');
						$Vl['ls'][$row_DtRg['clhcntc_enc']]['tot'] = $row_DtRg['tot'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}

			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));

    }
	public function CntHCntc_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->cnt_enc.'-'.$this->sisbd_enc);

		$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_CNT_H_CNTC." ( cnthcntc_enc, cnthcntc_cnt, cnthcntc_clhcntc )
														  VALUES ( %s, (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s), (SELECT id_clhcntc FROM "._BdStr(DBM).TB_CL_H_CNTC." WHERE clhcntc_enc = %s) )
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cntc_enc, 'out'), "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}
	public function CntHCntc_Eli($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_CNT_H_CNTC." WHERE
															cnthcntc_cnt = (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s) AND
															cnthcntc_clhcntc = (SELECT id_clhcntc FROM "._BdStr(DBM).TB_CL_H_CNTC." WHERE clhcntc_enc = %s)
							",
							GtSQLVlStr(ctjTx($this->cnt_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cntc_enc, 'out'), "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}
	//----------------- Contacto Tipo Contactabilidad --------------------//

	public function CntPrntIn($p=NULL){

		global $__cnx;

		if(!isN($this->rsp_fnc) && $this->rsp_fnc == 1){ $_rsp = 1; }else{ $_rsp = 2; }

		$__enc = Enc_Rnd($this->cnt_cnt.'-'.$this->cnt_rlc.'-'.$this->cnt_prnt);
		$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_PRNT." (cntprnt_enc, cntprnt_cnt_1, cntprnt_cnt_prnt_1, cntprnt_cnt_2, cntprnt_rsp_fnc) VALUES
								(%s, (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s), %s, (SELECT id_cnt FROM ".$this->bd.TB_CNT." WHERE cnt_enc = %s), %s)",
								   GtSQLVlStr($__enc, "text"),
								   GtSQLVlStr($this->cnt_cnt, "text"),
								   GtSQLVlStr($this->cnt_prnt, "text"),
								   GtSQLVlStr($this->cnt_rlc, "text"),
								   GtSQLVlStr($_rsp, "int"));


		$Result = $__cnx->_prc($insertSQL);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w'] = $insertSQL.'  <->  '.$__cnx->c_p->error;
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($rsp);

	}

	public function CntPrntMod($p=NULL){

		global $__cnx;

		$insertSQL = sprintf("UPDATE ".$this->bd.TB_CNT_PRNT." SET cntprnt_cnt_prnt_1=%s WHERE cntprnt_enc=%s",
								   GtSQLVlStr($this->cnt_prnt, "text"),
								   GtSQLVlStr($this->cnt_enc, "text"));

		$Result = $__cnx->_prc($insertSQL);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['w'] = $insertSQL;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}
		return _jEnc($rsp);
	}

	public function MdIn($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$rsp['p'] = $_p;


		if(!isN($_p['mdlcnt'])){
			$_mdl_cnt = $_p['mdlcnt'];
		}elseif(!isN($this->mdlcnt_md)){
			$_mdl_cnt = $this->nw_id_mdlcnt;
		}

		$rsp['nw_id_mdlcnt'] = $_mdl_cnt;
		$rsp['mdlcnt_md'] = $this->mdlcnt_md;

		if(!isN($this->nw_id_mdlcnt) && !isN($this->mdlcnt_md)){

			if($_p['tp'] == 'mdl'){

				$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_M_BD." (mdlcntm_mdlcnt, mdlcntm_k, mdlcntm_adg, mdlcntm_m, mdlcntm_dsp, mdlcntm_ref) VALUES (%s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr($_mdl_cnt, "int"),
								   GtSQLVlStr($this->mdlcnt_md_k, "text"),
								   GtSQLVlStr($this->mdlcnt_md_adg, "text"),
								   GtSQLVlStr($this->mdlcnt_md, "int"),
								   GtSQLVlStr($this->dvc, "text"),
								   GtSQLVlStr($this->ref, "text"));

				//$rsp['q'] =	$insertSQL;
			}

			if(!isN($insertSQL)){

				$Result = $__cnx->_prc($insertSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['s_msj'] = 'ok';
				}else{
					$rsp['s_msj'] = $rsp['w'] = $__cnx->c_p->error;
				}

			}else{
				$rsp['w'] = 'No query to execute';
			}

		}else{

			$rsp['w'][] = 'No data for process';
			if(isN($_mdl_cnt)){ $rsp['w'][] = '$this->nw_id_mdlcnt empty'; }
			if(isN($this->mdlcnt_md)){ $rsp['w'][] = '$this->mdlcnt_md empty'; }

		}

		return _jEnc($rsp);

	}

	public function CntEmlSndRmv($p=NULL){

        global $__cnx;

        $_r['e'] = 'no';

        if(!isN($this->cnteml_enc)){
	        $___eml = GtCntEmlDt(['id'=>$this->cnteml_enc, 'tp'=>'enc', 'bd'=>$this->bd, 'd'=>['plcy'=>'ok'] ]);
        }

        if(!isN($this->id_ecsnd) && !isN($___eml->id)){

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_EML_RMV." (cntemlrmv_cnteml, cntemlrmv_snd) VALUES (%s, %s)",
                       GtSQLVlStr($___eml->id, "int"),
                       GtSQLVlStr($this->id_ecsnd, "int"));

            $Result = $__cnx->_prc($insertSQL);
            $this->w_all .= 'CntEmlSndRmv:'.$__cnx->c_p->error;

            if($Result){
                $_r['id'] = $__cnx->c_p->insert_id;
                $_r['e'] = 'ok';
            }else{
                $_r['e'] = 'no';
                $this->w_all .= $_r['w'] = $__cnx->c_p->error;
            }

            $rtrn = _jEnc($_r);
            if(!isN($rtrn)){ return($rtrn); }

        }else{

	        $_r['w'] = 'No all data '.$this->id_ecsnd.' -> '.$___eml->id;

        }



        return _jEnc($_r);

    }

    function _Cnt_Cref($p=NULL){

		if(!isN( $this->cnt_cref ) && !isN($this->nw_id_cnt)){
			$cnt_ref = GtCntDt([  'bd'=>$this->bd, 't'=>'enc', 'id'=>$this->cnt_cref ]);
			if(!isN($cnt_ref->id)){
				$chk = $this->_Cnt_Cref_Chk([ 'ref'=>$cnt_ref->id ]);
				if(!$chk){ $_prc = $this->_Cnt_Cref_In([ 'ref'=>$cnt_ref->id ]); }
			}
		}

		return $_prc;
    }

    function _Cnt_Cref_Chk($p=NULL){

	    global $__cnx;

		if(!isN($this->nw_id_cnt) && !isN($p['ref'])){

			$query_DtRg = sprintf('SELECT * FROM '.$this->bd.TB_CNT_CREF.' WHERE cntcref_cnt=%s AND cntcref_cnt_ref=%s', GtSQLVlStr($this->nw_id_cnt, 'int'), GtSQLVlStr($p['ref'], 'int'));
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

			}

			$__cnx->_clsr($DtRg);

			if($Tot_DtRg==1){$_r=true;}else{$_r=false;}
			return($_r);
		}
	}

    public function _Cnt_Cref_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->nw_id_cnt.'-'.$p['ref']);

		$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_CNT_CREF." (cntcref_enc, cntcref_cnt, cntcref_cnt_ref) VALUES (%s,%s,%s)",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr($this->nw_id_cnt, "int"),
							GtSQLVlStr($p['ref'], "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function LsNewCd($_p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($_p['id'].' Ciudad');

		if(!isN($_p['ps'])){ $__dp = " ( SELECT id_siscddp FROM "._BdStr(DBM).TB_SIS_CD_DP." WHERE siscddp_ps = ".$_p['ps']." AND siscddp_ind = 1) "; }else{ $__dp = '89'; }

		$query = sprintf("INSERT INTO "._BdStr(DBM).MDL_SIS_CD_BD." (siscd_enc, siscd_tt, siscd_dp, siscd_vrf) VALUES (%s, %s, $__dp, %s)",
		                               GtSQLVlStr($__enc, "text"),
		                               GtSQLVlStr($_p['id'], "text"),
		                               GtSQLVlStr(2, "int"));

		$_r['dw'][] = $query;

        if(!isN($query)){
	        $Result = $__cnx->_prc($query);
	        if($Result){
		        $_r['e'] = 'ok';
		        $_r['i'] = $__cnx->c_p->insert_id;
		    }else{
			    $_r['e'] = 'no';
			    $_r['qry'] = $__cnx->c_p->error;
	        }
        }else{
	    	$_r['w'] = 'No query string';
        }

        return(_jEnc($_r));

	}

	public function CntHCntcIn($p=NULL){

	    global $__cnx;

	    $__dtcnthcntc = _ChckCntHCntc([ 'cnt'=>$p['cnt'], 'id'=>$p['cntc'], 'bd'=>$this->cl->bd ]);

    	if($__dtcnthcntc->e == 'no'){

            $__enc = Enc_Rnd($p['cntc'].'-'.$p['cnt']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_H_CNTC." (cnthcntc_enc, cnthcntc_cnt, cnthcntc_clhcntc) VALUES (%s, %s, %s)",
                           GtSQLVlStr( $__enc, "text"),
                           GtSQLVlStr( $p['cnt'] , "int"),
                           GtSQLVlStr( $p['cntc'], "int"));

            $Result = $__cnx->_prc($insertSQL);

            if($Result){

                $rsp['e'] = 'ok';
                $rsp['m'] = 1;
                $this->UpdCntFA([ 'id'=>$p['cnt'] ]);

            }else{
                $rsp['e'] = 'no';
                $rsp['m'] = $insertSQL;
                $this->w_all .= 'doc ->'.$__cnx->c_p->error;
            }
        }else{
            $this->w_all .= 'CntHCntcIn:' .$__dteml->cnt->id.' '.$__dteml->cnt->nm.' '.$__dteml->cnt->ap;
        }
        return _jEnc($rsp);

    }

    public function CntTpCntcIn($p=NULL){

	    global $__cnx;

		$__dtcnthcntc = _ChckCntTpCntc([ 'cnt'=>$p['cnt'], 'id'=>$p['tp'], 'bd'=>$this->cl->bd, 'cmmt'=>'ok' ]);

		$rsp['mddd'] = $__dtcnthcntc;

    	if($__dtcnthcntc->e == 'ok' && isN($__dtcnthcntc->id)){

            $__enc = Enc_Rnd($p['cntc'].'-'.$p['cnt']);

            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_TP_CNTC." (cnttpcntc_enc, cnttpcntc_cnt, cnttpcntc_tp) VALUES (%s, %s, %s)",
                           GtSQLVlStr( $__enc, "text"),
                           GtSQLVlStr( $p['cnt'] , "int"),
                           GtSQLVlStr( $p['tp'], "int"));

            $Result = $__cnx->_prc($insertSQL);

            if($Result){

                $rsp['e'] = 'ok';
                $rsp['m'] = 1;
                $this->UpdCntFA([ 'id'=>$p['cnt'] ]);

            }else{
                $rsp['e'] = 'no';
                $rsp['m'] = $insertSQL;
                $this->w_all .= 'doc ->'.$__cnx->c_p->error;
            }
        }elseif($__dtcnthcntc->e == 'ok' && !isN($__dtcnthcntc->id)){
			$rsp['e'] = 'ok';
		}else{
            $this->w_all .= 'CntTpCntcIn:' .$__dteml->cnt->id.' '.$__dteml->cnt->nm.' '.$__dteml->cnt->ap;
        }

        return _jEnc($rsp);

	}

	public function ChckMdlCntMdl($p=NULL){

        global $__cnx;

        $Vl['e'] = 'no';

        if( !isN($p['mdl_cnt']) && !isN($p['mdl']) ){

            if(!isN($p['mdl_cnt'])){ $_f .= sprintf(' AND mdlcntmdl_mdlcnt=%s ', $p['mdl_cnt']); }
            if(!isN($p['mdl'])){ $_f .= sprintf(' AND mdlcntmdl_mdl=%s ', $p['mdl']); }

            $query_DtRg = sprintf("SELECT id_mdlcntmdl, mdlcntmdl_enc FROM ".$this->bd.TB_MDL_CNT_MDL." WHERE id_mdlcntmdl != '' {$_f} LIMIT 1");
			$DtRg = $__cnx->_prc($query_DtRg);

            if($DtRg){

	            $row_DtRg = $DtRg->fetch_assoc();
	            $Tot_DtRg = $DtRg->num_rows;

	            if($Tot_DtRg == 1){
	                $Vl['e'] = 'ok';
	                $Vl['id'] = $row_DtRg['id_mdlcntmdl'];
	                $Vl['enc'] = $row_DtRg['mdlcntmdl_enc'];
	            }else{
	                $Vl['w'] = 'ChckMdlCntMdl:'.$__cnx->c_p->error;
	            }
            }

            $__cnx->_clsr($DtRg);

        }

        return(_jEnc($Vl));
	}

	public function MdlCntMdl(){

		global $__cnx;

		$__dtmdlcntmdl = $this->ChckMdlCntMdl([ 'mdl_cnt'=>$this->mdl_cnt_id, 'mdl'=>$this->mdl_id ]);

		if(isN($__dtmdlcntmdl->id) && $__dtmdlcntmdl->e == 'no'){

			$__enc = Enc_Rnd($this->mdl_cnt_id.'-'.$this->mdl_id);

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_MDL." (mdlcntmdl_enc, mdlcntmdl_mdlcnt, mdlcntmdl_mdl) VALUES (%s, %s, %s)",
							GtSQLVlStr( $__enc, "text"),
							GtSQLVlStr( $this->mdl_cnt_id, "int"),
							GtSQLVlStr( $this->mdl_id, "int"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$Vl['e'] = 'ok';
				$Vl['m'] = 1;
			}else{
				$Vl['e'] = 'no';
				$Vl['m'] = 2;
			}

		}else{
			$Vl['e'] = 'no';
		}

		return(_jEnc($Vl));
	}

	public function MdlCntAttch(){

		global $__cnx;

		$Vl['e'] = 'ok';

		$this->attch->allw = ['jpg','jpeg','pdf','png','gif','doc','docx','xls','xlsx'];

		if(!isN($this->mdlcnt->attch)){

			$_fle = new CRM_Fle();
			$_aws = new API_CRM_Aws();

			foreach($this->mdlcnt->attch['upl']['tmp_name'] as $_k => $_v){

				if(isset($this->mdlcnt->attch) && $this->mdlcnt->attch['upl']['error'][$_k] == 0 ) {

					$_FLD['upl']['name'] = $this->mdlcnt->attch['upl']['name'][$_k];
					$_FLD['upl']['error'] = $this->mdlcnt->attch['upl']['error'][$_k];
					$_FLD['upl']['size'] = $this->mdlcnt->attch['upl']['size'][$_k];
					$_FLD['upl']['tmp_name'] = $this->mdlcnt->attch['upl']['tmp_name'][$_k];
					$_FLD['upl']['type'] = $this->mdlcnt->attch['upl']['type'][$_k];

					$____fl_nm = 'fle';
					$__fl_ext = pathinfo($_FLD['upl']['name'], PATHINFO_EXTENSION);

					if(!in_array(strtolower($__fl_ext), $this->attch->allw)){

						$Vl['status'][] = 'error';
						$Vl['w'][] = TX_FLE_NO_SUP;
						break;

					}else{

						$__fl_nm = $_FLD['upl']['name'];
						$__fl_sze = $_FLD['upl']['size'];
						$__fl_ext = pathinfo($_FLD['upl']['name'], PATHINFO_EXTENSION);
						$__tmp_nm = $_FLD['upl']['tmp_name'];
						$__nw_nm = Enc_Rnd($____fl_nm.'_'.$this->nw_id_mdlcnt).'.'.$__fl_ext;

						$__sve = $this->MdlCntAttch_In([ 'fle'=>$__nw_nm, 'nm'=>$__fl_nm ]);

						if($__sve->e == 'ok'){

							$__nw_fld = DIR_PRVT_ATTCH;
							$_sve = $_aws->_s3_put([ 'b'=>'prvt', 'fle'=>$__nw_fld.$__nw_nm, 'src'=>$__tmp_nm ]);

							if($_sve->e == 'ok'){

								$Vl['e'] = 'ok';
								$Vl['status'][] = 'success';

								$Vl['fle'][] = [
									'id'=>$__sve->id,
									'e'=>$__fl_ext,
									'n'=>$__fl_nm,
									'u'=>$__nw_nm,
								];

							}else{

								$Vl['e'] = 'no';
								$Vl['status'][] = 'error'; $Vl['w'][] = TX_PRB_MOV_FLE; break;

							}

						}else{

							$Vl['e'] = 'no'; break;
						}
					}

				}else{

					$Vl['status'] = 'error';
					$Vl['w'] = TX_NO_RCV_FLE;

				}
			}

		}

		return(_jEnc($Vl));
	}

	public function MdlCntAttch_In($p){

		global $__cnx;

		if(!isN($this->nw_id_mdlcnt) && !isN($p['fle'])){

			$__enc = Enc_Rnd($this->nw_id_mdlcnt.'-'.$p['fle']);

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_ATTCH." (mdlcntattch_enc, mdlcntattch_mdlcnt, mdlcntattch_fle, mdlcntattch_fle_nm) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr( $__enc, "text"),
							GtSQLVlStr( $this->nw_id_mdlcnt, "int"),
							GtSQLVlStr( $p['fle'], "text"),
							GtSQLVlStr( ctjTx($p['nm'], 'out'), "text"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$Vl['e'] = 'ok';
				$Vl['m'] = 1;
				$Vl['id'] = $__cnx->c_p->insert_id;
			}else{
				$Vl['e'] = 'no';
				$Vl['m'] = 2;
			}

		}else{
			$Vl['e'] = 'no';
		}

		return(_jEnc($Vl));
	}


	public function MdlCntCnv($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->nw_id_mdlcnt) && !isN($this->maincnv_enc)){

			$__cnv_main = GtMainCnvDt([ 'enc'=>$this->maincnv_enc, 'cmmt'=>$_p['cmmt'] ]);

			if(!isN($__cnv_main->id)){

				$__chk = $this->MdlCntCnvChk([ 'cnv'=>$__cnv_main->id, 'cmmt'=>$_p['cmmt'] ]);

				if($__chk && !isN($__chk->id)){

					$rsp['e'] = 'ok';
					$rsp['tmp'] = 'step1';
					$rsp['id'] = $__chk->enc;

				}else{

					$__enc = Enc_Rnd($this->nw_id_mdlcnt.$this->maincnv_enc);

					$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_CNV." (mdlcntcnv_enc, mdlcntcnv_mdlcnt, mdlcntcnv_cnv) VALUES (%s, %s, %s)",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr($this->nw_id_mdlcnt, "int"),
									GtSQLVlStr($__cnv_main->id, "int"));

					$Result = $__cnx->_prc($insertSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['id'] = $__enc;
						$rsp['tmp'] = 'step2';
					}else{
						$rsp['w'][] = $__cnx->c_p->error;
						$rsp['s_msj'] = $__cnx->c_p->error;
					}

				}

			}else{
				$rsp['w'][] = '$__cnv_main empty:'.print_r($__cnv_main, true);
			}

		}else{

			if(isN($this->nw_id_mdlcnt)){ $rsp['w'][] = '$this->nw_id_mdlcnt is empty'; }
			if(isN($this->maincnv_enc)){ $rsp['w'][] = '$this->maincnv_enc is empty';  }

		}

		return _jEnc($rsp);

	}


	public function MdlCntCnvChk($p=NULL){

	    global $__cnx;

		$_r['e']='no';

		if(!isN($p['mdlcnt'])){ $_mdlcnt = $p['mdlcnt']; }else{ $_mdlcnt = $this->nw_id_mdlcnt; }

		if(!isN($p['cnv']) && !isN($_mdlcnt)){

			$query_DtRg = sprintf('	SELECT id_mdlcntcnv, mdlcntcnv_enc
									FROM '.$this->bd.TB_MDL_CNT_CNV.'
									WHERE mdlcntcnv_cnv=%s AND mdlcntcnv_mdlcnt=%s',
											GtSQLVlStr($p['cnv'], 'int'),
											GtSQLVlStr($_mdlcnt, 'int'));

			$DtRg = $__cnx->_prc($query_DtRg); //$_r['q']=$query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg==1){
					$_r['e']='ok';
					$_r['id']=$row_DtRg['id_mdlcntcnv'];
					$_r['enc']=$row_DtRg['mdlcntcnv_enc'];
				}else{
					$_r['w'] = $__cnx->c_p->error;
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);

	}


	public function MdlCnt_Sac($p=NULL){

		$_r['e'] = 'no';

		if(!isN($p['cnt'])){
			if($p['opn']=='ok'){
				$__dthmlg = GtCntEstTra([ 'cl'=>DB_CL_ID, 'est'=>_CId('ID_TRAEST_PRC') ]);
			}
			$_mdlcnt = GtMdlCntOth([ 'i'=>$p['cnt'], 'mdlstp'=>_Cns('SIS_MDLSTP_SAC'), 'est'=>$__dthmlg->id ]);
			if($_mdlcnt->tot > 0){ $_r = $_mdlcnt; }
		}else{
			$_r['w'] = 'No id for process';
		}

		return(_jEnc($_r));

	}

	public function CntCrg_Ls($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = "SELECT
							sisslc_enc, sisslc_tt,
							(
								SELECT
									COUNT(*)
								FROM
									".TB_ORG_SDS_CNT_CRG."
									INNER JOIN ".TB_ORG_SDS_CNT." ON orgsdscntcrg_orgsdscnt = id_orgsdscnt
								WHERE
									id_sisslc = orgsdscntcrg_crg
								AND orgsdscnt_enc = '".$this->orgdsdscnt_enc."'
							) AS __est
						FROM
							"._BdStr(DBM).TB_SIS_SLC."
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
						WHERE
							sisslctp_key = 'crg'
						ORDER BY
							__est DESC, id_sisslc DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['qry'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{
						$Vl['ls'][$row_DtRg['sisslc_enc']]['enc'] = $row_DtRg['sisslc_enc'];
						$Vl['ls'][$row_DtRg['sisslc_enc']]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
						$Vl['ls'][$row_DtRg['sisslc_enc']]['est'] = $row_DtRg['__est'];;
					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{

				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);



		return _jEnc($Vl);
	}

	public function CntCrg($p=NULL){

		$Vl['e'] = 'no';
		$__chk = $this->CntCrg_Chk();

		if(isN($__chk->id)){
			$__in = $this->CntCrg_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
		}elseif(!isN($__in) || !isN($__chk->id)){
			$__upd = $this->CntCrg_Del();
			$Vl['_upd']=$__upd;
			if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}

	public function CntCrg_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->orgdsdscnt_enc) && !isN($this->crg_enc) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf("SELECT
										id_orgsdscntcrg, orgsdscntcrg_enc
									FROM
										".TB_ORG_SDS_CNT_CRG."
									WHERE
										orgsdscntcrg_orgsdscnt = (SELECT id_orgsdscnt FROM ".TB_ORG_SDS_CNT." WHERE orgsdscnt_enc = %s) AND
										orgsdscntcrg_crg = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									LIMIT 1",
										   GtSQLVlStr($this->orgdsdscnt_enc,'text'),
										   GtSQLVlStr($this->crg_enc,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_orgsdscntcrg'];
					$Vl['enc'] = ctjTx($row_DtRg['orgsdscntcrg_enc'],'in');
				}
			}
			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function CntCrg_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->cnt_enc.'-'.$this->orgdsdscnt_enc);

		$query_DtRg =   sprintf("INSERT INTO ".TB_ORG_SDS_CNT_CRG." (orgsdscntcrg_enc, orgsdscntcrg_orgsdscnt, orgsdscntcrg_crg)
									VALUES (%s,(SELECT id_orgsdscnt FROM ".TB_ORG_SDS_CNT." WHERE orgsdscnt_enc = %s),
									(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->orgdsdscnt_enc, "text"),
						GtSQLVlStr($this->crg_enc, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function CntCrg_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".TB_ORG_SDS_CNT_CRG." WHERE
								orgsdscntcrg_orgsdscnt = (SELECT id_orgsdscnt FROM ".TB_ORG_SDS_CNT." WHERE orgsdscnt_enc = %s) AND
								orgsdscntcrg_crg = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",
								GtSQLVlStr($this->orgdsdscnt_enc, "text"),
								GtSQLVlStr($this->crg_enc, "text")
							);


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;

		}

		return _jEnc($rsp);

	}

}

?>