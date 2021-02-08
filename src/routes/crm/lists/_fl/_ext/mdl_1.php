<?php 	

	if(ChckSESS_superadm()){	
		?>
		
			<div class="cont_enc">
				<p class="_tx_enc">
					<?php echo $___Ls->dt->rw['mdl_enc'] ?>
				</p>
				<span class="confirm_txt">Texto copiado en el portapapeles</span>
			</div>

			<style>
				.cont_enc{position:relative}
				._tx_enc{background-color:#f6f6f6;padding:10px 0;color:#a4a4a4;border-radius:7px;position:relative;background-position:center left 45px;background-size:18px auto;background-repeat:no-repeat;cursor:pointer;background-image:url([FSVG]copy.svg)}
				.confirm_txt{display:none;color:green;text-align:center;width:55%;font-size:9px;background-color:#43b05c59;padding:2px 0;border:1px solid #0d8510;border-radius:3px;margin:0 auto;position:absolute;left:50%;top:-10%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}
				.confirm_txt.on{display:block}
			</style>
		
		<?php

		$CntWb .= "
		
			$('._tx_enc').off('click').click(function(e){ 

				var temp = $(\"<input>\");
				$(\"body\").append(temp);
				temp.val($('._tx_enc').html()).select(); 

				if(document.execCommand(\"copy\")){
					$('.confirm_txt').addClass('on');
					setTimeout(function(){ $('.confirm_txt').removeClass('on'); }, 4000);
					temp.remove();
				}
			});
		";
	}
		          	
	echo LsMdlS($___Ls->gt->tsb, 'mdl_mdls', 'id_mdls', $___Ls->dt->rw['mdl_mdls'], '', 1,'',[ 'cl'=>'ok']);

	$CntWb .= JQ_Ls('mdl_mdls', FM_LS_SLTP);
  	echo HTML_inp_tx('mdl_nm', TX_NM , ctjTx($___Ls->dt->rw['mdl_nm'],'in'), FMRQD); 
    echo HTML_inp_tx('mdl_pml', TX_PML, ctjTx($___Ls->dt->rw['mdl_pml'],'in'), FMRQD);
    
    
    $CntWb .= " SUMR_Main.pml.input({ tt:'#mdl_nm', pml:'#mdl_pml' });";
	
	if($___Ls->dt->tot > 0){
        $l = __Ls([ 'k'=>'sis_mdl_est', 'id'=>'mdl_est', 'va'=>$___Ls->dt->rw['mdl_est'], 'ph'=>FM_LS_SLEST ]); 
        echo $l->html; $CntWb .= $l->js;  
    }  

    if(!isN($__t3)){
    	echo HTML_inp_hd('mdl_mdlstp', ctjTx($__t3,'in')); 	   
    } 
    
?>

<div class="mdl_lnd">
	<div class="c1"></div>
	<div class="c2"><?php echo LsLnd('mdl_lnd','id_lnd', $___Ls->dt->rw["mdl_lnd"], MDL_LND, 2); $CntWb .= JQ_Ls('mdl_lnd',MDL_LND); ?></div>
</div>

<style>
	
	.mdl_dsh .mdl_lnd{ display: flex; }
	.mdl_dsh .mdl_lnd .c1{ width: 30px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_lnd.svg); background-repeat: no-repeat; background-position: left 6px; background-size: auto 55%; }
	.mdl_dsh .mdl_lnd .c2{ width: 95%;  }
	
</style>	