<?php 

    if($__i == _CId('ID_SISATMTCNDC_EST_EQL')){ //El estado es igual a
        
        echo LsCntEst([ 
            'id'=>'atmttrgrcndc_v_vl',
            'v'=>'id_siscntest', 
            'va'=>$__t_s_i,
            'lbl'=>TX_SLCEST, 
            'rq'=>2
        ]);
        
        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', 'Seleccione Estado');

    }elseif($__i == _CId('ID_SISATMTCNDC_EST_DF')){ //El estado es diferente a
        	
    }elseif($__i == _CId('ID_SISATMTCNDC_ETP_EQL')){ //La etapa es igual a
        
        echo LsCntEstTp(
            'atmttrgrcndc_v_vl', 
            'id_siscntesttp', 
            $__t_s_i, 
            TX_SLCETP,
            2
        );
    
        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', TX_ETP);

    }elseif($__i == _CId('ID_SISATMTCNDC_ETP_DF')){ //La etapa es diferente a
        
        echo LsCntEstTp(
                'atmttrgrcndc_v_vl', 
                'id_siscntesttp', 
                $__t_s_i, 
                TX_SLCETP,
                2
            );
        
        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', TX_ETP);

    }elseif($__i == _CId('ID_SISATMTCNDC_PAY_EQL')){ //Estado de Pago
        
        echo LsBcoPay([
            'id'=>'atmttrgrcndc_v_vl',
            'v'=>'id',
            'mlt'=>'no', 
            'va'=>$__t_s_i,
            'ph'=>'Seleccione Estado de Pago', 
            'rq'=>2
        ]);

        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', 'Seleccione Estado de Pago');

    }elseif($__i == _CId('ID_SISATMTCNDC_MD_EQL')){ //A traves de Medio
        	
    }elseif($__i == _CId('ID_SISATMTCNDC_CD_IN') || $__i == _CId('ID_SISATMTCNDC_CD_NOT_IN')){ //Ciudad igual a

        echo LsCdOld([ 
            'id'=>'atmttrgrcndc_v_vl', 
            'v'=>'id_siscd', 
            'mlt'=>'no', 
            'va'=>$__t_s_i, 
            'ph'=>'Seleccione Ciudad', 
            'rq'=>2
        ]);
        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', 'Seleccione Ciudad');
        
    }elseif($__i == _CId('ID_SISATMTCNDC_PS_IN') || $__i == _CId('ID_SISATMTCNDC_PS_NOT_IN') || $__i == _CId('ID_SISATMTCNDC_PS_TEL_IN') || $__i == _CId('ID_SISATMTCNDC_PS_TEL_NOT_IN')){ //Pais igual a

        echo LsPs([ 
            'id'=>'atmttrgrcndc_v_vl', 
            'v'=>'id_sisps', 
            'va'=>$__t_s_i, 
            'ph'=>'Seleccione Pais',
            'rq'=>2 
        ]); 
        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl',TX_SLCPS);
        
    }elseif($__i == _CId('ID_SISATMTCNDC_SAC_BRND_RLT')){ //Marca igual a

        echo LsGtStoreBrnd([ 
                'id'=>'atmttrgrcndc_v_vl', 
                'v'=>'id_storebrnd', 
                'va'=>$__t_s_i, 
                'rq'=>2
            ]);

        $CntWb .= JQ_Ls('atmttrgrcndc_v_vl', 'Seleccione Marca');
        
    }


?>