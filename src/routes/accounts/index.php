<?php

	try {

		$pth = '../../includes/'; include($pth .'inc.php');


		//---------------------- GROUP LIST ----------------------//


			$__pm1 = PrmLnk('rtn', 1, 'ok');


		//---------------------- GROUP LIST ----------------------//

			define('GL', __f());
			define('GL_HTML', __f('html'));
			define('GL_JSON', __f('json'));

		//---------------------- INCLUDE FILE ****--------------//


		if(!isN($__pm1)){
			include(GL.'json.php');
		}else{
			include(GL.'html.php');
		}



	} catch (Exception $e) {
		echo '<script> location.reload(); </script>';
	}

	ob_end_flush();

?>