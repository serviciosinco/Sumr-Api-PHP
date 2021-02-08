<?php  //if(ChckSESS_adm() ){ 


//--------------- Check image on BD ---------------//	
	
		
	$__g_i = Php_Ls_Cln($_GET['i']);
	$__g_id_el = Php_Ls_Cln($_GET['id_el']);
	$__g_bd_el = Php_Ls_Cln($_GET['bd_el']);
	$__g_bd_cl = Php_Ls_Cln($_GET['bd_cl']);
	$__g_dr_img = Php_Ls_Cln($_GET['dr_im']);
	$__max_w = Php_Ls_Cln($_GET['max_w']);
	$__max_h = Php_Ls_Cln($_GET['max_h']);
	$__dmn = _Cns(Php_Ls_Cln($_GET['dmn']));
	$__imnm = Php_Ls_Cln($_GET['ImNm']);

	if(!isN($__g_bd_cl)){ $_prfx_bd = DB_CL.'.'; }

	
	$colname_Dt_Img = "-1"; if(!isN($__g_i)){ $colname_Dt_Img = $__g_i; }
	 
	$Dt_Qry = sprintf("SELECT * FROM ".$_prfx_bd.$__g_bd_el." WHERE ".$__g_id_el." = %s LIMIT 1", GtSQLVlStr($colname_Dt_Img, "text"));
	$Dt_Img = $__cnx->_qry($Dt_Qry);


//--------------- Check record exists ---------------//	

	
	if($Dt_Img){
		
		$row_Dt_Img = $Dt_Img->fetch_assoc(); 
		$Tot_Dt_Img = $Dt_Img->num_rows; 
		
		$Nm_Fm = 'EdImgBn';
		$Img_Id = 'outer';			
		
		if( strpos($__g_dr_img, 'http://') !== false || strpos($__g_dr_img, 'https://') !== false ){
			
			$src_prnt = $__g_dr_img;
			
		}else{
			
			if(!isN($__dmn)){
				
				$__imgv = _ImVrs([ 'img'=>$row_Dt_Img[ $__imnm ], 'f'=>$__dmn ]);
				$__img_go = $__imgv->big;
				
			}elseif($__Dmnimg=='ok'){
				 
				$__img_go = $__g_dr_img.$row_Dt_Img[ $__imnm ]; 
				
			}
				
			$src = $__img_go;  
			$src_prnt = RtGlbImg($src);
		}

	
	}else{
		
		echo $__cnx->c_r->error;
	
	}
	
	
	
	if(($Tot_Dt_Img == 1)){
		
		$__crp = Php_Ls_Cln($_GET['Crp_Img']);		
		
		if($__crp == 1){
			$__crp_sz = "25 / 8";
		}elseif($__crp == 2){
			$__crp_sz = "26 / 6";
		}elseif($__crp == 3){
			$__crp_sz = "26 / 15";
		}
	
	
	
		$__crp_bx = 'CrpBxImg_'.Gn_Rnd(20);
?>

		<script type="text/javascript">
		
		
				try{
					
					$(document).ready(function(){	
						
						function CrpBx(){

							try{
								if(jQuery().Jcrop){
									$('#<?php echo $__crp_bx ?>').Jcrop({
										<?php if(isset($__crp_sz)&&($__crp_sz!='')){ ?>aspectRatio: <?php echo $__crp_sz ?>, <?php } ?>
										onSelect: updateCoords
									});
								}
							}catch(e){
								SUMR_Main.log.f({ t:'Error', m:e });	
							}

						}
						
						function updateCoords(c){
							try{
								$('#x').val(c.x);
								$('#y').val(c.y);
								$('#w').val(c.w);
								$('#h').val(c.h);
							}catch(e){
								SUMR_Main.log.f({ t:'Error', m:e });	
							}
						};
						
						function checkCoords(){
							try{
								if (parseInt($('#w').val())) return true;
								swal('Error', TX_SLCAR, 'error');
								return false;
							}catch(e){
								SUMR_Main.log.f({ t:'Error', m:e });	
							}
						};
						
						function ShLod(){
							try{
								if(checkCoords()){
									$('#<?php echo $Img_Id ?>').hide("scale", {}, 500);
									$('#LdEdtImgBn').fadeIn('fast');
								};
							}catch(e){
								SUMR_Main.log.f({ t:'Error', m:e });	
							}
						};
					
					
						function HdLod(est){

							try{
								$('#LdEdtImgBn').fadeOut('fast', function(){
									if(est == 'ok'){
										$('#Img_Crp_Ok').show("slide", { direction: "up" }, 1000).delay(2000).hide('slide', {direction: "up"}, 500, function(){
											$('#<?php echo $Img_Id ?>').show("scale", {}, 500);
										});
									}else{
										$('#Img_Crp_No').show("slide", { direction: "up" }, 1000).delay(2000).hide('slide', {direction: "up"}, 500, function(){
											$('#<?php echo $Img_Id ?>').show("scale", {}, 500);
										});
									}
								});
							}catch(e){
								SUMR_Main.log.f({ t:'Error', m:e });	
							}

						};
						
						var opc= {dataType:'json', beforeSubmit:ShLod, success: function(d){
							if(d.e == 'ok'){
								HdLod('ok');
							}else if(d.e == 'no'){
								HdLod();
							}else{
								HdLod();
							}
						}};
						
						try{
							$('#<?php echo $Nm_Fm ?>').ajaxForm(opc); 
						}catch(e){
							SUMR_Main.log.f({ t:'Error', m:e });	
						}
						
						CrpBx();
						
						try{
							$('#<?php echo $Nm_Fm; ?>').attr('onsubmit','return checkCoords();');
						}catch(e){
							SUMR_Main.log.f({ t:'Error', m:e });	
						}
						
					});
				
				}catch(e){
					
					SUMR_Main.log.f({ t:'Error', m:e });
					
				}
		
		</script>
		
		
		<div id="<?php echo $Img_Id ?>">
		<div id="Fm_ImBn">
		<form action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPLBN ?>" method="post" id="<?php echo $Nm_Fm?>" name="<?php echo $Nm_Fm?>">
			<input type="hidden" id="i" name="i" value="<?php echo $row_Dt_Img[ $__g_id_el ] ?>" />
		    <input type="hidden" id="Sz_Bn" name="Sz_Bn" value="<?php echo $_GET['Sz_Bn'] ?>" />
		    <input type="hidden" id="dr_im" name="dr_im" value="<?php echo Im_Fl($_GET['dr_im']); ?>" />
		    <input type="hidden" id="t" name="t" value="<?php echo $_GET['t'] ?>" /> 
		    <input type="hidden" id="id_el" name="id_el" value="<?php echo $__g_id_el ?>" />
		    <input type="hidden" id="bd_el" name="bd_el" value="<?php echo $__g_bd_el ?>" />
		    <input type="hidden" id="bd_cl" name="bd_cl" value="<?php echo $__g_bd_cl ?>" />
		    <input type="hidden" id="ImNm" name="ImNm" value="<?php echo $__imnm ?>" />
		    
		    
		    <input type="hidden" id="x" name="x" <?php echo FMRQD ?>/>
		    <input type="hidden" id="y" name="y" <?php echo FMRQD ?>/>
		    <input type="hidden" id="w" name="w" <?php echo FMRQD ?>/>
		    <input type="hidden" id="h" name="h" <?php echo FMRQD ?>/>
		    <input name="bdsrc" type="hidden" id="bdsrc" value="<?php echo $_GET['Bd_Src'] ?>" <?php echo FMRQD ?>/>
		    <input type="button" onclick="<?php echo UpLdImg([ 'icn'=>ID_LDR_PRC.'_Img', 
			    												'dv'=>DV_IMG.'_Img', 
			    												'fl'=>DT_GN, 
			    												'm'=>[ 
			    													'_t'=>'img', 
			    													'Img'=>urlencode($_GET['dr_im'].$row_Dt_Img[ $__imnm ] ) 
			    												], 
			    												'tp'=>1 
			    											]) 
			    							?>" value="<?php echo TX_VLVR ?>" class="_btn Vlv"/>
			    							
			    							
		    <input type="submit" value="<?php echo TX_EDIT ?>" class="_btn Prc"/></form>
		</div> 
		
		<div class="CrpBx"><img src="<?php echo $src_prnt.'?'.Gn_Rnd(20) ?>" id="<?php echo $__crp_bx ?>" onload="SUMR_Main.anm.tld('LdEdtImgBn','out'); "/></div>
		
		</div>

<?php } 

//} 
$Dt_Img->free; 
?>