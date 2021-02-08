<div class="quote_start" id="quote_start">		
	<ul class="steps _anm" id="quote_start_steps">
		<li class="sch on" id="quote_start_sch">
			<h2>Buscar/Crear <span>Cliente</span> <step>Paso 1</step> </h2>
		</li>
		<li class="sve off" id="quote_start_sve">
			<h2>Generar Id<span>Consecutivo</span> <step>Paso 2</step> </h2>
		</li>
		<li class="itms off">
			<h2>Seleccionar <span>Items</span> <step>Paso 3</step> </h2>
		</li>
	</ul>
		
	<div class="isch _anm" id="quote_start_isch">
		<?php echo HTML_inp_tx('quot_org_sch', '- ingresa un nombre, pagina web o id (documento) -', '', FMRQD); ?> 
		<?php echo HTML_inp_hd('quot_org'); ?>
		<button id="quote_start_isch_btn" class="btn-sch _anm"></button>
		<div id="quote_start_sch_org"></div>	
	</div>
	
	<div class="isve _anm" id="quote_start_isve">
		<?php echo HTML_inp_tx('quot_nm', 'Asignale un nombre a tu propuesta', '', FMRQD); ?> 
		<button id="quote_start_isve_btn" class="btn-sve _anm"></button>	
	</div>
	
</div>

<?php include(GL_RSLLR.'rsllr_quot_start_js.php'); ?>