<?php 
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
 	$__i = Php_Ls_Cln($_GET['__i'], 'enc');
	$__dtec = GtEcDt($__i, 'enc', [ 'dtl'=>[ 'are'=>'ok', 'tp'=>'ok' ] ]);
	
	
	if($__dtec->are->tot > 0){
		foreach($__dtec->are->ls as $_are_k=>$_are_v){
			$_ls_mdl_are[] = $_are_v->id;
		}
	}
	
	if(!isN($__dtec->tp) && $__dtec->tp->ls){
		foreach($__dtec->tp->ls as $_k=>$_v){
			$_ls_mdl_tp[] = $_v->tp->id;
		}
	}
						
?>
<div class="_fm_fnc dsh_ec_smlt"> 
    <div class="wrp">  
              
		<div class="_img" id="__url_end">
			<div style="background-image:url(<?php echo DMN_FLE_EC_IMG.$__dtec->img; ?>)" class="_img_src"></div>
		</div>	
			
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
		<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
			
			<div id="<?php echo $__id_fm ?>_flds">
  			
        <form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >

			<?php echo HTML_inp_hd('_tp', $__prfx->tp); ?>   

            <div id="<?php echo $__id_fm ?>_flds">        
					 
					<div class="_ln1">  
						<div class="_d1">
							<?php 
								echo LsMdl('ec_html_mdl', 'mdl_enc', '', '-emular modulo-', 2, '', [ 'tp'=>$_ls_mdl_tp, 'prfx'=>'mdls_nm', 'mdl_are'=>$_ls_mdl_are ]); 
								$CntWb .= JQ_Ls('ec_html_mdl', _MdlTx('-emular modulo-'));
							?> 
						</div>
                    </div>

					<ul>	
						<li class="_snd_fnc"><input type="button" class="btn" id="Do_Rqu" value="<?php echo 'Generar' ?>" /></li>		           	   
					</ul>
                
					<?php 	
						
						$CntWb .= "	


									var __go_m = '';
													
									$('#Do_Rqu').click(function() {
										
										var ec_html_mdl = $('#ec_html_mdl option:selected').val();
										if(ec_html_mdl != ''){ __go_m += '&_mdlI='+ec_html_mdl+''; } 
										
									var win = window.open('".DMN_EC.LNK_HTML.'/'.$__dtec->enc."/?'+__go_m, '_blank');
										win.focus();
									}); 

									
						";
					?>       		
				
				
			</div> 	 
				
		</form> 

    </div>
</div>

<style>
	
	
	.dsh_ec_smlt{}
	.dsh_ec_smlt ._img{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_broken.svg); background-color: #bfc3c5; background-size: auto 50%; opacity: 0.2; background-repeat: no-repeat; background-position: center center; position: relative; }
	.dsh_ec_smlt ._img ._img_src{ width: 100%; height: 100%; position: absolute; left: 0; top: 0; }
	
	
	
</style>	