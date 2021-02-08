<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *,
									"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tag' ])."	
								FROM ".TB_CL_TAG."
									".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cltag_sistag', 'als'=>'t' ])."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	

	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Count = "	
					(	SELECT COUNT(*)
						FROM 

							".TB_CL_TAG." 
							INNER JOIN ".TB_CL." ON cltag_cl = id_cl
							INNER JOIN ".TB_SIS_SLC." ON cltag_sistag = id_sisslc	
						WHERE ".$___Ls->ino." != '' AND cl_enc = '$__i'	 ".$___Ls->sch->cod." 
						ORDER BY ".$___Ls->ino." DESC

						
					) AS ".QRY_RGTOT.",";
								
		$___Ls->qrys = "	SELECT *, 
						 ".$Ls_Count."
						 "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tag' ])."	 
					FROM 

						".TB_CL_TAG." 
						INNER JOIN ".TB_CL." ON cltag_cl = id_cl
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cltag_sistag', 'als'=>'t' ])."
							
					WHERE ".$___Ls->ino." != '' AND cl_enc = '$__i' ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC"; 
		
	}
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_VL ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>

  	<?php      
		$__tag = json_decode($___Ls->ls->rw['___tag']); 
		
		if(is_array($__tag)){
			foreach($__tag as $__tag_k=>$__tag_v){
				$__cl_tag[$__tag_v->key] = $__tag_v;	
			}
		}
    ?>
	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),100,'Pt', true); ?></td>
	    <td width="20%" align="left" nowrap="nowrap" style="color:<?php echo $___Ls->ls->rw['cltag_vl']; ?>;"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cltag_vl'],'in'),50,'Pt', true); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php print_r( $__cl_tag['tp']->vl ); ?></td>
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

  	 <?php 
			
  			 
	?>             
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
                <?php echo HTML_inp_hd('cltag_cl', $__i); ?>
                <?php 
	                $l = __Ls(['k'=>'sis_tag', 'id'=>'cltag_sistag', 'va'=>$___Ls->dt->rw['cltag_sistag'] , 'ph'=>FM_LS_SLGN]); 
	                echo $l->html; $CntWb .= $l->js;    
                ?> 
          </div>
          <div class="col_2">
	          	<?php 
		          	
		          	$__tag = json_decode($___Ls->dt->rw['___tag']); 
					
					if(is_array($__tag)){
						foreach($__tag as $__tag_k=>$__tag_v){
							$__cl_tag[$__tag_v->key] = $__tag_v;	
						}
					}
		          	
	          	?>
		  		<?php 
			  		
			  		foreach($__cl_tag as $__cl_tag_k=>$__cl_tag_v){
				  		if($__cl_tag_v->vl == 'clr'){ $__inp = 'clr'; }
				  		elseif($__cl_tag_v->vl == 'chk'){ $__inp = 'chk'; }
				  		elseif($__cl_tag_v->vl == 'txta'){ $__inp = 'are'; }	
			  		}
			  		
			  		if($__inp == 'clr'){
			  			echo HTML_inp_clr([ 'id'=>'cltag_vl', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['cltag_vl'],'in') ]); 
			  		}elseif($__inp == 'chk'){
			  			echo OLD_HTML_chck('cltag_vl', '', ctjTx($___Ls->dt->rw['cltag_vl'],'in'), 'in'); 
			  		}elseif($__inp == 'are'){
			  			echo HTML_textarea('cltag_vl', '', ctjTx($___Ls->dt->rw['cltag_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']), FMRQD);
			  			
			  			
			  			$CntWb .= "
			  			
			  			
					  			$('#cltag_vl').summernote({
									height: 400,
									tabsize: 1,
							        formatPara: '<br>',
							        lang: 'es-ES',
							        toolbar: [
										['font', ['bold', 'italic', 'underline', 'clear']],
										[['ul', 'ol', 'paragraph']],
										['insert', ['hr', 'link', 'unlink']]
									],
									
								});
						";
					
					
			  		}else{
				  		echo HTML_inp_tx('cltag_vl', TX_VLR , ctjTx($___Ls->dt->rw['cltag_vl'],'in'), FMRQD);
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
