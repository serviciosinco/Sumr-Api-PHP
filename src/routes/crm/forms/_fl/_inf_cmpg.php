<?php $__id = '_inf_box_'.Gn_Rnd(20); $_wd_col = Html_Sty(['w'=>4]); ?>

<div class="dsh_inf_bx">
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>" action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">     
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo SlDt([ 'id'=>'fl_f_in', 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'cls'=>CLS_CLND ]); ?>	
	        	<?php echo HTML_inp_hd('fl_cmpg', Php_Ls_Cln($_GET['__i'])); ?>	
	        </div>
			<div class="col <?php echo $_wd_col ?>">
	        	<?php echo SlDt([ 'id'=>'fl_f_out', 'rq'=>'no', 'ph'=> TX_ORD_FOU, 'cls'=>CLS_CLND ]); ?>
	        </div>
	        <?php echo _Inf_Btn(); ?>
	        
	    </form>
	    <?php 
	
			$__f_bl = _JS_q(['f'=>'cmpg, f_in, f_out']);
			$__gtJS = $__f_bl->js; 
			$CntWb .= $__f_bl->js_wb;
			
		?> 
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>
</div>