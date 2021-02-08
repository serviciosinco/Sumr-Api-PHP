<?php 

    $_cnt_nm_fl_arr = explode(" ", $_cnt_nm_fl); //Convertir texto en arreglo
    $_cnt_nm_fl_arr_count = count($_cnt_nm_fl_arr); //Conteo de las frases
    
    if( $_cnt_nm_fl_arr_count == 1 ){ //Busca una sola frase Ejemplo: "Pepito"
        $__fl .= " 
                AND(
                    cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' OR
                    cnt_ap LIKE '%".$_cnt_nm_fl_arr[0]."%'
                )
        "; 
    }elseif( $_cnt_nm_fl_arr_count == 2 ){ //Busca dos frases Ejemplo: "Pepito Perez"
        $__fl .= " 
                AND(
                    cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_nm LIKE '%".$_cnt_nm_fl_arr[1]."%' OR
                    cnt_ap LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[1]."%' OR
                    cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[1]."%'
                )
        "; 
    }elseif( $_cnt_nm_fl_arr_count == 3 ){ //Busca tres frases Ejemplo: "Jose Pepito Perez"
        $__fl .= " 
                AND(
                    cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_nm LIKE '%".$_cnt_nm_fl_arr[1]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[2]."%' OR
	                cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[1]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[2]."%'
                )
        ";
    }elseif( $_cnt_nm_fl_arr_count == 4 ){ //Busca cuatro frases Ejemplo: "Jose Pepito Perez Gomez"
        $__fl .= " 
                AND(
                    cnt_nm LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_nm LIKE '%".$_cnt_nm_fl_arr[1]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[2]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[3]."%' OR
	                cnt_ap LIKE '%".$_cnt_nm_fl_arr[0]."%' AND cnt_ap LIKE '%".$_cnt_nm_fl_arr[1]."%' AND cnt_nm LIKE '%".$_cnt_nm_fl_arr[2]."%' AND cnt_nm LIKE '%".$_cnt_nm_fl_arr[3]."%'
                )
        ";
    }else{
        $__fl .= " 
                AND(
                    cnt_nm LIKE '%".$_cnt_nm_fl."%' OR
                    cnt_ap LIKE '%".$_cnt_nm_fl."%'
                )
        ";
    }

?>