<div id="<?php echo DV_GNR_FM_CMPPOP ?>" class="ck_cod _anm">
      
      	<section class="_hdr"></section>
            
            
        <div class="_bx">
	        <div class="_c _c1">
		        <h1>
			        <?php /*Seguimiento del sitio web 
			        <span>Etiqueta de sitio web</span> */?>
			        <?php echo TX_SGM_WB; ?>
			    </h1>
				
				
				<?php 
					$_txt_id = 'ta_'.Gn_Rnd(50);
					
					
					echo HTML_textarea($_txt_id, '', __CkCod([ 'prfl'=>DB_CL_PRFL ]) ,'','','','','','',' readonly="readonly" '); 
					
					
					$CntWb .= "
					
						$('#".$_txt_id."').off('click').click(function() {
						    $(this).select();
						});
						
					";
					
  
				?>
			</div>
			<div class="_c _c2">
				
				
				<div class="_txt"><?php echo TX_CP_PG; ?> <?php echo Strn(htmlentities('<BODY>')); ?> <?php echo TX_CP_PG_2 ?>
				</div>
				
					
			</div>
        </div>
      
</div>
<style>
	
	.ck_cod{ padding: 20px; 40px; }	
	.ck_cod ._hdr{ min-height: 150px; width: 100%; background-image: url('<?php echo DMN_IMG_ESTR_SVG.'cookie_code.svg'; ?>'); background-repeat: no-repeat; background-position: center center; background-size: auto 80%; }
	
	.ck_cod ._bx{ display: block; margin-top:0px;  }
	.ck_cod ._bx ._c{ display: inline-block; vertical-align: top; }
	.ck_cod ._bx ._c._c1{ width: 100%; padding:0 10px 0 10px; }
	.ck_cod ._bx ._c._c2{ width: 100%; padding:0 10px 0 10px; }
	
	.ck_cod ._bx ._c h1{ font-family: Economica; font-size: 22px; font-weight: 300; color: #414545; text-align: center; text-transform: uppercase; width: 100%; line-height: 25px; }
	.ck_cod ._bx ._c h1 span{ font-size: 13px; color: #9ba3a6; width: 100%; display: block; }
	
	.ck_cod ._bx ._c ._txt{ font-size: 11px; text-align:center; padding: 0 10px; color: #b9b9b9; margin-top: 10px; }
	.ck_cod ._bx ._c textarea{ width: 100% !important; padding: 20px 20px 15px 20px !important; height: 130px; font-size: 11.5px; font-family: Roboto; margin: 0; color: #939697; text-align: center; opacity: 0.4; }
	
	.ck_cod ._bx ._c textarea:hover,
	.ck_cod ._bx ._c textarea:focus{ color: #666868; opacity: 1; }
	
	
</style>