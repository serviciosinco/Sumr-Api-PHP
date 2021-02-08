<div class="dsh_rsllr_quote">	
	<div class="c nav">
		<h2>Reseller Opciones</h2>
		<nav>
			<ul>
				<li><button>Nuevo Cliente</button><?php ?></li>
				<li><button id="rsllr_new_quot">Nueva Cotización</button></li>
				<li><button>Opt 3</button></li>
			</ul>
		</nav>	
	</div>
	<div class="c">
		Flujo de Creacionde Cotizacion
		<div id="dsh_rsllr_quote_ls"></div>
	</div>
	<div class="c">
		
	</div>	
</div>
<?php 
	
	$CntWb .= "
		
		$('#rsllr_new_quot').off('click').click(function(){
			
			_ldCnt({ 
				u:'".FL_LS_GN.__t('rsllr_quot', true).TXGN_ING.TXGN_POP."',  
				pop:'ok', 
				w:'600', 
				h:'300',
				scrl:'no'
			});
			
		});					
		
		
		_ldCnt({ 
			c:'dsh_rsllr_quote_ls',
			u:'".FL_LS_GN.__t('rsllr_quot', true)."',  
		});
			
	";					
						
?>
<style>
	
	.dsh_rsllr_quote{ display: flex; }
	.dsh_rsllr_quote > div.c{ border: 1px dashed gray; width: 40%; }
	.dsh_rsllr_quote > div.c.nav{ width: 19%; margin-right: 1%; }
	
</style>