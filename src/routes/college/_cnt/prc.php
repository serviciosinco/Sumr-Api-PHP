<?php

	//------------------* SETUP - START ------------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';

		$__pm_1 = PrmLnk('rtn', 1, 'ok');

	//------------------* SETUP - END ------------------//

		$__Forms = new CRM_Forms();
		$__Forms->data = Php_Ls_Cln($_POST);
		$__r = $__Forms->_pdata();


		if(
				!isN($__r->cnt_nm) &&
				(!isN($__r->cnt_eml) || !isN($__r->cnt_dc))
			){

			if(isN($__r->cnt_eml->w)){

				//------------------ Check Data Before Insert ------------------//

				$__CntIn = new CRM_Cnt([ 'cl'=>$__dt_cl->id ]);
				$__ActIn = new CRM_Act();

				//------------------ DATOS BASICOS DE LEAD ------------------//

					$__CntIn->tp = $__t_p;
					$__CntIn->cnt_nm = $__r->cnt_nm;
					$__CntIn->cnt_eml = $__r->cnt_eml;
					$__CntIn->cnt_tel =[ 'no'=>$__r->cnt_tel ];
					$__CntIn->cnt_sndi = 1;
					$__CntIn->plcy_id = $__r->plcy_id;

				//------------------ DATOS BASICOS DE RELACION CON LEAD ------------------//

					$__CntIn->cnt_fnt = $__r->mdlcnt_fnt;
					$__CntIn->gt_cl_id = $__Forms->gt_cl->id;
		 			$__CntIn->invk->by = _CId('ID_SISINVK_FORM');

				//------------------ RELACIÓN A ORGANIZACIÓN ------------------//

					$__CntIn->cnt_org[] = [
						'id'=>$__r->org_sds,
						'tpr'=>ID_ORGCNTRTP_TRB_PRST,
						'tpr_o'=>ID_ORGTP_CLG,
						'crg'=>$__r->cnt_crg
					];

				//------------------ PROCESA REGISTRO - START ------------------//

					$__gcnt = $__CntIn->_Cnt();

					if(!isN($__gcnt->i) && $__gcnt->e == 'ok'){

						if(!isN($__r->org_sds)){

							$_org_sds_dt = GtOrgSdsDt([ 't'=>'enc', 'i'=>$__r->org_sds ]);

							if(!isN($_org_sds_dt->id)){

								$__ActIn->act_cl = $__dt_cl->id;
								$__ActIn->act_tt = 'Visita en Colegio';
								$__ActIn->act_est = _CId('ID_ACTEST_SLCT');
								$__ActIn->act_us = 3;
								$__ActIn->act_lgr = _CId('ID_ACTLGR_IN_CLG');
								$__ActIn->orgsdsact_orgsds = $_org_sds_dt->id;

								$Result_Act = $__ActIn->In();

								$_r['tmp_act'] = $Result_Act;

							}
						}

						if(!isN($Result_Act->e) && $Result_Act->e == 'ok'){

							$_r['e'] = 'ok';

						}

					}

				//------------------ PROCESA REGISTRO - END ------------------//

			}else{

				$_r['e'] = 'no';

			}

		}else{

			$_r['e'] = 'no_data';

		}




	//------------------* PRINT RESULTS ------------------//


	if(!isN($_r)){ echo json_encode($_r); }
	ob_end_flush();


?>