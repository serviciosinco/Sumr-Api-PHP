<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'orgsdsarr_tt';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("
			SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR." 
			INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
			INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
			WHERE ".$___Ls->ik." = %s LIMIT 1
			", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		
		$Ls_Whr = " FROM "._BdStr(DBM).TB_ORG_SDS_ARR."
					INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON id_cllcl = orgsdsarr_lcl
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
					INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
					WHERE ".$___Ls->ino." != ''
					AND  org_enc = '{$__i}'
					".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	
	}
	
	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
		    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    	<th width="20%" <?php echo NWRP ?>><?php echo "Titulo" //Ricardo ?></th>
				<th width="20%" <?php echo NWRP ?>><?php echo "Valor" //Ricardo ?></th>
		    	<th width="20%" <?php echo NWRP ?>><?php echo "Local" ?></th>
		    	<th width="5%" <?php echo NWRP ?>><?php echo 'Estado' ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo 'Valor Mes' ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo 'No reporta' ?></th>
		    	<th width="10%" <?php echo NWRP ?>><?php echo 'Fecha inicial' ?></th>
		    	<th width="10%" <?php echo NWRP ?>><?php echo 'Fecha final' ?></th>
				
		    	<th width="1%" <?php echo NWRP ?>></th>
		  	</tr>
		  	<?php do { ?>
		  	<tr> 
				<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
				<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarr_tt'],'in'),40); ?></td>
				<td width="20%" align="left" nowrap="nowrap"><?php echo cnVlrMon('', $___Ls->ls->rw['orgsdsarr_vl']); ?></td>
				<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cllcl_tt'],'in'),40); ?></td>
				<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx( ( ($___Ls->ls->rw['orgsdsarr_est'] == 1)? "Activo" : "Inactivo" ) ,'in'),40); ?></td>
				<td width="5%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['orgsdsarr_vl_mnt']),'',mBln($___Ls->ls->rw['orgsdsarr_vl_mnt'])); ?></td> 
				<td width="5%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['orgsdsarr_vl_rpt']),'',mBln($___Ls->ls->rw['orgsdsarr_vl_rpt'])); ?></td> 
				<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarr_vig_fi'],'in'),40); ?></td>
				<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarr_vig_fn'],'in'),40); ?></td>
				<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
		  	</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb">
	  <div id="<?php  echo DV_GNR_FM ?>"> 
		                                         
	    

		  	<?php
					
				$__tabs = [
					['n'=>'lcl', 't'=>'org_sds_arr_lcl', 'l'=>'Locales Anexos']
				];
				
				$___Ls->_dvlsfl_all($__tabs);
			?>
			<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
			<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny arr_data">
				
				<ul class="TabbedPanelsTabGroup" style="width: 70px !important;border-right: 1px solid #eeeeee !important;">						
					<?php echo $___Ls->tab->bsc->l ?>
					<?php echo $___Ls->tab->lcl->l ?>									            
				</ul>
				<div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent">

						<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
							<?php $___Ls->_bld_f_hdr(); ?> 
								<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> app_dashboard">			
									<div class="ln_1">
										
										<div class="col_1">
											<?php 
												echo HTML_inp_tx('orgsdsarr_tt', "Titulo (Opcional) " , ctjTx($___Ls->dt->rw['orgsdsarr_tt'],'in'));
												echo LsClLcl(['id'=>'orgsdsarr_lcl', 'v'=>'id_cllcl', 'va'=>$___Ls->dt->rw['orgsdsarr_lcl'], 'rq'=>1 ]); $CntWb .= JQ_Ls('orgsdsarr_lcl', 'Seleccione Local');
												echo HTML_inp_tx('orgsdsarr_vl', "Valor" , ctjTx($___Ls->dt->rw['orgsdsarr_vl'],'in'), FMRQD_NM);
											?>
											<div class="__orgsdsarr_vl">
												<span class="_dlr">$</span>
												<span class="_vl"><?php echo number_format($___Ls->dt->rw['orgsdsarr_vl'], 0, ",", "."); ?></span>
											</div>	
										</div>
										<div class="col_2">
											<?php 
												echo SlDt([ 'id'=>'orgsdsarr_vig_fi', 'va'=>$___Ls->dt->rw['orgsdsarr_vig_fi'], 'rq'=>'no', 'ph'=>'Fecha Inicio', 'lmt'=>'no' ]);
												echo SlDt([ 'id'=>'orgsdsarr_vig_fn', 'va'=>$___Ls->dt->rw['orgsdsarr_vig_fn'], 'rq'=>'no', 'ph'=>'Fecha Final', 'lmt'=>'no' ]);
												echo LsOrgSds([ 'id'=>'orgsdsarr_orgsds', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsds_enc'], 'rq'=>1, 'org'=>$__i ]);
											?>
										</div>
										<?php 
											echo OLD_HTML_chck('orgsdsarr_est', 'Activo', ( (!isN($___Ls->dt->rw['orgsdsarr_est']))? $___Ls->dt->rw['orgsdsarr_est'] : 1 ) );
											echo OLD_HTML_chck('orgsdsarr_vl_mnt', 'Valor mes', $___Ls->dt->rw['orgsdsarr_vl_mnt'] );
											echo OLD_HTML_chck('orgsdsarr_vl_rpt', 'No reporta', $___Ls->dt->rw['orgsdsarr_vl_rpt'] );
											$CntWb .= JQ_Ls('orgsdsarr_orgsds');
										?>
									</div>
								</div>
						</form>	

						<?php if($___Ls->dt->tot > 0){ ?>
					
							<div style="margin-top: 80px;">
								<?php
									$__act_icn = $___Ls->_dvls([ 'id'=>'icn', 'i'=>$___Ls->dt->rw[$___Ls->ik], 't'=>'org_sds_arr_rg' ]);
									echo $__act_icn->html;
								?>
							</div>
						
						<?php } ?>

					</div>
					<div class="TabbedPanelsContent">
							<div class="ln">
								<?php echo $___Ls->tab->lcl->d ?>
							</div> 
					</div>
				</div>
			</div>
	

		

	  </div>
	</div>   
	
	<?php 

		$CntWb .= "
					try{
						$('#orgsdsarr_vl').keyup(function(p){
							if( !isN($(this).val()) ){
								if( isNaN($(this).val()) ){
									$('.__orgsdsarr_vl ._vl').html('Numero no valido');
									$('.__orgsdsarr_vl ._vl').addClass('_err');
								}else{
									$('.__orgsdsarr_vl ._vl').removeClass('_err');
									let _num_frmt = $(this).val().replace(/\./g,'');
									_num_frmt = _num_frmt.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
									_num_frmt = _num_frmt.split('').reverse().join('').replace(/^[\.]/,'');
									$('.__orgsdsarr_vl ._vl').html(_num_frmt);
								}
							}else{
								$('.__orgsdsarr_vl ._vl').html(0);
							}
						});
					}catch(e) {
						SUMR_Main.log.f({ t:'Error en div __orgsdsarr_vl:', m:e });
					}
		";

	?>

	<style>
		.__orgsdsarr_vl{ width: 100%; height: 80px; border: 1px solid #f6f5f6; text-align: center; padding-top: 20px; }

		.__orgsdsarr_vl > span{ font-family: Economica; color: #759775; font-size: 20px; }
		.__orgsdsarr_vl > span._dlr{ font-size: 25px!important; }

		.__orgsdsarr_vl > span._vl._err{ color:#b75757!important; }
	</style>
	
<?php } ?>
<?php } ?>

<style>					        

.arr_data ul{ padding: 0px 0;background-color: transparent !important; display: inline-block;}
.arr_data ul li{ height: 50px;margin-left: 5px;list-style-type: none;cursor:pointer; }
.arr_data .TabbedPanelsContentGroup{ width: calc(100% - 75px) !important;display: inline-block;vertical-align: top; padding: 0 20px !important } 
.arr_data .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg); }
.arr_data .TabbedPanelsTab.TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg); opacity: 1; }

.arr_data .TabbedPanelsTab._lcl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>price_b.svg); }
.arr_data .TabbedPanelsTab.TabbedPanelsTabSelected._lcl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>price.svg); opacity: 1; }

.arr_data .TabbedPanelsTab {background-size: 60% auto !important;background-repeat: no-repeat;background-position: center;opacity: 0.5;}
</style>