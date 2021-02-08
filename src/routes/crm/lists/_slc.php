<?php if($__inc != 'ok'){ $Rt = '../../includes/'; $__fbsrc = 'ok'; include($Rt.'inc.php'); ob_start("compress_code"); Hdr_HTML(); } ?>
<?php

if(ChckSESS_adm() || ChckSESS_usr()){


	define('GL_SLC', __f('_slc'));
	define('GL_SLC_EC', GL_SLC.'ec/');
	define('GL_SLC_ATMT', GL_SLC.'atmt/');
	define('GL_SLC_MDL', GL_SLC.'mdl/');
	define('GL_SLC_CL', GL_SLC.'cl/');
	define('GL_SLC_DWN', GL_SLC.'dwn/');
	define('GL_SLC_ORG', GL_SLC.'org/');

	if(!isN($_GET['_i'])){ $__i = Php_Ls_Cln($_GET['_i']); }
	if(!isN($_GET['_ts'])){ $__ts = Php_Ls_Cln($_GET['_ts']); }
	if(!isN($_GET['_ts_i'])){ $__t_s_i = Php_Ls_Cln($_GET['_ts_i']); }
	if(!isN($_GET['_ts_e'])){ $__t_s_e = Php_Ls_Cln($_GET['_ts_e']); }
	if(!isN($_GET['_ts_p'])){ $__t_s_p = Php_Ls_Cln($_GET['_ts_p']); }elseif($__i_p != ''){ $__t_s_p = $__i_p; }
	if(!isN($_GET['_ts_f'])){ $__t_s_f = Php_Ls_Cln($_GET['_ts_f']); }else{ $__t_s_f = ''; }
	if(!isN($_GET['_ts_stot'])){ $__t_s_tot = Php_Ls_Cln($_GET['_ts_stot']); }
	if(!isN($_GET['_ts_trgr'])){ $__t_s_trgr = Php_Ls_Cln($_GET['_ts_trgr']); }
	if(!isN($_POST['_are'])){ $__t_s_are = Php_Ls_Cln($_POST['_are']); }

	if($__ts != ''){ $__prfx = _Fx_Prx([ 'v'=>$__ts ]); }



	define('GL_FLE', $__ts.'.php');



	if($__ts == 'prf_cd'){

		if( $__t_s_i  == 57){
			//echo LsCdOld($__ts, 'id_cd', $___Ls->dt->rw['prf_cd'], '', 2, 'ok'); $CntWb .= JQ_Ls('prf_cd',FM_LS_SLCD);
			echo LsCdOld(['id'=>$__ts, 'v'=>'id_cd', 'va'=>$___Ls->dt->rw['prf_cd'], 'rq'=>2, 'mlt'=>'ok' ]);
			$CntWb .= JQ_Ls('prf_cd',FM_LS_SLCD);

		}elseif($__t_s_i != 57){
			echo HTML_inp_tx($__ts.'_txt', TX_INGCD, ctjTx($___Ls->dt->rw['prf_cd_txt'],'in'));
		}

	}elseif($__ts == 'mdlcnt_mdl'){

		echo LsMdl($__ts, 'mdl_enc', $___Ls->dt->rw['mdl_enc'], '', 1, '', [ 'tp'=>$__t_s_p, 'mdls'=>$__i, 'mdl_s_sch' => 'ok', 'flt_are'=>'ok' ]);
		$CntWb .= JQ_Ls($__ts, TX_SLCNMDL);

	}elseif($__ts == 'mdlcnt_noi' || $__ts == 'mdlcnt_noi_op1' || $__ts == 'mdlcnt_noi_op2' || $__ts == 'mdlcnt_noi_op3' || $__ts == 'mdlcnt_noi_op4' || $__ts == 'mdlcnt_noi_op5' || $__ts == 'mdlcnt_noi_op6'){

        include(GL_SLC_MDL.'mdl_cnt_noi.php');

	}elseif($__ts == 'mdlcnt_noi_otc'){

		echo LsOrg($__ts, 'id_org', $___Ls->dt->rw['mdlcnt_noi_otc'],'','','uni');
		$CntWb .= JQ_Ls($__ts);

	}elseif($__ts == 'mdlcntvst_mdlcnt'){

		echo LsMdlCnt($__ts,'id_mdlcnt', $___Ls->dt->rw['mdlcntvst_mdlcnt'], FM_LS_SLINTRS,'', ['_f'=>" AND cnt_enc = '".$__t_s_i."' " ]); $CntWb .= JQ_Ls('mdlcntvst_mdlcnt', FM_LS_SLINTRS);

	}elseif ($__ts == $__prfx_slc->tp.'_ec_sgm_var'){

		include(GL_SLC_EC.'ec_lsts_sgm_var.php');

	}elseif($__ts == $___Ls->mdlstp->tp.'_ec_sgm_var_val' || $__ts == '_ec_sgm_var_val'){

		include(GL_SLC_EC.'ec_lsts_sgm_var_val.php');

	}elseif($__ts == 'ec'){

		include(GL_SLC_EC.GL_FLE);

	}elseif($__ts == 'ec_lsts'){

		include(GL_SLC_EC.GL_FLE);

	}elseif($__ts == 'ec_lsts_sgm'){

		include(GL_SLC_EC.GL_FLE);

	}elseif($__ts == 'atmt_trgr_act_ls'){

		include(GL_SLC_ATMT.GL_FLE);

	}elseif($__ts == 'atmt_trgr_cndc_ls'){

		include(GL_SLC_ATMT.'atmt_trgr_cndc.php');

		/*$__actdt = GtEcCndcDt(['id'=>$__t_s_i]);

		if(!isN($__actdt->ls)){
			$myf = $__actdt->ls->l;
			echo $myf('atmttrgrcndc_v_vl',$__actdt->ls->v, $__i, '', 1, '', ['tp'=>$___Ls->mdlstp->tp]);
	        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl',FM_LS_EST);
		}*/

	}elseif($__ts == 'atmt_trgr_ls'){

		include(GL_SLC_ATMT.GL_FLE);

	}elseif($__ts == 'atmt_trgr_vl'){

		include(GL_SLC_ATMT.GL_FLE);

	}elseif($__ts == 'mdl_cnt_sch'){

		include(GL_SLC_MDL.GL_FLE);

	}elseif($__ts == 'cl_app_tp_gen'){

		include(GL_SLC_CL.GL_FLE);

	}elseif($__ts == 'cl_app_tp_gen'){

		include(GL_SLC_CL.GL_FLE);

	}elseif($__ts == 'mdl_cnt_md'){

		include(GL_SLC_MDL.GL_FLE);

	}elseif($__ts == 'dwn_tme_prgm'){

		include(GL_SLC_DWN.GL_FLE);

	}elseif($__ts == 'marks_arr'){

		include(GL_SLC_ORG.GL_FLE);

	}elseif($__ts == 'org_dsh'){

		include(GL_SLC_ORG.GL_FLE);

	}elseif($__ts == 'ec_lsts_sgm_eml'){

		include(GL_SLC_EC.GL_FLE);

	}else{


		$__fle_cl = '../../'.DR_AC.DMN_SB.'/'.FL_SLC_GN;

		if(file_exists($__fle_cl)){

			include($__fle_cl);

		}

	}

?>
	<script type="text/javascript">

			<?php echo $CntJV ?>

				$(document).ready(function() {
					<?php echo $CntWb ?>
				});

    </script>
<?php

}else{
 	echo SESS_again();
}

?>
<?php if($__inc != 'ok'){ ob_end_flush(); } ?>