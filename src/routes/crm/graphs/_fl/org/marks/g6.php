<?php 

    $__dt_1 = date('Y-m-01');

    $__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) )  ;
    $__dt_2 = date ( 'Y-m-d' , $__dt_2 );

    $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
    

    $LsQry = "  SELECT
                    orgsdsarrsls_vl, orgsdsarrsls_f 
                FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                    INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                WHERE
                    id_orgsdsarrsls != ''
                AND org_enc = '".$__i."' AND orgsdsarr_est = 1
                $___Dt->qry_f ORDER BY orgsdsarrsls_f ASC
            ";
        
    $LsRg = $__cnx->_qry($LsQry);

    if($LsRg){ 
        
        $rwLsRg = $LsRg->fetch_assoc(); 
        $TotLsRg = $LsRg->num_rows; 
        
        if($TotLsRg > 0){
            
            do {

                $Vl2[$rwLsRg['orgsdsarrsls_f']]['date'] = $rwLsRg['orgsdsarrsls_f'];
				$Vl2[$rwLsRg['orgsdsarrsls_f']]['tot'] = $rwLsRg['orgsdsarrsls_vl'];
           
            } while ($rwLsRg = $LsRg->fetch_assoc());
 
            $Vl_Grph_1 = _jEnc($Vl2);

            echo bdiv([ 'id'=>'bx_grph_6_marks', 'sty'=>'height:150px; max-height:150px;' ]);

            for( $i = $__dt_1 ; $i <= $__dt_2 ; $i = date("Y-m-d", strtotime($i ."+ 1 days")) ){ 
                $__ctg[] = $i;	
    
                if(!isN($Vl_Grph_1->{$i}->tot)){ $_tot_1 = $Vl_Grph_1->{$i}->tot; }else{ $_tot_1 = 0; }
    
                $_medio_tot_1[] = intval($_tot_1);	
            }

            

            $_medio_tot_1 = implode(",", $_medio_tot_1);
            $__ctg = implode("', '", $__ctg);
						
            $CntWb .= "

                SUMR_Grph.f.g4({ 
                    id: '#bx_grph_6_marks',
                    c: ['".$__ctg."'],
                    d: [{ name:'Total ', data: [".$_medio_tot_1."] }],
                    tt: 'Ventas', 
                    tt_sb: 'Ventas por mes',
                    c_e: false,
                    lgnd: false
                });
            ";

                
        }
        
    }else{

        echo $__cnx->c_r->error;

    }        

?>