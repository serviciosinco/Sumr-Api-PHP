
<div class="cl_mdl_fle_dsh dsh_cnt">
	<div class="_c _c1 _anm _scrl">
		<?php //echo h2('<button new-tp="us"></button> '.'Archivos'); ?>
		<div class="_wrp">
			<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>
		</div>
	</div>
</div>
<style>
	.cl_mdl_fle_dsh ._c1{ width: 100%; }	


	.cl_mdl_fle_dsh ._c ul .itm.off {-webkit-filter: grayscale(100%);filter: grayscale(100%);opacity: 0.5;color: black}
	 
	
	.cl_mdl_fle_dsh ._c ul .itm.on,

	.cl_mdl_fle_dsh ._c ul .itm.off:hover {-webkit-filter: grayscale(100%);filter: grayscale(0%);opacity: 1;color: black;}
	
	
	.cl_mdl_fle_dsh h2{ background-color: rgba(222, 222, 222, 0.7) !important; text-align: center; border-bottom: none !important; border-top: 1px solid #a7adb0; padding-top: 20px !important; padding-bottom: 20px !important; }
	.cl_mdl_fle_dsh ._c ul.dls{ margin: 80px 0 0 0 !important; }
	

</style>
<?php 
	
	
	
	$CntJV .= "	
	
		var SUMR_Dsh_Fle = {
								mdlfle:{}
							}; 
		function Dom_Rbld(){

			var __mdls_bx_sch_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
			
			__mdls_bx_sch_itm.not('.sch').off('click').click(function(){
			
				$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
				var _id = $(this).attr('rel');

				_Rqu({ 
					t:'mdl_fle', 
					d:'fle',
					est: est,
					_id_mdl : '".Php_Ls_Cln($__i)."',
					_id_ec : '".Php_Ls_Cln($_GET['_eC'])."',
					_id_fle : _id,
					_bs:function(){ $('.cl_mdl_fle_dsh').addClass('_ld'); },
					_cm:function(){ $('.cl_mdl_fle_dsh').removeClass('_ld'); },
					_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
				});
				
			});	
			
			SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__mdls_bx_sch_itm });
		}
	
		function MdlFleEc_Html(){
			var __mdls_bx_sch = $('#bx_mdl_".$__Rnd."');
		
			__mdls_bx_sch.html('');
			__mdls_bx_sch.append('<li class=\"sch\">".HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
			
			if(!isN(SUMR_Dsh_Fle.mdlfle['ls'])){
				$.each(SUMR_Dsh_Fle.mdlfle['ls'], function(k, v) { 
					if(!isN(v.est) && v.est >= 1){ var _cls = 'on'; }else{ var _cls = 'off'; }
					__mdls_bx_sch.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
				});	
			}
			
			Dom_Rbld();	
		}
	
		function ClSet(p){
			if( !isN(p) ){ 
								 
				if( !isN(p.cl.mdl.fle) ){ 
					SUMR_Dsh_Fle.mdlfle['ls'] = p.cl.mdl.fle.ls; 
					SUMR_Dsh_Fle.mdlfle['tot'] = p.cl.mdl.fle.tot;
				}
				
				MdlFleEc_Html();
			}
		}	
	";
	
	
	$CntWb .= " 
	
		_Rqu({ 
			t:'mdl_fle', 
			_id_mdl : '".Php_Ls_Cln($__i)."',
			_id_ec : '".Php_Ls_Cln($_GET['_eC'])."',
			_cl:function(_r){
				if(!isN(_r)){ 
					ClSet(_r);
				}
			} 
		});
	";
	
 ?>

