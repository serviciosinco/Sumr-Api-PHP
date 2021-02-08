<?php $__id = '_inf_box_'.Gn_Rnd(3); $_wd_col = Html_Sty(['w'=>4]); ?>

<div class="dsh_inf_bx">
	
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>"  action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">
	       
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsCrr_Emp('_concrrofr_emp','id_empsub', $_GET['fl_concrrofremp'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_emp',FM_LS_SLEMP); ?>
	            <?php echo LsCrr_Emp_Grp('_empsub_emp','id_emp', $_GET['fl_empsubemp'], '', 2); $CntWb .= JQ_Ls('_empsub_emp',FM_LS_SLGRPEMP); ?>
				<?php echo LsCrr_Ofr_Tp('_concrrofr_tp','id_ofrtp', $_GET['fl_concrrofrtp'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_tp',FM_LS_SLTP); ?>
	            <?php echo LsProTp('con', '_concrrofr_mdl','id_contp', $_GET['fl_concrrofrmdl'], FM_LS_SLMD, 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_mdl',FM_LS_SLMD); ?>
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsCrr_Ofr_Cmp('_concrrofr_cmp','id_ofrcmp', $_GET['fl_concrrofrcmp'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_cmp',FM_LS_SLTPCMP); ?>
	            <?php echo LsCrr_Md('_concrrofr_md','id_crrmd', $_GET['fl_concrrofrmd'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_md',FM_LS_MD); ?>
	        	<?php echo LsCrr_Ofr_Est('_concrrofr_est','id_ofrest', $_GET['fl_concrrofrest'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_est',FM_LS_EST); ?>
	        	<?php echo LsCrr_Ofr_Rch('_concrrofr_rch','id_ofrrch', $_GET['fl_concrrofrrch'], '', 2, 'ok'); $CntWb .= JQ_Ls('_concrrofr_rch',FM_LS_SLNOI); ?>
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php if($__f_tp == 'm'){ $__dt_tp = 'mthyr'; $__dt_fr = 'yy-mm'; } ?>
	            <?php echo SlDt([ 'id'=>'fl_f_in', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_ORD_FIN, 'lmt'=>'no' ]); ?>
	        </div>      
	        <div class="col <?php echo $_wd_col ?>">
	        	 <?php echo SlDt([ 'id'=>'fl_f_out', 'rq'=>'ok', 't'=>$__dt_tp, 'ph'=>TX_ORD_FOU, 'lmt'=>'no' ]); ?>
	        </div>
			<?php echo _Inf_Btn(); ?>
	    </form>
	    <?php 
			$__gtJS = _JS_q(['f'=>'empsub, emp, f_in, f_out']);
		?>
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>

</div>