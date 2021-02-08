
<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

	
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

	   <?php $___Ls->_bld_f_hdr(); ?>

	      
      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      
        <div class="ln_1 _anm" id="dv_col">
          
          <div class="col_1 _anm" style="position: relative; ">
	          	
          	<a href="<?php echo Void(); ?>" id="cmp_col" class="__cmpc"></a>
            <?php 
	            
	             $CntWb .= "
	             		$('#cmp_col').click(function() {
		             		if( $('#dv_col').hasClass('_mny') ){
			             		$('#dv_col').removeClass('_mny');
		             		}else{
			             		$('#dv_col').addClass('_mny');
		             		} 
						});
	             ";
	            
            ?>
            <div class="ln_1 _anm">
	            <?php if($___Ls->dt->tot == 1){ echo bdiv(['c'=>$___Ls->dt->rw['ec_shr'], 'cls'=>'pml']); } ?>
            	<?php ?><iframe id="__html_ec" width="100%" height="1200" frameborder="0"></iframe> <?php ?>	
            </div>
            <?php 
                
                $CntWb .= "
					function __ifr_ec(_i, _p){
					
						var __js_ls = '".Fl_Rnd(FL_JSON_GN.__t('sgn',true))."&__sgn_i='+_i+'&Rd='+Math.random();
					  	
					  	$.ajax({
							url: __js_ls,
							dataType: 'json',
				            cache: false,
				            success: function(d) {
					          var __if_url = '".DMN_SGN.'hotelopera'."/'+d.enc+'/?_proC='+_p+'&__l=ok&__edit=ok&Rnd=".Gn_Rnd(20)."';  
						      $('#__html_ec').attr('src', __if_url);
						    }
						});
					}
					
					$('#__html_ec').contents().find('img').click(function(){ 
						console.log('Some'); 
					});					
					
                 ";
                
                if($___Ls->dt->rw['ec_sis'] == 1){ $_vl_d = '1'; }
				if($___Ls->dt->tot > 0){  $CntWb .= "__ifr_ec('".$___Ls->dt->rw['id_sgn']."', '".$_vl_d."');"; }
				 
           ?>
          </div>
          
          <div class="col_2 _anm">
            <?php //if(ChckSESS_superadm()){ ?>
                <?php 
					  	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
						$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
						$__idtp_ecctc = '_ctc';
				?>
			<?php //} ?>
				  <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny _bld_ec">
			              <ul class="TabbedPanelsTabGroup">
				                <li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_bsc').Spn(TX_DTSBSC,'','_tx') ?></li>
				                <li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_cod').Spn(TX_COD,'','_tx') ?></li> 
			              </ul>
			              <div class="TabbedPanelsContentGroup">
				              <?php ?>
			                        <div class="TabbedPanelsContent">
										<?php  
											echo HTML_inp_hd('sgn_dir', $___Ls->dt->rw['sgn_dir']!=''?ctjTx($___Ls->dt->rw['sgn_dir'],'in'):SIS_Y.'_'.Gn_Rnd(10) );
											echo HTML_inp_tx('sgn_tt', TX_TT, ctjTx($___Ls->dt->rw['sgn_tt'],'in'), FMRQD, 'onblur="SUMR_Main.pml.input({ tt:\'sgn_tt\', pml:\'sgn_pml\' });"');
											echo OLD_HTML_chck('sgn_est', 'Activo', $___Ls->dt->rw['sgn_est'] );
											echo '<br><br><br>'; 
											if($___Ls->dt->tot > 0){ ?>
												<div id="_upl_fle"></div>
								                <?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_sgn',true)).Fl_i($___Ls->dt->rw[$___Ls->ino])."', c:'_upl_fle' });"; ?>
					                        <?php } ?> 	
			                        </div>
			                        <div class="TabbedPanelsContent">
										<?php echo HTML_textarea('sgn_cd', '', ctjTx($___Ls->dt->rw['sgn_cd'],'in','',['html'=>'ok']), FMRQD, 'ok', '', 30); ?>
											         
			                        </div>
			                                                                    
			              </div>
			              <?php       
                    
                    
			                    /*$CntJV .=  _DvLsFl_Vr(array('i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_ecctc, 't'=>'ec_ctc'));	
										  	  
								$CntWb .= _DvLsFl(array('i'=>$__idtp_ecctc));*/
								
								
								$___Ls->_dvlsfl_all([
								['n'=>$__idtp_ecctc,'t'=>'ec_ctc']
								]);								
										  
			               ?> 
            
			        </div>
                
            
          </div>

        </div>
      </div>
    </form>
</div>