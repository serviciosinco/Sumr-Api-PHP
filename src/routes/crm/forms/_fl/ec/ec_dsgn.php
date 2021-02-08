<?php
if(class_exists('CRM_Cnx')){

	$_i = Php_Ls_Cln($_GET['_i']);
	$__dtec = GtEcDt($_i, 'enc', [ 'dtl'=>[ 'are'=>'ok', 'tp'=>'ok' ] ]); 
	
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
<?php if(!isN($__dtec->id)){ ?>			
<div class="ln_1 ec_cmz_edt" id="__edt_dtl">
    	
	<div class="_see_ec _anm _cntr">
        
        <div class="spnr"></div>
		<div class="cnt"></div>
		
    </div>
    
    <?php $__id = Gn_Rnd(20); ?>
    <div class="_see_cmz _anm _expnd" id="_see_cmz_<?php echo $__id; ?>">
        
       	<button type="button" class="__btn"  onclick="SUMR_Ec.f.edt_op_pnl();"></button>
        
        <div class="_cntr">    
            
            
            <div class="_bsc">
				
	            <div class="_lsts">
					<?php 

						echo LsMdl('_mdl', 'mdl_enc', '', 'Modulo', 2, '', [ 'tp'=>$_ls_mdl_tp, 'prfx'=>'mdls_nm', 'mdl_are'=>$_ls_mdl_are ]); 
						
						$CntWb .= JQ_Ls('_mdl', TX_SLCNMDL);
						
						$CntWb .= "
						
							$('#_mdl').change(function() {
								
								$('.html_editor').fadeIn();
								$('.html_editor').html(' ');
								$('#mdl_anx_".$__id."').html('');
						
								var __id_mdl = $(this).val();

								SUMR_Ec.cmz.a.ecdsgnsgm_mdl = __id_mdl;
								SUMR_Ec.cmz.edit.ld_all();
								
								_ldCnt({ 
									u:'".Fl_Rnd(FL_DT_GN.__t('mdl_fle',true))."&_i='+__id_mdl+'&_eC=".$__dtec->enc."',
									c:'mdl_anx_".$__id."' 
								});
		
							   
							});
						";
					?>
			    </div>
		    
            </div>
		    
		    <div class="_pnl_bx">
            
	            <div class="_btn_cms"><span><span class="_icn"></span>Panel de Edición</span></div>
	            <input id="id_ecdsgn" name="id_ecdsgn" type="hidden" value="<?php echo $__dtec->enc; ?>" />
	            <input id="ecdsgnsgm_sgm" name="ecdsgnsgm_sgm" type="hidden" value="" />
	            <input id="ecdsgnimg_img" name="ecdsgnimg_img" type="hidden" value="" />
	            <div class="_txa_vle" style="display: none; z-index:90999999999;">
		        
			        <form>    
			        	<div class="html_editor" style="display: none;"></div>
			        </form>
		            
			        <input type="button" class="s grd_blue sve" name="btn_sgm" id="btn_sgm" value="guardar" style="margin-bottom: 30px;">
			        
			        <?php $__ec_tags = GtSisTagCnctLs(['id'=>'EcTagList']); echo $__ec_tags->html; ?>
		            <?php $CntWb .= " SUMR_Main.ld.f.html(function(){ SUMR_Ec.f.tags({ id:'#EcTagList li' }); }); "; ?>
			                
			        <div class="_chr"></div>
		            
				</div>
				
				<div id="mdl_anx_<?php echo $__id; ?>"></div>
				
			</div>
    
		</div>   
	</div> 
		
</div>	

<?php } ?>
			
<?php

	$CntWb .= "	

		SUMR_Ec.f.edt_stvr({
			rnd:'".$__id."',
			flow:'ok',
			id_ecdsgn:'".$__dtec->enc."',
			ecdsgnsgm_mdl:'',
			cdg:'".addslashes(ctjTx($___Ls->dt->rw['ec_cd'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']))."',
			dir:'".$__dtec->dir."'
		});
	
		SUMR_Ec.cmz.edit.ld_all();

	";

	$CntWb .= "
	

		SUMR_Main.ld.f.html(function(){
			
			
			$('#btn_sgm').off('click').click(function (){
				
				var _sgm =  $('#ecdsgnsgm_sgm').val(); 
				
				if( !isN( $('#ecdsgnsgm_vle').val()) ){
					if ( $('#ecdsgnsgm_vle').valid() == true ) {
						var _vle = $('#ecdsgnsgm_vle').val();
						var _vle_u = 'ok';
					}
				}else{
					var _vle = $('.jqte_editor').html();
					var _vle_u = '';		
				}
				
				
				if( !isN($('#ecdsgnsgm_tag').val()) ){
					var _tag = $('#ecdsgnsgm_tag').val();
				}
				
				var _mdl = $('#_mdl option:selected').val();
				
				if(!isN(_mdl) && !isN(_vle) && !isN(_sgm)){
					SUMR_Ec.f.edt_sve({
						_t:'ec_dsgn',
						_d:{
							MM_insert_sgm:'EdEcDsgn',
							ecdsgnsgm_sgm: _sgm,
							ecdsgnsgm_vle: _vle,
							ecdsgnsgm_vle_u: _vle_u,
							ecdsgnsgm_tag: _tag,
							ecdsgnsgm_mdl: _mdl,
							id_ecdsgn: '".$__dtec->enc."'
						}
					});
				}else{
					swal({
						title: '".TX_WRNSLC."',
						text: 'Selecciona un modulo para editar',
						timer: 10000,
						type: 'warning'
					});
				}																				 																						 
			});	
				
		});		
			
	"; 

?>
</div>
<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte); ?>
<?php } ?>