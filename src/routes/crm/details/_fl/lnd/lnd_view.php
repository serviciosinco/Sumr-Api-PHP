<div class="lnd_view">
	<!--<div class="_hd"></div>-->
	<div class="_bdy">
		<div class="_slc_tp">
			<?php
	 			echo LsMdlSTp('_slc_tp_ls_view','id_mdlstp', '', TX_TP);
	 			$CntWb .= JQ_Ls('_slc_tp_ls_view', TX_TP);
			?>
		</div>
		<div class="_slc_mdl_tp">
			<select disabled="disabled" id='_slc_mdl_tp_ls_view' class='_slc_mdl_tp_ls_view' ></select>
			<?php $CntWb .= JQ_Ls('_slc_mdl_tp_ls_view', TX_TPMDL); ?>
		</div>
		<div class="_slc_mdl">
			<select disabled="disabled" id='_slc_mdl_ls_view' class='_slc_mdl_ls_view' ></select>
			<?php $CntWb .= JQ_Ls('_slc_mdl_ls_view', TX_MDLO); ?>
		</div>
		<button class="_btn"><?php echo TX_GNRR ?></button>
	</div>
</div>

<?php
	$CntJV .= "
	
		$('.lnd_view ._btn').off('click').click(function(){
			var _rnd = Math.random();
			if( isN($('.lnd_view #_slc_tp_ls_view').val()) ){
				swal('".TX_ERROR."', '".TX_SLCTP."', 'error');	
			}else if( isN($('.lnd_view #_slc_mdl_tp_ls_view').val()) ){
				swal('".TX_ERROR."', 'Seleccione tipo de modulo', 'error');	/* Ricardo */
			}else if( isN($('.lnd_view #_slc_mdl_ls_view').val()) ){
				swal('".TX_ERROR."', '".TX_SLCNMDL."', 'error');	
			}else{
				window.open('".DMN_LND.$__dt_cl->sbd."/'+_mdl_pml+'/?_lnd='+_lnd_enc+'&_mdl='+_mdl_enc+'&Rnd='+_rnd);
			}
		});
		
		$('.lnd_view #_slc_tp_ls_view').change(function(){
			SUMR_Lnd.f.Rqu({
		    	_tp:'_ls_mdl_tp',
		    	_enc:$(this).val(),
				_cl:function(_r){
				 		if(!isN(_r)){
					 		
					 		$('.lnd_view ._slc_mdl_tp #_slc_mdl_tp_ls_view').html('').attr('disabled', 'disabled');
					 		
					 		if(_r.e == 'ok'){
						 		$.each(_r.ls, function(k, v) { 
							 		if(!isN(v.id)){
							 			$('.lnd_view ._slc_mdl_tp #_slc_mdl_tp_ls_view').append('
							 				<option></option>
							 				<option value=\"'+v.id+'\">'+v.nm+'</option>
							 			').removeAttr('disabled');
						 			}
						 		});	
						 		SUMR_Lnd.f.DomRbld();
						 	}
					 		
				 		}
				} 
			});
		});
		
		$('.lnd_view #_slc_mdl_tp_ls_view').change(function(){
			SUMR_Lnd.f.Rqu({
		    	_tp:'_ls_mdl',
		    	_enc:$(this).val(),
				_cl:function(_r){
				 		if(!isN(_r)){
					 		
					 		$('.lnd_view ._slc_mdl #_slc_mdl_ls_view').html('').attr('disabled', 'disabled');
					 		
					 		if(_r.e == 'ok'){
						 		$.each(_r.ls, function(k, v) { 
							 		if(!isN(v.id)){
							 			$('.lnd_view ._slc_mdl #_slc_mdl_ls_view').append('
							 				<option></option>
							 				<option rel=\"'+v.pml+'\" value=\"'+v.enc+'\">'+v.nm+'</option>
							 			').removeAttr('disabled');
						 			}
						 		});	
						 		SUMR_Lnd.f.DomRbld();
						 	}
					 		
				 		}
				} 
			});
		});
		
		$('.lnd_view #_slc_mdl_ls_view').change(function(){
			_mdl_pml = $(' #_slc_mdl_ls_view  option:checked ').attr('rel');
		});
		
	";
?>

<style>
	.lnd_view{ display: block; width: 100%; height: 100%; }
	.lnd_view ._hd{ width: 100%; height: 30%; border: 1px solid #bd6363; display: block!important; }
	.lnd_view ._bdy{ width: 100%; height: 70%; }
	.lnd_view ._bdy ._slc_tp{ margin: auto; width: 60%; margin-top: 5%; }
	.lnd_view ._bdy ._slc_mdl_tp{ margin: auto; width: 60%; margin-top: 2%; }
	.lnd_view ._bdy ._slc_mdl{ margin: auto; width: 60%; margin-top: 2%; }
	.lnd_view ._bdy ._btn{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border: 1px solid #666666; color: #FFF; text-transform: uppercase;  cursor: pointer; background-color: #333; font: 300 13px/1em Economica; padding: 15px 25px;  width: 40%; line-height: 1px; display: block; margin: auto; margin-top: 4%; }
	.lnd_view ._bdy ._btn:Hover{ opacity: 0.7; }
</style>