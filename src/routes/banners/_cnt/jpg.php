<?php 
		
		__Cche_Img_Hdr();
		

		$Dir_Jpg = DMN_BN.'fl/'.$__dtbn->dir.'/src.jpg';
		$Dir_b_Jpg = 'fl/'.$__dtbn->dir.'/src.jpg';
		$__dt_pml = explode('.',PrmLnk('rtn', $Dir_b_Jpg));
		

		$__f = $Dir_b_Jpg;
				
		


		// Construye Imagen
		__Cche_Img($__f, 'jpg');
		// Finaliza construcción de imagen		
?>