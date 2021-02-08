<?php

	$_fl = '';
	$_fl_invk=[];
	$_fl_fi='';
	$___atmt_plcy = '';
	$___atmt_plcy_id = [];

	if($_vld == "ok"){

		if($___atmtdt->plcy->tot > 0){
			foreach($___atmtdt->plcy->ls as $_plcy_k=>$_plcy_v){
				$___atmt_plcy .= $this->h3(TX_HBSACCPT);
				if($_plcy_v->tot > 0){
					$___atmt_plcy .= $this->li($_plcy_v->nm);
					$___atmt_plcy_id[] = $_plcy_v->enc;
				}
			}
		}


		//Si tiene condicionales
		if( !isN($row_Ls_AtmtRg['_cndc']) ){

			//Se separan los registros
			foreach(explode(",", $row_Ls_AtmtRg['_cndc']) as $_v_cndc){

				//Se separan los valores
				$_v_cndc_v = explode("<->", $_v_cndc);
				$_cndc = $_v_cndc_v[0];
				$_cndc_v = $_v_cndc_v[1];


				if($_cndc == _CId('ID_SISATMTCNDC_EST_EQL')){ //El estado es igual a
					$_fl .= "AND mdlcnt_est = ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_EST_DF')){ //El estado es diferente a
					$_fl .= "AND mdlcnt_est != ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_ETP_EQL')){ //La etapa es igual a
					$_fl .= "AND siscntest_tp = ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_ETP_DF')){ //La etapa es diferente a
					$_fl .= "AND siscntest_tp != ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_PAY_EQL')){ //Estado de Pago
					$_fl .= "AND mdlcntpay_est = ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_MD_EQL')){ //A traves de Medio
					$_fl .= "AND mdlcnt_m = ".$_cndc_v." ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_CD_IN')){ //Ciudad igual a
					$_fl .= " AND mdlcnt_cnt IN ( SELECT cntcd_cnt FROM ".TB_CNT_CD." WHERE cntcd_cd = ".$_cndc_v." ) ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_CD_NOT_IN')){ //Ciudad diferente a
					$_fl .= " AND mdlcnt_cnt NOT IN ( SELECT cntcd_cnt FROM ".TB_CNT_CD." WHERE cntcd_cd = ".$_cndc_v." ) ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_SAC_BRND_RLT')){ //SAC Brand Related To
					$_fl .= " AND id_mdlcnt IN (
										SELECT mdlcnttra_mdlcnt
										FROM "._BdStr($_cl_v->bd).TB_MDL_CNT_TRA."
											 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
										WHERE tra_sbrnd = '".$_cndc_v."'
									) ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_PS_IN')){ //Pais igual a
					$_fl .= " AND mdlcnt_cnt IN ( SELECT cntcd_cnt FROM "._BdStr($_cl_v->bd).TB_CNT_CD." INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sispsWHERE id_sisps = ".$_cndc_v." )";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_PS_NOT_IN')){ //Pais diferente a
					$_fl .= " AND mdlcnt_cnt NOT ( SELECT cntcd_cnt FROM "._BdStr($_cl_v->bd).TB_CNT_CD." INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sispsWHERE id_sisps = ".$_cndc_v." )";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_PS_TEL_IN')){ //Pais Telefono igual a
					$_fl .= " AND mdlcnt_cnt IN ( SELECT cnttel_cnt FROM "._BdStr($_cl_v->bd).TB_CNT_TEL." WHERE cnttel_ps = ".$_cndc_v." ) ";
				}elseif($_cndc == _CId('ID_SISATMTCNDC_PS_TEL_NOT_IN')){ //Pais Telefono diferente a
					$_fl .= " AND mdlcnt_cnt NOT IN ( SELECT cnttel_cnt FROM "._BdStr($_cl_v->bd).TB_CNT_TEL." WHERE cnttel_ps = ".$_cndc_v.") ";
				}

			}

		}

		///--------- CONSULTO LEADS ----------///

			include('atmt_ext_2.php');

	}

	if($has_trgr_allw == 'ok'){

		$___h_trgr[$____id_atmt]['bx'] =  	$this->h2( ctjTx($row_Ls_AtmtRg['atmt_nm']." - ". $row_Ls_AtmtRg['sistp_nm'] ." - ".$_dte_tx." - ".$_lnl_cls,'in') ).
											$this->ul(
												$this->li( $this->Strn( ctjTx($row_Ls_AtmtRg['cletp_nm'],'in') ) ).$___atmt_plcy
											).
											$this->h3("[ATMT-".$____id_atmt."]");


		$___h_trgr[$____id_atmt]['trgr'][$____id_trgr]['bx'] =  $this->ul(

																			$this->li( $this->Strn( $this->Spn("id_atmttrgr")." ----- Id - ".ctjTx($row_Ls_AtmtRg['id_atmttrgr']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_enc")." ---- Enc - ".ctjTx($row_Ls_AtmtRg['atmttrgr_enc']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_nm")." ---- Nombre - ".ctjTx($row_Ls_AtmtRg['atmttrgr_nm']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_trgr")." ---- Disparador - ".ctjTx($row_Ls_AtmtRg['Trigger_sisslc_tt']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_v_ls")." - ".ctjTx($row_Ls_AtmtRg['atmttrgr_v_ls']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_v_vl")." - ".ctjTx($row_Ls_AtmtRg['atmttrgr_v_vl']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_dly")." ---- Tiempo de espera tipo - ".ctjTx($row_Ls_AtmtRg['Delay_sisslc_tt']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_dly_v")." ---- Tiempo de espera ".ctjTx($row_Ls_AtmtRg['atmttrgr_dly_v']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch").ctjTx(" ---- Hora de envio - ".$row_Ls_AtmtRg['Schedules_sisslc_tt']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_1").ctjTx(" ---- Lunes - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_1'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_2").ctjTx(" ---- Martes - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_2'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_3").ctjTx(" ---- Miercoles - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_3'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_4").ctjTx(" ---- Jueves - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_4'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_5").ctjTx(" ---- Viernes - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_5'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_6").ctjTx(" ---- Sabado - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_6'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_d_7").ctjTx(" ---- Domingo - ".mBln($row_Ls_AtmtRg['atmttrgr_sch_d_7'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_h1").ctjTx(" - ".$row_Ls_AtmtRg['atmttrgr_sch_h1']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_sch_h2").ctjTx(" - ".$row_Ls_AtmtRg['atmttrgr_sch_h2']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_ord").ctjTx(" ---- Orden - ".$row_Ls_AtmtRg['atmttrgr_ord']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_lnl")." ---- Lineal - ".mBln($row_Ls_AtmtRg['atmttrgr_lnl'])." " ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_rpt")." ---- Ciclico - ".mBln($row_Ls_AtmtRg['atmttrgr_rpt'])." " ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_hbl")." ---- Habilitado - ".mBln($row_Ls_AtmtRg['atmttrgr_hbl'])." " ) ).

																			$this->li( $this->Strn( $this->Spn("atmttrgr_invk_api").ctjTx(" ---- Fuente API - ".mBln($row_Ls_AtmtRg['atmttrgr_invk_api'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_invk_up").ctjTx(" ---- Fuente Carga - ".mBln($row_Ls_AtmtRg['atmttrgr_invk_up'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_invk_crm").ctjTx(" ---- Fuente Manual - ".mBln($row_Ls_AtmtRg['atmttrgr_invk_crm'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_invk_auto").ctjTx(" ---- Fuente CronJob - ".mBln($row_Ls_AtmtRg['atmttrgr_invk_auto'])." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("atmttrgr_invk_form").ctjTx(" ---- Fuente Form - ".mBln($row_Ls_AtmtRg['atmttrgr_invk_form'])." ",'in') ) ).

																			$this->li( $this->Strn( $this->Spn("atmttrgr_fi").ctjTx(" ---- Fecha ingreso - ".$row_Ls_AtmtRg['atmttrgr_fi']." ",'in') ) ).
																			$this->li( $this->Strn( $this->Spn("_cndc").ctjTx(" ---- Condicionales - ".$row_Ls_AtmtRg['_cndc']." ",'in') ) ).

																			$this->Spn("[TRGR-".$____id_trgr."]")

																		);


		$___h_trgr[$____id_atmt]['trgr'][$____id_trgr]['act'][$____id_act]['bx'] = 	$this->h2( $this->Strn( ctjTx($row_Ls_AtmtRg['id_atmttrgract'].". Accion - ".$row_Ls_AtmtRg['Action_sisslc_tt']." ",'in') ) ).
																					$this->h3( "[ACT-".$____id_act."]");


	}