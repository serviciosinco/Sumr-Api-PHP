<?php $__id = '_inf_box_'.Gn_Rnd(3); $_wd_col = Html_Sty(array('w'=>4)); ?>

<div class="dsh_inf_bx">
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>" action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">        
	        
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsEncTp('fl_enc','id_enc', '', '', 2, array('tp'=>$___Ls->mdlstp->tp)); $CntWb .= JQ_Ls('fl_enc',MDL_ENC); ?>
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php if($__f_tp == 'm'){ $__dt_tp = 'mthyr'; $__dt_fr = 'yy-mm'; } ?>
	            <?php echo SlDt([ 'id'=>'fl_f_in', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_FIN ]); ?>	
	        </div>      
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo SlDt([ 'id'=>'fl_f_out', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_ORD_FOU ]); ?>
	        </div>
			<div class="col <?php echo $_wd_col ?>"></div>
	        <?php echo _Inf_Btn(); ?>
	        
	    </form>
	    <?php 
	 		$__f_bl = _JS_q(array('f'=>'f_in, f_out, enc'));
			$__gtJS = $__f_bl->js; 
			$CntWb .= $__f_bl->js_wb;
		?> 
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>
</div>