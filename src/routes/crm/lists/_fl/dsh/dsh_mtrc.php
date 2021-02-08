<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = TX_MTRC;
	$___Ls->sch->f = 'dshmtrc_tt, dshmtrc_qry_tt, dshmtrc_qry_vl, dshmtrc_qry_id, dshmtrc_qry_ctg, dshmtrc_fi';
	//$___Ls->cnx->cl = 'ok';
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->img->dir = DMN_FLE_GRPH_MTRC;
	$___Ls->_strt();

	
	if(!isN($___Ls->gt->i)){
		$_qry_cl = ", (SELECT GROUP_CONCAT(dshmtrccl_cl) FROM dsh_mtrc_cl WHERE dshmtrccl_mtrc = id_dshmtrc ) AS _cl";
		$_qry_sub = ", (SELECT GROUP_CONCAT(dshdmsmtrc_dms) FROM "._BdStr(DBM).TB_DSH_DMS_MTRC." WHERE dshdmsmtrc_mtrc = id_dshmtrc) AS _dms";	
		$___Ls->qrys = sprintf("SELECT * $_qry_sub $_qry_cl FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")); 
	}elseif($___Ls->_show_ls == 'ok'){ 	 
		
		$_Cl_Dt_Id = $__dt_cl->id;
		
		$_qry_sub = ", (SELECT GROUP_CONCAT(dshdms_tt) FROM "._BdStr(DBM).TB_DSH_DMS_MTRC.","._BdStr(DBM).TB_DSH_DMS." WHERE dshdmsmtrc_dms = id_dshdms AND dshdmsmtrc_mtrc = id_dshmtrc) AS _dms";
		//$_qry_cl = ", (SELECT GROUP_CONCAT(dshmtrccl_cl) FROM dsh_mtrc_cl WHERE dshmtrccl_mtrc = id_dshmtrc ) AS _cl";
		$Ls_Whr = "FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $_qry_sub $_qry_cl $Ls_Whr ";
		
	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_DIMNS ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_TTLCNST ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_VLRCSNT ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_CNSLTID?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_CNSTCTG ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_tt'],'in'),150,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap">
		    <?php 
			    $_grph = explode(",", $___Ls->ls->rw['_dms']);
			    foreach($_grph as $_v){
				    echo Spn(ctjTx("( ".$_v,'in')." )",'','_f').HTML_BR;
			    }
			?>
		</td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_qry_tt'],'in'),150,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_qry_vl'],'in'),150,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_qry_id'],'in'),150,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_qry_ctg'],'in'),150,'Pt', true); ?></td>
    	<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshmtrc_fi'],'in'),150,'Pt', true); ?></td>
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
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

      <?php $___Ls->_bld_f_hdr(); ?>

       <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
          <div class="col_1">
          	<?php echo HTML_inp_tx('dshmtrc_tt', TX_TT, ctjTx($___Ls->dt->rw['dshmtrc_tt'],'in'), FMRQD);?>
          	<?php echo LsDms('dshmtrc_dms','id_dshdms', $___Ls->dt->rw['_dms'], TX_DIMNS, 1, 'ok'); $CntWb .= JQ_Ls('dshmtrc_dms',FM_LS_ASGNTRS);  ?>
          	<a class="exe_qry"><?php echo TX_EJCTCNS ?></a>
	        <?php echo HTML_BR; ?>
	        <span class="tot_qry"></span>
	        <div class="div_qry">
		        <table class="tble_qry">
			        <tr>
				        <thead>
					        <th nowrap="nowrap"><?php echo TX_ID; ?></th>
					        <th nowrap="nowrap"><?php echo TX_TTLO; ?></th>
						    <th nowrap="nowrap"><?php echo TX_VL; ?></th>
					        <th nowrap="nowrap"><?php echo TX_CTGR; ?></th>
					        <th nowrap="nowrap"><?php echo TX_CL; ?></th>
				        </thead>
				        <tbody class="tbody_qry">
				        </tbody>
			        </tr>
		        </table>
	        </div>
		  <div id="test_g"></div>
          </div>
          <div class="col_2">
	        <?php echo HTML_textarea('dshmtrc_qry', '', ctjTx($___Ls->dt->rw['dshmtrc_qry'],'in'), '', '',''); ?>
	        <?php echo HTML_inp_tx('dshmtrc_qry_tt', TX_TT, ctjTx($___Ls->dt->rw['dshmtrc_qry_tt'],'in'), '');?>
	        <?php echo HTML_inp_tx('dshmtrc_qry_vl', TX_VLE, ctjTx($___Ls->dt->rw['dshmtrc_qry_vl'],'in'), '');?>
	        <?php echo HTML_inp_tx('dshmtrc_qry_id', TX_ID, ctjTx($___Ls->dt->rw['dshmtrc_qry_id'],'in'), '');?>
	        <?php echo HTML_inp_tx('dshmtrc_qry_ctg', TX_CTG, ctjTx($___Ls->dt->rw['dshmtrc_qry_ctg'],'in'), '');?>
	      
	        <?php echo LsCl('dshmtrccl_cl','id_cl', $___Ls->dt->rw["_cl"], TX_CL, 2, 'ok'); $CntWb .= JQ_Ls('dshmtrccl_cl',TX_CL); ?>
	        
	      </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
	.exe_qry{ cursor: pointer; }
	.div_qry{ border: 1px solid #e1e1e1 ; display: none; }
	.tble_qry{ text-align: center; width: 100%; }
	.exe_qry{ display: block; text-align: center; text-align: center;  width: 30%; 
		background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mysql.svg');
		color:#a9a9a9 !important;
		text-transform:uppercase;
		font-family:Economica;
		font-size:12px;
		font-weight:300;
		margin-right:10px;
		border-radius: 20px 20px 20px 20px;
		-moz-border-radius: 20px 20px 20px 20px;
		-webkit-border-radius: 20px 20px 20px 20px;
		background-color: #ffffff;
		margin-left: auto;
		margin-right: auto;
		padding: 10px 35px 10px 35px;
		text-decoration: none !important;
		background-size: 25px auto;
		background-position: 10px center;
		background-repeat: no-repeat;
		border: 1px solid #bbbbbb !important;
		white-space: nowrap;
		background-color: transparent !important;
		margin-top: 30px;
	}
	.exe_qry:Hover{
		color:#000000 !important;
		text-decoration: none;
		border: 1px solid #232323;
	}
	.tble_qry td, .tble_qry tr, .tot_qry{ font-family: Economica; }
	.tble_qry th{ color:#8e8e8e; }
	.Rw_1{ background:#CFECFF; }
	.Rw_2{ background:#FFF; }
	.tble_qry tr{ cursor: pointer; }
	.tble_qry tr:Hover{ background: #FFC; }
	
</style>
<?php 
	$CntWb .= "
		$('.exe_qry').click(function(){
			$('.tbody_qry').html('');
			$('.div_qry').show('');
			var _qry = $('#dshmtrc_qry').val();
			var _tt = $('#dshmtrc_qry_tt').val();
			var _vl = $('#dshmtrc_qry_vl').val();
			var _id = $('#dshmtrc_qry_id').val();
			var _ctg = $('#dshmtrc_qry_ctg').val();
			
			SUMR_Main.ld_abrt({ p:'mtrc' });
						
			SUMR_Main.ibx['mtrc'] =$.ajax({
								type:'POST',
								url: '".Fl_Rnd(FL_JSON_GN.__t('dsh_mtrc',true))."',
								data: {
										'_tp':'mtrc_qry',
										'_qry': _qry,
										'_tt': _tt,
										'_vl': _vl,
										'_id': _id,
										'_ctg': _ctg
									  },
								beforeSend: function() {
								 				 },
								success:function(rsp){
									if(rsp.e == 'ok'){
										var _row = 1;
										for(let i = 0; i < rsp._tt.length; i++){
											$('.tbody_qry').append('<tr class=\"Rw_'+_row+'\"><td>'+rsp._id[i]+'</td><td>'+rsp._tt[i]+'</td><td>'+rsp._vl[i]+'</td><td>'+rsp._ctg[i]+'</td></tr>');
											$('.tot_qry').html('Total '+rsp._tot);
											if(_row == 1){ _row = 2; }else if(_row == 2){ _row = 1; }
										}
									}else{
										swal('Error!', rsp.w, 'error'); 
									}
								}
							})
		});
	";
?>
<?php } ?>
<?php } ?>
