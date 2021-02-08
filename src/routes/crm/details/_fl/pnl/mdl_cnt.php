<?php
	
	$grphRow = GtGrphRowDt();
	
	foreach($grphRow as $_k => $_v){
		
		if($_v->id != ''){	
			
			$__id_prfx = '_'.$_v->enc;
			$__id_f = 'Shw_'.$__id_prfx;
			
			
			$_enc = "box_".$_v->enc;
			$_tt = ($_v->tt != '' && $_v->tt != NULL) ? $_v->tt : "Sin titulo";
			$_clr_bc = $_v->clr_bc;
			$_clr = $_v->clr;
			$_row = $_v->bx;
			$_pnl[$_enc]=['id'=>$_enc, 'f'=>$__id_f];
			$__grph_id = Gn_Rnd(20);
			
			
			
			//Columnas basicas
			if($_v->grph == 1){
				// -- Columnas Basicas --
				$CntJV .= " function ".$__id_f."(_p){ console.log(_p); ";
				
					$CntJV .= " 
						SUMR_Grph.f.g1({ 
							id: '.dsh_col_bx_".$_row."',
							d: _p.d,
							c: _p.c,
							tt: '', 
							tt_sb: '".$_tt."',
							c_e: false
						});
						
						$('.dsh_col_bx_".$_row."').removeClass('grph_no');
						$('.spn_tt_".$_row."').addClass('spn_tt').html('".$_tt."').css({'background-color':'".$_clr_bc."', 'color':'".$_clr."'});
					";
				
				$CntJV .= " } ";
						
			// -- Pie Basico --
			}elseif($_v->grph == 2){
			
				$CntJV .= " function ".$__id_f."(_p){ ";
				
					$CntJV .= " 

						SUMR_Main.log.f({ m:_p.d });
						$('.dsh_col_bx_".$_row."').append('<div><h3 class=\"spn_tt\">".$_tt."</h3></div>');
					 
						SUMR_Grph.f.g2({ 
							id: '.dsh_col_bx_".$_row."',
							d: _p.d,
							tt: '".$_tt."', 
							tt_sb: '',
							c_e: false
						});
						
						$('.dsh_col_bx_".$_row."').removeClass('grph_no');
						$('.spn_tt_".$_row."').addClass('spn_tt').html('".$_tt."').css({'background-color':'".$_clr_bc."', 'color':'".$_clr."'});
					
					";
				
				$CntJV .= " } ";
			
			// -- Spline --
			}elseif($_v->grph == 3){
				
				$CntJV .= " function ".$__id_f."(_p){ ";
				
					$CntJV .= " 
						
						SUMR_Grph.f.g3({ 
							id: '.dsh_col_bx_".$_row."',
							d: _p.d,
							c: _p.c,
							tt: '".$_tt."', 
							tt_sb: '',
							c_e: false
						});
						
						$('.dsh_col_bx_".$_row."').removeClass('grph_no');
						$('.spn_tt_".$_row."').addClass('spn_tt').html('".$_tt."').css({'background-color':'".$_clr_bc."', 'color':'".$_clr."'});
					
					";
				
				$CntJV .= " } ";
				
			// -- Area Spline --
			}elseif($_v->grph == 4){
				
				$CntJV .= " function ".$__id_f."(_p){ ";
				
					$CntJV .= " 
						
						SUMR_Grph.f.g4({ 
							id: '.dsh_col_bx_".$_row."',
							d: _p.d,
							c: _p.c,
							tt: '".$_tt."', 
							tt_sb: '',
							c_e: false
						});
						
						$('.dsh_col_bx_".$_row."').removeClass('grph_no');
						$('.spn_tt_".$_row."').addClass('spn_tt').html('".$_tt."').css({'background-color':'".$_clr_bc."', 'color':'".$_clr."'});
					
					";
				
				$CntJV .= " } ";
				
			// -- Tabla --
			}elseif($_v->grph == 5){
				
				$CntJV .= " function ".$__id_f."(_p){  ";
				
					$CntJV .= "
					
						$('.spn_tt_".$_row."').addClass('spn_tt').html('".$_tt."').css({'background-color':'".$_clr_bc."', 'color':'".$_clr."'});
						$('.dsh_col_bx_".$_row."').append('<div><table class=\"tble_qry tble_qry_".$_row."\"><tbody class=\"tbody_qry tbody_qry_".$_row."\"></tbody></tr></table><br><span class=\"tot_qry tot_qry_".$_row."\"></span></div>');
						
						var _row = 1;
						for(i = 0; i < _p.d._tt.length; i++){
							$('.tbody_qry_".$_row."').append('<tr class=\"Rw_'+_row+'\"><td>'+_p.d._id[i]+'</td><td>'+_p.d._tt[i]+'</td><td>'+_p.d._vl[i]+'</td><td>'+_p.d._ctg[i]+'</td></tr>');
							$('.tot_qry_".$_row."').html('Total '+_p.d._tot);
							if(_row == 1){ _row = 2; }else if(_row == 2){ _row = 1; }
						}
						
						$('.dsh_col_bx_".$_row."').removeClass('grph_no');
						
						setTimeout(function(){
							SUMR_Main.ld.f.scrll(function(){
								$('.dsh_col_bx_".$_row."').mCustomScrollbar({ setHeight:\"300px\", theme:\"dark-3\" });
							});
						 }, 2000);
						
					";
				
				$CntJV .= " } ";
				
			}
		}
	}
	
?>