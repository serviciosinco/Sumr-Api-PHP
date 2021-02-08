<?php 
	
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop';
	$__id_upld = 'UplImg';
	$__id_upld_bx = 'UplImg_Bx';
	$__id_upld_nw = 'UplNwB';
	$__id_upld_bco = 'UplBco_Bx';

	$__tp = Php_Ls_Cln($_POST['tp']);
	$__img = Php_Ls_Cln($_GET['_img']);
	$__cmz = Php_Ls_Cln($_GET['id_cmz']);
	$__rtio = Php_Ls_Cln($_GET['_rtio']);
	$__pem = Php_Ls_Cln($_GET['_pem']);

	$__max_w = Php_Ls_Cln($_GET['max_w']);
	$__max_h = Php_Ls_Cln($_GET['max_h']);
	$__max_d = Php_Ls_Cln($_GET['max_d']);

	if((isset($_GET['_t']))){
		
		$__t = Php_Ls_Cln($_GET['_t']);
		$__dr_ec = Php_Ls_Cln($_GET['_dir']);
		
		if($__t == 'lnd_img_up'){
			if($__tp == "lnd_img"){
				
				$IdEl = 'id_climg'; // Id de Comparacion en Where
				$BdEl = _BdStr(DBM).TB_CL_IMG;
				$ImNm = ''; // Nombre del Campo de la Imagen
				//$DrIm = ;// Directorio de la Imagen
				$DrIm = '../_fle/lnd/img/';// Directorio de la Imagen 
				$SzBg_W = 2000;
				$SzBg_H = 2000;
				$SzTh = 200;
				$CrpRto = "16/10";
				$CrpRtoBn = 1;
				$DrPth = "img";
				$_ls = "SUMR_Lnd.Lnd_Ovr({ 'gn':'lnd_img', _sgm:'".Php_Ls_Cln($_POST['_sgm'])."' ,_mdl:'".Php_Ls_Cln($_POST['_mdl'])."' ,_lnd:'".Php_Ls_Cln($_POST['_lnd'])."' });";
				
			}
		}
		
	}
	
	if($__img != '' && $__cmz != ''){
		$_chk_img = ChkEcCmzImg(['img'=>$__img, 'eccmz'=>$__cmz]);
		$_img_id = $_chk_img->id;
		$_img_srcs = 'fl/'.$__dr_ec.'/'.$_chk_img->img->c;
		$_img_src = DMN_EC.$_img_srcs;
		$_img_srcf = '_sb/ec/'.$_img_srcs;
	}

	if($_mynm != ''){ $__t_gt=$_mynm; }else{ $__t_gt=$__t; } 
	if($DrPth == 'sis'){ $DrPth_Get = '&_sis=ok'; }
?>

<style>
	
	#_new_use{ width: 20%; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>ec_cmnt_add.svg'); }
	#_new_use, ._bco_sch{ color:#a9a9a9 !important; text-transform:uppercase; font-family:Economica; display:none; font-size:12px; font-weight:300; margin-right:10px; border-radius: 20px 20px 20px 20px; -moz-border-radius: 20px 20px 20px 20px; -webkit-border-radius: 20px 20px 20px 20px; background-color: #ffffff; margin-left: auto; margin-right: auto; padding: 10px 35px 10px 45px; text-decoration: none !important; background-size: 20px auto; background-position: 10px center; background-repeat: no-repeat; border: 1px solid #bbbbbb !important; white-space: nowrap; background-color: transparent !important; }
	#_new_use:hover, ._bco_sch:hover{ color:#789bbd !important; text-decoration: none; border: 1px solid #232323; }
	._new_use_bx{ width: 70%;margin:auto;display: none; position: relative; }
	
	._new_use_bx ._use_cls{ width:16px; height: 16px; cursor:pointer;position:absolute !important;z-index:10;width:16px;cursor:pointer;position:relative;top:0px !important;z-index:10;right:0% !important; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg'); }
	._new_use_bx .___txar input[type=text]{ width:100%!important;margin:auto!important;height:50px!important;background:rgba(255, 255, 255, 0.7);width:100%; }
	._new_use_bx .___txar input[type=text]:hover, ._new_use_bx .___txar input[type=text]:focus{ background:rgb(255, 255, 255); }
	
</style>

<?php if($__t != 'cmz_hdr'){  ?>
	<div class="upl_opt">
		<?php 
			$CntWb .= "	
				/*SUMR_Ec.f.edt_rfrsh({
					'_t':'snd_ec_cmz'
				});*/
			";
		?>
	</div>
<?php } ?>

<div id="<?php echo $__id_upld_bx ?>" class="UplImg_Bx" >	
		<form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.'?_t=up_img_lnd&'; ?>" enctype="multipart/form-data">
			<div id="<?php echo $__id_drop ?>" class="_drop">
				<?php echo TX_ARRTRAQ ?>
				<a><?php echo TX_EXPLR ?></a>
				<input type="file" name="upl" multiple />
                <input id="_i" name="_i" type="hidden" value="<?php echo $___Ls->dt->rw[$IdEl] ?>" />
                <input id="_nm" name="_nm" type="hidden" value="<?php if($FleNm!=''){ echo $FleNm; }else{ echo $__t; } ?>" />
                <input id="_bd" name="_bd" type="hidden" value="<?php echo $BdEl ?>" />
                <input id="_id" name="_id" type="hidden" value="<?php echo $IdEl ?>" />
                <input id="_fl" name="_fl" type="hidden" value="<?php echo $ImNm ?>" />
                <input id="_dr" name="_dr" type="hidden" value="<?php echo $DrIm ?>" />
                <input id="_tp" name="_tp" type="hidden" value="<?php echo $__t ?>" />
                <input id="_tp_img" name="_tp_img" type="hidden" value="<?php echo $__tp ?>" />
                <input id="id_eccmz" name="id_eccmz" type="hidden" value="<?php echo $__cmz; ?>" />
                <input id="id_img" name="id_img" type="hidden" value="<?php echo $__img; ?>" />                
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
		
		<div id="Dt_Im" <?php if($___Ls->dt->rw[$ImNm] == ''){ ?> style="display:none;" <?php } ?>>
			<div id="LdEdtPbImg"></div>
			<?php echo bdiv(['id'=>DV_IMG.'_Img']); echo UpLdImg([ 'icn'=>ID_LDR_PRC.'_Img', 'dv'=>DV_IMG.'_Img', 'fl'=>DT_GN, 'm'=>['_t'=>'img', 'Img'=>$DrIm.$___Ls->dt->rw[$ImNm].$DrPth_Get], 'tp'=>2 ]); ?>
		</div>

		<div id="UplImg_Rqu" class="UplImg_Rqu">
			<h2><?php echo TX_RQSTS ?></h2>
		    <ul>
		    	<li><?php echo Spn(TX_FRMT).'JPG, PNG, SVG' ?></li>
		        <li><?php echo Spn(TX_TMNMB).'Máximo 5 Mb' ?></li>
		        
		        <?php if($__t != 'cmz_hdr'){ ?>
		       		<li><?php echo Spn(TX_TMNPX).'Máximo 1200 x 1080 px' ?></li>
		        <?php }else{ ?>
		        	<li><?php echo Spn(TX_TMNPX).'Máximo 600 x 200 px' ?></li>
		        <?php } ?>
		        
		    </ul> 
		</div>
</div> 
<?php 

	$CntJV .= "
		function Upl_Bx(){
			$('#Dt_Im').fadeOut('slow', function(){
				$('#".$__id_upld_bx."').fadeIn();
			});
		}
	"; 
	
	$CntWb .= "SUMR_Main.upl.init({ btn:{ id:'$__id_drop' }, fm:'$__id_upld_nw', cbck:()=>{ ${$_ls} } });";

?>