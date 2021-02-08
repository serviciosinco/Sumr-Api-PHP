<?php

	//@ini_set('display_errors', true);
	//error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);

	try{

		$_tt = Php_Ls_Cln($_POST['tt']);

		if($_POST['tra']){ $_tra = Php_Ls_Cln($_POST['tra']); } else{ $_tra = Php_Ls_Cln($_POST['tra']); }
		if($_POST['id']){ $_id = Php_Ls_Cln($_POST['id']); } else{ $_id = Php_Ls_Cln($_POST['id']); }
		if($_POST['enc']){ $_enc = Php_Ls_Cln($_POST['enc']); } else{ $_enc = Php_Ls_Cln($_POST['enc']); }
		if($_POST['col']){ $_col = Php_Ls_Cln($_POST['col']); } else{ $_col = Php_Ls_Cln($_POST['col']); }
		if($_POST['tp']){ $_tp = Php_Ls_Cln($_POST['tp']); } else{ $_tp = Php_Ls_Cln($_POST['tp']); }

		$_clr = Php_Ls_Cln($_POST['clr_id']);
		$_icn = Php_Ls_Cln($_POST['icn_id']);
		$_tp = Php_Ls_Cln($_POST['tp']);


		if(!isN($_tp)){
			$__tra = new CRM_Tra();
			$__tra->post = $_POST;
			$__tra->db = $_tp;
		}

		if($_tp == 'dsh_start'){

			include( GL_TRA.'tra_start.php' );

		}elseif($_tp == 'new_col'){

			$TraColDt = GtTraColDt();
			if($TraColDt->ult > 0 && $TraColDt->ult!= '' && $TraColDt->ult != NULL){$__tra->tracol_ord = ($TraColDt->ult+1);}else{$__tra->tracol_ord = 1;}

			//$__clrs = __LsDt(['k'=>'tra_col_clr']);
			//$__icns = __LsDt(['k'=>'tra_col_icn']);

			$__tra->tracol_icn = $__icns->ls->rnd->id;
			$__tra->tracol_clr = $__clrs->ls->rnd->id;
			$__tra->tracol_tp = $__tp->ls->rnd->tp;
			$__tra->tracol_tt = $_tt;

			if(trim($__tra->tracol_tt) != '' && $__tra->tracol_icn != NULL && $__tra->tracol_clr != NULL){ $PrcDt = $__tra->In_Tra_Col(); }
			if($PrcDt->e == 'ok'){

				$TraColDt = GtTraColDt(['id'=>$PrcDt->enc, 't'=>'enc', 'prvt'=>'ok']);

				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $PrcDt->enc;
				$rsp['tt'] = $__tra->tracol_tt;
				$rsp['ord'] = $__tra->tracol_ord;
				//$rsp['clr'] = $__tra->tracol_clr;
				//$rsp['clr'] = $__clrs->ls->rnd;
				//$rsp['icn'] = $__icns->ls->rnd;
				$rsp['col_nw'] = $TraColDt;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'edi_col_tt'){

			$__tra->tracol_tt = $_tt;
			$__tra->tracol_enc = $_col;
			if(!isN(trim($__tra->tracol_tt))){ $PrcDt = $__tra->Upd_Tra_Col(); }

			if($PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['tt'] = $__tra->tracol_tt;
				$rsp['q'] = $PrcDt->q;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'edi_col_clr'){

			$__TraClr = __LsDt(['k'=>'tra_col_clr', 'tp'=>'enc', 'id'=>$_clr]);
			$__tra->tracol_clr = $__TraClr->d->id;
			$__tra->tracol_enc = $_enc;
			$__tra->t = 'clr';

			if( !isN(trim($__tra->tracol_clr)) ){ $PrcDt = $__tra->Upd_Tra_Col(); }

			if($PrcDt->e == 'ok'){

				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = $PrcDt->m;

				$rsp['clr']['enc'] = $__TraClr->d->enc;
				$rsp['clr']['vl'] = $__TraClr->d->clr->vl;

				//$tracol = GtTraColDt(['id'=>$_col, 't'=>'enc', 'prvt'=>'ok']);
				//$rsp['col'] = $tracol;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'edi_col_icn'){

			$__TraClr = __LsDt(['k'=>'tra_col_icn', 'tp'=>'enc', 'id'=>$_icn]);
			$__tra->tracol_icn = $__TraClr->d->id;
			$__tra->tracol_enc = $_col;
			$__tra->t = 'icn';

			if(trim($__tra->tracol_icn) != ''){ $PrcDt = $__tra->Upd_Tra_Col(); }

			if($PrcDt->e == 'ok'){

				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = $PrcDt->m;
				$tracol = GtTraColDt(['id'=>$_col, 't'=>'enc', 'prvt'=>'ok']);
				$rsp['col'] = $tracol;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'new_tra'){

			$tracol = GtTraColDt([ 'id'=>$_col, 't'=>'enc', 'noord'=>'ok' ]);

			if(!isN( $tracol->id )){

				$__tra->tra_col = $tracol->id;
				$__tra->tra_tt = $_tt;

				$__tra->trarsp_us = Php_Ls_Cln($_POST['us']);
				$__tra->traobs_us = Php_Ls_Cln($_POST['obs']);
				$__tra->tra_dsc = Php_Ls_Cln($_POST['dsc']);
				$__tra->invk->by = _CId('ID_SISINVK_CRM');

				if(!isN($__tra->tra_tt)){ $PrcDt = $__tra->In_Tra(); }

				if($PrcDt->e == 'ok' && !isN($PrcDt->enc)){

					$_tra_d = GtTraDt([ 'id'=>$PrcDt->enc, 't'=>'enc', 'prvt'=>'ok', 'ext'=>['all'=>'ok'] ]);
					$rsp['d'] = $_tra_d;
					$rsp['e'] = $PrcDt->e;
					$rsp['enc'] = $PrcDt->enc;
					$rsp['pbs'] = $PrcDt->obs;

				}else{

					$rsp['m'] = $PrcDt->m;
					$rsp['w2'] = $PrcDt;
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");

				}

			}else{

				$rsp['w'] = 'No data for column '.$_col;
				$rsp['w2'] = $tracol;

			}

		}elseif($_tp == 'edi_col_ord'){

			$_mve = Php_Ls_Cln($_POST['mve']);
			$_rplc = Php_Ls_Cln($_POST['rplc']);
			$_new_position = Php_Ls_Cln($_POST['new_position']);


			$tracol_dt = GtTraColDt(['id'=>$_mve, 't'=>'enc', 'nous'=>'ok' ]);
			$tracol_mve = GtTraColDt(['id'=>$_mve, 't'=>'enc', 'prvt'=>'ok']);
			$tracol_rplc = GtTraColDt(['id'=>$_rplc, 't'=>'enc', 'prvt'=>'ok']);

			if($tracol_mve->ord > $tracol_rplc->ord && $_new_position > 1){
				$__tra->new_position = ($tracol_rplc->ord+1);
			}else{
				$__tra->new_position = $tracol_rplc->ord;
			}

			$GtTraColOrdDt = GtTraColOrdDt([ 'col'=>$tracol_dt->id ]);

			if(isN($GtTraColOrdDt->id)){

				if($tracol_mve->ord > $tracol_rplc->ord && $_new_position > 1){
					$__tra->tracolord_ord = ($tracol_rplc->ord+1);
				}else{
					$__tra->tracolord_ord = $tracol_rplc->ord;
				}

				$PrcDt = $__tra->In_Tra_Col_Ord([ 'col'=>$tracol_dt->id ]);

				$rsp['__tmp']['in'] = $PrcDt;

				if($PrcDt->e == 'ok'){
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}

			}else{

				$__tra->old_position = !isN($tracol_mve->ord)?$tracol_mve->ord:1;
				$__tra->tracol_enc = $_enc;
				$PrcDt = $__tra->Upd_Tra_Col_Ord();

				//$rsp['__tmp']['mve'] = $tracol_mve;
				//$rsp['__tmp']['rplc'] = $tracol_rplc;
				$rsp['__tmp']['upd'] = $PrcDt;

				if($PrcDt->e == 'ok'){
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}

			}

		}elseif($_tp == 'new_tag'){

			$_val = Php_Ls_Cln($_POST['v']);

			$__tra->val = $_val;
			$__tra->enc = $_enc;

		}elseif($_tp == 'edi_tra_ord'){

			$_new_position = Php_Ls_Cln($_POST['new_position']);
			$_old_position = Php_Ls_Cln($_POST['old_position']);
			$_old_col = Php_Ls_Cln($_POST['old_col']);
			$_new_col = Php_Ls_Cln($_POST['new_col']);

			$__tra->new_position = $_new_position;
			$__tra->old_position = $_old_position;
			$__tra->tra_enc = $_enc;
			$__tra->tracol_enc = $_new_col;
			$__tra->oldtracol_enc = $_old_col;
			$__tra->this_col = Php_Ls_Cln($_POST['this_col']);
			$PrcDt = $__tra->Upd_Tra_Ord();

			if($PrcDt->e == 'ok'){
				/*$tracol_new = GtTraColDt(['id'=>$_new_col, 't'=>'enc', 'prvt'=>'ok']);
				$tracol_old = GtTraColDt(['id'=>$_old_col, 't'=>'enc', 'prvt'=>'ok']);
				$rsp['new_col'] = $tracol_new;
				$rsp['old_col'] = $tracol_old;*/
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w'] = $PrcDt->w;
				$rsp['tmp'] = $PrcDt;
				//throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'tra_upd' || $_tp == 'tra_col_upd'){

			/*Falta por pasar a clase*/
			$_k = Php_Ls_Cln($_POST['k']);
			$_v = Php_Ls_Cln($_POST['v']);

			if($_tp == 'tra_upd' ){

				$_cmp = "tra";

				if($_k == 'est'){
					$__tra->trausest_est = $_v;
					$__tra->trausest_tra = $_tra;
					$__usest = $__tra->Upd_Tra_Us_Est();

					//$rsp['tmp__usest'] = $__usest;

					if($__usest->e == 'ok'){
						$_allw_upd='ok';
					}

					if($__usest->allw == 'no'){
						$_estup_nwall = 'ok';
					}

				}

			}elseif($_tp == 'tra_col_upd'){

				$_cmp = "col";
				$_allw_upd='ok';

			}

			if($_allw_upd == 'ok' || $_k == 'f' || $_k == 'h' || $_k == 'dsc'){

				if(!isN($_tra) && !isN($_v)){

					$__prc = $__tra->Upd_Tra_F([ 't'=>$_cmp, 'k'=>$_k, 'v'=>$_v, 'id'=>$_tra ]);

					if($__prc->e == 'ok'){

						if($_k == 'est' && ($_v == _CId('ID_TRAEST_CMPL') || $_v == _CId('ID_TRAEST_PRC'))){
							$rsp['d'] = GtTraDt([ 'id'=>$_tra, 't'=>'enc', 'ext'=>['all'=>'ok', 'mdlcnt'=>[ 'attr'=>'ok', 'attch'=>'ok' ] ] ]);
						}

					}

				}

			}

			if(!isN($_tra) && !isN($_v) && $_estup_nwall != 'ok'){
				$__prc = $__tra->Upd_Tra_F([ 't'=>$_cmp, 'k'=>'f_cmpl', 'v'=>date('Y-m-d H:i:s'), 'id'=>$_tra ]);
			}

			if($__prc->e == 'ok' && $_estup_nwall != 'ok'){
				$rsp['e'] = 'ok';
				$rsp['enc'] = $__prc->enc;
			}else{

				if($_estup_nwall == 'ok'){
					$rsp['w'] = 'Cambio no permitido para tu cuenta';
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$__cnx->c_p->error : "");
				}
			}

		}elseif($_tp == 'new_ctrl'){

			$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
			$_v = Php_Ls_Cln($_POST['v']);

			if(!isN($_v)){

				$TraCtrlLs = GtTraCtrlLs(['t'=>'ult', 'id_tra'=>$_tra ]);

				if($TraCtrlLs->ult > 0 && $TraCtrlLs->ult!= '' && $TraCtrlLs->ult != NULL){
					$_ord = ($TraCtrlLs->ult+1);
				}else{
					$_ord = 1;
				}

				$_enc_ctrl = Enc_Rnd($_v);

				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_CTRL." (tractrl_tt, tractrl_enc, tractrl_est, tractrl_ord, tractrl_tra) VALUES(%s, %s, %s, %s, %s) ",
									GtSQLVlStr(ctjTx($_v,'out'), "text"),
									GtSQLVlStr(ctjTx( $_enc_ctrl ,'out'), "text"),
									GtSQLVlStr(2, "int"),
									GtSQLVlStr($_ord, "int"),
									GtSQLVlStr($_tradt->id, "int"));

				//$rsp['q'] = compress_code($query_DtRg);
				$DtRg = $__cnx->_prc($query_DtRg);

				if($DtRg){

					$__id = $__cnx->c_p->insert_id;
					$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);

					$rsp['e'] = 'ok';
					$rsp['in']['enc'] = $_enc_ctrl;
					$rsp['in']['tt'] = $_v;
					$rsp['in']['ord'] = $_ord;
					$rsp['tra']['tot'] = $_tradt->tot;

					$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_CTRL_IN'), "db"=>"tra_ctrl", "iddb"=>$__id, "post"=>$_POST["data"], "dbrlc"=>"tra", "iddbrlc"=>$TraDt->{$_enc}->id ]);

				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$__cnx->c_p->error : "");
				}

			}

		}elseif($_tp == 'edi_ctrl_chk'){

			if(!isN($_id)){

				/*Falta por pasar a clase*/
				$_v = Php_Ls_Cln($_POST['v']);
				if ($_v == 'ok'){ $_est = 1; } elseif ($_v == 'no'){ $_est = 2; }

				$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_est=%s WHERE tractrl_enc = %s ",
								GtSQLVlStr($_est, "int"),
								GtSQLVlStr(ctjTx($_id,'out'), "text"));

				$DtRg = $__cnx->_prc($query_DtRg);

				if($DtRg){

					$rsp['e'] = 'ok';
					$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
					$rsp['tra']['tot'] = $_tradt->tot;

				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$__cnx->c_p->error : "");
				}

			}

		}elseif($_tp == 'edi_ctrl'){

			/*Falta por pasar a clase*/
			$_v = Php_Ls_Cln($_POST['v']);

			$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_tt=%s WHERE tractrl_enc = %s ", GtSQLVlStr(ctjTx($_v, 'out'), "text"), GtSQLVlStr($_id, "text"));
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
				$TraCtrlDt = GtTraCtrlDt([ 'tp'=>'enc', 'id'=>$_enc ]);

				$rsp['e'] = 'ok';
				$rsp['tra']['tot'] = $_tradt->tot;

				$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_CTRL_MOD'), 'db'=>TB_TRA_CTRL, 'iddb'=>$TraCtrlDt->id, 'post'=>$_POST["data"], 'dbrlc'=>TB_TRA, 'iddbrlc'=>$_tradt->id ]);

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$__cnx->c_p->error : "");
			}

		}elseif($_tp == 'edi_ctrl_ord'){

			$_new_position = Php_Ls_Cln($_POST['new_position']);
			$_old_position = Php_Ls_Cln($_POST['old_position']);

			$__tra->new_position = $_new_position;
			$__tra->old_position = $_old_position;
			$__tra->tractrl_enc = $_id;
			$__tra->tra_enc = $_tra;

			$PrcDt = $__tra->Upd_Tra_Ctrl_Ord();
			//$rsp['tmp'] = $PrcDt;

			if($PrcDt->e == 'ok'){
				$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
				$rsp['e'] = $PrcDt->e;
				$rsp['tra']['tot'] = $_tradt->tot;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'eli_tra_ctrl'){

			$_v = Php_Ls_Cln($_POST['v']);
			$TraCtrl_UltDt = GtTraCtrlLs([ 't'=>'ult', 'id_tra'=>$_tra ]);
			$TraCtrl_Ls = GtTraCtrlLs([ 't'=>'tractrl_enc', 'id'=>$_id ]);

			$__tra->ult = $TraCtrl_Ls->ult;
			$__tra->tractrl_enc = $_id;
			$__tra->tra_enc = $_tra;

			$PrcDt = $__tra->Eli_Tra_Ctrl();

			if($PrcDt->e == 'ok'){

				$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
				$TraCtrlDt = GtTraCtrlDt([ 'tp'=>'enc', 'id'=>$_enc ]);

				$rsp['e'] = $PrcDt->e;
				$rsp['tra']['tot'] = $_tradt->tot;

				$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_CTRL_ELI'), "db"=>"tra_ctrl", "iddb"=>$TraCtrlDt->id, 'post'=>$_POST, "dbrlc"=>TB_TRA, 'iddbrlc'=>$_tradt->id ]);

			}else{

				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");

			}

		}elseif($_tp == 'tra_fl'){

			$_fl_sch = Php_Ls_Cln($_POST['fl_sch']);
			$_fl_fi = Php_Ls_Cln($_POST['fl_fi']);
			$_fl_prc = Php_Ls_Cln($_POST['fl_prc']);
			$_fl_cmpl = Php_Ls_Cln($_POST['fl_cmpl']);
			$_fl_ach = Php_Ls_Cln($_POST['fl_ach']);

			if(!isN($_fl_sch)){ $_fl .= "AND tra_tt like '%$_fl_sch%' "; }
			if(!isN($_fl_fi)){ $_fl .= "AND tra_fi like '%$_fl_fi%' "; }

			if(!isN($_fl_prc) || !isN($_fl_cmpl) || !isN($_fl_ach)){

					$_or = '';
					if(!isN($_fl_prc)){ $_fl_chk .= "tra_est = '"._CId('ID_TRAEST_PRC')."' "; $_or = 'OR'; }
					if(!isN($_fl_cmpl)){ $_fl_chk .= "$_or tra_est = '"._CId('ID_TRAEST_CMPL')."' "; $_or = 'OR'; }
					if(!isN($_fl_ach)){ $_fl_chk .= "$_or tra_est = '"._CId('ID_TRAEST_ARCHV')."' "; }

					$_fl .= "AND ( $_fl_chk )";

			}

			//Construye columnas y tareas con filtro
			$TraColDt = GtTraColLs(["fl_tra"=>$_fl, 't_id'=>'enc', 'd'=>[ 'tra'=>'ok' ] ]);

			if($TraColDt->tot > 0){
				$rsp['col'] = $TraColDt;
				$rsp['e'] = "ok";
			}

		}elseif($_tp == 'tra_cmnt'){

			$_val = Php_Ls_Cln($_POST['v']);
			$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);

			$__tra->val = $_val;
			$__tra->tra = $_tradt->id;

			$PrcDt = $__tra->Ins_Tra_Cmnt();

			if($PrcDt->e == 'ok'){

				$rsp['e'] = "ok";

				//$rsp['___id'] = $PrcDt->id;

				//$TraColDt = GtTraLs(['t'=>"enc", "id"=>$_enc, "k"=>"enc"]);
				$TraCmntDt = GtTraCmntDt([ 'id'=>$PrcDt->id ]);

				//$rsp['_dt'] = $TraColDt;
				$rsp['us'] = $TraCmntDt->us;
				$rsp['in']['enc'] = $TraCmntDt->enc;
				$rsp['in']['fi'] = $TraCmntDt->fi;
				$rsp['in']['tt'] = $_val;

				$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
				$rsp['tra']['tot'] = $_tradt->tot;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}


		}elseif($_tp == 'tra_cmnt_upd'){

			$_val = Php_Ls_Cln($_POST['v']);
			$_cmnt = Php_Ls_Cln($_POST['cmnt']);

			$PrcDt = $__tra->Upd_Tra_Cmnt([ 'v'=>$_val, 'id'=>$_cmnt ]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = "ok";
				$rsp['d']['val'] = $_val;
				$rsp['d']['enc'] = $_cmnt;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'tra_cmnt_eli'){

			$_id = Php_Ls_Cln($_POST['id']);
			$PrcDt = $__tra->Eli_Tra_Cmnt([ 'id'=>$_id ]);

			if($PrcDt->e == 'ok'){

				$rsp['e'] = "ok";
				$rsp['enc'] = $_id;

				$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
				$rsp['tra']['tot'] = $_tradt->tot;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'tra_rsp'){

			$_trarsp_us = Php_Ls_Cln($_POST['us']);
			$_trarsp_tp = Php_Ls_Cln($_POST['trarsp_tp']);
			$_trarsp_est = Php_Ls_Cln($_POST['est']);
			$_id_tra = GtTraDt([ 'id'=>$_enc, 't'=>'enc' ]);
			$_us_dt = GtUsDt($_trarsp_us, 'enc');

			if($_trarsp_est == 'in'){

				$__tra->tra_enc = $_enc;
				$__tra->id_tra = $_id_tra->id;
				$__tra->trarsp_tp = $_trarsp_tp;
				$__tra->trarsp_us = $_trarsp_us;
				$__tra->trarsp_est = $_trarsp_est;

				$_k = Php_Ls_Cln($_POST['k']);
				$_v = Php_Ls_Cln($_POST['v']);

				$_id_tra = GtTraDt([ 'id'=>$_enc, 't'=>'enc' ]);
				$_lets_in = 'ok';

				if($_k == 'rsp'){
					//Valida si existen mas responsables
					$GtTraUsRspDt = GtTraRspDt([ 't'=>'tra', 'k'=>'enc', 'id_tra'=>$_enc, 'tp'=>$_k ]);
					foreach($GtTraUsRspDt->ls as $_k_ls => $_v){
						$PrcDt = $__tra->Del_Tra_Rsp(['id'=>$_v->id]);
						if($PrcDt->e != 'ok'){ $_lets_in = 'no'; $_lets_in_w[] = $PrcDt; }
					}
				}

				//Valida si el usuario ya estaba en la tabla
				$GtTraRspDt = GtTraRspDt([ 't'=>'tra', 'k'=>'enc', 'id_tra'=>$_enc, 'us'=>$_trarsp_us ]);

				if( $GtTraRspDt->e == 'ok' && !isN($GtTraRspDt->id) && $_trarsp_tp != $GtTraRspDt->tp ){
					$__tra->enc = $_enc;
					$PrcDel = $__tra->Del_Tra_Rsp([ 'id'=>$GtTraRspDt->id ]);
					if($PrcDel->e != 'ok'){ $_lets_in = 'no'; $_lets_in_w[] = $PrcDel; }
				}

				if($_lets_in == 'ok'){

					$PrcDt = $__tra->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_RSP') ]);

					if($PrcDt->e == "ok"){
						//Ingresa mi usuario como observador
						if($_k == 'rsp'){
							if( SISUS_ENC != $_trarsp_us ){

								$Me_TraRspDt = GtTraRspDt([ 't'=>'tra', 'tp'=>'obs', 'k'=>'enc', 'id_tra'=>$_enc, 'us'=>SISUS_ENC ]);

								if($Me_TraRspDt->e == 'ok' && isN($GtTraRspDt->id)){
									$__tra->trarsp_tp = _CId('ID_USROL_OBS');
									$__tra->trarsp_us = SISUS_ENC;
									$__obs = $__tra->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_OBS') ]);
								}

							}
						}

					}else{
						$rsp['w'][] = $PrcDt;
					}

					$rsp['p'] =	'in';

					//$rsp['in'] = $PrcDt;

					if($PrcDt->e == 'ok'){
						$rsp['in']['enc'] = $_us_dt->enc;
						$rsp['in']['nm'] = $_us_dt->nm;
						$rsp['in']['img'] = $_us_dt->img;
					}

				}else{

					$rsp['w'][] = $_lets_in_w;

				}

			}elseif($_trarsp_est == 'del'){

				$GtTraRspDt = GtTraRspDt([ 't'=>'tra', 'k'=>'enc', 'id_tra'=>$_enc, 'us'=>$_trarsp_us ]);

				$PrcDt = $__tra->Del_Tra_Rsp([ 'tra'=>$_id_tra->id, 'rsp'=>$_us_dt->id ]);

				$rsp['p'] =	'del';
				$rsp['del'] = $PrcDt;

			}

			if($PrcDt->e == 'ok'){

				$rsp['e'] = 'ok';

				//$TraUsDt = GtTraUs(['t'=>"enc", "id"=>$_enc, "k"=>"rsp"]);
				//$TraDt = GtTraLs(['t'=>"enc", "id"=>$_enc, "k"=>"enc"]);

				//$rsp['dt_asg'] = $TraUsDt;
				//$rsp['dt_tra'] = $TraDt;

			}else{

				$rsp['w'] = $PrcDt->w;
				//$rsp['all'] = $PrcDt;

			}

		}elseif($_tp == 'up_tra_rsp'){

			$_trarsp_us = Php_Ls_Cln($_POST['v']);
			$_trarsp_tp = Php_Ls_Cln($_POST['trarsp_tp']);

			$__tra->enc = $_enc;
			$__tra->trarsp_us = $_trarsp_us;
			$__tra->trarsp_tp = $_trarsp_tp;

			$PrcDt = $__tra->Upd_Tra_Rsp();

			if($PrcDt->e == 'ok'){

				$TraUsDt = GtUsDt($_trarsp_us);
				//$TraDt = GtTraLs(['t'=>"enc", "id"=>$_enc, "k"=>"enc"]);

				$rsp['_dt_tra'] = $TraDt;
				$rsp['_dt'] = $TraUsDt;
				$rsp['e'] = 'ok';

			}else{

				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");

			}

		}elseif($_tp == 'tra_tme_rgs'){

			$__v = Php_Ls_Cln($_POST['v']);

			$__tra->tra = $_tra;
			$__tra->enc = $_enc;
			$__tra->_v = $__v;
			$__tra->_fi = $_fi;

			$PrcDt = $__tra->Ins_Rsg_Tme();

			if($PrcDt->e == 'ok'){

				$rsp['e'] = "ok";
				$rsp['id'] = $PrcDt->enc;
				//$rsp['qry_d'] = $PrcDt->id_r;
				//$rsp['qry_r'] = $PrcDt->e1;

				//$TraColDt = GtTraLs(["k"=>"enc"]);
				//$rsp['_dt'] = $TraColDt;
				if($__v == 1){
					$_tra_d = GtTraDt([ 'id'=>$_tra, 't'=>'enc', 'ext'=>['tme'=>'ok'] ]);
					$rsp['d'] = $_tra_d->tme;
				}

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}/*elseif($_tp == 'rgs_act'){

			$__v = $_POST['id_tme'];
			$_fi = $_POST['fi_tme'];
			$_ff = SIS_F_TS;

			$rsp['e'] = $__v;
			$rsp['fi'] = $_fi;
			$rsp['ff'] = $_ff;

			$fecha1 = new DateTime($_fi);
			$fecha2 = new DateTime($_ff);

			$intervalo = $fecha1->diff($fecha2);

			$rsp['time']['Y'] = $intervalo->format('%Y');
			$rsp['time']['m'] = $intervalo->format('%m');
			$rsp['time']['d'] = $intervalo->format('%d');
			$rsp['time']['h'] = $intervalo->format('%H');
			$rsp['time']['m'] = $intervalo->format('%i');
			$rsp['time']['s'] = $intervalo->format('%s');


		}*/elseif($_tp == 'col_eli'){


			if($_POST['v']==1){
				$rsp['e'] = "ok";
				$_Col = GtTraColLsAll(['enc'=>$_POST['enc']]);
				$rsp['cols'] = $_Col;
			}elseif($_POST['v']==2){
				$__tra->_id = $_POST['id'];
				$__tra->_enc = $_POST['enc'];
				$PrcDt = $__tra->Eli_Col();
				if($PrcDt->e == 'ok'){
					$rsp['e'] = "ok";
					$rsp['e1'] = $PrcDt->e1;

					$TraColDt = GtTraColDt(['id'=>$_POST['id'], 't'=>'enc', 'prvt'=>'ok']);
					$rsp['col_nw'] = $TraColDt;

					//$TraColDt = GtTraLs(["k"=>"enc"]);
					$rsp['_dt'] = $TraColDt;

				}else{
					$rsp['e'] = "no";
					$rsp['e1'] = $PrcDt->e1;
				}

			}else{

			}

		}elseif($_tp == 'mod_tag'){

			$_trarsp_us = Php_Ls_Cln($_POST['v']);
			$_trarsp_tp = Php_Ls_Cln($_POST['trarsp_tp']);


			$__tra->enc = $_enc;
			$__tra->trarsp_tp = $_trarsp_tp;

			foreach($_trarsp_us as $v){
				$__tra->trarsp_us = $v;
			}

			$PrcDt = $__tra->GtTraTagLs(['t'=>"tra", "id"=>$_enc, "k"=>"tag"]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $PrcDt->enc;
				$TraUsDt = GtTraUs(['t'=>"enc", "id"=>$_enc, "k"=>"obs"]);
				$rsp['_dt_us'] = $TraUsDt;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'cmp_tra_all'){

			$_enc_col = Php_Ls_Cln($_POST['enc']);

			$__tra->enc = $_enc_col;

			$PrcDt = $__tra->Cmp_Tra_All();

			if($PrcDt->e == 'ok'){

				$_tra_usest = Php_Ls_Cln($_POST['ids']);
				$__tra->trausest_est = 355;
				$__tra->trausest_tra = $_tra_usest;

				$PrcDt2 =$__tra->Upd_Tra_Us_Est_All();

				if($PrcDt2->e=='ok'){
					$rsp['e_est'] = 'ok';
				}

				$rsp['e'] = 'ok';
				$TraColDt = GtTraColDt(['id'=>$_col_col, 't'=>'enc', 'prvt'=>'ok']);
				$rsp['col'] = $TraColDt;

				//$TraDt = GtTraLs(["k"=>"enc"]);
				//$rsp['_dt'] = $TraDt;

			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}



		}elseif($_tp == 'arc_tra_all'){

			$_enc_col = Php_Ls_Cln($_POST['enc']);

			$__tra->enc = $_enc_col;

			$PrcDt = $__tra->Arc_Tra_All();

			if($PrcDt->e == 'ok'){

				$_tra_usest = Php_Ls_Cln($_POST['ids']);
				$__tra->trausest_est = 384;
				$__tra->trausest_tra = $_tra_usest;

				$PrcDt2 =$__tra->Upd_Tra_Us_Est_All();

				if($PrcDt2->e=='ok'){
					$rsp['e_est'] = 'ok';
				}

				$rsp['e'] = 'ok';

				$TraColDt = GtTraColDt(['id'=>$_col_col, 't'=>'enc', 'prvt'=>'ok']);
				$rsp['col'] = $TraColDt;

				//$TraColDt = GtTraLs(["k"=>"enc"]);
				//$rsp['_dt'] = $TraColDt;

			}else{

				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");

			}

		}elseif($_tp == 'dt'){

			$rsp['d'] = GtTraDt([ 'id'=>$_enc, 't'=>'enc', 'ext'=>['all'=>'ok', 'mdlcnt'=>[ 'attr'=>'ok', 'attch'=>'ok' ] ] ]);

		}elseif($_tp == 'tra_dsh'){

			$_fi = '';
            $_ff = '';

            if(!isN(Php_Ls_Cln($_POST['flt']))){
                if(!isN(Php_Ls_Cln($_POST['flt']['fi'])) && !isN(Php_Ls_Cln($_POST['flt']['ff']))){
                    $_fi = $_POST['flt']['fi'];
                    $_ff = $_POST['flt']['ff'];
                }
            }

            $rsp['d'] = GtTraDshDt([ 'fi'=>$_fi, 'ff'=>$_ff ]);
            $rsp['r'] = GtTraDshCmpl([ 'fi'=>$_fi, 'ff'=>$_ff ]);
            $rsp['us'] = GtTraDshUsCmpl([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['est'] = GtTraDshEst([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['tp'] = GtTraDshTp([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['mdlcnt'] = GtTraDshMdlCnt([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['e'] = GtTraDshFntDt([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['rspus'] = GtTraDshRspUs([ 'fi'=>$_fi, 'ff'=>$_ff ]);
			$rsp['a'] = GtTraDshAvgDt([ 'fi'=>$_fi, 'ff'=>$_ff ]);

			/*----*/


            $rsp['are'] = GtTraDshAre([ 'fi'=>$_fi, 'ff'=>$_ff ]);
            $rsp['tag'] = GtTraDshTag([ 'fi'=>$_fi, 'ff'=>$_ff ]);
            $rsp['uscol'] = GtTraDshColUs([ 'fi'=>$_fi, 'ff'=>$_ff ]);

		}elseif($_tp == 'tra_del_img'){

			$id_img = Php_Ls_Cln($_POST['id_img']);
			$PrcDt = $__tra->Del_Tra_Fle([ 'tp'=>'id', 'id'=>$id_img ]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $PrcDt->w;
			}

		}elseif($_tp == 'tra_col_us_ord'){

			$tp_ord = Php_Ls_Cln($_POST['tp_ord']);

			$PrcDt = $__tra->TraColUsOrd([ 'tp_ord'=>$tp_ord, 'id'=>$_id]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $PrcDt->w;
			}

		}elseif($_tp == 'edi_tra_brnd'){

			$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
			$id_brnd = Php_Ls_Cln($_POST['id_brnd']);

			$PrcDt = $__tra->Upd_Tra_Sbrnd([ 'brnd'=>$id_brnd, 'tra'=>$_tradt->id]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $PrcDt->w;
			}

		}elseif($_tp == 'edi_tra_col'){

			$_tradt = GtTraDt([ 'id'=>$_tra, 't'=>'enc' ]);
			$id_tracol = Php_Ls_Cln($_POST['id_tracol']);

			$PrcDt = $__tra->Upd_TraCol([ 'col'=>$id_tracol, 'tra'=>$_tradt->id]);

			if($PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $PrcDt->w;
			}

		}else{

			throw new Exception((ChckSESS_superadm()) ? "- ".TX_NEXTP.$_tp : "");

		}

	}catch(Exception $e){

		$rsp['e'] = 'no';
		$rsp['w']['m'] = TX_NSPPCSR.$e->getMessage();
		$rsp['w']['e'] = $e;

	}


?>