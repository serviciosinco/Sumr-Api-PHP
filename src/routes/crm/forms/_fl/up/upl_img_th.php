<?php

$colname_Dt_Img = "-1"; 
if(isset($_GET['i'])){ $colname_Dt_Img = $_GET['i']; }
if(is_numeric($colname_Dt_Img)){ $__t_fld='int'; }else{ $__t_fld='text'; }
if(isN($_GET['bd_cl'])){ $__t_bd=_BdStr(DBM); }

 
$Dt_Qry = sprintf("SELECT * FROM ".$__t_bd.$_GET['bd_el']." WHERE ".$_GET['id_el']." = %s LIMIT 1", GtSQLVlStr($colname_Dt_Img, $__t_fld));
$Dt_Img = $__cnx->_qry($Dt_Qry);


if($Dt_Img){
	$row_Dt_Img = $Dt_Img->fetch_assoc(); 
	$Tot_Dt_Img = $Dt_Img->num_rows; 
}else{
	if(ChckSESS_superadm()){
		echo $Dt_Qry.' - '.$__cnx->c_r->error;
	}
}

$Nm_Fm = 'EdImgTh'.$___Ls->id_rnd;
$Img_Id = 'outer'.$___Ls->id_rnd;
$Img_Crp = 'CrpBxImg'.$___Ls->id_rnd;


$__max_w = Php_Ls_Cln($_GET['max_w']);
$__max_h = Php_Ls_Cln($_GET['max_h']);
$__dr_im = Php_Ls_Cln($_GET['dr_im']);
$__dr_imo = Php_Ls_Cln($_GET['dr_imo']);
$__dmn = _Cns(Php_Ls_Cln($_GET['dmn']));
$__th_t = Php_Ls_Cln($_GET['t']);
$__rtat = Php_Ls_Cln($_GET['_rtat']);
$__eccmz = Php_Ls_Cln($_GET['_eccmz']);
$__eccmz_img_id = Php_Ls_Cln($_GET['_eccmz_img_d']);

if( strpos($__dr_im, 'http://') !== false || strpos($__dr_im, 'https://') !== false ){
	$src_prnt = $__dr_im;
}else{
	//$src = $__dr_im.'_bg_'.$_GET['t'].'_'.$row_Dt_Img[$_GET['id_el']].'.jpg';  -- ANTES
	$src = $__dr_im./*$_GET['t'].'_'.*/$row_Dt_Img[$_GET['id_el']].'.jpg';
	$src_prnt = RtGlbImg($src, ['fld'=>$__dr_im, 'dmn'=>$__dmn] );
}

if(!isN($__dr_imo)){ 
	$src_prnt = $__dr_imo;
}


if(($Tot_Dt_Img == 1)){
	
	$__crp = Php_Ls_Cln($_GET['Crp_Img']);
	$__crpb = Php_Ls_Cln($_GET['Crp_ImgB']);
	
	if(!isN($__crpb)){ 
		$__crp = str_replace('-', '/',$__crpb);
	}
	
?>
<script type="text/javascript">

	try{

		SUMR_Main.img.crp.id = '<?php echo $Img_Id; ?>';

		$('#<?php echo $Nm_Fm ?>').ajaxForm({
			dataType:'json', 
			beforeSubmit:SUMR_Main.img.crp.ldr.shw, 
			success: function(d){
				if(!isN(d) && !isN(d.e)){
					if(d.e == 'ok'){

						SUMR_Main.img.crp.ldr.hde('ok');
						
						<?php if($__th_t == 'ec_cmz' && !isN($__eccmz_img_id)){ ?>

							var imgdv = $('#_dv_img<?php echo $__eccmz_img_id; ?> img');
							var imgnew = '<?php echo urldecode($__dr_im); ?>?_rnd='+Math.random();

							if(imgdv.length == 0){ 
								$('#_dv_img<?php echo $__eccmz_img_id; ?>').removeClass('_empty').prepend('<img src="'+imgnew+'" width="" height="" />'); 
							}else{
								imgdv.attr('src', imgnew);
							}
						
						<?php } ?>

					}else if(d.e == 'no'){
						SUMR_Main.img.crp.ldr.hde();
					}else{
						SUMR_Main.img.crp.ldr.hde();
					}
				}
			}
		}); 
		
		<?php if(!isN($__crp)){ ?>SUMR_Main.img.crp.asRtio = <?php echo $__crp ?>; <?php } ?>

		<?php if(!isN($__max_w)){ ?>
			
			SUMR_Main.img.crp.msZe = ['<?php echo $__max_w; ?>', '<?php echo $__max_h; ?>'];
			
			<?php if($__th_t != 'ec_cmz'){ ?>
				
				SUMR_Main.img.crp.sSlct = [ 0, 0, <?php echo $__max_w; ?>, <?php echo $__max_h!=''?$__max_h:300; ?> ];
			
			<?php }else{ ?>
				
				<?php 	
					$__dt_img = EcCmzImgDt([ 'id'=>$_GET['i'] ]);
					$__x = $__dt_img->img->cut->x;
					$__x2 = $__dt_img->img->cut->x2;
					$__y = $__dt_img->img->cut->y;
					$__y2 = $__dt_img->img->cut->y2;
					$__w = $__dt_img->img->cut->w;
					$__h = $__dt_img->img->cut->h;
				?>
				
				SUMR_Main.img.crp.sSlct = [ 	
								<?php echo $__x!=''?$__x:0; ?>, 
								<?php echo $__y!=''?$__y:0; ?>, 
								<?php if($__x2 != ''){ echo $__x2; }else{ echo $__max_w!=''?$__max_w:0;} ?> , 
								<?php if($__y2 != ''){ echo $__y2; }else{ echo $__max_h!=''?$__max_h:300;} ?> 
							];
			
			<?php } ?>
			
		<?php } ?>
		
		var cimg = document.getElementById('<?php echo $Img_Crp; ?>');
		SUMR_Main.img.crp.box = '#<?php echo $Img_Crp; ?>';
		SUMR_Main.img.crp.init();

		cimg.onload = function () {
			SUMR_Main.anm.tld('LdEdtPbImgTh','out'); 
			SUMR_Main.img.crp.init();
		};
		
	}catch(e){	

		SUMR_Main.log.f({ m:'Error on upload image thumb', m:e });	

	}

</script>
<div id="<?php echo $Img_Id ?>">
	<div id="Fm_ImTh" class="ImgTh_Cut <?php if($__th_t == 'ec_cmz'){ echo 'cut_eccmz'; } ?>">
		<form action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPLTH ?>" method="post" id="<?php echo $Nm_Fm; ?>" name="<?php echo $Nm_Fm ?>" onsubmit="return SUMR_Main.img.crp.checkCoords();">
			<input type="hidden" id="i" name="i" value="<?php echo $row_Dt_Img[$_GET['id_el']] ?>" />
			<input type="hidden" id="Sz_Th" name="Sz_Th" value="<?php echo $_GET['Sz_Th'] ?>" />
			<input type="hidden" id="dr_im" name="dr_im" value="<?php if($_GET['dr_imf'] != ''){ echo Im_Fl($_GET['dr_imf']); }else{ echo Im_Fl($__dr_im); } ?>" />
			
			
			<?php if($__dr_imo != ''){ ?>
				<input type="hidden" id="dr_imo" name="dr_imo" value="<?php echo Im_Fl($__dr_imo); ?>" />
			<?php } ?>
			
			<?php if($_GET['dr_imnoth'] != ''){ ?>
				<input type="hidden" id="dr_noth" name="dr_noth" value="ok" />
			<?php } ?>

			<input type="hidden" id="t" name="t" value="<?php echo Php_Ls_Cln($_GET['t']) ?>" /> 
			<input type="hidden" id="id_el" name="id_el" value="<?php echo Php_Ls_Cln($_GET['id_el']) ?>" />
			<input type="hidden" id="bd_el" name="bd_el" value="<?php echo Php_Ls_Cln($_GET['bd_el']) ?>" />
			<input type="hidden" id="bd_cl" name="bd_cl" value="<?php echo Php_Ls_Cln($_GET['bd_cl']) ?>" />
			<input type="hidden" id="x" name="x" <?php echo FMRQD ?>/>
			<input type="hidden" id="y" name="y" <?php echo FMRQD ?>/>
			<input type="hidden" id="x2" name="x2" <?php echo FMRQD ?>/>
			<input type="hidden" id="y2" name="y2" <?php echo FMRQD ?>/>
			<input type="hidden" id="w" name="w" <?php echo FMRQD ?>/>
			<input type="hidden" id="h" name="h" <?php echo FMRQD ?>/>
			<input name="bdsrc" type="hidden" id="bdsrc" value="<?php echo Php_Ls_Cln($_GET['Bd_Src']) ?>" <?php echo FMRQD ?>/>
			
			<?php if($__th_t != 'ec_cmz'){ ?>
			<input type="button" onclick="<?php echo UpLdImg([ 'icn'=>ID_LDR_PRC.'_Img', 'dv'=>DV_IMG.'_Img', 'fl'=>DT_GN, 'm'=>[ '_t'=>'img', 'Img'=>urlencode($__dr_im.$row_Dt_Img[$_GET['ImNm']]) ], 'tp'=>1 ]) ?>" value="<?php echo TX_VLVR ?>" class="Vlv"/>
			<?php } ?>
			
			
			<?php if($__th_t == 'ec_cmz'){ ?>
				<input type="hidden" id="ec_cmz" name="ec_cmz" value="<?php echo $__eccmz ?>" />
			<?php } ?>
			
			<?php 
				
				$___btn_rnd = Gn_Rnd(20);
				
				$CntWb .= "
			        	
						$('#_left_{$___btn_rnd}, #_right_{$___btn_rnd}').off('click').click(function() {
							
							try{
							
								var __d = $(this).attr('rel');

								$.ajax({
									type: 'POST',
									dataType: 'json',
									url:'".Fl_Rnd(PRC_UPLD_GN.'?'.TXGN_UPLTH)."Rd='+Math.random(),
									data: {
										i: '".$row_Dt_Img[$_GET['id_el']]."',
										t: '".Php_Ls_Cln($_GET['t'])."',
										id_el: '".Php_Ls_Cln($_GET['id_el'])."',
										bd_el: '".Php_Ls_Cln($_GET['bd_el'])."',
										id_cmz: '".$__eccmz."',
										dr_im: '".($_GET['dr_imf']!=''?Im_Fl($_GET['dr_imf']):Im_Fl($__dr_im))."',
										MM_update: 'ImgRte',
										rte:__d
									},
									success: function(d) {
										
										try{

											if(!isN(d.e) && d.e == 'ok'){
												
												/*__cut_".$row_Dt_Img[$_GET['id_el']]."();*/
												
												swal({
													title: 'Super!',
													text: 'Se rotó la imagen',
													type: 'success',
													timer: 2000,
													showConfirmButton: false
												});
												
											}else{
												SUMR_Ec.f.w();
											}

										}catch(e){
											SUMR_Main.log.f({ t:'Error', m:e });	
										}

									},
									error: function (request, status, error) {
										
										if(error != 'abort'){ SUMR_Ec.f.w(); }
										
									}
								});

							}catch(e){	
								SUMR_Main.log.f({ t:'Error on upload image thumb', m:e });
							}
							
						});	

					";
			?>
			
			<?php if($__rtat == 'ok'){ ?><button class="_Rotate R-Left _anm" id="_left_<?php echo $___btn_rnd; ?>" rel="left" onclick="return false;"></button><?php } ?>

			<input type="submit" value="<?php echo TX_CUT ?>" class="Prc _anm"/>
			
			<?php if($__rtat == 'ok'){ ?><button class="_Rotate R-Right _anm" id="_right_<?php echo $___btn_rnd; ?>" rel="right" onclick="return false;"></button><?php } ?>
		</form>
	</div> 
	
	<?php //if($__max_w != '' && ($__max_w > $__max_h) ){ $__sty .= ' width:'.$__max_w.'px; '; }elseif($__max_h != '' && ($__max_w < $__max_h) ){ $__sty .= ' height:'.$__max_h.'px; '; } ?>
	
	<?php if(!isN($src_prnt)){ ?>
	<div class="CrpScrll">
		<div class="CrpBx" style="overflow: hidden; ">
			<img src="<?php echo $src_prnt.'?'.Gn_Rnd(20) ?>" id="<?php echo $Img_Crp; ?>" style="<?php echo $__sty; ?>" />
		</div>
	</div>
	<?php } ?>
	
	<?php if($__th_t == 'ec_cmz'){ ?>
	<style>
		.crm-panel._upl .crm-panel-content{ padding: 50px 0; }	
	</style>	
	<?php } ?>

</div>

<?php }else{ echo h2('No record on database'); } ?>