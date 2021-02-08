<div class="dsh_scan">	
	<div class="_cvr_tmp" style="background-color:#F7F7FF; margin-top: 45px;">
		<button id="scan_demo_<?php echo $___Ls->id_rnd; ?>">Scan (Demo)</button>
	</div>	
	<div class="_txt _ld">
		<ul class="cnt-data">
			<ul>
				<li class="nm">GLORIA ALCIRA GONZALEZ MONICO</li>
				<li class="doc">51682140</li>
			</ul>
		</ul>
		<button class="go_next" id="scan_go_nxt_<?php echo $___Ls->id_rnd; ?>">Continuar <strong>10</strong></button>
	</div>
</div>

<script>	
	<?php 
	
		$_dc_start = Php_Ls_Cln($_POST['dc_start']);
	
		$CntWb .= "
			
			
			var __nxtbtn = $('#scan_go_nxt_".$___Ls->id_rnd."');
			var __nxtbtn_n = $('#scan_go_nxt_".$___Ls->id_rnd." strong');
			

			var scan_count = 10;
			
			function scan_timer_h() {
			    if(scan_count > 0){
			        __nxtbtn_n.html(scan_count);
			        scan_count--;
			        setTimeout(scan_timer_h, 700);
			    }else {
			    	scan_next_go();
			    }
			}
			
			
			function scan_next_go(){	
				$('#__sch_json_btn').click();
				SUMR_Main.pop.bck({ t:'pnl' });
			}
			
			
			$('#scan_demo_".$___Ls->id_rnd."').click(function(e){  	        
	    	
		    	e.preventDefault();
		    	
				if(e.target != this){
			    	
			    	e.stopPropagation(); return;
			    	
				}else{
					
					$('.dsh_scan ._txt').removeClass('_ld');
					
					$('#".$_dc_start."').val('51682140');
					$('#cnt_nm').val('Gloria Alcira');
					$('#cnt_ap').val('Gonzalez Monico');
					$('#cntdc_tp').val('177').trigger('change');
					$('#mdlcnt_m').val('1').trigger('change');
					$('#mdlcnt_fnt').val('11').trigger('change');
					$('#cnt_sndi').prop('checked', true );
					
					scan_timer_h();
						
				}	    
	
		    });	
		    
		    
		    
		    $('#scan_go_nxt_".$___Ls->id_rnd."').click(function(e){  	        
	    	
		    	e.preventDefault();
		    	
				if(e.target != this){
			    	
			    	e.stopPropagation(); return;
			    	
				}else{
					
					scan_next_go();
						
				}	    
	
		    });	
		    
	    
	    
	    
			
		";
		
		
	?> 
</script>
<style>

	.dsh_scan figure{  }

	.dsh_scan .cnt-data{  }
	
	.dsh_scan ._cvr_tmp{ background-image: url('<?php echo DMN_IMG_ESTR ?>cvr_scan.jpg'); background-size: auto 100%; min-height: 200px; }
	.dsh_scan ._cvr_tmp button{ background-color: transparent; font-size: 11px; margin-top: 10px; border: none; }
	
	
	.dsh_scan ._txt{ min-height: 200px; position: relative; }
	.dsh_scan ._txt._ld::before{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-size: 30px 30px; position: absolute; left: 50%; top: 50%; margin-left: -15px; margin-top: -15px; width: 30px; height: 30px; }
	
	.dsh_scan ._txt._ld .go_next,
	.dsh_scan ._txt._ld .cnt-data{ display: none;  }
	
	
	.dsh_scan ._txt .cnt-data{ }
	.dsh_scan ._txt .cnt-data ul{ list-style: none; padding: 0; margin: 50px 0 50px 0; font-family: Economica; }
	.dsh_scan ._txt .cnt-data ul li{ text-align: center; text-transform: uppercase; font-weight: 700; }
	.dsh_scan ._txt .cnt-data ul li::before{ display: inline-block; width: 20px; height: 20px; margin-right: 15px; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; }
	
	.dsh_scan ._txt .cnt-data ul li.nm{ font-size: 30px; }
	.dsh_scan ._txt .cnt-data ul li.nm::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_leads.svg); }
	.dsh_scan ._txt .cnt-data ul li.doc{ color: #7d7a7a; font-size: 25px; }
	.dsh_scan ._txt .cnt-data ul li.doc::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_docs.svg); }
	
	
	.dsh_scan ._txt .go_next{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-color: white; border: 1px solid #706c6c; padding: 10px 5px; width: 50%; margin-left: auto; margin-right: auto; font-family: Economica; text-transform: uppercase; display: block; }
	
</style>