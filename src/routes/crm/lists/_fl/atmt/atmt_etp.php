<?php
if(class_exists('CRM_Cnx')){


	$___Ls->cnx->aut = 'ok';
	$___Ls->sch->f = 'atmt_nm';

	$___Ls->new->w = 500;
	$___Ls->new->h = 600;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 600;

	$___Ls->_strt();


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("	SELECT *
									FROM ".TB_ATMT."
									WHERE ".$___Ls->ik." = %s
									LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
								);

	}elseif($___Ls->_show_ls == 'ok'){


		$Ls_Whr = "	FROM ".TB_ATMT_ETP."
						 INNER JOIN ".TB_ATMT." ON atmtetp_atmt = id_atmt
						 INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmtetp_etp = id_cletp
					WHERE ".$___Ls->ino." != '' AND atmt_enc = '$__i' $_f_tp $__fl
					ORDER BY atmtetp_ord ASC";

		$___Ls->qrys = "SELECT *,
						  (SELECT COUNT(*) $Ls_Whr) AS __rgtot
						  $Ls_Whr";


	}


	$___Ls->_bld();
	$___days_week = _WkDays();


?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  <tbody>
		<?php do { ?>
        <tr>

            <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls" width="1%" valign="top"><?php echo Spn($___Ls->ls->rw['atmtetp_ord'], '', '_etp_n'); ?></td>
            <td align="left" <?php echo $_clr_rw ?>>
	            <?php
		              echo h2( $___Ls->ls->rw['cletp_nm']!=''?ctjTx($___Ls->ls->rw['cletp_nm'],'in'):ctjTx($___Ls->ls->rw['atmtetp_nm'],'in') .
		              		   bdiv([
			              		    'cls'=>'trgr_icn',
		              		   		'c'=>$__icn_tt
		              		   ])
		              	   );
		        ?>
	        </td>
	        <?php $rnd = Gn_Rnd(10); ?>
			<td align="left" <?php echo $_clr_rw ?>  width="14%" valign="top"><?php echo OLD_HTML_chck($rnd, 'Activo', $___Ls->ls->rw['atmtetp_on'], 'in'); ?></td>
			<?php

				$CntWb .= "

						$('#".$rnd."').change(function (){
							if($(this).is(':checked')){
								_chck_on({'id':'".$___Ls->ls->rw['atmtetp_enc']."', 'e':'on'});
							}else{
								_chck_on({'id':'".$___Ls->ls->rw['atmtetp_enc']."'});
							}
						});

				 ";
			?>

            <?php if(ChckSESS_superadm() || (_ChckMd('ec_etp_mod'))){ ?>
	            <td width="1%" align="left" nowrap="nowrap">
	                <?php

		                if( $_lnktr_l != '' ){
		                	echo HTML_Ls_Btn(  ['t'=>'edt', 'js'=>'ok', 'l'=>_Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'jv'=>'no', 'r'=>$__bxrld, 'w'=>'90%', 'h'=>'90%' ]) ]);
		                }
		            ?>
	            </td>
            <?php } ?>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc());


	          $CntWb .= "
					function _chck_on(_p){

						if(_p.e == 'on'){ var __snd_e = 1; }else{ var __snd_e = 2; }

						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: '".Fl_Rnd(PRC_GN.__t('atmt_etp',true))."',
							beforeSend: function() {

							},
							data: {
								atmtetp_on : __snd_e,
								MMM_Update_auto: 'EdAtmtEtp',
								atmtetp_enc: _p.id
							},
							success: function(d){
								"._DvLsFl([ 'i'=>'_auto', 't'=>'s' ])."
						    }
						});
					}


				";

        ?>
  </tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

     	<?php $___Ls->_bld_f_hdr(); ?>

		<div id="<?php echo $___Ls->fm->fld->id ?>">

			<div class="ln_1" id="__edt<?php echo $__prfx_fm; ?>" >
					<div class="col_1">
	                    <?php echo h2(TX_DTSBSC); ?>


	                    <?php echo HTML_inp_hd('atmtetp_atmt', $___Ls->dt->rw['atmtetp_atmt']!=''?$___Ls->dt->rw['atmtetp_atmt']:_SbLs_ID('i') ); ?>

	                    <?php $__id_btn = Gn_Rnd(20); ?>
	                    <div style="display: none;" id="bx_<?php echo $__id_btn; ?>">
	                    	<?php echo HTML_inp_tx('cletp_nm', TX_NM, ctjTx($___Ls->dt->rw['cletp_nm'],'in')); ?>
	                    </div>

	                    <div id="bxtt_<?php echo $__id_btn; ?>">
	                    	<?php

		                    	if($___Ls->dt->tot > 0){
		                    		echo h1(  $___Ls->dt->rw['cletp_nm']!=''?ctjTx($___Ls->dt->rw['cletp_nm'],'in'):ctjTx($___Ls->dt->rw['cletp_nm'],'in') );
		                    	}else{
			                    	echo h1(  '-' );
		                    	}

		                    ?>
	                    	<div class="__bx_dt __fm_opt">
								<div class="__btn" style="z-index: 99999999; ">

								            <?php echo '<a href="'.Void().'" id="___edt_btn'.$__id_btn.'" class="___edt_btn">'.TX_EDIT.'</a>' ; ?>
								            <?php
												$CntWb .= '$("#___edt_btn'.$__id_btn.'").click(function(){

																$("#bxtt_'.$__id_btn.'").fadeOut("fast", function(){
																	$("#bx_'.$__id_btn.'").fadeIn();
																});


															}); ';
											?>
								</div>
							</div>
	                    </div>
					</div>

	                <div class="col_2">
		                <?php echo h2(TX_OTHDT); ?>
						<?php
							$__cletp =  LsClEtp('atmtetp_etp','cletp_enc', $___Ls->dt->rw['atmtetp_etp'], FM_LS_ETP);
							$CntWb .= JQ_Ls('atmtetp_etp', FM_LS_ETP);

							if(!isN($__cletp)){

								echo $__cletp;

						?>

							<?php echo HTML_inp_tx('atmtetp_ord', TX_NM, ctjTx($___Ls->dt->rw['atmtetp_ord'],'in'));


								$CntWb .= "

									$('#atmtetp_etp').change(function() {

										__sl = $('#atmtetp_etp option:selected');
										__sl_t = __sl.text();
										__sl_r = __sl.attr('rel');

										$('#atmtetp_ord').val(__sl_r);
										$('#bxtt_".$__id_btn." h1').html(__sl_t);

									});";

							?>
							<?php echo HTML_inp_tx('atmtetp_d_bfr', 'Dias Atras', ctjTx($___Ls->dt->rw['atmtetp_d_bfr'],'in') ); ?>
							<?php echo OLD_HTML_chck('atmtetp_on', 'Activo', $___Ls->dt->rw['atmtetp_on'], 'in'); ?>
						<?php

							}else{

								echo '<div class="_msg wrn">Debe crear las etapas en '._Cns('TB_CL_ETP').'</div>';

							}

						?>

	                </div>
			</div>

		</div>

    </form>

 	</div>

</div>
<?php } ?>
<?php } ?>