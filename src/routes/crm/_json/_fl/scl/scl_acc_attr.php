<?php


	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_fld = Php_Ls_Cln($_POST['id_fld']);
		$_id_qus = Php_Ls_Cln($_POST['id_qus']);
		$__tp = Php_Ls_Cln($_POST['tp']);
		$__tp_ls = Php_Ls_Cln($_POST['__tp_ls']);
		$prc = Php_Ls_Cln($_POST['prc']);

		$__post = Php_Ls_Cln($_POST);

		$__Form = new CRM_Thrd();

		$__Form->post = $__post;
		$__Form->id_fld = $_id_fld;
		$__Form->id_qus = $_id_qus;
		$__Form->est = $_est;

		if($_tp == 'scl_acc_attr' && $_est == 'in' && $__tp == 'qus'){

			$Prc = $__Form->SclFormAttrFldIn();

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['st'] = 'in';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'scl_acc_attr' && $_est == 'del' && $__tp == 'qus'){

			$Prc = $__Form->SclFormAttrFldDel();

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['st'] = 'out';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}


		}elseif(!isN($prc) && $_tp == 'scl_acc_attr' && $__tp == 'qus_opt' && $__tp_ls == 'universidad_a_la_que_aspira'){

			$_dt = GtOrgDt([ 'i'=>$_id_fld,'t' => 'enc' ]);

			$__Form->id_rel = 'sclaccformqusoptorg_org';
			$__Form->bd = TB_SCL_ACC_FORM_QUS_OPT_ORG;
			$__Form->id = 'sclaccformqusoptorg_qusopt';
			$__Form->id_fld = $_dt->id;
			$__Form->id_tx = 'id_sclaccformqusoptorg';
			$__Form->enc = 'sclaccformqusoptorg_enc';

			$PrcDt = $__Form->SclOpt();

			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif(!isN($prc) && $_tp == 'scl_acc_attr' && $__tp == 'qus_opt' && $__tp_ls == 'mdl_gen'){

			$Cl = GtClDt(CL_ENC, 'enc');

			$_dt = GtMdlDt([ 't'=>'enc', 'id'=>$_id_fld ]);

			$__Form->id_rel = 'sclaccformqusoptmdl_mdl';
			$__Form->bd = $Cl->bd.'.'.TB_SCL_ACC_FORM_QUS_OPT_MDL;
			$__Form->id = 'sclaccformqusoptmdl_qusopt';
			$__Form->id_fld = $_dt->id;
			$__Form->id_tx = 'id_sclaccformqusoptmdl';
			$__Form->enc = 'sclaccformqusoptmdl_enc';

			$PrcDt = $__Form->SclOpt();

			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_tp == 'scl_acc_attr' && $__tp == 'mdl_id'){

			$__Form->id_fm = Php_Ls_Cln($_POST['_id_fm']);
			$__Form->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			$__Form->enc_mdl = Php_Ls_Cln($_POST['_enc_fm']);

			$Prc = $__Form->SclFormUpd();
			$Prc1 = $__Form->FormChk(['enc'=>$__Form->enc_mdl]);

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['enc'] = Php_Ls_Cln($_POST['_enc_fm']);
				$rsp['e1'] = $Prc1;
			}else{
				$rsp['e'] = 'no';
			}
		}elseif($_tp == 'scl_acc_attr' && $__tp == 'plcy_id'){

			$__Form->id_fm = Php_Ls_Cln($_POST['_id_fm']);
			$__Form->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			$__Form->enc_mdl = Php_Ls_Cln($_POST['_enc_fm']);

			$Prc = $__Form->SclFormUpdPlcy();
			$Prc1 = $__Form->FormChk(['enc'=>$__Form->enc_mdl]);

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['enc'] = Php_Ls_Cln($_POST['_enc_fm']);
				$rsp['e1'] = $Prc1;
			}else{
				$rsp['e'] = 'no';
			}
		}elseif($_tp == 'scl_acc_attr' && $__tp == 'md_id'){

			$__Form->id_fm = Php_Ls_Cln($_POST['_id_fm']);
			$__Form->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			$__Form->enc_mdl = Php_Ls_Cln($_POST['_enc_fm']);

			$Prc = $__Form->SclFormUpdMd();
			$Prc1 = $__Form->FormChk(['enc'=>$__Form->enc_mdl]);

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['enc'] = Php_Ls_Cln($_POST['_enc_fm']);
				$rsp['e1ss'] = $Prc;
				$rsp['e1'] = $Prc1;
			}else{
				$rsp['e'] = 'no';
			}
		}elseif($_tp == 'scl_acc_attr' && $__tp == 'est_id'){

			$__Form->id_fm = Php_Ls_Cln($_POST['_id_fm']);
			$__Form->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			$__Form->enc_mdl = Php_Ls_Cln($_POST['_enc_fm']);

			$Prc = $__Form->SclFormUpdEst();

			if($Prc->e == 'ok'){
				$Prc1 = $__Form->FormChk(['enc'=>$__Form->enc_mdl]);
				$rsp['e'] = 'ok';
				$rsp['enc'] = Php_Ls_Cln($_POST['_enc_fm']);
				$rsp['e1'] = $Prc1;
				$rsp['e2'] = $Prc;
			}else{
				$rsp['e'] = 'no';
			}
		}


		if($__tp == 'qus'){

			$rsp['scl'] = $__Form->SclFormQusFldLs(['qus'=>$_id_qus]);

		}elseif($__tp == 'qus_opt' && $__tp_ls == 'universidad_a_la_que_aspira'){

			$rsp['scl'] = $__Form->SclFormQusOptOrgLs(['id'=>$_id_qus,'tp'=>'uni']);

		}elseif($__tp == 'qus_opt' && $__tp_ls == 'mdl_gen'){

			$rsp['scl'] = $__Form->SclFormQusOptMdlLs(['id'=>$_id_qus]);

		}else{

			$rsp['scl'] = $__Form->SclFormQusOptFldLs(['id'=>$_id_qus]);

		}


	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
?>