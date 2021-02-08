<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'us_ntf_exp' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

        try {

            if($this->_s_cl->tot > 0){

                foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                    //if( $this->tallw_cl([ 't'=>'key', 'id'=>'us_ntf_exp', 'cl'=>$_cl_v->id ])->est == 'ok' ){

                        //--------- AUTO TIME CHECK - START ---------//

                        $___datprcs = [];

                        $_AUTOP_d = $this->RquDt([ 't'=>'us_ntf_exp', 'cl'=>$_cl_v->id, 's'=>10 ]);

                        if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

                            $this->Rqu([ 't'=>'us_ntf_exp', 'cl'=>$_cl_v->id ]);

                            $NtfExp_Qry = "    SELECT  id_ntf, ntf_enc, ntf_tp, ntf_acc, ntf_htrgr, ntf_tt, ntf_dsc, ntf_e, id_usdvc, usdvc_gcm_tkn, id_us,
                                                    "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
                                                    ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ])."
                                            FROM "._BdStr(DBM).TB_NTF."
                                                 INNER JOIN "._BdStr(DBM).TB_CL." ON ntf_cl = id_cl
                                                 INNER JOIN "._BdStr(DBM).TB_US." ON ntf_us = id_us
                                                 INNER JOIN "._BdStr(DBM).TB_US_DVC." ON usdvc_us = id_us
                                                 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ntf_tp', 'als'=>'t' ])."
                                            WHERE cl_enc = '".$_cl_v->enc."' AND
                                                  ntf_e = 2 AND
                                                  NOW() > CONCAT(ntf_ftrgr,' ',ntf_htrgr) + INTERVAL 1 HOUR
                                            ORDER BY ntf_ftrgr ASC
                                            LIMIT 100
                                        ";

                            //echo compress_code( $NtfExp_Qry );
                            $NtfExp = $__cnx->_qry($NtfExp_Qry);

                            if($NtfExp){

                                $rwNtfExp = $NtfExp->fetch_assoc();
                                $TotNtfExp = $NtfExp->num_rows;

                                echo $this->h1($_cl_v->nm.' - Remove Expired Notifications '.$this->Spn($TotNtfExp) );

                                if($TotNtfExp > 0){
                                    do{
                                        $___datprcs[] = $rwNtfExp;
                                    } while ($rwNtfExp = $NtfExp->fetch_assoc()); $NtfExp->free;
                                }

                            }else{

                                echo $this->err( $__cnx->c_p->error );

                            }

                            $__cnx->_clsr($NtfExp);

                            if(!isN( $___datprcs )){

                                foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

                                    $this->_ntf->ntf_id_upd = $___datprcs_v['ntf_enc'];
                                    $_ntf_e_upd = $this->_ntf->Upd([ 'e'=>3 ]);

                                    echo $this->li( 'Notification id:'.$___datprcs_v['id_ntf'].' from us:'.$___datprcs_v['id_us'] );

                                    if($_ntf_e_upd->e == 'ok'){
                                        echo $this->scss('Updated success');
                                    }else{
                                        echo $this->err('Problem on process '.$_ntf_e_upd->w);
                                    }

                                }

                            }

                        }else{
                            echo $this->h1($_cl_v->nm.' - Users '.$this->Spn('Remove Expired'), 'Auto_Tme_Prg');
                        }

                    // }else{
					// 	echo $this->nallw($_cl_v->nm.' Remove Expired Off');
					// }

                }

            }

        } catch (Exception $e) {

			echo 'Error Proceso Automation: ',  $e->getMessage(), "\n";

		}

	}

}else{

	echo $this->nallw('Users - Remove Expired Notifications - Off');

}

?>