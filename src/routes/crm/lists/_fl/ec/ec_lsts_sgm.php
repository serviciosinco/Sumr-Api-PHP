<?php

if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->tpr = 'ec_lsts_sgm';
	$___Ls->sch->f = 'eclstssgm_nm';
	$___Ls->edit->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->ing->vrall = [ADM_LNK_OP];
	$___Ls->ino = 'id_eclstssgm';
	$___Ls->ik = 'eclstssgm_enc';

	$___Ls->edit->big = 'ok';

	$___Ls->new->w = 600;
	$___Ls->new->h = 700;

	$___Ls->ls->lmt = 400;

	$___Ls->_strt();


	if(_SbLs_ID('i')){

		$__fl .= " AND eclstssgm_lsts = ( 	SELECT id_eclsts
											FROM "._BdStr(DBM).MDL_EC_LSTS_BD."
											WHERE eclsts_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
										)";
	}


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT *
								FROM "._BdStr(DBM).MDL_EC_LSTS_SGM_BD."
								WHERE eclstssgm_enc = %s LIMIT 1", GtSQLVlStr($_GET['_i'], "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "	FROM "._BdStr(DBM).MDL_EC_LSTS_SGM_BD."
					WHERE id_eclstssgm != '' {$___Ls->sch->cod} $__fl
					ORDER BY eclstssgm_nm ASC";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS __rgtot $Ls_Whr $Tot_Var";

	}

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
	  <tbody>

			<?php do { ?>
				<?php
					$__sgm_dt = GtEcLstsSgmDt([ 'id'=>$___Ls->ls->rw["id_eclstssgm"], 'd'=>[ 'var'=>'ok' ] ]);
				?>
				<tr <?php
		                $Nm = Itc($NmNw);
						/*$_lnktr_l = FL_LS_GN.__t($__bdtp,true).
									_pFl([
										'g'=>$Flt_Cmp.$Flt_CmpND,
										't'=>'get'
									]).
									_SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$__id].
									_pFl(['g'=>$Flt_Cmp.$Flt_CmpND, 't'=>'get']).$___Ls->ls->vrall.
									$_adsch;*/
		                $NmNw = $Nm;
		        ?>>
			        <td align="left" <?php echo $_clr_rw ?> width="1%">
			            <?php
				            //print_r($__sgm_dt->var->qry_t);
				        	echo Spn($___Ls->ls->rw['id_eclstssgm']);
			            ?>
			        </td>
			        <td align="left" <?php echo $_clr_rw ?> width="90%" class="__sgm_ls">
			            <?php
				            //print_r($__sgm_dt->var->qry_t);
				        	echo h2(ctjTx($___Ls->ls->rw['eclstssgm_nm'],'in')).Strn(TX_FICR).' '.Spn(_DteHTML(['d'=>$___Ls->ls->rw['eclstssgm_fi'], 'nd'=>'ok']), '', '_f');
			            ?>
			        </td>
			         <td align="center" <?php echo $_clr_rw ?> width="9%" class="">
				       <?php

							if($__sgm_dt->var->qry_t->tot->allw > 0){

								echo h2("Leads ").Spn( $__sgm_dt->var->qry_t->tot->allw , '', 'bdge');

							}else{

								$pdt = GtEcEmlTot([
									'lsts'=>[ 'id'=> $___Ls->ls->rw["eclstssgm_lsts"] ],
									'sgm'=>[ 'id'=> $___Ls->ls->rw["id_eclstssgm"] ],
									'cl' => DB_CL_ID
								]);

								echo h2("Leads ").Spn(( (isN($pdt->tot->allw)? 0 : $pdt->tot->allw ) ), '', 'bdge');

							}
				        ?>
			        </td>
			         <td width="1%" align="left" nowrap="nowrap">
		                <?php
			            	echo HTML_Ls_Btn([
				            					'id',
			            						't'=>'md',
												'l'=>'_ldCnt({
													u:\''.FL_DT_GN.__t('ec_snd_rprt', true).ADM_LNK_DT.'\&__i='.$___Ls->ls->rw["id_eclstssgm"].'&_g_tot_tp=_ec_lsts_sgm_eml_tot\',
													pop:\'ok\',
													pnl:{
														e:\'ok\',
														s:\'l\',
														tp:\'h\'
													}
												})'
											]);
						?>
		            </td>
		            <td width="1%" align="left" nowrap="nowrap">
		                <?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
		            </td>
		        </tr>
	        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>

	  </tbody>
	</table>

	<style>

		.Ls_Rg span.bdge{ color:#fff; background-color: #48006f; font-weight: 700; padding: 5px 10px; display: inline-block; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; margin-left: auto; margin-right: auto; }

	</style>


	<?php //$___Ls->_bld_l_pgs(); ?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>">

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

      	<div id="<?php echo $___Ls->fm->fld->id ?>">

			<?php

				$___Ls->_bld_f_hdr();
				$__sgm_g = $___Ls->_dvls([ 'id'=>'sgm_var', 'i'=>$_GET['_i'], 't'=>$___Ls->mdlstp->tp.'ec_lsts_sgm_var' ]);

			?>
			<?php echo HTML_inp_hd('eclstssgm_lsts', $___Ls->gt->isb); ?>

			<?php if($___Ls->dt->tot > 0){ ?>
				<?php
		        	$__id_rnd = Gn_Rnd(20);
		        	$__id_btn = '___edt_btn'.$__id_rnd;
		        	$__id_div = '___edt'.$__id_rnd;
		        	$__id_dtl = '___edt_dtl'.$__id_rnd;
		        ?>
				<div class="ln_1" id="<?php echo $__id_dtl; ?>">
					<div class="__bx_dt __fm_opt">
						<div class="__btn" style="z-index: 99999999; ">
					        <?php if( !_DtV() ){ ?>

					            <?php echo '<a href="'.Void().'" id="'.$__id_btn.'" class="___edt_btn">'.TX_EDIT.'</a>' ; ?>
					            <?php
									$CntWb .= '$("#'.$__id_btn.'").click(function(){
													$("#'.$__id_dtl.'").fadeOut("fast", function(){
														$("#'.$__id_div.'").fadeIn();
													});
												}); ';
								?>
					        <?php } ?>
						</div>
					</div>
					<?php echo h1( ctjTx($___Ls->dt->rw['eclstssgm_nm'],'in') ); ?>
				</div>
			<?php } ?>


            <div class="ln_1" id="<?php echo $__id_div; ?>" <?php if($___Ls->dt->tot > 0){ ?>style="display: none;"<?php } ?>>
	            <?php echo HTML_inp_tx('eclstssgm_nm', TX_NM, ctjTx($___Ls->dt->rw['eclstssgm_nm'],'in')); ?>
			</div>

          </div>
    </form>

    <?php if($___Ls->dt->tot > 0){ ?>

	    <!-- Inicia Segmentos -->
            <div class="ln _nowrp">
                <?php echo $__sgm_g->html ?>
            </div>
	    <!-- Finaliza Segmentos -->

    <?php } ?>

  </div>

</div>
<?php } ?>
<?php } ?>
