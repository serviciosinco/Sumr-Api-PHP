 <?php if(class_exists('CRM_Cnx')){ ?>
	<!-- Css -->
	<?php include('sgn_css.php'); ?>
	<!-- Css -->
	<!-- HTML -->
	
	<div class="sgn_pnl">
			<h1 class="h1"><?php echo TX_FRMSPRZN ?></h1>
			<div class='_sgn_new'></div>
			<div class='_sgn_mod _anm'>
				<div class="atr"><div class="btn_atr"></div><div class="btn_vtp"></div></div>
				<div class="_sgn_cnt"></div>
			</div>
			<div class='_sgn_mod_vst _anm'>
				<div class="atr"><div class="btn_atr"></div><div class="btn_dsn"></div></div>
				<div class="_sgn_vst"></div>
			</div>
			
			<div class='orv_sgn _anm'>
				<div class='_sgn_opc _anm'>
					<div class='x'>x</div>
					<h1><?php echo TX_SLCCPLNT ?></h1>
					<div class="_opc"></div>
				</div>
			</div>
		<?php
			echo "<div class='_sgn_add'>";
				$CntJV .= " SISUS_ID = '".SISUS_ID."'; ";
				
				$CntJV .= "_sgns = {}; _sgns['dt'] = {};";
				$CntJV .= "_sgn = {}; _sgn['dt'] = {};";
				
				$GtSgnCLs = GtSgnCLs();
				$CntJV .= " _sgns['ls'] = ".json_encode($GtSgnCLs->ls)."; ";
				
				$GtSgnLs = GtSgnLs();
				$CntJV .= " _sgn['ls'] = ".json_encode($GtSgnLs->ls)."; ";
				
				$CntJV .= " 
					
					
								
						function SgnDsh_Bld(p){
							if(!isN(_sgns.ls)){
								$('._sgn_add').html('');
								$.each(_sgns.ls, function(sgn_k, sgn_v) {
									_sgns['dt'][sgn_v.enc] = sgn_v;
									if(!isN(sgn_v.enc)){
										SgnS(sgn_v.enc, sgn_v);
										Sgn_Add_Html({
											plc:'b',
									 		enc:sgn_v.enc,
									 		_cl:function(){ }
								 		});
									}
								});	
							}
							
							if(!isN(_sgn.ls)){
								$('._opc').html('');
								$.each(_sgn.ls, function(sgn_k, sgn_v) {
									$('._opc').append('<div id=\"'+sgn_v.enc+'\" class=\"opc_s _anm\"><p>'+sgn_v.nm+'</p></div>');		
																
								});
								
							}
							
							
							
							
	
						}
					
				";
				$CntWb .= "									SgnDsh_Bld(); 

							";
			echo "</div>";
		?>    
	</div>
	<!-- HTML -->
	<!-- JavaScript -->
	<?php include('sgn_js.php'); ?>
	<!-- JavaScript -->   
	<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte); ?>
<?php } ?>