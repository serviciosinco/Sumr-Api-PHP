<?php 
if(class_exists('CRM_Cnx')){
	
	
	$__cmpg_dt = GtEcCmpgDt([ 'id'=>$__i, 't'=>'enc', 'q_tot'=>'ok' ]); 
	
	if(!isN($__cmpg_dt->_tot_snd)){	
		
		$_grf_tag = "";
		
		$op = (($__cmpg_dt->_tot_op*100) / $__cmpg_dt->_tot_snd);
		$err = (($__cmpg_dt->_tot_err*100) / $__cmpg_dt->_tot_snd);
		$rstn = ((($__cmpg_dt->_tot_snd-($__cmpg_dt->_tot_op+$__cmpg_dt->_tot_err)) * 100) / $__cmpg_dt->_tot_snd);
		
		$_medio1[] = "{ name:'".ctjTx(str_replace("'", "",'Abiertos'),'in')."',   y:". number_format($op, 2, '.', '') .", color:'#2E9AFE' } ";
		$_medio1[] = "{ name:'".ctjTx(str_replace("'", "",'Rebotes'),'in')."',   y:". number_format($err, 2, '.', '') .", color:'#EE4545' } ";
		$_medio1[] = "{ name:'".ctjTx(str_replace("'", "",'Sin abrir'),'in')."',   y:". number_format($rstn, 2, '.', '') .", color:'rgb(204, 204, 204)' } ";
		
		$_medio[] = "{ name:'".ctjTx(str_replace("'", "",'Enviados'),'in')."',   data:[". number_format($__cmpg_dt->_tot_snd, 2, '.', '') ."], color:'#58FA82' } ";
		$_medio[] = "{ name:'".ctjTx(str_replace("'", "",'Rebotes'),'in')."',   data:[". number_format($__cmpg_dt->_tot_err, 2, '.', '') ."],  color:'#EE4545' } ";
		$_medio[] = "{ name:'".ctjTx(str_replace("'", "",'Abiertos'),'in')."',   data:[". number_format($__cmpg_dt->_tot_op, 2, '.', '') ."],  color:'#2E9AFE' } ";
		$_medio[] = "{ name:'".ctjTx(str_replace("'", "",'Clicks'),'in')."',   data:[". number_format($__cmpg_dt->_tot_trck, 2, '.', '') ."],  color:'#04B4AE' } ";	
				                    
		$_grf_tag1 = implode(",", $_medio1);
		$_grf_tag = implode(",", $_medio);
	
	}
?>

<?php if($__f == 'prnt'){ echo h2('Resumen '); } ?>


<div id="__grph_crsl_dtl_<?php echo $___Dt->id_rnd; ?>" class="owl-carousel owl-theme no-draggable-area">
    <div class="item">	
	    <div id="Grph_bx_dt_3_2<?php echo $___Dt->id_rnd ?>" class=""><?php //% Apertura ?></div>
	</div>
	<div class="item">
	    <div id="Grph_bx_dt_3_3<?php echo $___Dt->id_rnd ?>" class=""><?php //% Apertura ?></div>	
	</div>
</div> 

<?php 
	
	
	$CntWb .= '
		
		SUMR_Main.ld.f.owl( function(){
			
			$("#__grph_crsl_dtl_'.$___Dt->id_rnd.'").owlCarousel({
				items:1,
				margin: 10,
				nav:true
			});
		
		});
	
	';
							
	
	if(!isN($_grf_tag)){
		$CntWb .= " 
	
			SUMR_Grph.f.g1({ 
				id: '#Grph_bx_dt_3_3".$___Dt->id_rnd."',
				dt_lbl: true,
				d: [".$_grf_tag."],
				tt: 'Total ', 
				tt_sb: 'Relacionados',
				c_e: false
			});
			
		";
	}
	
	if(!isN($_grf_tag1)){
		
		$CntWb .= " 
			
			SUMR_Grph.f.g2({ 
				id: '#Grph_bx_dt_3_2".$___Dt->id_rnd."',
				g_h: 350,
				g_mrg_t:0,
				g_mrg_b:0,
				d: [ ".$_grf_tag1." ],
				tt: ' ',
				tt_sb: ' ',
				dt_lbl: false,
				lgnd:true,
				dt_lbl_frmt: '{point.percentage:.1f}%',
				lgnd_frmt: function() {
		              return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
		        },
		        i_s:'50%',
		        lgnd_lyt: 'horizontal',
		        lgnd_valgn: 'bottom',
				lgnd_algn: 'center',
				lgnd_y: 0
			});
						
		";
	
	}
	
?>	

<?php } ?>
<?php $Ls_Cnt_Rg->free;  ?>