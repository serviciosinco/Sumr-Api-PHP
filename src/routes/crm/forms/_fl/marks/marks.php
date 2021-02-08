<?php $__id = '_inf_box_'.Gn_Rnd(3); $_wd_col = Html_Sty(array('w'=>4)); ?>

<div class="dsh_inf_bx">
	
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>" action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">        

			<div class="col <?php echo $_wd_col ?>">
				<?php

					echo HTML_inp_hd('fl_fch_act', $_GET['__fch_act'] ); 

					$l = __Ls([ 'k'=>'lcl_lvl', 'id'=>'fl_cllcl_lvl', 'va'=>'', 'ph'=>'Piso', 'mlt'=>'no', 'rq' => '2' ]);
					echo $l->html; $CntWb .= $l->js;  
				?>

				<?php
					$l = __Ls([ 'k'=>'eti_org', 'id'=>'fl_orgtag', 'va'=>'', 'ph'=>'Etiquetas', 'mlt'=>'no', 'rq' => '2' ]);
					echo $l->html; $CntWb .= $l->js;
				?>
				<?php echo LsOrg('fl_orgls', 'id_org', '', 'Marca', 2, 'marks', '', ''); $CntWb .= JQ_Ls('fl_orgls'); ?>
			</div>

	        <div class="col col_f <?php echo $_wd_col ?>">
		       <?php echo SlDt([ 'id'=>'fl_f_in', 'va'=>$___fecha_fi, 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?>
	        </div>      
	        <div class="col col_f <?php echo $_wd_col ?>">
	        	<?php echo SlDt([ 'id'=>'fl_f_out', 'va'=>$___fecha_fi, 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?>
	        </div>
			<div class="col <?php echo $_wd_col ?>"></div>
	        <?php echo _Inf_Btn(); ?>
	        
	    <?php 
		    $__f_bl = _JS_q(array('f'=>'f_in, f_out, f_cd, cllcl_lvl, orgtag, orgls, fch_act',''));
			$__gtJS = $__f_bl->js;
		?> 
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>

</div>

<style> /* Temporal */ #_inf_fm > .col.col_f{ border: 1px solid #aaaaaa; } </style>
