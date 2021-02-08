<?php $__id = '_inf_box_'.Gn_Rnd(3); $_wd_col = Html_Sty(['w'=>4]); ?>

<div class="dsh_inf_bx">
	
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>"  action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">
	       
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsCrr_Emp('_empcnt_emp','id_empsub', $_GET['fl_empcntemp'], '', 2, 'ok'); $CntWb .= JQ_Ls('_empcnt_emp',FM_LS_SLEMP); ?>
				<?php echo LsCrr_Emp_Grp('_empsub_emp','id_emp', $_GET['fl_empsubemp'], '', 2); $CntWb .= JQ_Ls('_empsub_emp',FM_LS_SLGRPEMP); ?>
		
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php if($__f_tp == 'm'){ $__dt_tp = 'mthyr'; $__dt_fr = 'yy-mm'; } ?>
	            <?php echo SlDt([ 'id'=>'fl_f_in', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_ORD_FIN, 'lmt'=>'no' ]); ?>
	        </div>      
	        <div class="col <?php echo $_wd_col ?>">
	        	 <?php echo SlDt([ 'id'=>'fl_f_out', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_ORD_FOU, 'lmt'=>'no' ]); ?>
	        </div>
			<div class="col <?php echo $_wd_col ?>"></div>
	        <?php echo _Inf_Btn(); ?>
	             
	    </form>
	    <?php 
			$__gtJS = _JS_q(['f'=>'pro, fac, f_in, f_out']);
		?>
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>

</div>