<?php 
if(class_exists('CRM_Cnx')){
	
	//$___Ls->cnx->cl = 'ok';
	$___Ls->img->dir = DMN_FLE_LRN;
	$___Ls->sch->f = 'id_lrn';
	$___Ls->new->w = 700;
	$___Ls->new->h = 500;
	$___Ls->edit->w = 700;
	$___Ls->edit->h = 500;
		
	$___Ls->_strt();
	$__tb = Php_Ls_Cln($_GET['Tb']);

	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_LRN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){
		 
		$Ls_Whr = "FROM ".TB_LRN." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>

<?php if(($___Ls->qry->tot > 0)){   ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
        	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <th width="30%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
            <th width="20%" <?php echo NWRP ?>><?php echo TX_DSC ?></th>
            <th width="20%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
	</thead>
	<tbody>
		<?php do { ?>
        <tr>
	        <td align="left" width="1%"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="30%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrn_tt'],'in'); ?></td>
			<td width="20%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrn_dsc'],'in'); ?></td>
			<td width="20%" align="left"><?php echo mBln($___Ls->ls->rw['lrn_e']); ?></td>
			<td width="10%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrn_fi'],'in'); ?></td>
			<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody> 
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<?php 
		
		$__tabs = [
				['n'=>'vd', 't'=>'lrn_vd', 'l'=>TX_VD],
				['n'=>'vd_play', 't'=>'lrn_vd_play', 'l'=>TX_VW]
			];
		
		$___Ls->_dvlsfl_all($__tabs);
		 
	?>
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> lead_data"> 
	  	
        <?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny lead_data_tb">
          	<ul class="TabbedPanelsTabGroup">
	            <?php echo $___Ls->tab->bsc->l ?>
	            <?php echo $___Ls->tab->vd->l ?>
	            <?php echo $___Ls->tab->vd_play->l ?>
	            <?php echo $___Ls->tab->vd_cl->l ?>
			</ul>
		  	<div class="TabbedPanelsContentGroup">
	        	<div class="TabbedPanelsContent">
	              	<div class="ln_1">  	
	                    <div class="col_1"> 
	                      	<?php echo HTML_inp_tx('lrn_tt', TX_TT , ctjTx($___Ls->dt->rw['lrn_tt'],'in'), FMRQD); ?>     
	                      	<?php echo OLD_HTML_chck('lrn_e', TX_ACTV, $___Ls->dt->rw['lrn_e'], 'in'); ?>                       
	                    </div>
	                    <div class="col_2"> 
	            			<?php echo HTML_textarea('lrn_dsc', TX_DSC, ctjTx($___Ls->dt->rw['lrn_dsc'],'in'), '');  ?>         
	                    </div>
	              	</div>    
	        	</div>
				<div class="TabbedPanelsContent">
	                <div class="ln">
                        <?php echo $___Ls->tab->vd->d ?>
                    </div> 
	            </div>     
	            
	            <div class="TabbedPanelsContent">
	                <div class="ln">
                        <?php echo $___Ls->tab->vd_play->d ?>
                    </div> 
	            </div>
	            
	        
	            
          	</div>
  
            <style>
	        	.lead_data .VTabbedPanels .TabbedPanelsTab._vd{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lrn_vd.svg); }
				.lead_data .VTabbedPanels .TabbedPanelsTabSelected._vd{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lrn_vd_w.svg); }
				
				.lead_data .VTabbedPanels .TabbedPanelsTab._vd_play{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lrn_vd_play.svg); }
				.lead_data .VTabbedPanels .TabbedPanelsTabSelected._vd_play{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lrn_vd_play_w.svg); }
            </style>
        </div>
        
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>