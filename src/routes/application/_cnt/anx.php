<?php 
	$__i = Php_Ls_Cln($_POST['__i']);
	$__t = Php_Ls_Cln($_POST['_t']);
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;

?>
<div class="contr">
	<div class="header" style="  margin: 15px auto;  width: 700px;
	    background-image: url(https://fle.sumr.cloud/cl/lgo/lght/9dabba8….svg);
	    height: 100px;background-image:url(<?php echo $__cl->lgo->lght->big ?>);"></div>
	<div id="UplImg_Bx" class="UplImg_Bx" <?php if($row_Dt_Rg[$ImNm] != ''){ ?> style="display:none;" <?php } ?>>
	
		<p style="text-align: center;font-size: 17px;color: var(--font-s-prgddr);">Recuerda que los documentos marcados con la (x) son obligatorios.</p>
	
	    <form id="<?php echo $__id_upld_nw ?>" class="UplNwB" method="post" action="up/upl_anx.php" enctype="multipart/form-data">
		        
		    <div>    
		        <div id="<?php echo $__id_drop ?>" class="_drop ok _anm">
		            
		            <div class="_bar"></div>
		            <?php echo TX_ARRTRAQ ?><br>
		            <span class="tp_doc"></span>
		            	<?php
	
					        echo Spn(TX_FLE_SUP.' (JPG, PDF)'); 
	 
				        ?>   
				        
		            <a><?php echo TX_EXPLR ?></a>
		            <input type="file" name="upl" multiple />
		            <input id="id_appl" name="id_appl" type="hidden" value="<?php echo $__pm_3; ?>" />
		            <input id="id_tp" name="id_tp" type="hidden" value="" />
		            <input id="___cl" name="___cl" type="hidden" value="<?php echo $__cl->enc ?>" />
		            <input name="MM_update_fle" type="hidden" value="FleUplNw" />
		            
		        </div>
		        <?php  ?>
		        <div class="ls_anx _anm">
			        <ul class="itms_anx"> </ul>
		        </div>
	        </div>
	        <ul class="anx_ing"></ul>
	    </form>
	</div> 
</div>
<style>
	
	.contr{ position: absolute;width: 700px;left: 50%;top: 45%;-moz-transform: translate(-50%, -50%);-o-transform: translate(-50%, -50%);-ms-transform: translate(-50%, -50%);-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%); }
	#UplImg_Bx{min-height:300px;text-align:center;margin:0 auto;border:4px dashed #bbb;}
	#UplImg_Bx .UplNwB{width:100%;background-color:#fff;position:relative}
	#UplImg_Bx ._drop.ok{background-color:#e8e8e8;border:0!important;width:50%;display:inline-block}
	#UplImg_Bx .ls_anx.ok{width:33%;display:inline-block}
	#UplImg_Bx .ls_anx{width:33%;display:inline-block;vertical-align:top;margin-left:50px}
	#UplImg_Bx .ls_anx li{cursor:pointer;height:40px!important;color:#9e9e9e!important;padding:10px!important;margin:10px 0}
	#UplImg_Bx .UplNwB .ls_anx ul{border:0}
	#UplImg_Bx .UplNwB .ls_anx ul li.on span{width:15px;height:100%;display:inline-block;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>check-mark.svg);top:0;right:5px}
	#UplImg_Bx .UplNwB .ls_anx ul li.off span{width:15px;height:100%;display:inline-block;background-image:none;top:0;right:5px}
	#UplImg_Bx .UplNwB ul{border:0!important}
	#UplImg_Bx .ls_anx li{cursor:pointer;height:40px!important;color:#5f5656!important;padding:10px!important;margin:10px 0;border:2px dashed #d8d8d8!important;border-radius:4px;background-color:#f3f3f3!important;background-image:none!important}
	#UplImg_Bx .ls_anx li:hover{background-color:var(--font-s-prgddr)!important}
	#UplImg_Bx .UplNwB ._drop .tp_doc{display: block;font-size: 15px;font-weight: 600;color: var(--font-s-prgddr);padding: 5px 0;}
	
	#UplImg_Bx .ls_anx li._anm.itm.mdlfm.off.rqd_1 span {width: 15px !important;height: 100% !important;display: inline-block !important;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_mn_chkno.svg) !important;top: 0 !important;right: 5px !important;}
	
	#UplImg_Bx ._drop a,
	#UplImg_Bx ._drop a:hover{background-color: var(--font-s-prgddr);}
</style>

<?php $CntWb .= "

	function Ajax(){
		$.ajax({
		    type:'POST',
		    	url: '/json/anexos.json', 
		    	data : { cnt_appl : '".$__pm_3."', cl : '".$__cl->enc."' },
		    	dataType: 'json',
		    	success: function(e){
		    		if(!isN(e)){
			    		if(!isN(e.cnt.anx)){
				    		ClSet(e.cnt.anx);	
			    		}
		    		}
			}
		});	
	}
	
	Ajax();

	function ClSet(_r){
		
		$('.itms_anx').html('');
		
		$.each(_r.ls, function(k, v) {

			if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
			$('.itms_anx').append('<li class=\"_anm itm mdlfm '+_cls+' rqd_'+v.vl+' \" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span></span>'+v.nm+'<figure></figure></li>');
		});	

		Dom_Rbld();
			
	}
	
	function Dom_Rbld(){
		$('.ls_anx li').off('click').click(function() {  
	    
		    Ajax();
		    
		    rel = $(this).attr('rel');  
		    $('#id_tp').val(rel);  
			$(this).addClass('ok');	
			$('.tp_doc').text($(this).text());
			
			

	    });	
	}

            
    var e = $('#{$__id_upld_nw} ul.anx_ing');
    
    
    $('#{$__id_drop} a').off('click').click(function() {
	    var vl_tp = $('#id_tp').val();

	    if(vl_tp == ''){
			swal('Error', 'Porfavor selecciona el tipo de documento a subir.', 'error'); 	   
	    }else{
			$(this).parent().find('input').click();    
	    }
	    
        
    });
	
	if(jQuery().fileupload){
			
		$('#{$__id_upld_nw}').fileupload({
			
			dataType: 'json',
			sequentialUploads: true,
			dropZone: $('#{$__id_drop}'),
			add:function(n, r) {
				
					var i = $('<li class=\"working\"><input type=\"text\" value=\"0\" data-width=\"48\" data-height=\"48\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"1\" data-bgColor=\"#3e4043\" /><p></p><span></span></li>');
					i.find('p').text(r.files[0].name).append('<i>' + SUMR_Ld.f.nSz(r.files[0].size) + '</i>');
					r.context = i.appendTo(e);
					i.find('input').knob();
					i.find('span').click(function() {
						if (i.hasClass('working')) { s.abort(); }
						i.fadeOut(function(){ 
							i.remove();
						})
					});
				
				var s = r.submit();
			},
			beforeSend:function(e, data){
				var vl_tp = $('#id_tp').val();

				if(vl_tp == ''){
					swal('Error', 'Porfavor selecciona el tipo de documento a subir.', 'error');
					return false;	   
				}

			},
			progress: function(e, t) {
				var n = parseInt(t.loaded / t.total * 100, 10);
				t.context.find('input').val(n).change();								
			},
			progressall: function (e, data) {
				var n = parseInt(data.loaded / data.total * 100, 10);
				$('#{$__id_upld_nw} ._bar').fadeIn('fast').css('width', n + '%');
			},
			fail: function(e, t) {
				t.context.addClass('error')
			},
			done: function (e, t) {
				var n = parseInt(t.loaded / t.total * 100, 10);
				if (n == 100 && t.result.status == 'success') {	
					t.context.removeClass('working').delay(1000).fadeOut('fast');
					Ajax();
				}else{
					t.context.addClass('error');
					if(!isN(t.result.w)){ swal('Error', t.result.w, 'error'); }
				}
			},
			stop: function (e) {
					
			}
		});
	
	}	
    
    /*$(document).on('drop dragover', function(e) {
        e.preventDefault();
    });*/

"; 
   
   
   
?>
