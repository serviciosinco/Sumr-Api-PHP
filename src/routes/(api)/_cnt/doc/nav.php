<?php 

	$__id_tab1 = 'TabbedPanels1_'.Gn_Rnd(20);	
	$CntWb .= "var $__id_tab1 = new Spry.Widget.TabbedPanels('$__id_tab1');";
	$_ClDt = GtClDt($_POST['cl'],'enc');

	$__scl = __LsDt(['k'=>'api_docs_tabs', 'cl' => $_ClDt->id]);
	
	$CntWb .= " 

		function LsSch(p){
			if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.str) && !SUMR_Ld.f.isN(p.ls)){
				var _ls = p.ls;
				$(p.str).bind('keyup', function() {
				    _schS = $(this).val().toLowerCase();
				    _ls.each(function(){
			            var _this = $(this).html().toLowerCase();
			            var _vle = _this.indexOf(_schS) !== -1;		
			            $(this).toggle(_vle);
			        });      
				});
			}
		}
	";

	

	$CntWb .= "

        SUMR_Api = {

            dom:function(p){
				$('.Nav_Api li').off('click').click(function(e){
					e.preventDefault();

					var url = $(this).attr('rel');
					var file = $(this).attr('data-file');
					var sis = $(this).attr('data-sis');
					var cl = $(this).attr('data-cl');
					var api = $(this).attr('data-api');
					
					SUMR_Api.Rqu({
						d:{ tp: url, fl: file, cl: ".$_ClDt->id.", sbd: sis, _cl: cl, api: api },
						_bs:function(){ $('.tend_li_form').addClass('_ldp'); },
						_cm:function(){ $('.tend_li_form').removeClass('_ldp'); },
						_cl:function(_r){ 
							if(!SUMR_Ld.f.isN(_r.ls.e) && _r.ls.e == 'ok'){
								console.log(_r.ls);
								SUMR_Api.build(_r.ls);
							}
						}
					});
					
				});
            },

			Rqu:function(p=null){

				if (SUMR_Ld.f.onl() && !SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.d.tp)){
					
					_u = 'docs/json';
					
					var __opt = $.ajax({
								type:'POST',
								url: _u,
								data: p.d,
								dataType: 'json',
								beforeSend: function() {
									if(!SUMR_Ld.f.isN(p._bs)){ p._bs(); }
								 },
								 error:function(e){
									 if(!SUMR_Ld.f.isN(p._w)){ p._w(e); }
								 },
								success:function(_r){
									if(!SUMR_Ld.f.isN(p._cl)){ p._cl(_r); }
								},
								complete:function(e){
									if(!SUMR_Ld.f.isN(p._cm)){ p._cm(e); }
								}
							});
			
					ibx['main'] = __opt;							
				}
			},
			
			build:function(p=null, fst=null){

				if(!SUMR_Ld.f.isN(fst) && fst == 'fst'){
					var conte_api = $('.Nav_Api_Div .TabbedPanelsContent:first');
				}else{
					var conte_api = $('.Nav_Api_Div .TabbedPanelsContentVisible');
				}

				conte_api.html('');
				
				var tr = '';
				var td = '';

				for(let i = 0; i < p.ls.l.length; i++) {

					td = '';

					for(let j = 0; j < p.ls.l[i].length; j++) {
						td = td+'<td>'+p.ls.l[i][j]+'</td>';	
					}

					tr = tr+'<tr>'+td+'</tr>';
				}

				tbl = '<table class=\"item_nav_api\" width=\"100%\">'+tr+'</table>';

				conte_api.append(tbl);
			}          
		};

		var url = $('.Nav_Api.TabbedPanelsTabGroup li.TabbedPanelsTab:first').attr('rel');
		var file = $('.Nav_Api.TabbedPanelsTabGroup li.TabbedPanelsTab:first').attr('data-file');
		var sis = $('.Nav_Api.TabbedPanelsTabGroup li.TabbedPanelsTab:first').attr('data-sis');
		var cl = $('.Nav_Api.TabbedPanelsTabGroup li.TabbedPanelsTab:first').attr('data-cl');
		var api = $('.Nav_Api.TabbedPanelsTabGroup li.TabbedPanelsTab:first').attr('data-api');

		SUMR_Api.Rqu({
			d:{ tp: url, fl: file, cl: ".$_ClDt->id.", sbd: sis, _cl: cl, api: api },
			_bs:function(){ $('.tend_li_form').addClass('_ldp'); },
			_cm:function(){ $('.tend_li_form').removeClass('_ldp'); },
			_cl:function(_r){ 
				if(!SUMR_Ld.f.isN(_r.ls.e) && _r.ls.e == 'ok'){
					SUMR_Api.build(_r.ls, 'fst');
				}
			}
		});

		SUMR_Api.dom(); 
    ";

?>
<div id="<?php echo $__id_tab1 ?>" class="VTabbedPanels">
	
	<ul class="Nav_Api TabbedPanelsTabGroup">
		<?php 
			foreach($__scl->ls->api_docs_tabs as $k => $v){ 
				if(!isN($v->inc_arc->vl) && $v->inc_arc->vl != 2){ $tp = 'file'; }else{ $tp = 'n_file'; }
				if(!isN($v->ls_sis->vl) && $v->ls_sis->vl != 2){ $_stp = 'sis'; }else{ $_stp = 'bd'; }
				if(!isN($v->flt_cl->vl) && $v->flt_cl->vl != 2){ $_cl = 'ok'; }else{ $_cl = 'no'; }
				if(!isN($v->api_rel->vl)){ $_api = $v->api_rel->vl; }else{ $_api = ''; }
		?>
			<li data-api="<?php echo $_api; ?>" data-file="<?php echo $tp; ?>" data-cl="<?php echo $_cl; ?>" data-sis="<?php echo $_stp; ?>" rel="<?php echo $v->bd->vl; ?>" class="TabbedPanelsTab _anm"><?php print_r($v->tt); ?></li>	
		<?php } ?>
	</ul>
	<div class="Nav_Api_Div TabbedPanelsContentGroup">
		<?php foreach($__scl->ls->api_docs_tabs as $k => $v){ ?>
			<div class="TabbedPanelsContent __c_<?php echo $v->bd->vl; ?>" id="tab_<?php echo $v->cns; ?>">
				<?php ?>
			</div>
		<?php } ?>		
	</div>
</div>
<style>
	.search{ width: 300px;outline: none;height: 40px;border-radius: 12px 12px 12px 12px;-moz-border-radius: 12px 12px 12px 12px;-webkit-border-radius: 12px 12px 12px 12px;border: 1px solid #d2d2d2;margin: 12px 0;float: right;padding: 0 15px; }
	.search:hover{background-color: #f5f5f5;border: 1px solid #929292;  }
	table {border-top: 1px solid #bfbfbf;}
</style>