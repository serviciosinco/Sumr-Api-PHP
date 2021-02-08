<div class="bld_cl_row">
	<p class="add_row"></p>
	<div class="col col1 sortable" id="sortable2"></div>
	<div class="col col2 sortable" id="sortable"></div>
</div>
<?php 
	
	$CntJV .= "

		function Dom_Rbld(){
			$( function() {
			    $( '#sortable' ).sortable();
			    $( '#sortable' ).disableSelection();
			 });
		}
		function ClGrpAre_Html(){

			$(  '#sortable' ).html('');
			$(  '#sortable2' ).html('');

			if(_mdltpfm['tot'] > 0){
				$.each(_mdltpfm['ls'], function(k, v) {
					$('#sortable').append('<div class=\"home ui-sortable cols cols_'+v.cols+'\" data-id=\"'+v.enc+'\" id=\"'+v.enc+'\"><button rel=\"'+v.enc+'\" class=\"eli_row\" type=\"button\"></button></div>');
					if(v.fld.tot > 0){				
						$.each(v.fld.ls, function(_k, _v) {
							$('#'+v.enc).append('<div data-id=\"'+_v.enc+'\" id=\"'+_v.enc_fldrow+'\" class=\"tx\"><div rel=\"'+_v.enc_fldrow+'\" class=\"eli_fld\"></div>'+_v.tt+'</div>');		
						});	
					}
				});
			}
			
			if(_mdltpfmout['tot'] > 0){
				$('#sortable2').append('<div id=\"fld_nop\" class=\"cols col1 beta cap ui-sortable\"></div>');
 
				if(_mdltpfmout['tot'] > 0){
					$.each(_mdltpfmout['ls'], function(k, v) {
						$('#sortable2 #fld_nop').append('<div data-id=\"'+v.enc+'\" id=\"'+v.enc+'\" class=\'tx no\'>'+v.tt+'</div>');
					});
				}
			}
			
			$('.beta').sortable({
				appendTo: document.body,
				items: '.tx',
				connectWith: '.home',
				receive: function (event, ui) {
					if ($(ui.item).hasClass('special')) {
						ui.sender.sortable('cancel');	
					}
				}
			});
			
			$('.add_row').off('click').click(function(){
				_Rqu({ 
					t:'cl_row', 
					d:'new_row',
					est: 'mod',
					_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
					_bs:function(){ $('.sortable').addClass('_ld'); },
					_cm:function(){ $('.sortable').removeClass('_ld'); },
					_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
				});
			});
			
			$('.eli_row, .eli_fld').off('click').click(function(event){
				event.stopPropagation();
				
				if($(this).hasClass('eli_row')){
					var tp = 'eli_row';
				}else{
					var tp = 'eli_fld';	
				}
				
				var id = $(this).attr('rel');
				
				_Rqu({ 
					t:'cl_row', 
					d: tp,
					_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
					_id : id,
					_bs:function(){ $('.sortable').addClass('_ld'); },
					_cm:function(){ $('.sortable').removeClass('_ld'); },
					_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
				});
			});

			$('#sortable').sortable({
				update: function (event, ui) {
					var enc = $(this).attr('id');
					var _order = $('#'+enc).sortable('toArray',{ attribute: 'data-id' });		
					_Rqu({ 
						t:'cl_row', 
						d:'row',
						est: 'mod',
						_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_id_row: enc,
						_ord : _order,
						_bs:function(){ $('.sortable').addClass('_ld'); },
						_cm:function(){ $('.sortable').removeClass('_ld'); },
						_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
					});					
				}	
			});
			
			$('.home').sortable({
				appendTo: document.body,
				items: '.tx',
				connectWith: '.home',
				start: function(event, ui) {
				    var enc =$(this).attr('id');
				    enc_glb = $(this).attr('id');
				    _order_old = $('#'+enc).sortable('toArray',{ attribute: 'data-id' });
				},
				over : function(event, ui){
					var _id = $(this).attr('id');
					$('#'+_id).css('background-color', '#d0d0d0');
			    },
				out: function(event, ui){
					$(this).css('background-color', '#f5f5f5');
				},
				stop: function (event, ui) { 
				 
					var enc = $(this).attr('id');
					var id = ui.item.attr('id');
					var _order = $('#'+enc).sortable('toArray',{ attribute: 'data-id' });		

					_Rqu({ 
						t:'cl_row', 
						d:'self_row',
						est: 'mod',
						_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_id: id,
						_id_row: enc,
						_ord : _order,
						_bs:function(){ $('.sortable').addClass('_ld'); },
						_cm:function(){ $('.sortable').removeClass('_ld'); },
						_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); console.log(_r); } } } 
					});									
				},
				receive: function (event, ui) {
					var enc = $(this).attr('id');
					var _order = $('#'+enc).sortable('toArray',{ attribute: 'id' });		
					var id = ui.item.attr('id');
					
					if($('#'+id).hasClass('no')){
						var _order = $('#'+enc).sortable('toArray',{ attribute: 'data-id' });						
						_Rqu({ 
							t:'cl_row', 
							d: 'nw_row',
							est: 'mod',
							_id: id,
							_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
							_id_row: enc,
							_ord : _order,
							_bs:function(){ $('.sortable').addClass('_ld'); },
							_cm:function(){ $('.sortable').removeClass('_ld'); },
							_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
						});		
					}else{
						_Rqu({ 
							t:'cl_row', 
							d: 'oth_row',
							est: 'mod',
							old: enc_glb,
							_order_old,
							_id: id,
							_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
							_id_row: enc,
							_ord : _order,
							_bs:function(){ $('.sortable').addClass('_ld'); },
							_cm:function(){ $('.sortable').removeClass('_ld'); },
							_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
						});		
					}
				}
			});
			Dom_Rbld();	
		}
		
		
		function ClSet(p){
			if( !isN(p) ){
				_mdltpfm = {};
				_mdltpfmout = {};

				if( !isN(p.cl) ){
					_mdltpfm['ls'] = p.cl.in.ls;
					_mdltpfm['tot'] = p.cl.in.tot;	
					
					_mdltpfmout['ls'] = p.cl.out.ls;
					_mdltpfmout['tot'] = p.cl.out.tot;
						
					ClGrpAre_Html();
				}
				
				if(_mdltpfm['tot'] == 0){
					$('#sortable').append('<div class=\"empty\"><h3>No hay columnas</h3><p>".TX_NW_ROW."</p></div>');	
				}
			}
		}	
	";
	
	$CntJV .= " 	
		_Rqu({ 
			t:'cl_row', 
			_id_mdl : '".Php_Ls_Cln($___Ls->gt->isb)."',
			_cl:function(_r){ 
				if(!isN(_r)){ 
					 ClSet(_r);
					 console.log(_r);
				} 
			} 
		});
	";
?>
<style>
.bld_cl_row .add_row{width:40px;height:40px;font-size:0;cursor:pointer;margin:10px auto;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg);}
.bld_cl_row .col{width:49%;display:inline-block;vertical-align:top}
.bld_cl_row .col .home{margin:10px;padding:10px;cursor:move;background-color:#f5f5f5;height:65px;border:1px dashed #c3c3c3;position:relative}
.bld_cl_row .col.col1 .tx{width:calc(33% - 30px);margin:10px!important}
.bld_cl_row .col .cols .tx{display:inline-flex;height:43px;margin:0 10px;background:#f5f8fa;color:#a2a2a2;border:1px solid #d2d2d2;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;font-size:13px;position:relative;cursor:move;pointer-events:auto;align-items:center;justify-content:center}
.bld_cl_row .col.col2 .cols_1 .tx{width:calc(100% - 20px)}
.bld_cl_row .col.col2 .cols_2 .tx{width:calc(50% - 20px)}
.bld_cl_row .col.col2 .cols_3 .tx{width:calc(33% - 30px)}
.bld_cl_row .col.col2.sortable .empty{background-position:center;background-repeat:no-repeat;background-size:100% auto;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>empty-inbox.svg);width:200px;height:200px;display:block;vertical-align:top;margin:90px auto}
.bld_cl_row .col.col2.sortable .empty h3{padding-top:175px;text-align:center;border-bottom:1px dotted #CCC;color:#CCC;font:700 25px Economica;margin-bottom:20px;margin-top:20px}
.bld_cl_row .col.col2.sortable .empty p{text-align:center;width:100%;display:block;white-space:normal;color:#ccc;font-family:Roboto}
.bld_cl_row .col.col2 .cols .tx .eli_fld,
.bld_cl_row .col.col2 .cols .eli_row{width:25px;display:none;font-size:0;cursor:pointer;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);top:0;position:absolute;background-color:#e24d5c;background-repeat:no-repeat;background-position:center;height:100%}
.bld_cl_row .col.col2 .cols .tx .eli_fld{left:0}
.bld_cl_row .col.col2 .cols .eli_row{left:-25px;border:1px dotted #c3c3c3;top:-1px;height:calc(100% + 2px);border-right:0}
.bld_cl_row .col.col2 .cols .tx:hover .eli_fld,
.bld_cl_row .col.col2 .cols.home:hover .eli_row {display:block}
.bld_cl_row .col.col1{height: 50px;width: 49%;display: inline-block;vertical-align: top;min-height: 500px;margin-top: 10px;border: 4px dashed #eaeaea;}
</style>