<?php 
	$__i = $_GET['_i'];
	$__fmnm = 'EdUsPss'; // Nombre Formulario
	$__fmprc = PRC_GN.'?_t=my_pss'; // Archivo Procesa BD
	$__rnd = '_'.Gn_Rnd(20);
?>
<?php $_jsvld = VldChnPss($__fmnm,ICN_LDR_POP,DV_GNR_FM_CMPPOP); $CntWb .= $_jsvld; ?>

<div id="<?php echo DV_GNR_FM_CMPPOP ?>" class="my_pss __ld _anm">
      
      	<section class="_hdr"></section>
      
      	<form action="<?php echo $__fmprc ?>" method="POST" name="<?php echo $__fmnm ?>" target="_self" id="<?php echo $__fmnm ?>" class="_anm">
           	
            <input name="_i<?php echo $__rnd; ?>" type="hidden" id="_i<?php echo $__rnd; ?>" value="<?php echo SISUS_ENC; ?>" />
            <input type="hidden" name="MM_update" id="MM_update" value="<?php echo $__fmnm ?>" />
            <input type="hidden" name="_mypsskey" id="_mypsskey" value="<?php echo $__rnd ?>" />
            
            
            <?php if(isN($__i)){ ?>
                <input <?php echo FMRQD ?> name="us_passold" type="password" id="us_passold" placeholder="<?php echo TX_CLVACTU ?>"/>
                <input name="_i" type="hidden" id="_i" value="<?php echo SISUS_ID; ?>" />
            <?php } else {?>
                <input name="us_passold" type="hidden" id="us_passold" value="no" />
                <input name="_i" type="hidden" id="_i" value="<?php echo $__i; ?>" />
            <?php } ?>

			<?php echo Pss_Strn([ 'id'=>'pwdMeter'.$__rnd ]); ?>
			<div id="LgInFm_Cm_Ld<?php echo $__id_rnd; ?>"></div>
            

            <?php $CntWb .= "
	            			
				$('#".DV_GNR_FM_CMPPOP."').addClass('__ld');
				
				if( $('#us_pass').length == 0 ){
					$('#LgInFm_Cm_Ld".$__id_rnd."').append('<input ".FMRQD." name=\"us_pass\" type=\"password\" id=\"us_pass\" placeholder=\"".TX_NWPSW."\" />');
				}
				if( $('#us_passcnf').length == 0 ){
					$('#LgInFm_Cm_Ld".$__id_rnd."').append('<input ".FMRQD." name=\"us_passcnf\" type=\"password\" id=\"us_passcnf\" placeholder=\"".TX_CNFNWPSW."\"/>');
				}
				

			"; ?>
            <?php 
	            
	            $CntWb .= "
	            			
	            			SUMR_Ld.f.js({
		            			t:'c',
		            			u:'jquery.pss.js',
		            			c:function(){ 
		            				$('#us_pass').pwdMeter({ 
			            				idLabel:'#pwdMeter".$__rnd."',
		            					minLength: 10, 
		            				}); 	            				
		            				$('#".DV_GNR_FM_CMPPOP."').removeClass('__ld');
		            			}
	            			});
	            			
	            		"; 
	        ?>
            
            
            <input type="submit"name="but_mod" id="but_mod" value="<?php echo TXBT_GRDR ?>" class="_sndbtn" <?php echo HTML_Fm_Cnf(TX_CFED); ?> />
        
      	</form>
      
</div>
<style>
	
	.my_pss{ padding: 20px; 40px; }
	.my_pss.__ld{ opacity: 1; }
	.my_pss.__ld form{ position: relative; min-height: 200px; }
	.my_pss.__ld form:before{ top:0; opacity: 1; pointer-events: all; }
	
	.my_pss form:before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg'); position: absolute; left: 0; top: -1000px; width: 100%; height: 100%; background-repeat: no-repeat; background-position: center top 50px; background-color: white; opacity: 0; pointer-events: none; }
	
	.my_pss ._hdr{ min-height: 150px; width: 100%; background-image: url('<?php echo DMN_IMG_ESTR_SVG.'my_pss.svg'; ?>'); background-repeat: no-repeat; background-position: center center; background-size: auto 80%; }
	
	
	
	
</style>