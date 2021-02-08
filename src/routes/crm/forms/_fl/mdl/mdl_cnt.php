<?php $__id = '_inf_box_'.Gn_Rnd(3); $_wd_col = Html_Sty(array('w'=>4)); ?>

<div class="dsh_inf_bx">
	
	<div class="_nav _anm">
	    <form id="<?php echo ID_FM_INF ?>" name="<?php echo ID_FM_INF ?>" action="<?php echo FL_INF_GN; ?>" method="get" target="_blank">        
	        
	        <div class="col <?php echo $_wd_col ?>">
		        
					<?php
					
					if(_ChckMd('ls_are_all','ok')){ $_all = 'ok'; }else{ $_all = 'no'; }

					echo LsClAre([	
			        						'id'=>'fl_f_are', 
							        		'v'=>'id_clare', 
											'va'=>$___Ls->dt->rw['fl_f_are'],
											'rq'=>2, 
											'mlt'=>'no', 
											'attr'=>['attr'=>['send-id'=>'mdlare_enc', 'send-fk'=>'ok'], 'tp_k'=>Php_Ls_Cln($_GET['_tp'])],
											'all'=>$_all
							           ]); 
						
						$CntWb .= JQ_Ls('fl_f_are', TX_SLCAR); 
		        	?>
		        	
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
				<?php /*echo LsMdl('fl_f_mdl', 'mdl_enc', $___Ls->dt->rw['mdl_enc'], 'Modulo', 2, '', [ 'tp_k'=>Php_Ls_Cln($_GET['_tp']) ]);*/  ?>

				<?php 
					echo LsMdl('fl_f_mdl', 'mdl_enc', $___Ls->dt->rw['mdl_enc'], 'Modulo' , 2, 'ok', [ 'tp_k'=>Php_Ls_Cln($_GET['_tp']), 'flt_are'=>'ok' ] ); 
					$CntWb .= JQ_Ls('fl_f_mdl', TX_SLCNMDL);
				?>
	        </div>
			<div class="col <?php echo $_wd_col ?>">
				<?php
					echo LsMdlS( Php_Ls_Cln($_GET['_tp']), 'fl_f_mdl_s', 'id_mdls', '', FM_LS_SLTP, 2, '', [ 'cl'=>'ok', 'tp'=>'ok' ] ); 
					$CntWb .= JQ_Ls('fl_f_mdl_s', '');
				?>
			</div>
	        <div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsSis_Md('fl_f_md', 'id_sismd', $___Ls->dt->rw['fl_f_md'], '', 2); $CntWb .= JQ_Ls('fl_f_md', FM_LS_SLTP); ?>
	        </div>
			<div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsCntFnt('fl_f_fnt','id_sisfnt', $___Ls->dt->rw['fl_f_fnt'] , FM_LS_CNTFNT, 2, ''); $CntWb .= JQ_Ls('fl_f_fnt'); ?>
	        </div>
			<div class="col <?php echo $_wd_col ?>">
	        	<?php echo LsUs('fl_f_us','id_us', '' ,'Usuarios', 2,'ok'); $CntWb .= JQ_Ls('fl_f_us','Usuarios'); ?>
	        </div>

			<?php 
				$__tp = Php_Ls_Cln($_GET['_tp']); 
				if(!isN($__tp)){
					$_tp = $__tp;
				}else{
					$_tp = '';
				}
			?>
	        
	         <div class="col <?php echo $_wd_col ?>">
		        <?php echo LsMdlSPrd('fl_f_prd_i','id_mdlsprd', $___Ls->dt->rw['mdlcnt_prd'] ,TX_PRDING , 2,'', [ 'tp_mdl' => $_tp ]);  
				 $CntWb .= JQ_Ls('fl_f_prd_i',TX_PRDING);  ?>
	        </div>
	        <div class="col <?php echo $_wd_col ?>">
		        <?php echo LsMdlSPrd('fl_f_prd_a','id_mdlsprd', $___Ls->dt->rw['mdlcnt_prd'] , TX_PRD_A, 2,'', [ 'tp_mdl' => $_tp ]);  
				 $CntWb .= JQ_Ls('fl_f_prd_a',TX_PRD_A);  ?>
	        </div>

			

	        <?php 
		        
		        $__t2t = Php_Ls_Cln($_GET['_t2']);
		            
		        if($__t2t == "gst_are" || $__t2t == "cnt_gst" || $__t2t == "gst"){
			        $_fi_tp = "f_his";
		        }else{
			        $_fi_tp = "f_i";
		        }
					
	        ?>
	        
	        
	        <div class="col <?php echo $_wd_col ?>">
		        <?php echo Ls_GstIng('fl_f_tp','id_f_tp', $_fi_tp , 'Tipo de fecha', 2,'');  
				 $CntWb .= JQ_Ls('fl_f_tp','Tipo de fecha');  ?>
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
		    $__f_bl = _JS_q(array('f'=>'f_in, f_out, f_mdl, f_us, f_md, f_are, f_prd_a, f_prd_i, f_tp, f_fnt, f_mdl_s',''));
			$__gtJS = $__f_bl->js;
		?> 
	</div>
	<div id="<?php echo $__id ?>" class="_inf_cnt _anm" style="display: none;"></div>

</div>

<style> /* Temporal */ #_inf_fm > .col.col_f{ border: 1px solid #aaaaaa; } </style>
