<?php 

	echo h2('Atributos','tt_mdl_s_tp_fm_attr');
	
	?>
	<div class="bx_mdl_s_tp_fm_row_fld_attr">
		<div class="loader_attr"></div>
		<button data-fld="mdlstpfmrowfld_enc" id="add_fld_attr_btn<?php echo $___Ls->rnd; ?>" class="add_fld_attr_btn _anm new"></button>
		<div id="fm_fld_attr<?php echo $___Ls->rnd; ?>" class='fm_fld_attr_cont'></div>
	</div>
		

	<?php 

$CntJV .= "

	var SUMR_Dsh_Fm_Attr = {
		mdltpfmattr:{},
		_bx_mdltpfmfldattr: $('#fm_fld_attr".$___Ls->rnd."'),
		_bnt_add_fld_attr_btn: $('#add_fld_attr_btn".$___Ls->rnd."'),
	}; 

	function Dom_Rbld(){

		$('.eli_fld_attr_btn').off('click').click(function(){

			var id = $(this).parent().parent().attr('data-id');

			if($(this).hasClass('prc')){
				_Rqu({ 
					t:'mdl_s_tp_fm_attr', 
					_id_fld : '".$__i."',
					_cl:function(_r){ 
						if(!isN(_r)){ 
							$('.intv').removeClass('intv');
							AttrSet(_r);
						} 
					} 
				});	
			}else{
				swal({									  
					title: '".TX_ETSGR."',              
					text: '".TX_DLTFLD."!',  
					type: 'warning',                        
					showCancelButton: true,                 
					confirmButtonClass: 'btn-success',       
					confirmButtonText: '".TX_YESDLT."',      
					confirmButtonColor: '#E1544A',          
					cancelButtonText: '".TX_CNCLR."',           
					closeOnConfirm: true                   
				},										  
				function(){                               					
					_Rqu({ 
						t:'mdl_s_tp_fm_attr', 
						d:'eli',
						_id_fld : '".$__i."',
						_enc: id,
						_bs:function(){ $('.loader_attr').addClass('_ld'); },
						_cm:function(){ $('.loader_attr').removeClass('_ld'); },
						_cl:function(_r){ 
							if(!isN(_r)){
								if(!isN(_r)){ 
									$('.intv').removeClass('intv');
									AttrSet(_r); 
								} 
							} 
						} 
					}); 
				});
			}
		});

		$('.edt_fld_attr_btn').off('click').click(function(e){

			if( $(this).hasClass('prc') ){

				var id = $(this).parent().parent().attr('data-id');

				swal({									  
					title: '".TX_ETSGR."',              
					text: '".TX_SWAL_SVE."!',  
					type: 'warning',                        
					showCancelButton: true,                 
					confirmButtonClass: 'btn-success',       
					confirmButtonText: '".TX_YSV."',      
					confirmButtonColor: '#E1544A',          
					cancelButtonText: '".TX_CNCLR."',           
					closeOnConfirm: true                   
				},										  
				  function(){                               					
					_Rqu({ 
						t:'mdl_s_tp_fm_attr', 
						d:'edt',
						_id_fld : '".$__i."',
						_attr: $('#Fld_Attr').val(),
						_vl: $('#Fld_Vl').val(),
						_enc: id,
						_bs:function(){ $('.loader_attr').addClass('_ld'); },
						_cm:function(){ $('.loader_attr').removeClass('_ld'); },
						_cl:function(_r){ 
							if(!isN(_r)){
								if(!isN(_r)){ 
									$('.intv').removeClass('intv');
									AttrSet(_r); 
								} 
							} 
						} 
					}); 
				});
			}else{
				$('.attr_cont').addClass('intv');
				SUMR_Dsh_Fm_Attr._bnt_add_fld_attr_btn.addClass('intv');

				var id = $(this).parent().parent().attr('data-id');
				
				var i1 = $( '.attr_cont[data-id=\"'+id+'\"] .col_1');
				i1.html( '<input id=\"Fld_Attr\" type=\"text\" value=\"'+i1.html()+'\" placeholder=\"Atributo\">' );

				var i2 = $( '.attr_cont[data-id=\"'+id+'\"] .col_2');
				i2.html( '<input id=\"Fld_Vl\" type=\"text\" value=\"'+i2.html()+'\" placeholder=\"Valor\">' );

				$(this).addClass('prc');
				$('.eli_fld_attr_btn').addClass('prc');

				$( '.attr_cont[data-id=\"'+id+'\"]').removeClass('intv');
			}

			
		});

		$('.save_fld_attr_btn').off('click').click(function(){
			swal({									  
				title: '".TX_ETSGR."',              
				text: '".TX_SWAL_SVE."!',  
				type: 'warning',                        
				showCancelButton: true,                 
				confirmButtonClass: 'btn-success',       
				confirmButtonText: '".TX_YSV."',      
				confirmButtonColor: '#E1544A',          
				cancelButtonText: '".TX_CNCLR."',           
				closeOnConfirm: true                   
			},										  
		  	function(){                               					
				_Rqu({ 
					t:'mdl_s_tp_fm_attr', 
					d:'new',
					_id_fld : '".$__i."',
					_attr: $('#Fld_Attr').val(),
					_vl: $('#Fld_Vl').val(),
					_bs:function(){ $('.loader_attr').addClass('_ld'); },
					_cm:function(){ $('.loader_attr').removeClass('_ld'); },
					_cl:function(_r){ 
						if(!isN(_r)){
							if(!isN(_r)){ 
								$('.intv').removeClass('intv');
								AttrSet(_r); 
							} 
						} 
					} 
				}); 
		  	});
		});

		$('.cnl_fld_attr_btn').off('click').click(function(){
			$('.intv').removeClass('intv');
			$('#new_attr').remove();
		});

	}

	function Attr_Html(){

		SUMR_Dsh_Fm_Attr._bx_mdltpfmfldattr.html('');

		if(!isN(SUMR_Dsh_Fm_Attr.mdltpfmattr['ls'])){
			$.each(SUMR_Dsh_Fm_Attr.mdltpfmattr['ls'], function(k, v) { 
				SUMR_Dsh_Fm_Attr._bx_mdltpfmfldattr.append('<div class=\"attr_cont\" data-id=\"'+v.enc+'\" > 
																<div class=\"col col_1\">'+v.attr+'</div>
																<div class=\"col col_2\">'+v.vl+'</div>
																<div class=\"attr_btns\">
																	<button class=\"edt_fld_attr_btn _anm edt\"></button>	
																	<button class=\"eli_fld_attr_btn _anm eli\"></button>
																</div>
															</div>');
			});	
		}

		Dom_Rbld();
	 
	}

	SUMR_Dsh_Fm_Attr._bnt_add_fld_attr_btn.off('click').click(function(){

		$('.attr_cont').addClass('intv');
		SUMR_Dsh_Fm_Attr._bnt_add_fld_attr_btn.addClass('intv');

		SUMR_Dsh_Fm_Attr._bx_mdltpfmfldattr.append('<div id=\"new_attr\" class=\"attr_cont\" > 
															<div class=\"col col_1\"><input id=\"Fld_Attr\" type=\"text\" placeholder=\"Atributo\"></div>
															<div class=\"col col_2\"><input id=\"Fld_Vl\"  type=\"text\" placeholder=\"Valor\"></div>
															<div class=\"attr_btns\">
																<button class=\"save_fld_attr_btn _anm save\"></button>
																<button class=\"cnl_fld_attr_btn _anm cnl\"></button>
															</div>
														</div>');
		Dom_Rbld();
	});	

	function AttrSet(p){
		if( !isN(p) ){ 
			if( !isN(p.mdl_fm.attr.ls) ){ 
				SUMR_Dsh_Fm_Attr.mdltpfmattr['ls'] = p.mdl_fm.attr.ls; 
				Attr_Html();
			}
		}
	}
";

$CntJV .= " 

	_Rqu({ 
		t:'mdl_s_tp_fm_attr', 
		_id_fld : '".$__i."',
		_cl:function(_r){ 
			if(!isN(_r)){ 
				$('.intv').removeClass('intv');
				AttrSet(_r);
			} 
		} 
	});
";

?>

<style>

h2.tt_mdl_s_tp_fm_attr{width:100%;margin:0;background-color:#fff;font-family:Economica;text-transform:uppercase;font-weight:300;padding:5px 0;font-size:27px;margin-left:5px;text-align:center;color:#a7a7a7}

.bx_mdl_s_tp_fm_row_fld_attr{position:relative}
.bx_mdl_s_tp_fm_row_fld_attr .intv{opacity:.7;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);filter:grayscale(100%);pointer-events:none}
.bx_mdl_s_tp_fm_row_fld_attr .loader_attr._ld{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg)!important;background-repeat:no-repeat;background-position:center center;background-size:30px 30px;z-index:999999999;position:absolute;width:100%;height:100%;background-color:#0000000d}

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont{display:flex;width:90%;margin:5px auto;background-color:#f7f7f7;padding:13px;border-radius:12px}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .col{width:50%;text-align:center;background-color:#f2f9f3;border-radius:9px;padding:10px 0;margin:0 10px;border:2px dashed #049059}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .col input{width:93%;border:1px solid #9c9c9c;margin:0 auto;padding:10px}
.bx_mdl_s_tp_fm_row_fld_attr .add_fld_attr_btn{background-repeat:no-repeat;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mail_add.svg);height:30px;width:30px;background-size:auto 90%;margin:15px auto;display:block;border:0}

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns{position:relative}

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns button{ right:-20px;position:absolute;width:25px;display:none;height:25px;border-radius:20px;border:0; background-repeat:no-repeat;background-position:center center; }

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .edt_fld_attr_btn{top:-5px;background-size:70% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>editar.svg);background-color:#f15340}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .eli_fld_attr_btn{top:25px;right:-20px;background-size:70% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);background-color:#9aeca6}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .save_fld_attr_btn{top:-5px;right:-20px;background-size:55% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>save.svg);background-color:#f15340}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .cnl_fld_attr_btn{top:25px;right:-20px;background-size:70% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg);background-color:#9aeca6}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .edt_fld_attr_btn.prc{top:-5px;background-size:55% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>save.svg);background-color:#f15340}
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .eli_fld_attr_btn.prc{background-size:70% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg);background-color:#9aeca6}


.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .eli_fld_attr_btn:hover,
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .edt_fld_attr_btn:hover,
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .cnl_fld_attr_btn:hover{background-size:90% auto}

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont .attr_btns .save_fld_attr_btn:hover{background-size:65% auto}

.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont:hover .edt_fld_attr_btn,
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont:hover .eli_fld_attr_btn,
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont:hover .save_fld_attr_btn,
.bx_mdl_s_tp_fm_row_fld_attr .fm_fld_attr_cont .attr_cont:hover .cnl_fld_attr_btn{display:block}

</style>