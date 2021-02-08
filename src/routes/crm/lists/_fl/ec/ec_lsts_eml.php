<?php

if(class_exists('CRM_Cnx')){


	$___Ls->cnx->cl = 'ok';
	$___Ls->tpr = 'ec_lsts_eml';
	$___Ls->sch->f = 'cnteml_eml';
	$___Ls->edit->big = 'ok';
	$___Ls->ino = 'id_eclstseml';
	$___Ls->ik = 'eclstseml_enc';
	$___Ls->_strt();


	if(_SbLs_ID('i')){

		$__fl .= " AND eclstseml_lsts = ( 	SELECT id_eclsts
											FROM "._BdStr(DBM).MDL_EC_LSTS_BD."
											WHERE eclsts_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
										) ";
	}


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT *
								FROM ".TB_EC_LSTS_EML."
									 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
									 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
								WHERE eclstseml_enc = %s LIMIT 1", GtSQLVlStr($_GET['_i'], "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "	FROM ".TB_EC_LSTS_EML."
						".GtSlc_QryExtra(['t'=>'tb', 'col'=>'eclstseml_tp', 'als'=>'t'])."
						INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstseml_lsts = id_eclsts
						INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
						INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
						INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
						INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
						INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
						INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts
					WHERE id_eclstseml != '' AND eclstsplcy_e=1 $__fl ".$___Ls->sch->cod."

					";

		$___Ls->qrys = "	SELECT *,
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t']).",
						(SELECT COUNT(DISTINCT id_cnteml) $Ls_Whr) AS __rgtot
						$Ls_Whr $Tot_Var
						GROUP BY id_cnteml
						ORDER BY cnt_nm ASC";

	}

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  	<thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN //TX_FM_No ?></th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_CNTSNDI; ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
            <th width="25%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
        </tr>
  	</thead>
  	<tbody>
		<?php do { ?>
		<?php   if( 	mBln($___Ls->ls->rw['cntplcy_sndi']) != 'ok' ||
			    		mBln($___Ls->ls->rw['clplcy_e']) != 'ok' ||
			    		mBln($___Ls->ls->rw['cnteml_rjct']) == 'ok' ||
					mBln($___Ls->ls->rw['cntemlplcy_sndi']) != 'ok' ||
					$___Ls->ls->rw['cnteml_est'] != _CId('ID_SISEMLEST_ACT')
				)
				{

				    $__cls_del = 'del';

				}else{

					$__cls_del = '';

				}

				$__eml_nrml = 	_plcy_scre([
					't'=>'eml',
					'v'=>$___Ls->ls->rw['cnteml_eml'],
					'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
				]);

				$__fnm_nrml = 	_plcy_scre([
					't'=>'nm',
					'nm'=>$___Ls->ls->rw['cnt_nm'],
					'ap'=>$___Ls->ls->rw['cnt_ap'],
					'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
				]);

		?>
        <tr class="<?php echo $__cls_del; ?>">

            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_DteHTML(['d'=>$___Ls->ls->rw['eclstseml_fi'], 'nd'=>'ok', 'br'=>'ok' ]), '', '_f'); ?></td>
            <td width="1%" <?php echo NWRP.$_clr_rw ?> style="text-align: center; ">
	        	<?php

	            	$__sis_cld = LsSis_Cld([ 'id'=>'St_'.$___Ls->ls->rw['id_eclstseml'], 'v'=>'id', 'va'=>$___Ls->ls->rw['cnteml_cld'], 'rq'=>2, 'dsbl'=>'ok' ]);

	            	$CntWb .= JQ_Ls('St_'.$___Ls->ls->rw['id_eclstseml'],FM_LS_CLD);
	            	echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
		        ?>
            </td>
            <td width="1%" align="center" <?php echo $_clr_rw ?>>
				<?php echo mBln($___Ls->ls->rw['cnt_sndi'],'in'); ?>
            </td>
            <td width="25%" align="center" <?php echo $_clr_rw ?>>
				<?php echo $__eml_nrml; ?>
            </td>
            <td width="25%" align="center" <?php echo $_clr_rw ?>>
				<?php echo $__fnm_nrml['first']; if(!isN($__fnm_nrml['last'])){ echo ' '.$__fnm_nrml['last']; } ?>
            </td>
            <td width="10%" align="center" <?php echo $_clr_rw ?>>
				<?php echo ctjTx($___Ls->ls->rw['tp_sisslc_tt'],'in'); ?>
            </td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody>
</table>


<style>

	.__rtio{ display: block; }
	.__rtio .star-rating-control{ display: flex; }

	.LsRgNw tr.del{ background-color: #ffeaea; text-decoration: line-through; }
	.LsRgNw tr td{ text-align: center; }

</style>


<?php
	$CntWb .= '$("._dtl").colorbox({ width:"60%", height:"50%", trapFocus:false, overlayClose:false, escKey:false}); ';
	$CntWb .= '$("._dt2").colorbox({ width:"800", height:"400" }); ';
	$CntWb .= JV_Blq(NULL);
?>

<?php $___Ls->_bld_l_pgs(); ?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>">


    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

     	<?php

			$___Ls->_bld_f_hdr();
			$__sgm_g = $___Ls->_dvls([ 'id'=>'sgm_var', 'i'=>$_GET['_i'], 't'=>$___Ls->mdlstp->tp.'ec_lsts_sgm_var' ]);

		?>

      	<?php if(/*ChckIRO() &&*/ ($row_Dt_Rg['eclstseml_lck_us'] != SISUS_ID) && $row_Dt_Rg['eclstseml_lck_us'] != '' && $row_Dt_Rg['eclstseml_lck_us'] != 0){ ?>
      		<?php $_dt_lck_us = GtUsDt($row_Dt_Rg['eclstseml_lck_us']); ?>
      		<h2 class="__advr">Contacto en gestión por <?php echo Strn($_dt_lck_us->nm_fll) ?></h2>
      		<div class="__ovr"></div>
      	<?php } ?>

      	<?php
			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";
			$__idtp_gst = '_gst';
		?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" id="<?php echo $_id_tbpnl.'_1' ?>"><?php echo Spn('','','_tt_icn _tt_icn_bsc').TX_DTSBSC ?></li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">

                 <div id="<?php echo $___Ls->fm->fld->id ?>">


                 		<?php if($___Ls->dt->tot == 0){ ?>
                              <div class="__sch_json" id="__sch_json">
                                    <?php $CntWb .= "


                                            $('#__sch_json_btn').click(function(){
											    var __i = $('#eclstseml_eml').val();
											    if($('#eclstseml_eml').valid()){ __sch_cnt(__i); }
                                            });


                                            function __sch_cnt(__i){
	                                           		$.post('".Fl_Rnd(FL_JSON_GN.__t('cnt',true))."',{
                                                        _i: __i
                                                    },
                                                    function(d, status){

                                                        if(d.e == 'ok'){

                                                           $('#eclstseml_eml').val(__i);

                                                            $('#eclstseml_nm').val(d.nm);
                                                            $('#eclstseml_ap').val(d.ap);


                                                            $('#__eml').html('<h1>'+__i+'</h1>');


                                                            $('#__fm_col').slideDown('slow');
                                                            $('#__sch_json').slideToggle(200);

                                                        }else if(d.e == 'no'){

															if(d.t_s == 'eml'){
																$('#eclstseml_eml').val(__i);
															}else{

															}


                                                            $('.cnt_frst').show();
                                                            $('#__fm_col').slideDown('slow');
                                                            $('#__sch_json').slideToggle(200);

                                                        }
                                                    });
                                            }
                                    ";
                                    ?>
                                    <div class="_c1"><?php echo HTML_inp_tx('eclstseml_eml', TT_FM_EML, '', FMRQD); ?></div>
                                    <div class="_c2"><input id="__sch_json_btn" name="__sch_json_btn" type="button" class="br_rds grd_blue" value="<?php echo TX_SCH ?>" /></div>
                              </div>
						<?php } ?>

                             <div class="ln_1" id="__fm_col" <?php if($___Ls->dt->tot == 0){ ?>style="display:none;"<?php } ?>>


                                    <div class=" <?php if( !_DtV() ){ ?> col_1 <?php } ?> ">

                                    	<input id="eclstseml_cnt" name="eclstseml_cnt" type="hidden" value="<?php echo $__dt_cnt->id ?>" />

                                            <?php echo HTML_inp_tx('eclstseml_nm', TT_FM_NM, ctjTx($row_Dt_Rg['cnt_nm'],'in'), FMRQD); ?>
                                            <?php echo HTML_inp_tx('eclstseml_ap', TT_FM_AP, ctjTx($row_Dt_Rg['cnt_ap'],'in'), FMRQD); ?>

                                        <div class="cnt_frst" style="display:none;">

                                        </div>


                                    </div>

                                    <?php if( !_DtV() ){ ?>
                                    <div class="col_2">
	                                    <?php echo HTML_inp_hd('eclstseml_idcnt', $row_Dt_Rg['id_cnt']); ?>
	                                    <?php echo HTML_inp_hd('eclstseml_dc', $row_Dt_Rg['cntdc_dc']); ?>
                    					<?php echo HTML_inp_hd('eclstseml_lsts', _SbLs_ID('i')); ?>

                                        <?php echo h2(TT_FM_EML) . '<div id="__eml">'. h1($row_Dt_Rg['cnteml_eml']).'</div>' ; ?>

                                    </div>
                                    <?php } ?>
                          </div>
            		</div>
            </div>


          </div>
        </div>


    </form>
  </div>


</div>



<?php } ?>
<?php } ?>