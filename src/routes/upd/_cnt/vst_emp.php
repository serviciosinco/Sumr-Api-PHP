<?php 

	function __upd_this_rg($p=NULL){
		
			global $__cnx;
		
			if ($p != NULL) { 
			$updateSQL = sprintf("UPDATE ".TB_EMP_VST." SET empvst_est=%s WHERE id_empvst=%s",	
								   GtSQLVlStr(1, "int"),
								   GtSQLVlStr($p['id'], "int"));

				$Result = $__cnx->_prc($updateSQL);
				
				if($Result){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = 'no';
				} 
				
				$rtrn = _jEnc($rsp);
				return($rtrn);
			}
			
			$__cnx->_clsr($Result);
			
	}
	
	$__dt_vst = GtVstDt($__i, 'enc');
?>

	<header><img src="<?php echo DMN_IMG ?>sis/vst_logo.png"></header>
    <section class="__cpt" style="background-image: url('<?php echo DMN_IMG ?>sis/vst_hdr.jpg'); "></section>
    
    <?php if($__dt_vst->clc->ngtv){ ?>
    	<?php __upd_this_rg(['id'=>$__dt_vst->id]); ?>
        <section class="__rsp __ok">
            <h1>Gracias!</h1>
            <p>Su visita en <?php echo Strn($__dt_vst->cnt->emp_rs) ?><br> del día <?php echo $__dt_vst->f_tt ?> <br> con <?php echo $__dt_vst->cnt->nm_fll ?> fue marcada <br>en el sistema como realizada.</p>
        </section>
    <?php }else{ ?>
    	<section class="__rsp __no">
            <h1>Su visita</h1>
            <p>No puede ser modificada hasta no ser realizada</p>
        </section>
    <?php } ?>