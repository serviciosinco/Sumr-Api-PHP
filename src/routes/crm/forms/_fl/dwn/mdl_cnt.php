<?php
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_fm = 'FmEnc'.$___Ls->id_rnd;
	$_t2 = Php_Ls_Cln($_GET['_t2']);
?>
<div class="_fm_fnc">
    <div class="wrp" style="padding-top: 50px;">

		<div class="_img _hdr_dwn" style="height:225px !important;" id="__url_end"></div>

		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>

				<div id="<?php echo $__id_fm ?>_flds" style="padding:30px 20px 100px 20px;">


	        <form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >

				<input name="MM_download" id="MM_download" type="hidden" value="MdlCnt" />
				<?php echo HTML_inp_hd('_tp', $___Ls->tpg); ?>
				<?php echo HTML_inp_hd('_key', $___Ls->id_rnd); ?>

	            <div id="<?php echo $__id_fm ?>_flds" style=" display: flex; ">

					<div class="col_1" style="width:50%;">

		             	<?php /*$l = __Ls(['k'=>'dwn_frmt', 'id'=>'_frm', 'va'=>$___Ls->dt->rw['dwn_frm'] , 'ph'=>FM_LS_SLGN ]); echo $l->html; $CntWb .= $l->js;*/ ?>
						<?php if(ChckSESS_superadm()){ echo LsUs('_us','id_us', '' ,'Usuario', 2); $CntWb .= JQ_Ls('_us','Usuario'); } ?>

		            	<?php echo LsClAre([
								            	'id'=>'_cntAre',
								            	'v'=>'id_clare',
								            	'va'=>$___Ls->dt->rw['clare_prnt'],
								            	'rq'=>2,
								            	'mlt'=>'no'
											]);

			            	$CntWb .= JQ_Ls('_cntAre',TX_ARE);
			            ?>

						<?php echo LsMdl('_cntMdl', 'id_mdl', $___Ls->dt->rw['mdl_enc'], _MdlTx(TX_SLCMDL), 2, 'ok', [ 'tp_k'=> $___Ls->tpg, 'flt_are'=>'ok' ] ); $CntWb .= JQ_Ls('_cntMdl', _MdlTx(TX_SLCMDL)); ?>
						<?php echo LsCntEst([ 'id'=>'_est', 'v'=>'siscntest_enc', 'rq'=>2, 'mlt'=>'ok', 'v_go'=>'enc', 'mdlstp'=>$___Ls->mdlstp->id ]); $CntWb .= JQ_Ls('_est', FM_LS_EST); ?>
						<?php echo LsCntEstTp('_cntEst','id_siscntesttp', '', '', 2, 'ok'); $CntWb .= JQ_Ls('_cntEst', FM_LS_SLFAC);?>
						<?php echo LsSis_Md('_cntMd' ,'id_sismd', '','', 2, '', ['attr'=>['send-id'=>'sismd_enc']] ); $CntWb .= JQ_Ls('_cntMd', FM_LS_SLFAC);?>

						<?php if(DB_CL_ENC == '7d51bb17c7bf84009158bd691caccbdeabd3d4cf'){
							echo LsMdlSHrs('_cntSch','mdlssch_enc', '', TX_PSG_HRA, 2, 'ok' ); $CntWb .= JQ_Ls('_cntSch', FM_LS_SLFAC);
							echo LsUs('_cntUs','us_enc', '' ,'Usuarios', 2,'ok'); $CntWb .= JQ_Ls('_cntUs','Usuarios');
						} ?>


						<div class="_c2" style="display:flex;">
				            <div class="_d1"><?php echo LsMdlSPrd('_cntPrdI', 'mdlsprd_enc', '', TX_PRDING, 2, '', [ 'tp_mdl' => $_t2 ] ); $CntWb .= JQ_Ls('_cntPrdI','Periodo Ingreso'); ?></div>
							<div class="_d2" style="margin-left: 5px;"><?php echo LsMdlSPrd('_cntPrdA', 'mdlsprd_enc', '', TX_PRD_A, 2, '', [ 'tp_mdl' => $_t2 ] ); $CntWb .= JQ_Ls('_cntPrdA','Periodo Aplica'); ?></div>
	                    </div>

						<!--
						<div class="_c3">
							<div class="_d1">
								<?php //echo LsSis_MdlPrd('_prdapl', 'id_proprd','', 'Periodo Aplica', 2, 'ok', array('tp'=>$___Ls->tpg)); $CntWb .= JQ_Ls('_prdapl', 'Periodo Aplica'); ?>
							</div>
				            <div class="_d2">
					            <?php //echo LsSis_MdlPrd('_prding', 'id_proprd','', 'Periodo de ingreso', 2, 'ok', array('tp'=>$___Ls->tpg)); $CntWb .= JQ_Ls('_prding', 'Periodo de ingreso'); ?>
				            </div>
				            <div class="_d3">
					            <?php //echo LsCntTp('_u','id_siscnttp', '', '', 2, ''); $CntWb .= JQ_Ls('_u', FM_LS_VNCU); ?>
				            </div>
						</div>
						-->

						<?php
							if(ChckSESS_superadm() || _ChckMd('dwn_all') ){
								$rq_f = 'no';
								$CntWb .= " var adm = 'ok';";
							}else{
								$rq_f = 'ok';
								$CntWb .= " var adm = 'no';";
							}
						?>

						<div class="_c2">
				            <div class="_d1"><?php echo SlDt([ 'id'=>'_f_in', 'lmt'=>'no', 'yr'=>'ok', 'mth'=>'ok', 'rq'=>$rq_f, 'ph'=>TX_ORD_FIN ]); ?></div>
							<div class="_d2"><?php echo SlDt([ 'id'=>'_f_out', 'lmt'=>'no', 'yr'=>'ok', 'mth'=>'ok', 'rq'=>$rq_f, 'ph'=>TX_ORD_FOU ]); ?></div>

	                    </div>

	                	<!--
	                    <div class="_c2">
							<div class="_d1"><?php echo OLD_HTML_chck('_inc_dc', 'Sin Documento','', 'in');  ?></div>
				            <div class="_d2"><?php echo OLD_HTML_chck('_inc_eml', 'Sin E-Mail','', 'in');  ?></div>

	                    </div>
	                    <div class="_c2">
		                    <div class="_d1"><?php echo OLD_HTML_chck('_inc_tel', 'Sin Telefono','', 'in');  ?></div>
							<div class="_d2"><?php echo OLD_HTML_chck('_eml_bad', 'E-mails Errados','', 'in'); ?></div>
	                    </div>
	                    <div class="_c2">
				            <div class="_d1"><?php echo OLD_HTML_chck('_tel_bad', 'Telefonos Errados','', 'in');  ?></div>
							<div class="_d2"><?php echo OLD_HTML_chck('_eml_snd', 'Enviar e-mail','', 'in');  ?></div>
	                    </div>
	                    -->

						<ul>
							<li class="_snd_fnc"><input type="button" class="btn" id="Sve_Dwn" value="<?php echo 'Descargar' ?>" /></li>
						</ul>
					</div>

					<div class="col_2" style="width:49%; padding-left:30px;">
						<?php
							if(SISUS_ID == 163 && _ChckMd('dwn_tme_prgm') || ChckSESS_superadm()){

								echo OLD_HTML_chck('prgm_chk', 'Programación','', 'in');
								echo HTML_BR;
								?><div id="dwn_tme_prgm_bx" class="_sbls dwn_tme_prgm_bx _anm"></div><?php

								$CntWb .= "

											$('#prgm_chk').change(function() {
												if(this.checked) {
													SUMR_Main.ld.f.slc({ i:'', t:'dwn_tme_prgm', b:'dwn_tme_prgm_bx', t_i:'".$__cl->enc."', t_e: '', t_p: '".$__id_rnd."' });
												}else{
													$('#dwn_tme_prgm_bx').html('');
												}
											});

										";

							}
						?>
					</div>

						<?php

							if(ChckSESS_superadm()){
								$__days_down = 600;
							}else{
								$__days_down = 210;
							}


							$CntWb .= "



								function __ShwDwn(){ _ldCnt({ u:'".FL_LS_GN."?_t=dwn&Rd='+Math.random() }); }


								$('#Sve_Dwn').off('click').click(function() {


										if( $('#{$__id_fm}').valid() ){
											var fechaInicio = new Date($('#_f_in').val()).getTime();
											var fechaFin    = new Date($('#_f_out').val()).getTime();

											var contdias = Math.round( (fechaFin - fechaInicio) / (1000*60*60*24));

											if(contdias > $__days_down && adm == 'no' ){
												swal('Recuerda', 'Solo puedes hacer descargas en un rango de 6 meses', 'info');
											}else{
												$.ajax({
													type: 'POST',
													dataType: 'json',
													url:'".FL_JSON_GN.__t('dwn_mdl_cnt', true).$___Ls->ls->vrall."',
													data: $('#{$__id_fm}').serialize(),
													beforeSend: function() {
														$('#{$__id_fm}_ld').fadeIn();
														$('#{$__id_fm}_flds').fadeOut();
													},
													success: function(d) {

														if(d.e == 'ok'){
															SUMR_Main.pnl.f.shw();
														}else{
															$('#{$__id_fm}_flds').fadeIn();
														}

													},
													complete: function(){
														$.colorbox.close();
														__ShwDwn();
														$('#{$__id_fm}_ld').fadeOut();
													}
												});
											}
										}



								});


							";
						?>


				</div>

			</form>
		</div>
    </div>
</div>
<style>

	.dwn_tme_prgm_bx{ min-height:250px !important; width:100%; position:relative; }
	.dwn_tme_prgm_bx:empty{  }
	.dwn_tme_prgm_bx::before{ content:''; height:50px; width:50px; position:absolute; left:50%; top:50%; margin-left:-25px; margin-top:-25px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dwn_fm_prgr.svg); background-repeat:no-repeat; background-position:center center; background-size:auto 80%; opacity:0; pointer-events:none; -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; transition-duration: 0.3s; -webkit-transition-timing-function: ease; -moz-transition-timing-function: ease; -ms-transition-timing-function: ease; -o-transition-timing-function: ease; transition-timing-function: ease; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; }
	.dwn_tme_prgm_bx:empty::before{ opacity:1; height:150px; width:150px; margin-left:-75px; margin-top:-75px; }

</style>