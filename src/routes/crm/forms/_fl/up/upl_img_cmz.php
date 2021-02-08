<?php 

$__id_rnd = '_'.Gn_Rnd(20);
$__id_drop = 'drop';
$__id_upld = 'UplImg';
$__id_upld_bx = 'UplImg_Bx';
$__id_upld_nw = 'UplNwB';
$__id_upld_bco = 'UplBco_Bx';

$__t = Php_Ls_Cln($_GET['tp']);
$__img = Php_Ls_Cln($_GET['_img']);
$__img_d = Php_Ls_Cln($_GET['_img_d']);
$__cmz = Php_Ls_Cln($_GET['id_cmz']);
$__rtio = Php_Ls_Cln($_GET['_rtio']);
$__pem = Php_Ls_Cln($_GET['_pem']);

$__hdr = Php_Ls_Cln($_GET['_hdr']);
$__hdr_tp = Php_Ls_Cln($_GET['_hdr_tp']);

$__max_w = Php_Ls_Cln($_GET['max_w']);
$__max_h = Php_Ls_Cln($_GET['max_h']);
$__max_d = Php_Ls_Cln($_GET['max_d']);
 

 
if(!isN($__t)){ 
	
	$__dr_ec = Php_Ls_Cln($_GET['_dir']);
	
	if($__t == 'cmz'){
		
		$IdEl = 'id_eccmzimg'; // Id de Comparacion en Where
		$BdEl = TB_EC_CMZ_IMG;  // Base de Datos de Consulta
		$ImNm = ''; // Nombre del Campo de la Imagen
		
		
		$DrIm = DIR_FLE_EC_CMZ;// Directorio de la Imagen 
		$DrImS = DMN_FLE_EC_CMZ;
		
		$SzBg_W = 2000;
		$SzBg_H = 2000;
		$SzTh = 200;
		$CrpRto = "16/10";
		$CrpRtoBn = 1;
		
	}elseif($__t == 'cmz_hdr'){
		
		$IdEl = 'id_eccmzhdr'; // Id de Comparacion en Where
		$BdEl = TB_EC_CMZ_HDR;  // Base de Datos de Consulta
		$ImNm = ''; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_EC_CMZ;// Directorio de la Imagen 
		$SzBg_W = 2000;
		$SzBg_H = 2000;
		$SzTh = 200;
		$CrpRto = "16/10";
		$CrpRtoBn = 1;
		
	}	
}

if(!isN($__img)){
	$_chk_img = ChkEcCmzImg([ 'img'=>$__img, 'eccmz'=>$__cmz ]);
	$_img_id = $_chk_img->id;
	$_img_srcs = 'fl/'.$__dr_ec.'/'.$_chk_img->img->c;
	$_img_src = DMN_EC.$_img_srcs;
	$_img_srcf = '_sb/ec/'.$_img_srcs;
}


$_ec_cmz = GtEcCmzDt([ 'cmz'=>$__cmz ]); 
 
$Dt_Qry = sprintf("SELECT * FROM "._BdStr(DBM).TB_EC." WHERE id_ec = %s LIMIT 1", GtSQLVlStr($_ec_cmz->ec, "int"));

if($Dt_Qry){
	
	$Dt_Rg = $__cnx->_qry($Dt_Qry); 
	$row_Dt_Rg = $Dt_Rg->fetch_assoc(); 
	$Tot_Dt_Rg = $Dt_Rg->num_rows;

}

if($_mynm != ''){ $__t_gt=$_mynm; }else{ $__t_gt=$__t; } 
if($DrPth == 'sis'){ $DrPth_Get = '&_sis=ok'; }
?>

<?php if($__t != 'cmz_hdr'){ ?>

	<div class="upl_opt">
		
		<div class="_upl">
			<span>Subir</span>	
		</div>	
		<div class="_bco">
			<span>Banco</span>
		</div>	
		
		<?php 
			
			$CntWb .= "	
				
				$('.upl_opt ._upl').off('click').click(function (){
					$('.upl_opt').fadeOut('fast', function(){
						$('#{$__id_upld_bx}').fadeIn('fast');
					});
				});
				
				$('.upl_opt ._bco').off('click').click(function (){
		
					$('.upl_opt').fadeOut('fast', function(){
						
						$('#{$__id_upld_bco}').fadeIn('fast');
						$('._fl_new').fadeIn('fast');
						$('.bco_pg').fadeIn('fast');
						
						_pgn = 0;
						
						$('.bck').css('cursor','no-drop');
						
						SUMR_Ec.f.bco({
							d:{ sch:'' },
							t:'bco'+'&pgN='+_pgn,
							s:function(d){
								_tot_bco = d.tot;
								$('#{$__id_upld_bco} ._ls').html( d.html );
								___bco_a();
							}
						});
						
					});
					
				});
	
	
				$('#UplBco_Bx .sch input').on('keypress', function(e){
					if(e.which == 13){
						snd_sch({'which':e.which, 'v': $(this).val()});
					}
				});
	
				$('#_bco_sch').click(function(){
					$('#dv_new_".$___Ls->id_rnd."').hide('slow');
					$('#_new_use').removeClass('_use_cls');	
					$('#_new_use').addClass('_new_use');
					$('#_new_use').css('background-image', 'url(".DMN_IMG_ESTR_SVG.'ec_cmnt_add.svg'.")');
					snd_sch({'which':'', 'v': ''});
				});
	
				$('.bck').click(function(){
					if(_pgn > 0){
						_pgn = (_pgn-1);
						console.log('Atras '+_pgn);
						snd_sch({'which':'', 'v': ''});
					}
				});
				
				$('.nxt').click(function(){
					console.log('_tot_bco');
					if(_pgn < _tot_bco){	
						_pgn = (_pgn+1);
						console.log('Adelante '+_pgn);
						snd_sch({'which':'', 'v': ''});
					}
					
				});
				
				function snd_sch(e){
					
					if(e.which == 13){ _sch = e.v; }
					else{ _sch = $('#UplBco_Bx .sch input').val(); }
					
					SUMR_Ec.f.bco({
						t:'bco'
						+'&_bcofl_id='+$('#_bcofl_id').val()
						+'&_bcofl_are='+$('#_bcofl_are').val()
						+'&_bcofl_tag='+$('#_bcofl_tag').val()
						+'&_bcofl_w='+$('#_bcofl_w').val()
						+'&_bcofl_h='+$('#_bcofl_h').val()
						+'&_bcofl_mk='+$('#_bcofl_mk').val()
						+'&_bcofl_mdl='+$('#_bcofl_mdl').val()
						+'&pgN='+_pgn
						+'&_sch='+_sch
						,
						b_s:function(){
							$('#{$__id_upld_bco} ._ls').html('');
						},
						s:function(d){
							if(_pgn > 0){
								$('.bck').css('cursor','pointer');
							}else{
								$('.bck').css('cursor','not-allowed');
							}
							
							if(_pgn < _tot_bco){	
								$('.nxt').css('cursor','pointer');
							}else{
								console.log('4');
								$('.nxt').css('cursor','not-allowed');
							}
							
							$('#{$__id_upld_bco} ._ls').html( d.html );
							___bco_a();
						}
					});	
				}
				
				/*
				SUMR_Ec.f.edt_rfrsh({
					'_t':'snd_ec_cmz'
				});
				*/
			";
			
		?>
	</div>	

<?php } ?>

<div id="<?php echo $__id_upld_bx ?>" class="UplImg_Bx" <?php if($__t != 'cmz_hdr'){ ?> style="display:none;" <?php } ?> >
	<style>
		.chck{ width: 80%; margin: 0 auto; }
		.chck .info_img{ width: 100px;margin: 30px auto;height: 100px;background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>warning.svg); }
		.chck .info_tx{ color: #b7b7b7 !important;font-family: Economica;font-size: 20px !important; }
		.chck .check_prm{ position: relative;padding: 5px 10px;margin: 5px 0; }
		.chck .check_prm.error{border: 1px solid #f87b00;border-radius: 10px;}
		.chck .check_prm h3{ font-family: Roboto !important;color: #b6b6b6 !important;width: calc(100% - 70px) !important;vertical-align: middle;margin: 10px 0 !important;margin-left: -70px !important;font-size: 15px !important; }
		.chck .check_prm .__slc{ width: auto !important;position: absolute;right: -25px;top: 50%;transform: translate(-50%, -50%);-webkit-transform: translate(-50%, -50%); }
		.chck .next_ec_img{margin: 30px auto;font-size: 19px;padding: 10px 20px;border: 0;  color: #525961;cursor: pointer;}
		.chck .next_ec_img:hover{ background-color: #a4a4a4; }
		.chck .info_tx.info_r{font-size:16px !important}
	</style>
	<div class="chck">
		<div class="info_img" ></div>
		<p class="info_tx">Por favor tenga en cuenta lo siguientes puntos antes de subir una imagen:</p>

		<?php 
			$adv = GtLsBcoAdv(); 

			foreach($adv as $k => $v){

				if($v->chk == 1){
					echo HTML_chck([ 'id'=>'check_prm'.$v->id, 'ph'=>$v->tx, 'v'=>'', 'tp'=>'in', 'dc'=>'check_prm' ]);
				}else{
					echo '<p class="info_tx info_r">'.$v->tx.'</p>';
				}
				
			}
		?>
		
		<button class="next_ec_img">Continuar</button>

		<?php 
		
				$CntWb .= '

					$(".next_ec_img").off("click").click(function(e){

						e.preventDefault();	

						if(e.target != this){    
							e.stopPropagation(); 
							return false;  
						}else{

							var bck = true;

							$(".check_prm input").each(function() {

								var chk = $(this).attr("id");

								var condiciones = $("#"+chk).is(":checked");

								if (!condiciones) {
									bck = false;
									$("#"+chk+"_div").addClass("error");
								} else{
									$("#"+chk+"_div").removeClass("error");	
								}

							});

							if(bck == true){
								$(".chck").hide("fast");	
								$(".form_img_ec").show("fast");	
							}
						}

						

					});


					$(".check_prm").change(function () {

						
						
					});';

		?>		
	</div>

	<div class="form_img_ec" style="display:none;">
		<form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.'?_t=upl_img_cmz&'; ?>" enctype="multipart/form-data">
			<div id="<?php echo $__id_drop ?>" class="_drop">
				Arrastre Aquí
				<a>Explorar</a>
				<input type="file" name="upl" multiple />
                <input id="_i" name="_i" type="hidden" value="<?php echo $row_Dt_Rg[$IdEl] ?>" />
                <input id="_nm" name="_nm" type="hidden" value="<?php if($FleNm!=''){ echo $FleNm; }else{ echo $__t; } ?>" />
                <input id="_bd" name="_bd" type="hidden" value="<?php echo $BdEl ?>" />
                <input id="_id" name="_id" type="hidden" value="<?php echo $IdEl ?>" />
                <input id="_fl" name="_fl" type="hidden" value="<?php echo $ImNm ?>" />
                <input id="_dr" name="_dr" type="hidden" value="<?php echo $DrIm ?>" />
                <input id="_tp" name="_tp" type="hidden" value="<?php echo $__t ?>" />
                <input id="id_eccmz" name="id_eccmz" type="hidden" value="<?php echo $__cmz; ?>" />
                <input id="id_img" name="id_img" type="hidden" value="<?php echo $__img; ?>" />

				<?php if(!isN($__img_d)){ ?>
					<input id="_eccmz_img_d" name="_eccmz_img_d" type="hidden" value="<?php echo $__img_d; ?>" /> 
				<?php } ?>

                <?php if($DrPth != ''){ ?>
                	<input id="_pth" name="_pth" type="hidden" value="<?php echo $DrPth ?>" />
                <?php } ?>
                
                <?php if($__max_w != ''){ ?>
                	<input id="maxw" name="maxw" type="hidden" value="<?php echo $__max_w; ?>" /> 	   
                <?php } ?>
                
                <?php if($__max_h != ''){ ?>
               		 <input id="maxh" name="maxh" type="hidden" value="<?php echo $__max_h; ?>" /> 
                <?php } ?>
                
                <?php if($__max_d != ''){ ?>
               		 <input id="maxd" name="maxd" type="hidden" value="<?php echo $__max_d; ?>" /> 
                <?php } ?>
                
                
                <input name="MM_update" type="hidden" value="ImgUpl" />
			</div>
			<ul></ul>
		</form>
		
		<div id="Dt_Im" <?php if($row_Dt_Rg[$ImNm] == ''){ ?> style="display:none;" <?php } ?>>
			<div id="LdEdtPbImg"></div>
			<?php 
				echo bdiv([ 'id'=>DV_IMG.'_Img' ]); 
				echo UpLdImg([ 'icn'=>ID_LDR_PRC.'_Img', 'dv'=>DV_IMG.'_Img', 'fl'=>DT_GN, 'm'=>[ '_t'=>'img', 'Img'=>$DrIm.$row_Dt_Rg[$ImNm].$DrPth_Get ], 'tp'=>2 ]); 
			?>
		</div>

		<div id="UplImg_Rqu" class="UplImg_Rqu">
			<h2>Requisitos</h2>
		    <ul>
		    	<li><?php echo Spn('Formato').'JPG' ?></li>
		        <li><?php echo Spn('Tamaño Mb').'Máximo 5 Mb' ?></li>
		        
		        <?php if($__t != 'cmz_hdr'){ ?>
		       		<li><?php echo Spn('Tamaño Px').'Máximo 1200 x 1080 px' ?></li>
		        <?php }else{ ?>
		        	<li><?php echo Spn('Tamaño Px').'Máximo 600 x 200 px' ?></li>
		        <?php } ?>
		        
		    </ul> 
		</div>
	</div>
</div> 


<?php //if(ChckSESS_superadm()){ ?>
	
	<div class="_fl_new" style="display: none">
		<a href="javascript:void(0)" id="_new_use" name="_new_use" class="_new_use" style="text-align: center; display: block;">Filtros Avanzados</a><br>
		<form method="POST" id="frm_new" class="FmTb" name="frm_new" target="_self">
			<div id="dv_new_<?php echo $___Ls->id_rnd; ?>" name="dv_new_<?php echo $___Ls->id_rnd; ?>" class="_new_use_bx">
				<?php echo HTML_inp_tx('_bcofl_id', 'Identificador (Numeros)', _GPJ(array('j'=>$__f_g, 'v'=>'fl_bcoflid' )), FMRQD_NMR); ?>
				<?php //echo LsAre('_bcofl_are',  'id_are', _GPJ(array('j'=>$__f_g, 'v'=>'fl_bcoflare')), '', 2, 'ok'); $CntWb .= JQ_Ls('_bcofl_are', FM_LS_SLFAC); ?>
				<?php echo LsSis_SiNo('_bcofl_tag','id_sissino', $_GET['fl_bcofltag'], 'Etiquetas', 2, 'ok', 'Etiquetas'); $CntWb .= JQ_Ls('_bcofl_tag', 'Etiquetas');	?>
				<?php echo LsBcoK('_bcofl_w','bcoattr_v', $_GET['fl_bcoflw'], 'Seleccione Ancho (Width)', 2, 'ok', 'Width'); $CntWb .= JQ_Ls('_bcofl_w', 'Width');	?>
				<?php echo LsBcoK('_bcofl_h','bcoattr_v', $_GET['fl_bcoflh'], 'Seleccione Alto (Height)', 2, 'ok', 'Height'); $CntWb .= JQ_Ls('_bcofl_h', 'Height');	?>
				<?php echo LsBcoK('_bcofl_mk','bcoattr_v', str_replace('*.',' ',$_GET['fl_bcoflmk']), 'Seleccione Fabricante', 2, 'ok', 'Make'); $CntWb .= JQ_Ls('_bcofl_mk', 'Make');	?>
				<?php echo LsBcoK('_bcofl_mdl','bcoattr_v', str_replace('*.',' ',$_GET['fl_bcoflmdl']), 'Seleccione Modelo', 2, 'ok', 'Model'); $CntWb .= JQ_Ls('_bcofl_mdl', 'Model');	?>
				<!--<?php echo SlDt('_bcofl_f1', $_GET['fl_bcoflf1'],'ok','', TX_ORD_FIN, 'no', '', 'ok'); ?>
				<?php echo SlDt('_bcofl_f2', $_GET['fl_bcoflf2'],'ok','', TX_ORD_FOU, 'no', '', 'ok'); ?>-->
				<a href="javascript:void(0)" id="_bco_sch" name="_bco_sch" class="_bco_sch" style="text-align: center; display: block;">Buscar</a>
			</div>
		</form>
	</div>
	
	<div id="<?php echo $__id_upld_bco ?>" class="UplBco_Bx" style="display:none;">	
		<div class="sch">
			<?php echo HTML_inp_tx('sch', 'buscar', ''); ?>
		</div>
		<ul class="uplbco _ls"></ul>
	</div>
	
	<div class="bco_pg" style="display: none;">
		<a class="bck _anm" ></a>
		<a class="nxt _anm" ></a>
	</div>

	
	<?php $CntWb .= "
				
				
		
		function Dom_Bco_Rbld(){		

			$('#_new_use').off('click').click(function(){
				
				var _cls = $(this).attr('class');
				
				if(_cls == '_new_use'){
					$('#_new_use').css('background-image', 'url(".DMN_IMG_ESTR_SVG.'cancel.svg'.")');
					$('#_new_use').removeClass('_new_use');
					$('#_new_use').addClass('_use_cls');
					$('#dv_new_".$___Ls->id_rnd."').show('slow');
				}else if(_cls == '_use_cls'){
					$('#dv_new_".$___Ls->id_rnd."').hide('slow');	
					$('#_new_use').removeClass('_use_cls');	
					$('#_new_use').addClass('_new_use');
					$('#_new_use').css('background-image', 'url(".DMN_IMG_ESTR_SVG.'ec_cmnt_add.svg'.")');
				}
			
			});
		
		}
		
		
		Dom_Bco_Rbld();
	   
	"; ?>
	
<?php //} ?>



<style>
	
	._fl_new h3._alrt{ text-align: center; font-family: Economica; color: #918d66; }
	._fl_new span._alrt{ text-align: center; font-family: Economica; color: #a6a7a7; margin: auto; display: block; }
	
	.bco_pg{ text-align: center; }
	
	.bco_pg a{ cursor: pointer; display: inline-block; }
	
	
	.bco_pg .bck{ margin-right: 10px; }
	.bco_pg .nxt{ margin-left: 10px; }
	.bco_pg .bck{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>bco_btn_prev.svg'); width: 32px; height: 32px; opacity: 0.5; }
	.bco_pg .nxt{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>bco_btn_nxt.svg'); width: 32px; height: 32px; opacity: 0.5; }
	.bco_pg .bck:Hover { opacity: 1; }
	.bco_pg .nxt:Hover { opacity: 1; }
	
	.bco_pg .nxt,
	.bco_pg .bck{ background-size: 100% auto;}
	
	
	
	.upl_opt{ text-align: center; padding-top: 60px; }
	.upl_opt span{ font-family: Economica; text-transform: uppercase; }
	
	.upl_opt ._upl,
	.upl_opt ._bco{
		width: 150px;
		padding-top: 140px;
		padding-bottom: 20px;
		color: #ffffff;
		display: inline-block;
		vertical-align: top;
		background-repeat: no-repeat;
		background-position: center 35px;
		background-size: 50% auto;
		border-radius:8px !important; -moz-border-radius:8px !important; -webkit-border-radius:8px !important;
		border: 3px dashed #4d5960;		
		cursor: pointer;
		margin-right: 20px;
		margin-left: 20px;
	}
	
	.upl_opt ._upl:hover,
	.upl_opt ._bco:hover{
		background-color: rgba(255, 255, 255, 0.05);
	}
	
	.upl_opt ._upl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>ec_up_opup.svg'); }
	.upl_opt ._bco{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>ec_up_opbco.svg'); }
	
	
	.uplbco{ padding: 0; margin: 0; width: 90%; margin-left: auto; margin-right: auto; text-align: center; padding-bottom: 50px; }
	.uplbco li{ display: inline-block; width: 70px; height: 70px; list-style: none; padding: 0; margin: 0; background-size: auto 100%; background-repeat: no-repeat; background-position: center center; border: 2px solid rgba(255, 255, 255, 0.7); margin-right: 10px; margin-bottom: 10px; border-radius:7px;
-moz-border-radius:7px;
-webkit-border-radius:7px; cursor: pointer; opacity: 0.5; }
	.uplbco li:hover{ border: 2px solid #00ff1f; opacity: 1; }

	
	#UplBco_Bx .sch{ width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 20px; }
	#UplBco_Bx .sch input{ width: 98%; background-color: rgba(0, 0, 0, 0.3)!important; border: none; text-align: center; color: #ffffff; }
	
	._bco_sch{
		width: 20%; 
		background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>search.svg');
	}
	
	#_new_use{
		width: 160px; 
		background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>ec_cmnt_add.svg');
		overflow: hidden;
		text-overflow: ellipsis;
	}
	
	#_new_use, ._bco_sch{
		margin-top: 20px;
		color:#a9a9a9 !important;
		text-transform:uppercase;
		font-family:Economica;
		display:none;
		font-size:12px;
		font-weight:300;
		border-radius:8px;
		-moz-border-radius:8px;
		-webkit-border-radius:8px;
		background-color: #ffffff;
		margin-left: auto;
		margin-right: auto;
		padding: 10px 25px 10px 45px;
		text-decoration: none !important;
		background-size: 20px auto;
		background-position: 10px center;
		background-repeat: no-repeat;
		border: 1px solid #bbbbbb !important;
		white-space: nowrap;
		background-color: transparent !important;
	}
	
	
	#_new_use:hover, ._bco_sch:hover{
		color:#789bbd !important;
		text-decoration: none;
		border: 1px solid #232323;
	}
	
	
	._new_use_bx{
		width: 70%;margin:auto;display: none; position: relative;
	}
	
	._new_use_bx ._use_cls{
		width:16px; height: 16px; cursor:pointer;position:absolute !important;z-index:10;width:16px;cursor:pointer;position:relative;top:0px !important;z-index:10;right:0% !important; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg');
	}
	
	
	._new_use_bx .___txar input[type=text]{
		width:100%!important; background:rgba(255, 255, 255, 0.7);width:100%; margin-bottom: 10px;
	}
	
	._new_use_bx .___txar input[type=text]:hover,
	._new_use_bx .___txar input[type=text]:focus{
		background:rgb(255, 255, 255);
	}
	
</style>	

	
<?php 

$CntJV .= "
	function Upl_Bx(){
		$('#Dt_Im').fadeOut('slow', function(){
			$('#".$__id_upld_bx."').fadeIn();
		});
	}	
"; 

if($__t != 'cmz_hdr'){ 
	
	$___after_load = "	SUMR_Ec.f.icut({
							eccmz: '".$__cmz."',
							sw:'ok',
							img:{
								id: t.result.img.src.id,
								did: '".$__img_d."',
								src: t.result.img.src.u.o,
								src_f: t.result.img.src.f,
								src_o: t.result.img.src.o,
								rtio:'".urlencode($__rtio)."',
								max:{
									w:'".urlencode($__max_w)."',
									h:'".urlencode($__max_h)."',
									d:'".urlencode($__max_d)."'
								}
							}
						});
					";

}else{

	$___after_load = "

		if(!isN(t.result) && !isN(t.result.img) && !isN(t.result.img.src) && !isN(t.result.img.src.u) && !isN(t.result.img.src.u.n)){
			
			console.log('Change it');

			var new_html = '<div class=\"_edt_hdr _anm\">
								<img style=\"max-width:600px;\" width=\"600\" align=\"left\" src=\"'+t.result.img.src.u.n+'?rnd='+Enc_Rnd()+'\"> 			
								<div class=\"e_btn _anm\">
									<div class=\"_btn _up\" hdr-id=\"{$__hdr}\" hdr-tp=\"{$__hdr_tp}\" eccmz-id=\"{$__cmz}\" eccmz-dir=\"{$__dr_ec}\" title=\"Cargar\"></div>
									<div class=\"_btn _rmv\" eccmz-id=\"{$__cmz}\" title=\"Ocultar\"></div>
								</div>
							</div>';
			
			$('.ec_cmz_edt ._edt_hdr').replaceWith( new_html ).removeClass('_empty');

			SUMR_Ec.cmz.edit.dom();
			SUMR_Main.pnl.f.shw();

		}else{

			console.error('There is no all data for replace image cutted');

		}
		
	";	

}

$CntWb .= "							
		
		function ___upd_crop(){
			
			SUMR_Ec.f.edt_rfrsh({
				'_t':'snd_ec_cmz'
			});
						
		}
		
					
						
		function ___bco_a(){

			$('.uplbco li').click(function (){		

				var __i = $(this).attr('rel');
				
				swal({
				  title: '¿Deseas usar esta imagen?',
				  type: 'info',
				  showCancelButton: true,
				  closeOnConfirm: false,
				  showLoaderOnConfirm: true,
				},
				function(){
					
					if(!isN(__i)){
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url:'".FL_JSON_GN.__t('bco_use_nw', true)."',
							data: '_desc=Se ingresó en PushMail con ".CODNM_EC."".$__pem." &_bco='+__i+'&_us='+".SISUS_ID."+'&_tp=30'
						});
					}
					
					SUMR_Ec.f.bco({
						t:'bco_to_eccmz',
						d:{ 
							bco:__i,
							eccmz:'".$__cmz."',
							ecdir:'".$DrIm."',
							img:'".$__img."',
							img_d:'".$__img_d."',
							maxw:'".urlencode($__max_w)."',
							maxh:'".urlencode($__max_h)."',
							maxd:'".urlencode($__max_d)."',
						},
						s:function(d){

							if(d.e == 'ok'){
								
								var imgdv = $('#_dv_img".$__img_d." img');
								var imgnew = d.fle.src+'?_rnd='+Math.random();

								if(imgdv.length == 0){ 
									$('#_dv_img".$__img_d."').removeClass('_empty').prepend('<img src=\"'+imgnew+'\" width=\"\" height=\"\" />'); 
								}else{
									imgdv.attr('src', imgnew );	
								}

								$('#__img_uprc__dv_img".$__img_d."').attr('img-id', d.id);
								$('#__img_uprc__dv_img".$__img_d."').attr('img-src', encodeURIComponent(d.fle.src) );
								$('#__img_uprc__dv_img".$__img_d."').attr('img-src-o', encodeURIComponent(d.fle.srco) );

								SUMR_Ec.f.icut({
									eccmz: '".$__cmz."',
									img:{
										id: d.id,
										did: '".$__img_d."',
										src: d.fle.src,
										src_f: d.fle.srcf,
										src_o: d.fle.srco,
										rtio: '".urlencode($__rtio)."',
										max:{
											w:'".urlencode($__max_w)."',
											h:'".urlencode($__max_h)."',
											d:'".urlencode($__max_d)."'
										}
									},
									cl:function(){
										swal({
											title: 'Ok, todo esta listo',
											text: 'Ahora recortemos la imagen'
										});	
									}
								});
								
							}else{
								swal({
									title: 'Tuvimos problemas',
									type: 'warning',	
								});
							}
						}
					});
					
				});
				
			});
			
		}
		
		var e = $('#{$__id_upld_nw} ul');

		$('#{$__id_drop} a').off('click').click(function() {
			$(this).parent().find('input').click()
		});
		
		
		SUMR_Main.ld.f.upl( function(){

			if(jQuery().fileupload){

				$('#{$__id_upld_nw}').fileupload({
					dataType: 'json',
					sequentialUploads: true,
					dropZone: $('#{$__id_drop}'),
					add: 
					
						function(n, r) {
							var i = $('<li class=\"working\"><input type=\"text\" value=\"0\" data-width=\"48\" data-height=\"48\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"1\" data-bgColor=\"#3e4043\" /><p></p><span></span></li>');
							i.find('p').text(r.files[0].name).append('<i>' + SUMR_Ld.f.nSz(r.files[0].size) + '</i>');
							r.context = i.appendTo(e);
							i.find('input').knob();
							i.find('span').click(function() {
								if (i.hasClass('working')) {
									s.abort()
								}
								i.fadeOut(function() {
									i.remove()
								})
						});
						var s = r.submit()
					},
					progress: function(e, t) {
						var n = parseInt(t.loaded / t.total * 100, 10);
						t.context.find('input').val(n).change();								
					},
					progressall: function (e, data) {
						var n = parseInt(data.loaded / data.total * 100, 10);
						$('#{$__id_upld_nw} ._bar').fadeIn('fast').css(
							'width',n + '%'
						);
					},
					fail: function(e, t) {

						/*alert(e.result.w);*/
						t.context.addClass('error')
					},
					done: function (e, t) {
						
						var n = parseInt(t.loaded / t.total * 100, 10);

						if (n == 100 && t.result.status == 'success') {	
							
							t.context.removeClass('working').delay(1000).fadeOut('fast');
							
							$('#{$__id_upld_bx}').fadeOut('fast', function(){				
								
								/*
								SUMR_Ec.f.edt_rfrsh({
									'_t':'snd_ec_cmz'
								});
								*/
										
								$___after_load	
								
							});

						}else{
							t.context.addClass('error');
							if(t.result.w != 'undefined' && t.result.w != undefined){ alert(t.result.w); }
						}
					}
				});	
			}

		});	
		
		
		/*$(document).on('drop dragover', function(e) {
			e.preventDefault();
		});	*/
		
"; 
 ?>