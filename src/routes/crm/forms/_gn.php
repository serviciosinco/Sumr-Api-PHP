<?php $Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); ob_start("cmpr_fm"); Hdr_HTML();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_EMP', __f('emp'));
		define('GL_DSH', __f('dsh'));
		define('GL_MDL', __f('mdl'));
		define('GL_UP', __f('up'));
		define('GL_MY', __f('my'));
		define('GL_INF', __f('inf'));
		define('GL_EC', __f('ec'));
		define('GL_SCL', __f('scl'));
		define('GL_CHAT', __f('chat'));
		define('GL_SND', __f('snd'));
		define('GL_BCO', __f('bco'));
		define('GL_TRA', __f('tra'));
		define('GL_MARKS', __f('marks'));
		define('GL_ORG', __f('org'));

	//---------------------- VARIABLES GET ----------------------//

		$__i = Php_Ls_Cln($_POST['_i']);
		$__i2 = Php_Ls_Cln($_GET['__i']);

		$_i = Php_Ls_Cln($_GET['_i']);
		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
		$__tp = Php_Ls_Cln($_GET['_tp']);
		$__prfx = _Fx_Prx(['v'=>$__t]);

		$___Ls = new CRM_Ls();


	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		if($__t == 'login'){

			$___to_inc = GL.'login.php';

		}elseif($__t == 'my_pssw'){

            $___to_inc = GL_MY.'pss.php';

        }elseif($__t == 'my_lng'){

            $___to_inc = GL_MY.'lng.php';

        }elseif($__t =='mdl_cod_md' || $__t =='mdl_gen_cod_md'){

            $___to_inc = GL_MDL.'mdl_cod_md.php';

        }elseif($__t =='mdl_cnt'){

            $_bt_inf = 'ok';
            $___to_inc = GL_MDL.'mdl_cnt.php';

        }elseif($__t =='mdl_cnt_pay_lnk'){

            $___to_inc = GL_MDL.'mdl_cnt_pay_lnk.php';

        }elseif($__t =='marks'){

            $_bt_inf = 'ok';
            $___to_inc = GL_MARKS.'marks.php';

        }elseif($__t =='act_enc'){

            $___to_inc = GL_MDL.'mdl_act_enc.php';

        }elseif($__prfx->lt == 'enc_cnt'){
            $___to_inc = GL_MDL.FM_ENC_CNT;
            $_bt_inf = 'ok';
		}elseif($__t == 'emp_cnt'){
            $___to_inc = FM_GN_EMP_CNT;
			$_bt_inf = 'ok';
        }elseif($__t == 'emp'){
            $___to_inc = FM_GN_EMP;
			$_bt_inf = 'ok';
        }elseif($__t == 'emp_ofr'){
            $___to_inc = FM_GN_EMP_OFR;
			$_bt_inf = 'ok';


		}elseif($__t == 'upl_img' /*&& ChckSESS_adm()*/){

            $___to_inc = GL_UP.'upl_img.php';

        }elseif($__t == 'upl_imgth' /*&& ChckSESS_adm()*/){

            $___to_inc = GL_UP.'upl_img_th.php';

        }elseif($__t == 'upl_imgbn' /*&& ChckSESS_adm()*/){

            $___to_inc = GL_UP.'upl_img_bn.php';

        }elseif($__t == 'upl_nw'){

            $___to_inc = GL_UP.FM_GN_IMG_NEW;

        }elseif(($__t == 'up_col')){

	        $___to_inc = GL_UP.'up_col.php';

		}elseif($__t == 'sms_test'){

            $___to_inc = GL.'sms_test.php';

		}elseif($__t == 'sms_cmpg'){

			$___to_inc = GL.'_inf_cmpg.php';
			$_bt_inf = 'ok';

		}elseif($__t == 'snd_ec_cmpg'){

			$___to_inc = GL.'_inf_cmpg.php';
			$_bt_inf = 'ok';

		}elseif($__t == 'snd_ec_cmpg_test'){

			$___to_inc = GL_SND.'ec_cmpg_test.php';

		}elseif($__t == 'call'){

			$___to_inc = GL.'call.php';

		}elseif($__t == 'dsh_grph'){

            $___to_inc = GL_DSH.'dsh_grph.php'; $__non_c = 'ok';

        }elseif($__t == 'dsh_col_prs'){
            $___to_inc = GL_DSH.'dsh_col_prs.php';
        }elseif($__t == 'up_sgn'){
			$___to_inc = GL_UP.'up_sgn.php';
		}elseif($__t == 'prg_cnt' || $__t == 'psg_cnt' || $__t == 'con_cnt' || $__t == 'rose_cnt'){
 		 	$_fl_tt = TX_CNT;
			$___to_inc = INF_PRO_CNT;
		}elseif($__t == 'emp'){
 		 	$_fl_tt = TX_EMPS;
			$___to_inc = INF_EMP;
		}elseif($__t == 'evns_mdl_cnt' || $__t == 'acd_mdl_cnt' || $__t == 'spa_mdl_cnt'  || $__t == 'rst_mdl_cnt'  || $__t == 'pqt_mdl_cnt'  || $__t == 'pqr_mdl_cnt'){
			$_fl_tt = TX_EMPS;
			$___to_inc = GL_INF.'mdl_cnt.php';
		}elseif($__t == 'enc_cnt'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_INF.'enc_cnt.php';
		}elseif($__t == 'up_ec'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_ec.php';
		}elseif($__t == 'up_lnd'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_lnd.php';
		}elseif($__t == 'up_bn'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_bn.php';
		}elseif($__t == 'up_mdl'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_mdl.php';

		}elseif($__t == 'up_anx'){
 		 	$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_anx.php';

		}elseif($__t == 'up_app'){

			$_fl_tt = TX_ENC;
			$___to_inc =  GL_UP.'up_app.php';

	 	}elseif($__t == 'ec_rpr'){

			$___to_inc =  GL_EC.'ec_rpr.php';

		}elseif($__t == 'ec_html'){

			$___to_inc =  GL_EC.'ec_html.php';

		}elseif($__t == 'ec_cmnt_us'){

			$___to_inc =  GL_EC.'ec_cmnt_us.php';

		}elseif($__t == 'scl_acc_form'){

			$___to_inc =  GL_SCL.'scl_acc_form.php';

		}elseif($__prfx->lt == 'ec_dsgn' || $__t == 'ec_dsgn'){

			$___to_inc = GL_EC.'ec_dsgn.php';

		}elseif($__t == 'snd_ec_cpy'){

			$___to_inc = GL_EC.'ec_cpy.php';

		}elseif( $__t == 'eccmz_sgm_his' ){

			$___to_inc = GL_EC.'eccmz_sgm_his.php';

		}elseif( $__t == 'eccmz_sgm_opt' ){

			$___to_inc = GL_EC.'eccmz_sgm_opt.php';

		}elseif( $__t == 'upl_img_cmz' ){

			$___to_inc = GL_UP.'upl_img_cmz.php';

		}elseif( $__t == 'up_tw' ){

			$___to_inc = GL_UP.'up_tw.php';

		}elseif(($__t == 'chat')){

			$___to_inc = GL_CHAT.'chat.php';

		}elseif($__t == 'bitly'){

			$___to_inc = GL.'bitly.php';

		}elseif($__t == 'bco_rote'){

			$___to_inc = GL_BCO.'bco_rote.php';

		}elseif($__t == 'tck_tra'){

			$___to_inc = GL_TRA.'tck_tra.php'; $__non_c = 'ok';

		}elseif($__t == 'org_dsh'){

			$___to_inc = GL_ORG.'org_dsh.php';

		}elseif($__t == 'up_rd'){

			$_fl_tt = TX_ENC;
		  	$___to_inc =  GL_UP.'up_rd.php';

	  	}elseif($__t == 'tra_fle'){

			$_fl_tt = TX_ENC;
		  	$___to_inc =  GL_UP.'up_tra_fle.php';

	  	}elseif($__t == 'tra_brnd'){
		  	$___to_inc =  GL_TRA.'tra_brnd.php';

	  	}elseif($__t == 'tra_col'){
			$___to_inc =  GL_TRA.'tra_col.php';
		}else{

			$___to_inc = '../../'.DR_AC.DMN_SB.'/'.FL_FM_GN;

		}


		if($___to_inc != ''){ include($___to_inc); }


		if($_bt_inf == 'ok'){

			$_flds = $__gtJS;

			$_fld_p = " +'&Rnd='+Math.random()+'&_f=prnt' ";
			$_fld_x = " +'&_f=xls&_t2=".$__t2."&_tp=".$__tp."' ";
			$_fle = "'".Fl_Rnd(FL_INF_GN.__t($__t,true))."' + _q ";

			$_fld_t2 = " +'&_t2=".$__t2."' ";
			$_fld_tp = " +'&_tp=".$__tp."' ";

			$CntWb .= " var __myinf_fm = $('#".ID_FM_INF."');";

			$CntWb .= " $('#__inf_ld').off('click').click(function(){
							if(__myinf_fm.valid()){
								$_flds
								_ldCnt({ u:$_fle+'&_t2=".$__t2."&_tp=".$__tp."', c:'".$__id."' });
							}
						});";

			$CntWb .= " $('#__inf_prnt').off('click').click(function(){
							if(__myinf_fm.valid()){
								$_flds
								window.open(".$_fle.$_fld_p.$_fld_t2.$_fld_tp.",'_blank');
							}
						});";

			$CntWb .= " $('#__inf_xls').off('click').click(function(){
							if(__myinf_fm.valid()){
								$_flds
								window.open(".$_fle.$_fld_x.",'_blank');
							}
						});";


			if(!isN($__i) || !isN($__i2)){
				$CntWb .= " $_flds; _ldCnt({ u:$_fle+'&_t2=".$__t2."&_tp=".$__tp."', c:'".$__id."' }); ";
			}


		}


		//---------------------- JS SCRIPTS ----------------------//


		if($__non_c == 'ok'){ $CntJV .= "$('#cnt').addClass('_non');"; }



?>

	<script type="text/javascript">

		try{
			<?php echo /*$___Fm->jv.*/$_CntJV; ?>

			$('#__Ldr_Sis').addClass('_inf_ldr');

			$('#__opn').off('click').click(function() {
				if( $( "#cboxContent" ).hasClass('_cls_tb') ){
					$( "#cboxContent" ).removeClass('_cls_tb');
				}else{
					$( "#cboxContent" ).addClass('_cls_tb');
				}
			});

		}catch(e){
			console.log( 'Error:', e );
		}


        $(function() {

			try{

				SUMR_Main.ld.f.upl( function(){
					$('._inf').fadeIn('fast');
					$('#__Ldr_Sis').removeClass('_inf_ldr');
					<?php echo $_bldr->js.$CntWb ?>
				});

			}catch(e){
				console.log( 'Error:', e );
			}

        });

    </script>

<?php ob_end_flush(); ?>