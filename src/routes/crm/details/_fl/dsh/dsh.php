<?php if(class_exists('CRM_Cnx') && !isN($__t)){ ?>
	<div class="dashboard_main">
		<?php echo HTML_inp_hd('_dsh_edt',  ($_GET['_dsh_edt']=='ok')? 'ok' : 'no'); ?>
		<div class="nav">
			<div class="_nav_wrp">
				<div class="col c1"></div>
				<div class="col c2"></div>
				<div class="col c3">
					<h2>Opciones | Dashboard</h2>	
					<button class="_dsh_edi _anm" title="Modo Edición">Editar</button>	
				</div>
			</div>
		</div>
			
		<div class="_dsh_all"></div>
		
		<button id="_dsh_add" name="_dsh_add" class="_dsh_add _anm" style="text-align: center;"> <?php echo TX_ADD.' '.TX_ROW ?></button>
		
		<!-- Agregar - modificar graficas -->
		<div style="display: none;">
			<div class="_dsh_grph_mod">
				<div class="_fm_fnc"></div>
			</div>
		</div>
		
	
		<!-- Personalizar Columnas -->
		<div style="display: none;">
			<div class="_dsh_col_prs">
				<div class="_fm_fnc"></div>
			</div>
		</div>
		
	</div>

	<!-- JavaScript -->
		<?php
		
			$CntJV .= "SUMR_Dsh.m.o.edt = $('#_dsh_edt').val();";
			
			$CntWb .= "
				SUMR_Main.ld.f.html(function(){
					SUMR_Dsh.m.init();
				});
			";
			
		?>
	<!-- JavaScript -->

	
<?php } ?>