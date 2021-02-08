
<div id="tra_tme_lne" class="lead_detail _tra_tme_lne">
	<div class="cnt_tml">
		<div class="_scrl">
			<?php echo h2( Spn('','','_tt_icn _tt_icn_oth'). TX_ACTVRCNT, '__cmnt'); ?>
			<div class="_wrp">	
				<div id="Lead_Tml_Bx" class="_ls"></div>
			</div>
		</div>
		<div id="Lead_Tml_Opt" class="opt"></div>
	</div>
</div>

<?php 

	$CntWb .= "
		_Rqu({ 
			t:'mdl_cnt', 
			id:'".Php_Ls_Cln($_GET['_mdlcnt'])."',
			_bs:function(){ },
			_cm:function(){ },
			_cl:function(_r){
				
				if(!isN(_r)){
					if(!isN(_r.dsh)){
						try{

							if(!isN(_r.dsh.tml) && !isN(_r.dsh.tml.tot) && _r.dsh.tml.tot > 0){ 
								SUMR_Main.mdlcnt.f.tml_ui.init({ 
									ls:'Lead_Tml_Bx', 
									opt:'Lead_Tml_Opt',
									itms:_r.dsh.tml,
									c:function(){
										SUMR_Main.mdlcnt.f.dom();
									}
								});
							}

						}catch(e) {
							SUMR_Main.log.f({ t:'JSON mdl_cnt:', m:e });
						}
					}
				}
			} 
		});	
	";

?>