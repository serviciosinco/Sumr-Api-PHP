<?php $__lng = GtLngLs(); ?>
<div class="my_lng __ld _anm">
	<section class="_hdr"></section>
	<h1 class="_tt">
		<div class="_anm main"><?php echo TX_CMBIDM ?></div>
		<?php foreach ($__lng->ls as $_k=>$_v) { ?>
			<div class="_anm hvr <?php echo $_v->cod; ?>"><figure><div style="background-image: url(<?php echo $_v->flg; ?>); "></div></figure><?php echo Spn($_v->nm) ?></div>
		<?php } ?>	
	</h1>
	<ul>
		<?php foreach ($__lng->ls as $_k=>$_v) { ?>
			<?php if( CRM_SES::GtSess('lng') == $_v->cod ){ $__cls='_nw'; }else{ $__cls=''; } ?>
			<li lng-cod="<?php echo $_v->cod; ?>" lng-iso="<?php echo $_v->iso->{'6391'}; ?>" class="<?php echo $__cls; ?>"><figure><div style="background-image: url(<?php echo $_v->flg; ?>); "></div></figure></li>
		<?php } ?>
	</ul>
</div>

<?php 
	
	$CntWb .= "
		
		$('.my_lng > ul > li').hover(
			function() {
				var _cod = $(this).attr('lng-cod');
		    	$('.my_lng ._tt .main').addClass('_hde');
		    	$('.my_lng ._tt .hvr.'+_cod).addClass('_shw');
			}, function() {
		    	$('.my_lng ._tt .main').removeClass('_hde');
		    	$('.my_lng ._tt .hvr').removeClass('_shw');
			}
		);
		
		
		$('.my_lng > ul > li').off('click').click(function(){
			
			var _cod = $(this).attr('lng-cod');
			var _iso = $(this).attr('lng-iso');

			
			_Rqu({ 
				f:'prc',
				t:'my_lng', 
				lng:_cod,
				iso:_iso,
				_bs:function(){ $('.my_lng').addClass('_ld'); },
				_cm:function(){ $('.my_lng').removeClass('_ld'); },
				_cl:function(_r){
					if(!isN(_r)){
						if(_r.e == 'ok'){
							
							SUMR_Ld.f.strg.s({ k:'".LCLS_L."', v:{ cod:_cod, iso:_iso }, j:'ok' });
							SUMR_Ld.lng.cod = _cod; 
							SUMR_Ld.lng.iso = _iso;
							
							$.colorbox.close();

							swal({ 
								title: '".TX_PERF."', 
								text: '".TX_ACTUZBW."',  
								type:'success' 
							},
							function(){ 
								__sis_rfrsh({ d:'".DMN_CRM."' });
							});		
						}else{
							swal({ title: '".TX_PROBLHST."', type:'error' });	
						}
					}
				} 
			});
			
		});
		
		
		
		
		$('.my_lng').removeClass('__ld');
			
		
	";

?>
	 
<style>
	
	.my_lng{ padding: 20px; 40px; }
	.my_lng.__ld{ opacity: 1; }
	.my_lng.__ld:before{ top:150px; opacity: 1; pointer-events: all; }
	.my_lng:before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg'); position: absolute; left: 0; top: -1000px; width: 100%; height: 100%; background-repeat: no-repeat; background-position: center top 50px; opacity: 0; pointer-events: none; }
	
	
	.my_lng.__ld ._tt,
	.my_lng.__ld > ul{
		display: none;
	}
	
	
	.my_lng ._hdr{ min-height: 150px; width: 100%; background-image: url('<?php echo DMN_IMG_ESTR_SVG.'my_lng.svg'; ?>'); background-repeat: no-repeat; background-position: center center; background-size: auto 80%; }
	
	.my_lng ._tt{ font-family: Economica; font-size: 20px; margin: 0; padding: 0; text-align: center; color: #929799; text-transform: uppercase; font-weight: 300; min-height: 20px; max-height: 20px; position: relative; }
	
	.my_lng ._tt .main{}
	.my_lng ._tt .main._hde{ position: absolute; top:-500px; pointer-events: none; opacity: 0; }
	
	.my_lng ._tt .hvr{ margin-left: -1000px; pointer-events: none; position: absolute; left: 0; top: 0; font-size: 16px; }
	.my_lng ._tt .hvr figure{ width: 16px; height: 16px; display: inline-block; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; border: 1px solid #acb1b2; position: relative; padding: 0; margin: 0 10px 0 0; }
	.my_lng ._tt .hvr figure div{ width: 10px; height: 10px; display: block; background-repeat: no-repeat; background-position: center center; background-size: auto 150%; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; position: absolute; left: 2px; top: 2px; }
	
	.my_lng ._tt .hvr._shw{ margin-left: 0; pointer-events: all; position: relative; }
	
	
	
	
	
	.my_lng ul{ display: block; padding: 0; margin: 0; text-align: center; width: 100%; margin-top: 20px; }
	.my_lng ul li{ display: inline-flex; max-width: 30px; cursor: pointer; }
	.my_lng ul li figure{ width: 23px; height: 23px; display: block; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; border: 2px solid #acb1b2; position: relative; padding: 0; margin: 0; }
	
	
	.my_lng ul li figure div{ width: 15px; height: 15px; display: block; background-repeat: no-repeat; background-position: center center; background-size: auto 150%; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; position: absolute; left: 2px; top: 2px; }
	
	.my_lng ul li h2{ font-size: 11px; font-family: Economica; text-transform: uppercase; color: #909597; max-width: 1px; max-height: 1px; overflow: hidden; }
	.my_lng ul li._nw figure{ border-color: var(--main-bg-color); }
	
	.my_lng._ld ._tt div,
	.my_lng._ld > ul{ display: none; }
	
	.my_lng._ld ._tt:before{ min-height: 100px; display: block; width: 100%; position: relative; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg'); background-repeat: no-repeat; background-position: center center; background-size: 20px 20px; }
	
	
	
	

</style>