<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->flt = 'ok';
	$___Ls->tpr = 'ec';
	$___Ls->sch->f = 'id_ec, ec_ord, ec_pml, ec_cd, ec_tt, ec_cd';
	$___Ls->edit->big = 'ok';
	$___Ls->new->scrl = 'ok';
	$___Ls->ing->vrall = [ADM_LNK_OP];
	$___Ls->ino = 'id_ec';
	$___Ls->ik = 'ec_enc';
	//$___Ls->upl_f = 'ok';

	if(_ChckMd('snd_ec_tmpl_grph')){
		$___Ls->grph->h = 'mny';
		$___Ls->grph->tot = 1;
	}

	$___Ls->edit->big = 'ok';

	if($___Ls->gt->tmpl == 'mycmz'){

		$___Ls->new->w = $__new_cod_w = 800;
		$___Ls->new->h = $__new_cod_h = 340;

		$__new_cmz_cod_w = 850;
		$__new_cmz_cod_h = 450;

	}else{
		if(isN($___Ls->gt->i)){
			$___Ls->new->w = 600;
			$___Ls->new->h = 700;
		}else{
			$___Ls->new->big = 'ok';
			$__new_cod_w='95%';
			$__new_cod_h='95%';
		}
	}

	if($___Ls->gt->tmpl == 'cmz'){
		$___Ls->img->dir = DMN_FLE_EC_IMG;
	}

	$___Ls->_strt();



	if(_Chk_GET('fl_ecest', $__f_g)){ $__fl .= _AndSql('ec_est', _GPJ([ 'j'=>$__f_g,'v'=>'fl_ecest' ]) ); }
	if(_Chk_GET('fl_ecus', $__f_g)){ $__fl .= _AndSql('ec_us', _GPJ([ 'j'=>$__f_g,'v'=>'fl_ecus' ]) ); }
	if(_Chk_GET('fl_ecpay', $__f_g)){ $__fl .= _AndSql('ec_pay', _GPJ([ 'j'=>$__f_g,'v'=>'fl_ecpay' ]) ); }

	if($___Ls->gt->tmpl == 'all'){ $__fl .= ' AND id_ec NOT IN (SELECT ecmdlstp_ec FROM '._BdStr(DBM).TB_EC_TP.' WHERE ecmdlstp_ec = id_ec ) '; }


	if($___Ls->gt->tmpl == 'sis'){
		$__fl .= _AndSql('ec_frm', _CId('ID_SISECFRM_SIS'));
	}else{
		$__fl .= " AND ec_frm != '"._CId('ID_SISECFRM_SIS')."' " ;
	}


	/*
	if(!isN($___Ls->mdlstp->id)){
		$_f_tp = " AND id_ec IN (SELECT ecmdlstp_ec FROM ".TB_EC_TP." WHERE ecmdlstp_ec = id_ec AND ecmdlstp_mdlstp = ".$___Ls->mdlstp->id.") ";
	}
	*/

	if(!isN($___Ls->mdlstp->id) && $___Ls->gt->tmpl != 'sis'){

	    $_f_tp = " AND id_ec IN (SELECT ecmdlstp_ec FROM "._BdStr(DBM).TB_EC_TP." WHERE ecmdlstp_ec = id_ec AND ecmdlstp_mdlstp = ".$___Ls->mdlstp->id.") ";

	}

    if(!isN($___Ls->gt->i)){

       	$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_EC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

    }elseif($___Ls->_show_ls == 'ok'){


	    if(!isN($___Ls->_fl->fk->clare_enc)){

			if(is_array($___Ls->_fl->fk->clare_enc)){
				$__all_are = implode(',', $___Ls->_fl->fk->clare_enc);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->clare_enc."'";
			}

			$___Ls->qry_f .= ' AND id_ec IN ( SELECT ecare_ec
										FROM '._BdStr(DBM).TB_EC_ARE.'
											 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON ecare_are = id_clare
										WHERE clare_enc IN ('.$__all_are.') AND clare_est = 1
									) ';
		}


		if(!isN($___Ls->_fl->fk->us_enc)){

			/*if(is_array($___Ls->_fl->fk->us_enc)){
				$__all_are = implode(',', $___Ls->_fl->fk->us_enc);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->us_enc."'";
			}

			$___Ls->qry_f .= ' AND id_ec IN ( SELECT ecare_ec
										FROM '._BdStr(DBM).TB_EC_ARE.'
											 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON ecare_are = id_clare
										WHERE clare_enc IN ('.$__all_are.')
									) ';	*/
		}


	    if(!ChckSESS_superadm()){
			if(!_ChckMd('snd_ec_cmz_all') && !_ChckMd('snd_ec_cmz_are') ){
				if(defined('SISUS_ARE') && !isN(SISUS_ARE)){
					$__fl .= ' AND
									(	id_ec IN (
											SELECT ecare_ec
											FROM '._BdStr(DBM).TB_EC_ARE.'
											WHERE ecare_are IN ('.SISUS_ARE.')
										) ||

										ec_us = "'.SISUS_ID.'"

									)';
				}
			}
		}

		if(!ChckSESS_superadm()){
			if(_ChckMd('snd_ec_cmz_are')){
				if(defined('SISUS_ARE') && !isN(SISUS_ARE)){
					$__fl .= ' AND
									(	id_ec IN (
											SELECT ecare_ec
											FROM '._BdStr(DBM).TB_EC_ARE.'
											WHERE ecare_are IN ('.SISUS_ARE.')
										) ||

										ec_us = "'.SISUS_ID.'"

									)';
				}
			}
		}

        if(!ChckSESS_superadm() && $___Ls->gt->tmpl == 'mycmz' && !_ChckMd('snd_ec_cmz_all') && !_ChckMd('snd_ec_cmz_are') ){
            $__fl .= "AND ec_cmzrlc IN (SELECT id_eccmz FROM "._BdStr(DBM).TB_EC_CMZ." WHERE ec_cmzrlc = id_eccmz AND eccmz_us = '".SISUS_ID."')";
        }


        if($___Ls->gt->tmpl == 'mycmz'){ $___Ls->tt = TX_MY.' '.MDL_EC; $_fl_tmpl .= ' AND ec_cmzrlc IS NOT NULL '.$__fl;  }
        elseif($___Ls->gt->tmpl == 'cmz'){ $___Ls->tt = MDL_EC.' '.TX_EDTBLS; $_fl_tmpl .= ' AND ec_cmz = 1 AND ec_cmzrlc IS NULL '; }
        elseif($___Ls->gt->tmpl == 'data'){ $___Ls->tt = MDL_EC.' '.TX_FLJ; $_fl_tmpl .= ' AND ec_flj = 1 ';  }
        else{
            if($__t != 'ec'){
                $___Ls->tt = MDL_EC.' Código';
                $_fl_tmpl .= ' AND (ec_flj != 1 AND ec_cmz != 1 AND ec_cmzrlc IS NULL) ';
            }
        }

		if(isN($___Ls->gt->tmpl)){
			$Ls_TotApr = ", (SELECT COUNT(*) FROM ".TB_EC_OP.", ".TB_EC_SND." WHERE ecop_snd = id_ecsnd AND ecsnd_ec = id_ec) AS __tot_apr ";
        	$Ls_TotLnk = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_EC_LNK." WHERE eclnk_ec = id_ec) AS __tot_lnk ";
       		$Ls_TotLnkOpn = ", (SELECT COUNT(*) FROM ".TB_EC_TRCK.", ".TB_EC_SND." WHERE ectrck_snd = id_ecsnd AND ecsnd_ec = id_ec) AS __tot_lnk_opn ";
		}

		if($___Ls->gt->tmpl == 'mycmz'){
        	$Ls_EcCmzE = ", (SELECT eccmz_enc FROM "._BdStr(DBM).TB_EC_CMZ." WHERE id_eccmz = ec_cmzrlc LIMIT 1) AS eccmz_enc ";
        	$Ls_EcCmzF = ", (SELECT eccmz_f_snd FROM "._BdStr(DBM).TB_EC_CMZ." WHERE id_eccmz = ec_cmzrlc LIMIT 1) AS eccmz_f_snd ";
        	$Ls_EcCmzH = ", (SELECT eccmz_h_snd FROM "._BdStr(DBM).TB_EC_CMZ."  WHERE id_eccmz = ec_cmzrlc LIMIT 1) AS eccmz_h_snd ";
        	$_tot_cmnt = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_EC_CMNT." WHERE id_ec = eccmnt_ec AND eccmnt_rd = 2 ) AS _tot_cmnt";
		}

        $Ls_Whr = "	FROM "._BdStr(DBM).TB_EC."
        				INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
				        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ec_est', 'als'=>'e' ])."
				        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ec_pay', 'als'=>'p' ])."
				        INNER JOIN "._BdStr(DBM).TB_US." ON ec_us = id_us

				    WHERE ".$___Ls->ino." != '' ".$___Ls->qry_f."
				        		$_f_tp
				        		$__fl
				        		$_fl_tmpl
				        		".$___Ls->sch->cod." AND ec_est != '"._CId('ID_SISEST_OBSL')."' AND cl_enc = '".DB_CL_ENC."'
				    ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT id_ec, ec_enc, ec_frm, ec_tt, ec_fi, ec_cd, ec_pay, ec_ord, ec_est, ec_frm,
								ec_cmzrlc, us_nm, us_ap, us_user, ec_chngtot,
					        	"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
								"._QrySisSlcF([ 'als'=>'p', 'als_n'=>'Pago']).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Pago', 'als'=>'p' ]).",
					        (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
					        	{$Ls_TotApr}
					        	{$Ls_TotLnk}
					        	{$Ls_TotLnkOpn}
					        	{$Ls_FacTt}
					        	{$Ls_EcCmzE}
					        	{$Ls_EcCmzF}
					        	{$Ls_EcCmzH}
					        	{$Ls_EcCmzAre}
					        	{$Ls_EcCmzFac}
					        	{$Ls_EcCmzAreCod}
					        	{$Ls_EcCmzFacCod}
					        	{$Ls_EcUsNm}
					        	{$Ls_EcUsAp}
					        	{$_tot_cmnt}
					        	{$Ls_Whr}";

		//echo compress_code($___Ls->qrys).HTML_BR.HTML_BR.HTML_BR;

	}

	//if(SISUS_ID == 1 ||  SISUS_ID == 599){ echo $___Ls->qrys; }
	?>

		<div style="display:none;"><?php echo $___Ls->qrys; ?></div>

	<?php

	$___Ls->_bld();

?>
	<?php if($___Ls->ls->chk=='ok'){  ?>


		<?php $___Ls->_bld_l_hdr(); ?>


		<?php

			if(!isN($___Ls->grph)){

				$CntWb .= "

					_ldCnt({
						u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$___Ls->ls->vrall)."&_h=150&_t2=".$___Ls->gt->tsb."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' ,
						c:'bx_grph_".$___Ls->id_rnd."_1',
						trs:false,
						anm:'no',
						_cl:function(){


						}
					});

				";

			}

		?>

		<?php if(($___Ls->qry->tot > 0)){  ?>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">

		  	<tbody>

			 	<?php

				 	do {

				  		if($___Ls->ls->rw['ec_frm'] == _CId('ID_SISECFRM_SIS')){ $__icn_sis = Spn('sis','','___ecsis'); }else{ $__icn_sis = ''; }

				  		$__are = GtEcAreLs([ 'cnx'=>$___Ls->c_r, 'ec'=>$___Ls->ls->rw['id_ec'] ]);
						$__estado = json_decode($___Ls->ls->rw['___Estado']);
						$__pago = json_decode($___Ls->ls->rw['___Pago']);

				  		foreach($__estado as $__estado_k=>$__estado_v){
					  		$__estado_attr[$__estado_v->key] = $__estado_v->vl;
						}

						foreach($__pago as $__pago_k=>$__pago_v){
							$__pag_attr[$__pago_v->key] = $__pago_v->vl;
						}

				  		$_clslnk = '';
				  		$_clsopn = '';
			  	?>
			  	<tr>
			    <td class="_img_rnd" width="10%" <?php echo NWRP ?>>
				    <div class="_img_cod">
				    	<div class="_bimg"><?php echo $___Ls->_h_ls_img(); ?></div>
				    	<div class="_btt">
					    	<?php
						    	if($___Ls->gt->tmpl == 'mycmz'){
						    		echo Strn(CODNM_EC.ctjTx($___Ls->ls->rw['id_ec'],'in'),'_nmb');
						    	}elseif(isN($___Ls->gt->tmpl)){
							    	echo Strn(ctjTx($___Ls->ls->rw['id_ec'],'in'),'_nmb __cod');
						    	}
						    ?>
					    </div>
				    </div>
				</td>
			    <?php

				    if($___Ls->gt->tmpl == 'mycmz'){

						if(!isN($___Ls->ls->rw['_eccmz_are'])){
							$_are_fac = TX_ARDPTO;
							$_att = $___Ls->ls->rw['_eccmz_are'];
							$_cod = $___Ls->ls->rw['_eccmz_are_cod']." -";
						}else{
							$_are_fac = "";
							$_tt = "";
							$_cod = "";
						}

						$___mycmz_hdr = ($_are_fac!=''?ctjTx(Spn($_are_fac,'','_f'), 'in').HTML_BR:'').($_att!=''?ctjTx(Spn($_att), 'in').HTML_BR:'');

					}
				?>
					<?php

						if(!isN($___Ls->ls->rw['eccmz_f_snd'])){
							$dias = (strtotime(SIS_F2)-strtotime($___Ls->ls->rw['eccmz_f_snd']))/86400; $dias = abs($dias); $dias = floor($dias);
							$_date = $___Ls->ls->rw['eccmz_f_snd'];
							$_hour = $___Ls->ls->rw['eccmz_h_snd'];
						}else{
							$dias = ""; $_date = ""; $_hour = "";
						}
					?>
				    <td width="95%" align="left" nowrap="nowrap">
					    <?php
						    echo h2( ShortTx( ctjTx($_cod." ".$___Ls->ls->rw['ec_tt'],'in') ,60,'Pt', true) ) .
						    	 (($___Ls->ls->rw['ec_fi']!='')?Spn($___Ls->ls->rw['ec_fi'],'','_f').HTML_BR:'' );

						    if($___Ls->gt->tmpl == 'mycmz'){
						    	echo Spn( ctjTx($_cod." ".$___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in') ,'','_f').HTML_BR;
								echo Spn( ctjTx($_cod." ".$___Ls->ls->rw['us_user'],'in') ,'','_f').HTML_BR;
						    }

							echo '<div class="are-status">';
								echo Spn( Strn(ctjTx($___Ls->ls->rw['Estado_sisslc_tt'],'in'),'','','color:'.$__estado_attr['clr'].';') ,'','_f ec_status', (!isN($___Ls->ls->rw['Estado_sisslc_img'])?'background-image:url('.DMN_FLE_SIS_SLC.$___Ls->ls->rw['Estado_sisslc_img'].') ':'') ).HTML_BR;
								if(!isN($__are->html)){ echo $__are->html; }
							echo '</div>';

							if($___Ls->gt->tmpl == 'mycmz'){
							    if(!isN($_date)){
									echo Spn($_date,'','_f').HTML_BR.Spn($_hour,'','_f').($dias!=''?HTML_BR.Spn($dias.' dias'):'');
								}
							}

						?>
					</td>

				<?php if(ChckSESS_superadm() && isN($___Ls->gt->tmpl)){ ?>
					<td width="1%" class="c" align="center" nowrap="nowrap" style="position: relative;">
						<?php
							if($___Ls->ls->rw['ec_chngtot'] > 0){
								echo Spn( ctjTx($___Ls->ls->rw['ec_chngtot'],'in') ,'','tot_ec_chng');
							}

						?>
					</td>
				<?php } ?>

				<?php if(ChckSESS_superadm() && $___Ls->gt->tmpl != 'mycmz'){ ?>
					<td width="1%" class="c" align="center" nowrap="nowrap">
						<?php
							//$__clrs = __LsDt(['k'=>'sis_pay_est']);
							//$clr = $__clrs->ls->sis_pay_est->{$___Ls->ls->rw['ec_pay']}->clr->vl;
						?>
						<?php  echo '<br>'.Strn( ctjTx($___Ls->ls->rw['Pago_sisslc_tt'],'in') ,'','','color:'.$__pag_attr['clr'] ); echo HTML_BR.Spn('¿'.TX_PGD.'?');  ?>
					</td>
				<?php } ?>

				<?php if(ChckSESS_superadm() && $___Ls->gt->tmpl != 'snd_ec' && $___Ls->gt->tmpl != 'mycmz'){ ?>

					<td width="1%" class="c" align="center" nowrap="nowrap">
						<?php  echo Strn($___Ls->ls->rw['ec_ord'],'ok'); echo HTML_BR.Spn(TX_ORD);  ?>
					</td>

				<?php } ?>

				<?php if(ChckSESS_superadm() && $___Ls->gt->tmpl != 'snd_ec' && $___Ls->gt->tmpl != 'mycmz'){ ?>

				    <td width="0%" class="c" align="center" nowrap="nowrap">
					    <?php if(!_cdgwrn($___Ls->ls->rw['ec_cd'])){ echo Strn('Bien','ok'); } else{ echo Strn('Mal','no') ; } echo HTML_BR.Spn(TX_COD);  ?>
					</td>
				    <td width="1%" class="c" align="center" nowrap="nowrap" <?php echo $_clr_rw ?>>
					    <?php echo Strn(ctjTx($___Ls->ls->rw['__tot_lnk'],'in'),'_nmb').HTML_BR.Spn(TX_LNKS); ?>
					</td>
				    <td width="1%" class="c" align="center" nowrap="nowrap" <?php echo $_clr_rw ?>>
					    <?php if($___Ls->ls->rw['__tot_apr'] > 0){ $_clsopn = '_nmb_ok'; } echo Strn(ctjTx($___Ls->ls->rw['__tot_apr'],'in'),'_nmb '.$_clsopn); echo HTML_BR.Spn(TX_EML_APR); ?>
					</td>
				    <td width="1%" class="c" align="center" nowrap="nowrap" <?php echo $_clr_rw ?>>
					    <?php if($___Ls->ls->rw['__tot_lnk_opn'] > 0){ $_clslnk = '_nmb_lnk'; } echo Strn(ctjTx($___Ls->ls->rw['__tot_lnk_opn'],'in'),'_nmb '.$_clslnk); echo HTML_BR.Spn(TX_EML_LNK); ?>
					</td>

				<?php } ?>

					<td>
						<ul class="LsEc_Opt">
							<?php if($___Ls->gt->tmpl == 'mycmz'){ ?>

								<?php if($___Ls->ls->rw['ec_est'] == _CId('ID_SISEST_APRB')){ ?>
								<!--<li width="1%" class="c img_ec_aprb" align="center" style="" nowrap="nowrap">
									<div style="" class=""></div>
									<?php echo Spn(TX_PAPROB); ?>
								</li>-->
								<?php } ?>

								<?php
									if(($___Ls->ls->rw['ec_est'] == _CId('ID_SISEST_OK') ||  $___Ls->ls->rw['ec_est'] == _CId('ID_SISEST_APRB')) || _ChckMd('snd_ec_mod_aprb_cmn')){
										$__cls_cmnt = '_ec_cmnt_no';
									}else{
										$__cls_cmnt = '';
									}
								?>
								<?php if($___Ls->ls->rw['_tot_cmnt'] > 0){ ?>
								<li class="ccc1" width="0%" align="center" nowrap>
									<figure style="" class="c img_ec_cmnt <?php echo $__cls_cmnt; ?>" id="<?php echo $___Ls->ls->rw['id_ec']; ?>">
										<div><i style=""><?php echo $___Ls->ls->rw['_tot_cmnt']; ?></i></div>
										<?php echo Spn(TX_CMTN); ?>
									</figure>
								</li>
								<?php } ?>

								<?php if(_ChckMd('snd_ec_cpy')){ ?>
									<li class="ccc2 c img_ec_copy" id="<?php echo $___Ls->ls->rw['ec_cmzrlc']; ?>" align="center" nowrap="nowrap">
										<div></div>
										<?php echo Spn(TX_DPLPEM); ?>
									</li>
								<?php } ?>

								<li class="ccc3 c" align="center" nowrap="nowrap">
									<?php if(( 	$___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_PAPRB') || _ChckMd('snd_ec_mod_aprb') || _ChckMd('snd_ec_aprb') || _ChckMd('snd_ec_dsgn') ) &&
												$___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_OK') &&
												$___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_APRB') ||
												ChckSESS_superadm() ||
												_ChckMd('snd_ec_mod_aprb_cmn') ){ ?>

										<?php

											if(SISUS_ID == 163){
												echo $___Ls->ls->rw['ec_est'].' <-> '._CId('ID_SISEST_OK').' <-> '._CId('ID_SISEST_PAPRB').HTML_BR.HTML_BR;
											}

											if(($___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_OK') && ($___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_PAPRB') || _ChckMd('snd_ec_cmz_all') ) ) || ChckSESS_superadm() ){

												echo $___Ls->_btn([ 't'=>'mycmz', 'tp'=>'snd_ec_cmz', 'ik'=>'eccmz_enc', 'cll'=>"

																		function(){
																			$('.note-popover').hide();
																		}"
																]);
											}

										?>

									<?php }else{ ?>
										<?php //echo HTML_Ls_Btn([ 't'=>'mycmz', 'js'=>'ok', 'cls'=>'icn_fll', 'l'=>'javaScript:void(0)' ]); ?>
									<?php } ?>
								</li>

							<?php }elseif($___Ls->gt->tmpl == 'data'){ ?>

								<li class="ccc4 c" align="center" nowrap="nowrap">
									<?php

										echo $___Ls->_btn([ 't'=>'dsgn', 'tp'=>'ec_dsgn', 'ik'=>'ec_enc', 'cll'=>"

																		function(){
																			$('.note-popover').hide();
																		}"
																]);

										/*
										echo HTML_Ls_Btn([
															't'=>'dsgn',
															'js'=>'no',
															'l'=>_Ls_Lnk_Rw([ 'l'=>FL_FM_GN.__t('ec_dsgn',true).
																				_pFl([ 'g'=>$Flt_Cmp.$Flt_CmpND, 't'=>'get' ]).
																				_SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino].$___Ls->ls->vrall.$_adsch,
																			'jv'=>'no',
																			'sb'=>$__pop,
																			'r'=>$___Ls->bx_rld,
																			'h'=>'99%',
																			'w'=>'99%',
															]),
															'cls'=>'_dsgn icn_fll',
															'h'=>'99%', 'w'=>'99%',

														]);
										*/

									?>
								</li>
							<?php } ?>

							<?php if($___Ls->gt->tmpl == 'cmz' || $___Ls->gt->tmpl == 'data' || $___Ls->gt->tmpl == '' || $___Ls->ls->rw['ec_frm'] == _CId('ID_SISECFRM_SIS') || ChckSESS_superadm() || _ChckMd('snd_ec_mod')){ ?>
							<li class="ccc5 cdd" nowrap="nowrap">
								<?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
							</li>
							<?php } ?>

							<li class="ccc6" align="center" nowrap="nowrap">
								<?php
									if($___Ls->gt->tmpl == 'mycmz' && (_ChckMd('snd_ec_aprb') && $___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_NO') && $___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_APRB')) ){
										if($___Ls->ls->rw['ec_est'] != _CId('ID_SISEST_OK')){
											echo HTML_Ls_Btn([ 't'=>'aprb', 'rel'=>$___Ls->ls->rw['ec_enc'], 'cls'=>'_ec_apr icn_fll', 'l'=>Void() ]);
										}
									}
								?>
							</li>

							<?php if(ChckSESS_superadm() && $___Ls->gt->tmpl == 'mycmz'){ ?>
							<li class="ccc7 c" align="center" nowrap="nowrap">
								<?php  echo HTML_Ls_Btn([ 't'=>'aprb_sg', 'rel'=>$___Ls->ls->rw['ec_enc'], 'cls'=>'_ec_apr_sg icn_fll', 'l'=>Void() ]);  ?>
							</li>
							<?php } ?>

							<?php if(_ChckMd('snd_ec_eli') && $___Ls->gt->tmpl == 'mycmz'){  ?>
							<li class="ccc8 c" align="center" nowrap="nowrap">
								<?php  echo HTML_Ls_Btn([ 't'=>'eli', 'rel'=>$___Ls->ls->rw['ec_enc'], 'cls'=>'_ec_eli icn_fll', 'l'=>Void() ]);  ?>
							</li>
							<?php } ?>

							<?php if(ChckSESS_superadm() && isN($___Ls->gt->tmpl)){ ?>
							<li class="ccc9" align="center" nowrap="nowrap">
								<?php echo HTML_Ls_Btn([ 't'=>'rpr', 'l'=>Fl_Rnd(FL_FM_GN.__t('ec_rpr',true).Fl_i($___Ls->ls->rw['id_ec'])), 'cls'=>'_rpr' ]); ?>
							</li>
							<?php } ?>

							<li align="center" class="ccc10 c" nowrap="nowrap">
								<?php if( $___Ls->ls->rw['ec_est'] == _CId('ID_SISEST_APRB') || $___Ls->ls->rw['ec_est'] == _CId('ID_SISEST_OK') || _ChckMd('snd_ec_onl') ){ ?>
									<?php
										if($___Ls->gt->tmpl == 'data'){
											echo HTML_Ls_Btn([ 't'=>'outl', 'l'=>Fl_Rnd(FL_FM_GN.__t('ec_html',true).Fl_i($___Ls->ls->rw['ec_enc']))."&Rd=+Math.random()", 'cls'=>'_html' ]);
										} else{
											echo HTML_Ls_Btn([ 't'=>'outl', 'cls'=>'outl', 'jq'=>'ok', 'attr'=>[ 'data-url'=>DMN_EC.LNK_HTML.'/'.$___Ls->ls->rw['ec_enc'].'/?_r='.$___Ls->id_rnd ] ]);
										}
									?>
								<?php } ?>
							</li>
							<li class="ccc11 c" width="0%" align="center" nowrap="nowrap"><?php echo HTML_Ls_Btn([ 't'=>'dwn', 'l'=>DMN_DWN.PrmLnk('bld', LNK_EC).$___Ls->ls->rw['ec_enc']."/?__e=ec_dwn&_r=".$___Ls->id_rnd.'&__tp='.$___Ls->gt->tmpl, 'cls'=>'_dwn' ]); ?></li>
						</ul>
					</td>
				</tr>

			  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>

			</tbody>

		</table>

		<style>
			.tot_ec_chng{position: absolute;width: 30px;background-color: #03A9F4;display: block;text-align: center;padding: 8px 0;font-size: 13px !important;border-radius: 50%;color: white;left: -30px;top: 30px;}
			.TabbedPanelsTab._ec_chng{opacity: 0.4;height: 30px;background-size: 26px !important;background-position: 10px 0 !important;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>change.svg) !important;}
			.TabbedPanelsTab._ec_chng.TabbedPanelsTabSelected{opacity: 1;}
		</style>

		<div style="display:none;">
			<div id="_apr_sg_us_bx_<?php echo $___Ls->id_rnd; ?>" class="___bx_apr_sgu">
				<div class="_icn"></div>
				<h2><?php echo TX_GBR_LNK_APRB; ?></h2>
				<div class="_inln">
					<?php echo LsUs('__apr_sg_us_'.$___Ls->id_rnd,'us_enc', '', '', 2); $CntWb .= JQ_Ls('__apr_sg_us_'.$___Ls->id_rnd,'');?>
					<button id="_apr_sg_us_btn_<?php echo $___Ls->id_rnd; ?>"><?php echo TX_OPN_LNK ?></button>
				</div>
			</div>
		</div>

		<?php $___Ls->_bld_l_pgs(); ?>

		<?php }  ?>


		<?php


		$CntWb .= '
			$("._rpr").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false });
			$("._html").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false });
			$("._dwn").colorbox({ iframe:true, width:"1000px", height:"600px", overlayClose:false, escKey:false, trapFocus:false });
			$("._dsgn").colorbox({ width:"95%", height:"95%", overlayClose:false, escKey:false});
		';


		$CntJV .= "

			function _rld_ec_".$___Ls->gt->tmpl."(){
				_ldCnt({
					u:SUMR_Main.url['".$___Ls->gt->plct."'].lnk,
					c:SUMR_Main.url['".$___Ls->gt->plct."'].box
				});
			}

		";

		$CntWb .= "

			var __apr_o = {};

			$('.ls_btn.outl').off('click').click(function(){
				var _url = $(this).attr('data-url');
				if(!isN(_url)){
					window.open(_url+'&_rnd='+Math.random());
				}
			});

			$('#_apr_sg_us_btn_".$___Ls->id_rnd."').off('click').click(function(){
				var __us = $('#__apr_sg_us_".$___Ls->id_rnd." option:selected').val();
				__apr_o.us = __us;
				if(!isN(__apr_o.ec) && !isN(__apr_o.us)){
					window.open('".DMN_EC."a/'+__apr_o.ec+'/'+__apr_o.us);
				}
			});

			$('._ec_apr_sg').click(function(){
				var _enc = $(this).attr('rel');
				__apr_o.ec = _enc;
				$.colorbox({ inline:true, href:'#_apr_sg_us_bx_".$___Ls->id_rnd."', width:'350px', height:'300px', overlayClose:false, escKey:false, trapFocus:false });
			});

			$('._ec_apr').click(function() {

				var _id = $(this).attr('rel');

				swal({
					title: '".TX_APR."',
					text: '".TX_ESAPRPM."',
					type: 'info',
					showCancelButton: true,
					confirmButtonColor: '#64b764',
					confirmButtonText:'".TX_ACPT."',
					cancelButtonText: '".TX_CNCLR."',
					showLoaderOnConfirm: true,
					closeOnConfirm: false
				},
				function(){

					$.ajax({
						type: 'POST',
						data:('ec_enc='+_id+'&MM_Update_ec_est=EdEcEst'),
						dataType: 'json',
						url: '".Fl_Rnd(PRC_GN.__t('snd_ec_cmz',true))."',
						beforeSend: function() {
						},
						success: function(d){
					     	if(d.e == 'ok'){
					            swal('Bien','".TX_APROEXT."', 'success');
					            _rld_ec_".$___Ls->gt->tmpl."();
							}else{
								swal('Error', '".TX_NSAPRB."', 'error');
							}
					    }
				    })

				});

			});


			$('._ec_eli').click(function() {

				var _id = $(this).attr('rel');

				swal({
				  title: '".TX_CFRMCN."',
				  text: '".TX_SGDLTPM."',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#c35454',
				  confirmButtonText: '".TX_SGR."',
				  cancelButtonText: '".TX_CNCLR."',
				  showLoaderOnConfirm: true,
				  closeOnConfirm: false,
				},
				function(){

					$.ajax({
						type: 'POST',
						data:('uid='+_id+'&MM_delete=EdEc'),
						dataType: 'json',
						url: '".Fl_Rnd(PRC_GN.__t('snd_ec_tmpl',true))."',
						beforeSend: function() {
						},
						success: function(d){
					     	if(d.e == 'ok'){
					            swal('Bien', '".TX_DLTEX."', 'success');
					            _rld_ec_".$___Ls->gt->tmpl."();
							}else{
								swal('Error', '".TX_NDLT."', 'error');
							}
					    }
				    })

				});

			});

			/*

			$('#cboxClose').click(function(){
				$('.note-popover').hide();
				".JQ__ldCnt([ 'u'=>FL_LS_GN.__t($___Ls->tp,true).$___Ls->ls->vrall, 'c'=>$___Ls->bx_rld, 'js'=>'no' ])."
			});

			*/

			$('.img_ec_cmnt').click(function (){

				if(!$(this).hasClass('_ec_cmnt_no')){

					var id_eccmnt = $(this).attr('id');

					_ldCnt({
						u:'".FL_LS_GN.__t('snd_ec_cmz_cmnt',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+id_eccmnt,
						w:'98%',
						h:'98%',
						pop:'ok',
						pnl:{
							e:'ok',
							tp:'h',
							s:'l'
						}
					});

				}

			});

			$('.img_ec_copy').off('click').click(function (){

				var id_eccmnt = $(this).attr('id');

				_ldCnt({
					u:'".FL_FM_GN.__t('snd_ec_cpy',true).TXGN_ING.TXGN_POP.TXGN_BX.$___Ls->bx_rld."&_i='+id_eccmnt,
					w:'50%',
					h:'50%',
					pop:'ok'
				});

			});


		";

	?>

	<?php $___Ls->_h_ls_nr(); ?>

	<?php } ?>

	<?php if($___Ls->fm->chk=='ok'){ ?>

		<div class="FmTb">

		  	<div id="bld_strt<?php echo $___Ls->fm->id; ?>" <?php if($___Ls->gt->op != 'ok' || $___Ls->dt->tot > 0){ ?>style="display: none;" <?php } ?> >
		  		<?php include(DIR_EXT.'ec_1.php'); ?>
		  	</div>

		  	<div id="bld_ec<?php echo $___Ls->fm->id; ?>" <?php if($___Ls->gt->op == 'ok' && $___Ls->dt->tot == 0){ ?>style="display: none;" <?php } ?> >
		  		<?php include(DIR_EXT.'ec_2.php'); ?>
		  	</div>
		</div>

	<?php } ?>


<?php } ?>