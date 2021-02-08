<?php 

    //-------------- GET PARAMETERS --------------//

        $gpaylnk = Php_Ls_Cln($_GET['paylnk']);
        $gcl = Php_Ls_Cln($_GET['cl']);
        $j_data  = _jEnc(_PostRw());

    //-------------- SET ACCOUNT --------------//

        if(!isN($gcl)){ $_cl_d = GtClDt($gcl, 'enc'); }

    //-------------- CLASSES --------------//

        $__gtwy = new CRM_Gtwy([ 'cl'=>$_cl_d ]);

    //-------------- FOLDERS INTERNOS --------------//
		
		define('API_F_GATEWAY_MPAGO', API_F_GATEWAY.'mercadopago/');

    //-------------- GET DATA --------------//

        if(!isN($gpaylnk)){ 
            $_paylnk_d = $__gtwy->pay_lnk_dt([ 'enc'=>$gpaylnk ]);
        } 

    //-------------- START PROCESS --------------//

    if($j_data->action == 'payment.created'){ 
                        
        try {
            include(API_F_GATEWAY_MPAGO.'payment.php');
        } catch (Exception $e) {
            $__incerror = $e->getMessage();
        }
                                
    }

	
?>