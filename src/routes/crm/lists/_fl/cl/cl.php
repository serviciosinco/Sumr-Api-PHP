<?php 
if(class_exists('CRM_Cnx') && ChckSESS_superadm()){
	
	$___Ls->tt = _Cns('TX_CL');
	$___Ls->img->dir = DMN_FLE_CL;
	$___Ls->sch->f = '_cl.cl_nm';
	
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->ls->lmt = 1000;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *, (SELECT cltag_vl FROM ".TB_CL_TAG." WHERE cltag_cl = id_cl AND cltag_sistag = 271) AS __clr
							FROM ".TB_CL." 
							WHERE ".$___Ls->ik." = %s 
							LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){
		
		$Ls_Whr = "	FROM ".TB_CL." AS _cl 
						 LEFT JOIN ".TB_CL." AS _rsllr ON _cl.cl_rsllr = _rsllr.id_cl
					WHERE _cl.".$___Ls->ino." != '' ".$___Ls->sch->cod." 
					ORDER BY _cl.cl_nm ASC";
					
		$___Ls->qrys = "SELECT 	_cl.id_cl AS id_cl, 
								_cl.cl_enc AS cl_enc,
								_cl.cl_nm AS cl_nm,
								_rsllr.cl_nm AS rsllr_nm,
				   		(SELECT cltag_vl FROM ".TB_CL_TAG." WHERE cltag_cl = _cl.id_cl AND cltag_sistag = 271) AS __clr,
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
		<th width="48%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="48%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
    <tr>  
		<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
		<td width="48%" align="left" <?php echo $_clr_rw ?>>
			<?php 
				echo ctjTx($___Ls->ls->rw['cl_nm'],'in');
				if(!isN($___Ls->ls->rw['rsllr_nm'])){ echo Spn( ctjTx($___Ls->ls->rw['rsllr_nm'],'in'), 'ok', 'rsllr'); }
			?>
		</td>
		<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['__clr'].'; ') . ctjTx($___Ls->ls->rw['__clr'],'in');?>
		</td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
	<div class="FmTb __cl_detail">
	  <div id="<?php  echo DV_GNR_FM ?>">

		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
		<?php $___Ls->_bld_f_hdr(); ?>    

	 	<div class="mapbck _ovrmap_emp" style="height:auto;">		   
            <div class="_ovrmap_logo">
            	<?php 
	            	$__cl_logo = _ImVrs([ 'img'=>$___Ls->dt->rw['cl_img'], 'f'=>DMN_FLE_CL ]);
	            	echo _DivLogoTM([ 'i'=>$__cl_logo->th_400, 'c'=>$___Ls->dt->rw['__clr'] ]); 
	            ?>
            </div>
        </div> 
        
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			
        <div class="">
	        <div></div>
	        <div></div>
	        <div></div>
        </div> 
             
        <?php 
       		
       		$___Ls->_dvlsfl_all([
				['n'=>'tag', 't'=>'cl_tag', 'l'=>TX_TAGS],
				['n'=>'are', 't'=>'cl_are', 'l'=>TX_ARDPTOFCLT],
				['n'=>'mdlstp','t'=>'cl_mdls_tp', 'l'=>TX_MDLBS],
				['n'=>'mdls', 't'=>'cl_mdls', 'l'=>MDL_S],
				['n'=>'dmn', 't'=>'cl_dmn', 'l'=>TX_DMNS],
				['n'=>'ftp', 't'=>'cl_ftp', 'l'=>TX_CLFTP],
				['n'=>'flj', 't'=>'cl_flj', 'l'=>TX_CLFLJ],
				['n'=>'bd', 't'=>'cl_bd',   'l'=>TX_BD],
				['n'=>'scrpt', 't'=>'cl_scrpt', 'l'=>TX_SCRPT],
				['n'=>'app', 't'=>'cl_app', 'l'=>TX_CLAPP],
				['n'=>'wdgt', 't'=>'cl_wdgt', 'l'=>TX_WDGT],
				['n'=>'wthsp', 't'=>'cl_wthsp', 'l'=>'Whatsapp'],
				['n'=>'store', 't'=>'store', 'l'=>'Tienda Virtual'],
				['n'=>'aws_acc', 't'=>'cl_aws_acc', 'l'=>'Aws Accounts'],
				['n'=>'gtwy_pay', 't'=>'cl_gtwy_pay', 'l'=>'Gateway Pay'],
				['n'=>'vtex', 't'=>'cl_vtex', 'l'=>'VTex']
			],[
				'idb'=>'ok',
				'icn_sty'=>'d2'
			]);
								
		?>
		<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels TbGnrl mny">
            <ul class="TabbedPanelsTabGroup">
	            <?php echo $___Ls->tab->bsc->l ?>
	            <?php echo $___Ls->tab->tag->l ?>
	            <?php echo $___Ls->tab->are->l ?>
	            <?php echo $___Ls->tab->mdlstp->l ?>
	            <?php echo $___Ls->tab->mdls->l ?>
	            <?php //echo $___Ls->tab->us->l ?>
	            <?php echo $___Ls->tab->dmn->l ?>
	            <?php echo $___Ls->tab->ftp->l ?>
	            <?php echo $___Ls->tab->flj->l ?>
	            <?php echo $___Ls->tab->bd->l ?>
	            <?php echo $___Ls->tab->scrpt->l ?>
	            <?php echo $___Ls->tab->app->l ?>
	            <?php echo $___Ls->tab->wdgt->l ?>
				<?php echo $___Ls->tab->wthsp->l ?>
				<?php echo $___Ls->tab->store->l ?>
				<?php echo $___Ls->tab->aws_acc->l ?>
				<?php echo $___Ls->tab->gtwy_pay->l ?>
				<?php echo $___Ls->tab->vtex->l ?>
            </ul>
            <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">
                
                    <div class="ln_1">
			          	<div class="col_1">
				          	<?php echo HTML_inp_tx('cl_nm', TX_NM , ctjTx($___Ls->dt->rw['cl_nm'],'in'), FMRQD); ?>						         
				          	<?php echo HTML_inp_tx('cl_sbd', TX_SBDM , ctjTx($___Ls->dt->rw['cl_sbd'],'in'), FMRQD); ?>
				          	<?php echo HTML_inp_tx('cl_dir', TX_ADRS , ctjTx($___Ls->dt->rw['cl_dir'],'in'), FMRQD); ?>
				          	<?php echo HTML_inp_tx('cl_web', TX_WEB , ctjTx($___Ls->dt->rw['cl_web'],'in'), FMRQD); ?>
				          	<?php echo LsCl('cl_rsllr','id_cl', $___Ls->dt->rw['cl_rsllr'], TX_RSLLR, 2, '','', [ 'ex'=>$___Ls->dt->rw['id_cl'] ]); $CntWb .= JQ_Ls('cl_rsllr',TX_RSLLR); ?>
				          	<?php echo OLD_HTML_chck('cl_on', TX_ACTV, $___Ls->dt->rw['cl_on'], 'in'); ?>
				          					          	
							<ul class="upl_img_opt">
								<li><button class="_anm upl_img upl_bck" id="<?php echo 'upl_bck_'.$___Ls->fm->id; ?>"> <span class="_anm">Background</span></button></li>
								<li><button class="_anm upl_img upl_svg" id="<?php echo 'upl_svg_'.$___Ls->fm->id; ?>"> <span class="_anm">Logo SVG</br> (White)</span></button></li>
								<li><button class="_anm upl_img upl_svg_lght" id="<?php echo 'upl_svg_lght_'.$___Ls->fm->id; ?>"> <span class="_anm">Logo (Fondo Blanco)</span></button><li>
								<li><button class="_anm upl_img upl_rsllr" id="<?php echo 'upl_rsllr_'.$___Ls->fm->id; ?>"> <span class="_anm">Reseller</span></button><li>
								<li><button class="_anm upl_img upl_ico" id="<?php echo 'upl_ico_'.$___Ls->fm->id; ?>"> <span class="_anm">.ICO</span></button><li>
								<li><button class="_anm upl_img upl_bck_app" id="<?php echo 'upl_bck_app_'.$___Ls->fm->id; ?>"> <span class="_anm">App Background</span></button><li>
							</ul>
								
							<?php 
								
								$_f = HTML_ClrBxImg('cl_bck').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_bck_'.$___Ls->fm->id, 'u'=>$_f ]);
								
								$_f = HTML_ClrBxImg('cl_lgo').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_svg_'.$___Ls->fm->id, 'u'=>$_f ]);
								
								$_f = HTML_ClrBxImg('cl_lgo_lght').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_svg_lght_'.$___Ls->fm->id, 'u'=>$_f ]);
								
								
								$_f = HTML_ClrBxImg('cl_lgo_rsllr').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_rsllr_'.$___Ls->fm->id, 'u'=>$_f ]);
								
								$_f = HTML_ClrBxImg('cl_lgo_ico').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_ico_'.$___Ls->fm->id, 'u'=>$_f ]);
								
								
								$_f = HTML_ClrBxImg('cl_bck_app').$___Ls->uidn;
								$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_bck_app_'.$___Ls->fm->id, 'u'=>$_f ]);
								
							?>
	  	
			          	</div>
					  	<div class="col_2">
							 
						  	<?php if($___Ls->dt->tot > 0){ ?>
								<button id="cldata_publish" class="cldata_publish">Publicar JSON</button>
								<?php 
	
									$CntJV .= "	
									

										function Dom_Cl_Rbld(){
											
											$('#cldata_publish').off('click').click(function(e){

												e.preventDefault();
										
												if(e.target != this){ 
													e.stopPropagation(); return false;
												}else{

													var _this = $(this);

													_Rqu({ 
														f: 'prc',
														t: 'cl',
														cl_enc: '".$___Ls->dt->rw['cl_enc']."',
														MM_rebuild: 'EdClJson',
														_bs:function(){ _this.addClass('_ld'); },
														_cm:function(){ _this.removeClass('_ld'); },
														_cl:function(d){
															if(!isN(d)){
																if(!isN(d.e) && d.e == 'ok'){ _this.addClass('rdy'); }
															}
														}
													});
												}
											});	

										}
										
										Dom_Cl_Rbld();

									";

								?>
							<?php } ?>

				         	<?php echo h2( TX_ARS.'/'.TX_DPTOS); ?>
				         	<?php echo h2( MDL_S_TP); ?>
				         	<?php echo h2( TX_SUBMD); ?>
				         	<?php echo h2( TX_USRS); ?>
				         	
			          	</div>
			        </div>
                  
                </div>
                <?php if($___Ls->dt->tot == 1){  ?>
                <div class="TabbedPanelsContent">    
	                <?php echo $___Ls->tab->tag->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->are->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->mdlstp->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->mdls->d ?>
				</div>
				<!--<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->us->d ?>
				</div> -->
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->dmn->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->ftp->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->flj->d ?>
				</div>
                <div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->bd->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->scrpt->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->app->d ?>
				</div>
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->wdgt->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->wthsp->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->store->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->aws_acc->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->gtwy_pay->d ?>
				</div> 
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->vtex->d ?>
				</div> 
                <?php } ?>
            </div>
        </div>
		<style>
			:root{--cl-dt-clr:<?php echo $___Ls->dt->rw['__clr']; ?>;}
			.__cl_detail .VTabbedPanels .TabbedPanelsTab:first-child{ background-color:var(--cl-dt-clr) !important; background-image: url(<?php echo $__cl_logo->th_400; ?>); background-size: 100% auto; opacity: 1; }
        </style>
	  </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>