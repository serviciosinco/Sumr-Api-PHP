<?php 
	
	//----------------- GET Parameters -----------------//
	
		$__sgm = Php_Ls_Cln($_POST['_sgm']);
		$__mdl = Php_Ls_Cln($_POST['_mdl']);
		$__lnd = Php_Ls_Cln($_POST['_lnd']);
		$__tab = Php_Ls_Cln($_POST['_tab']);
	
	//----------------- Process -----------------//
		
	$___sgm_dt = GtLndMdlSgmDt([ 'sgm_enc'=>$__sgm, 'mdl_enc'=>$__mdl, 'lnd_enc'=>$__lnd  ]);

?>
<div class="lnd_img">
	<div class="_ls">
		<div class="_add"></div>
		
		<?php 
			
			$ImgLs = GtImgLs();
			
			if($ImgLs->e == "ok"){
				
				foreach($ImgLs->ls as $_k => $_v){
					$_div .= " <div class='_lgo' data-img-enc='".$_v->enc."' data-img-fle='".$_v->fle."' style=\" background: url(".DMN_FLE_LND_IMG.$_v->fle."); \" ></div> ";
				}
				
				echo $_div;
				
				$CntJV .= "	SUMR_Lnd.f.DomRbld();";
				
			}
		?>
	</div>
</div>


<?php 
	$CntJV .= "
		
		SUMR_Lnd.sgm = '".$__sgm."';
		SUMR_Lnd.mdl = '".$__mdl."';
		SUMR_Lnd.lnd = '".$__lnd."';
		
		SUMR_Lnd.f.DomRbld();
		
	";
?>


<style>
	
	.lnd_img{ display: inline-block; width: 100%; height: 100%; }
	.lnd_img ._ls{ display: inline-block; margin-left: 20px; }
	.lnd_img ._ls ._add{ width: 100px; height: 100px; display: inline-block; background: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_add_lgo.svg'); background-repeat:no-repeat; background-position: center center; margin-left: 5px; margin-top: 5px; -webkit-filter: grayscale(100%); filter: grayscale(100%); cursor: pointer; opacity: 0.3; background-size: auto 50%; border: 2px dashed #b7bfbe; }
	.lnd_img ._ls ._add:hover{ opacity: 0.6; }
	
	.lnd_img ._ls ._lgo{ display: inline-block; width: 100px; height: 100px; background-repeat:no-repeat !important; background-size: auto 70% !important; margin-left: 5px; margin-top: 5px; cursor: pointer; background-position: center center !important; vertical-align: top; border: 2px dotted #c2c6c7; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }
	.lnd_img ._ls ._lgo:Hover{ opacity: 0.7; border-color:var(--main-bg-color); }

</style>