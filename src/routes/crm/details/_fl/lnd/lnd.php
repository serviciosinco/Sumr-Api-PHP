<?php if(class_exists('CRM_Cnx')){ ?>
	
	<?php header('Access-Control-Allow-Origin: *'); ?>
		
	<!-- Css -->
	<?php include('lnd_css.php'); ?>
	<!-- Css -->
	
	<!-- Loader Spinner -->
	<?php include('lnd_load.php'); ?>
	<!-- Loader Spinner -->
	
	<!-- HTML -->
	<div class="lnd_pnl">
		
		<div class="_ovr _anm">
			<div class="_lnd_mod_ovr _anm">
					
				<div class="_hdr">
					<nav>
						<div class="_left"> </div>
						<div class="_right">	
							<div class="mn"></div>
							<div class="x"></div>
						</div>
					</nav>
				</div>
				
				<div class="_bdy _anm">
					<div class="lnd_img">
						<div class="_ls"></div>
					</div>
				</div>
					
			</div>
		</div>
		
		<h1>Landing Page</h1>
		
		<div class='_lnd_mod _anm'>
			<div class="_lnd_col_1 cls _anm" rel=" ">
 				<div class="_hdt"></div>
 				<div class="_bdy"></div>
 			</div>
 			<div class="_lnd_col_2 opn _anm" rel=" ">
	 			<div class="_hd">
		 			<div class="btn_pnl"></div>
	 			</div>
	 			<div class="_bdy">
		 			<div class="row_1">
			 			<div class="col_1"><span><?php echo TX_DSN ?></span></div>
			 			<div class="col_2"><span><?php echo TX_MODL ?></span></div>
			 			<div class="col_3"><span><?php echo TX_VSTPRV ?></span></div>
			 			<!--<div class="col_4"><span>Generar</span></div>-->
		 			</div>
		 			<hr>
		 			<div class="row_2">
			 			<div class="col_1 _slc" tb="1"><span><?php echo TX_USMDLS; ?></span></div><div class="col_2" tb="2"><span><?php echo TX_STLS; ?></span></div><div class="col_3" tb="3"><span><?php echo TX_ATRBTS ?></span></div>
		 			</div>
		 			<div class="row_3">
			 			<div class="col_1 _slc">
				 			<div class="_slc_tp" id="__slc_tp<?php echo $___Dt->id_rnd; ?>">
				 				<?php 
						 			echo LsMdlSTp('_slc_tp_ls','id_mdlstp', '', TX_TP,'','','',[ 'sis'=>'no' ]);
						 			$CntWb .= JQ_Ls('_slc_tp_ls',"Tipo");
					 			?>
				 			</div>
				 			<div class="_slc_mdl_tp">
								<select disabled="disabled" id='_slc_mdl_tp_ls' class='_slc_mdl_tp_ls' ></select>
								<?php $CntWb .= JQ_Ls('_slc_mdl_tp_ls', TX_TPMDL); ?>
							</div>
							<div class="_slc_mdl">
								<ul></ul>
							</div>
			 			</div>
			 			<div class="col_2">
				 			<?php 
					 			$__scl = __LsDt(['k'=>'lnd_attr']);
					 			foreach($__scl->ls->lnd_attr as $_k => $_v){
						 			echo "
							 			<div class='_attr'>
							 				<div class='_left'>
							 					<span>".$_v->tt."</span>
							 				</div>
							 				<div class='_right'>
						 						".HTML_inp_tx('lndmdlsgmattr_vle_'.$_k, $_v->tt, ctjTx( $___Ls->dt->rw['emp_nit'],'in'), $_k,'', 'lndmdlsgmattr_vle', '', '', $_k)."
						 					</div>
						 				</div>
						 			"; 
					 			}
				 			?>
				 			<div class="_clr">
					 			<span>#000000</span>
					 			<?php echo HTML_inp_clr([ 'id'=>'_clr', 'plc'=>TX_NM_CL, 'vl'=>'#000000' ]); ?>
				 			</div>
			 			</div>
			 			<div class="col_3"><?php echo TX_PRUBS ?></div>
		 			</div>
	 			</div>
 			</div>
		</div>
		
		<!--<div class='_lnd_new _anm'></div>-->
		
		<?php 
			
			echo "<div class='_lnd_add'></div>";
			
			$CntWb .= "
						SUMR_Main.ld.f.lnd(function(){  
							SUMR_Lnd.f.Strt({ r:'{$___Dt->id_rnd}', d:'".DB_CL_FLD."' });	
						});
					";
	
		?>
		    
	</div>
	<!-- HTML -->
	    
	<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte); ?>
	
<?php } ?>