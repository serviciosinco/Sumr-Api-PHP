<?php 

        $__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
        $__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) )  ;

		$__dt_2 = date ( 'Y-m-d' , $__dt_2 );


        if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
            $_grph_subt = 'Mes actual';
        }elseif(isN($___Dt->_fl->f2)){
            $_grph_subt = FechaESP_OLD($___Dt->_fl->f1);
        }else{
            $_grph_subt = FechaESP_OLD($___Dt->_fl->f1).' - '.FechaESP_OLD($___Dt->_fl->f2);
        }


        if(!isN($__dt_1) && isN($__dt_2)){
            $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_1.'" ';
        }elseif(isN($__dt_1) && !isN($__dt_2)){
            $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
        }elseif(!isN($__dt_1) && !isN($__dt_2)){
            $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
        }

        if(!isN($___Dt->_fl->fk->cllcl_lvl)){
            $__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$___Dt->_fl->fk->cllcl_lvl." )";	
        }

        if(!isN($___Dt->_fl->fk->_fl_orgtag)){

            $__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
                        INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
                            WHERE orgtag_tag = ".$___Dt->_fl->fk->_fl_orgtag." )";

        }

        if(!isN($___Dt->_fl->fk->_fl_orgls)){

            $__fl .= " AND id_org IN ( ".$___Dt->_fl->fk->_fl_orgls." )";

        }

        if(!isN($___Dt->_fl->fk->_fl_orgest)){
			$__fl .= " AND org_est = ".$___Dt->_fl->fk->_fl_orgest;	
		}

    $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
    

    $LsQry = "  SELECT
                    orgsdsarrsls_trs, orgsdsarrsls_f, orgsdsarr_orgsds, org_nm 
                FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                    INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                WHERE
                    id_orgsdsarrsls != ''
                    ".$___Dt->qry_f." ".$__fl." ORDER BY org_nm ASC, orgsdsarrsls_f ASC
            ";
        
    $LsRg = $__cnx->_qry($LsQry);

    if($LsRg){ 
        
        $rwLsRg = $LsRg->fetch_assoc(); 
        $TotLsRg = $LsRg->num_rows; 
        
        if($TotLsRg > 0){
            
            do {

                    $Vl['ctg'][$rwLsRg['orgsdsarrsls_f']] = $rwLsRg['orgsdsarrsls_f'];	
					$Vl['d'][$rwLsRg['orgsdsarr_orgsds']]['nm'] = ctjTx($rwLsRg['org_nm'], 'in');
					$Vl['d'][$rwLsRg['orgsdsarr_orgsds']]['f'][$rwLsRg['orgsdsarrsls_f']]['tot'] = $rwLsRg['orgsdsarrsls_trs'];
           
            } while ($rwLsRg = $LsRg->fetch_assoc());

            $Vl_Grph = _jEnc($Vl);

            echo bdiv([ 'id'=>'bx_grph_6_marks', 'sty'=>'height:300px; max-height:300px;' ]);

            

            for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
				}
				
            }
            
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}

            $_grph_d = implode(",", $_medio);
            $_grph_c = implode(",", $__ctg);
            

           
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#bx_grph_6_marks',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Transacciones', 
					tt_sb: 'Transacciones por mes',
                    c_e: false
				});
			";

                
        }
        
    }else{

        echo $__cnx->c_r->error;

    }        

?>