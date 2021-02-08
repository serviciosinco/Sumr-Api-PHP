<?php 					
						
	$CntJV .= " 
									
		var _sto = [];
		
		SUMR_Rsllr = {
			
			tot:'',
			bse:{},
			plntp:{},
			itms:{},
			us:1
				
		};
		
		{$__tp_pln}
		{$__tp_add}
		
		SUMR_Rsllr.itms = _sto;
		
		
		function Rsllr_Cal_PlntTp(){
			
			var _usrs = parseInt( $('#usr_qty').val() );
			var _pltp = SUMR_Rsllr.plntp; 					
			var _r = '';
			
			for (var key in _pltp) {
			    if (_pltp.hasOwnProperty(key)) {
				    
				    var _o = _pltp[key];
					var _min = parseInt(_o.lmt.min);
					var _max = parseInt(_o.lmt.max);
					
					
					if(_min == '0' && !isN(_max) && _usrs <= _max){
					    _r = _o.key; 
				    }else if( !isN(_min) && !isN(_max) && _usrs >= _min && _usrs <= _max){    
					    _r = _o.key;
				    }else if(_usrs >= _o.lmt.min && isN(_o.lmt.max) ){
					    _r = _o.key;
				    }
			    }
			}

			return _r;
		}
		
		function Rsllr_currencyFormat(n) {
			if(!isN(n)){
				var _no = parseInt(n);
				var _r = '$' + _no.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
				return _r;
			}else{
				return n;
			}
		}
		
		
		
		
		function Rsllr_Itm_Html(p) {
			
			var _tot_bsc = $('.itms ul.bsnss_lne li.bsc').length;
			
			if(p.bsc == 'ok'){
				if(_tot_bsc > 0){
					$('.itms ul.bsnss_lne').find('.bsc:last').before(p.c);
				}else{	
					$('.itms ul.bsnss_lne').find('._us:last').after(p.c);
				}
			}else{	
				$('.itms ul.bsnss_lne').append(p.c);
			}
		}
		
		
		function Rsllr_No(n) {
			if(!isN(n)){
				var _no = parseInt(n);
				var _r = _no.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
				return _r;
			}else{
				return n;
			}
		}
		
		
		function Rsllr_Chk(p){
			
			var _itm_id = p.id;
			
			if ($('#itm_chk_'+_itm_id).is(':checked')) {
				$('#itm_'+_itm_id).addClass('on');
		 	}else{ 
			 	$('#itm_'+_itm_id).removeClass('on');
		 	}	
		 	
		 	Rsllr_SumTot();
		}
		
		
		function Rsllr_ShTot(p){
			$('#rsllr_psos').html( Rsllr_currencyFormat(SUMR_Rsllr.tot)+' <span>/ mes</span>' );
		}	
		
		function Rsllr_SumItm(p){
			
			if(!isN(p)){
				
				var _pltp = Rsllr_Cal_PlntTp();
				var _itm_id = p.id;
				
				if(!isN(_itm_id) && !isN(_pltp)){

					var _itm_vl = SUMR_Rsllr.itms[_itm_id][_pltp];
					var _itm_qty = $('#itm_qty_'+_itm_id);
					
					if(!isN(_itm_vl)){
							
						if(_itm_qty.length){
							
							if(!isN(_itm_qty.val()) && !isN(_itm_vl)){
								var _itm_vqty = _itm_qty.val();
								var _itm_vl = parseInt(_itm_vqty) * parseInt(_itm_vl);	
							}else{	
								var _itm_vqty = '';
								var _itm_vl = '';
							}
							
						}
						
						if(!isN(_itm_vqty)){
							var _itm_qty_bx = ' <span class=\"_qty\">'+Rsllr_No(_itm_vqty)+'</span>';
						}else{
							var _itm_qty_bx = '';
						}
						
						
						if ($('#itm_chk_'+_itm_id).is(':checked')) {
							
							SUMR_Rsllr.tot = parseInt(SUMR_Rsllr.tot + _itm_vl * 1);
							
							var _itm_rsmn = $('#itm_'+_itm_id+' .__slc_ok h3 span.tt').html();
							
							if(!isN(_itm_vl) && _itm_vl != 0){ 
								var _itm_vl_go = '<strong>'+ Rsllr_currencyFormat(_itm_vl) +'</strong> '; 
							}else if(p.bsc == 'ok'){ 
								var _itm_vl_go = '<i>Incluido</i> '; 
							}else{ 
								var _itm_vl_go = ''; 
							}
							
							var _html_go = '<li id=\"itm_rsmn_'+_itm_id+'\">'+_itm_rsmn + _itm_qty_bx + _itm_vl_go +'</li>';
							
							$('#rsllr_itms').append(_html_go);	
							
							
					 	}else{
						 	SUMR_Rsllr.tot = parseInt(SUMR_Rsllr.tot - _itm_vl * 1);
						 	$('#itm_rsmn_'+_itm_id).remove();
					 	}
					 	
					 	Rsllr_ShTot();
					 	
				 	}	
			 	
			 	}
		 	
		 	}
			
		}
		
		
		
		
		function Rsllr_SumTot(){
				
			var _pltp = Rsllr_Cal_PlntTp();
			var _usrs = $('#usr_qty').val();
			
			if( !isN(SUMR_Rsllr.plntp['usr_'+_pltp]) ){
				var _usrs_e = parseInt( SUMR_Rsllr.plntp['usr_'+_pltp].vl[_pltp] );		
			}else{
				var _usrs_e = 0;
			}
				
			var _usrs_p = _usrs_e * parseInt(_usrs) ;
			
			$('#rsllr_psos').html('');
			$('#rsllr_itms').html('').append('<li class=\"_us\">'+ _usrs +' usuario(s) <span>'+ Rsllr_currencyFormat(_usrs_e) +' c/u </span><strong>'+ Rsllr_currencyFormat( _usrs_p ) +'</strong> </li>');	
			
			
			if(!isN( SUMR_Rsllr.bse ) && !isN( SUMR_Rsllr.bse[_pltp] )){
					
				$('#rsllr_nme').html(SUMR_Rsllr.bse[_pltp].tt);
				
				SUMR_Rsllr.tot = _usrs_p + parseInt( SUMR_Rsllr.bse[_pltp].v );
				
				Rsllr_ShTot();
				
				$('.itms ul li').each(function(i){
					if( $(this).hasClass('on') ){
						var _itm_id = $(this).attr('data-itm-id');
						var _itm_bsc = $(this).attr('data-itm-bsc');
						Rsllr_SumItm({ id:_itm_id, bsc:_itm_bsc });
					}
				});
			
			}
		
		}
				
	";
	
	
	$CntWb .= "
		
		
		$('.itms ul li input[type=checkbox]').change(function(){	
			var _itm_id = $(this).attr('data-itm-id');
			Rsllr_Chk({ id:_itm_id });	
		});
		
		
		$('.itms ul li input[type=text]').change(function() {
			Rsllr_SumTot();				
		});
		
		
		$('.itms ul li ._mre').off('click').click(function(){
			
			var _itm_id = $(this).closest('li').attr('data-itm-id'); 
			
			_ldCnt({ 
				u:'".FL_DT_GN.__t('rsllr_itm', true).ADM_LNK_DT."'+_itm_id,
				c:'',
				pop:'ok',
				pnl:{
					e:'ok',
					s:'l',
					tp:'h'
				},
				cls:'_fll'
			});
						
		});
		
		
		setTimeout(function(){ Rsllr_SumTot(); }, 500);
		
				
	";
		
	
	
	
?>