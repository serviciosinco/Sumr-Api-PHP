<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'store_nm';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->img->dir = DMN_FLE_CL_STORE;
	$___Ls->img->svg = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBS).TB_STORE." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBS).TB_STORE." 
						 INNER JOIN "._BdStr(DBM).TB_CL." AS _cl ON store_cl = _cl.id_cl
					WHERE _cl.cl_enc != '' AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	
	}
	
	$___Ls->_bld(); 
	$___days_week = _WkDays();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_BTSTR ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_HDR?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['store_nm'],'in'),40,'Pt', true); ?></td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['store_clr_strt'].'; ') . ctjTx($___Ls->ls->rw['store_clr_strt'],'in');?>
					</td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['store_clr_hdr'].'; ') . ctjTx($___Ls->ls->rw['store_clr_hdr'],'in');?>
					</td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb store_detail">
	  <div id="<?php  echo DV_GNR_FM ?>"> 
                                       
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
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
			<?php 
				
				$___Ls->_dvlsfl_all([
					['n'=>'brnd', 't'=>'store_brnd', 'l'=>TX_MRCS],
					['n'=>'ctg', 't'=>'store_ctg', 'l'=>TX_CTGR]
				],[
					'idb'=>'ok',
					'icn_sty'=>'d2'
				]);
									
			?>
			<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels TbGnrl mny">
				<ul class="TabbedPanelsTabGroup">
					<?php echo $___Ls->tab->bsc->l ?>
					<?php echo $___Ls->tab->brnd->l ?>
					<?php echo $___Ls->tab->ctg->l ?>
				</ul>
				<div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent">
							<?php echo HTML_inp_hd('store_cl', $__i); ?>
							<?php echo HTML_inp_tx('store_nm', TX_NM, ctjTx($___Ls->dt->rw['store_nm'],'in')); ?>
							<?php echo HTML_inp_tx('store_pml', TX_PML, ctjTx($___Ls->dt->rw['store_pml'],'in')); ?>
							<?php if($___Ls->dt->tot > 0){ ?>
								<div class="opt">
									<button id="store_publish" class="store_button publish">Publicar</button>
									<button id="store_test" class="store_button test">Test</button>
								</div>
							<?php } ?>
					</div>
					<?php if($___Ls->dt->tot == 1){  ?>
					<div class="TabbedPanelsContent">    
						<?php echo $___Ls->tab->brnd->d ?>
					</div>
					<div class="TabbedPanelsContent">
						<?php echo $___Ls->tab->ctg->d ?>
					</div>
					<?php } ?>                          
				</div>
			</div>
			<style>
				
				.store_detail .VTabbedPanels{ display: flex; }
				.store_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width: 55px !important; }
				.store_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
				.store_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; padding-left: 20px !important; }
				.store_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
				.store_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 40px; min-width: 40px; max-width: 40px; background-repeat: no-repeat; opacity: 0.3; cursor:pointer; } 
				.store_detail .VTabbedPanels .TabbedPanelsTabSelected,
				.store_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
				
				.store_detail .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>store_main.svg); }
				.store_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_brnd{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>store_brnd.svg); }
				.store_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_ctg{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>store_ctg.svg); }
				
			</style>
		  
	    </form>			
			
	  </div>
	</div> 
	
	<?php 
	
		$CntJV .= "	
		

			function Dom_Rbld(){
				
				$('#store_publish').off('click').click(function(e){

					e.preventDefault();
			
					if(e.target != this){ 
						e.stopPropagation(); return false;
					}else{

						var _this = $(this);

						_Rqu({ 
							f: 'prc',
							t: 'store',
							store_enc: '".$___Ls->dt->rw['store_enc']."',
							MM_rebuild: 'EdStore',
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


				$('#store_test').off('click').click(function(e){

					e.preventDefault();
			
					if(e.target != this){
						e.stopPropagation(); return false;
					}else{
						var win = window.open('".DMN_WDGT."test/?id=".$___Ls->dt->rw['store_enc']."', '_new');
  						win.focus();
					}
					
				});	

			}
			
			Dom_Rbld();

		";

	?>

<?php } ?>
<?php } ?>