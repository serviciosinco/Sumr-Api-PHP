<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'us_ntf' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

        try {

            if($this->_s_cl->tot > 0){

                foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                    if( $this->tallw_cl([ 't'=>'key', 'id'=>'us_ntf', 'cl'=>$_cl_v->id ])->est == 'ok' ){

                        //--------- AUTO TIME CHECK - START ---------//

                        $___datprcs = [];

                        $_AUTOP_d = $this->RquDt([ 't'=>'us_ntf', 'cl'=>$_cl_v->id, 's'=>10 ]);

                        if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

                            $this->Rqu([ 't'=>'us_ntf', 'cl'=>$_cl_v->id ]);

                            $Ntf_Qry = "    SELECT  id_ntf, ntf_enc, ntf_tp, ntf_acc, ntf_htrgr, ntf_tt, ntf_dsc, ntf_e, id_us
                                            FROM "._BdStr(DBM).TB_NTF."
                                                 INNER JOIN "._BdStr(DBM).TB_CL." ON ntf_cl = id_cl
                                                 INNER JOIN "._BdStr(DBM).TB_US." ON ntf_us = id_us
                                            WHERE cl_enc = '".$_cl_v->enc."' AND
                                                  ntf_e = 2 AND
                                                  ntf_ftrgr <= '".SIS_F2."' AND
                                                  (ntf_htrgr <= '".SIS_H2."' || ntf_ftrgr <= '".SIS_F2."' ) AND
                                                  EXISTS (
                                                        SELECT id_usdvc
                                                        FROM "._BdStr(DBM).TB_US_DVC."
                                                        WHERE   usdvc_us = id_us AND
                                                                usdvc_cl = id_cl AND
                                                                usdvc_gcm_tkn IS NOT NULL AND
                                                                usdvc_e = 1
                                                  )
                                            ORDER BY ntf_ftrgr ASC
                                            LIMIT 100
                                        ";

                            //echo compress_code( $Ntf_Qry );
                            $Ntf = $__cnx->_qry($Ntf_Qry);

                            if($Ntf){

                                $rwNtf = $Ntf->fetch_assoc();
                                $TotNtf = $Ntf->num_rows;

                                echo $this->h1($_cl_v->nm.' - Send Notifications FCM '.$this->Spn($TotNtf) );

                                if($TotNtf > 0){
                                    do{
                                        $___datprcs[] = $rwNtf;
                                    } while ($rwNtf = $Ntf->fetch_assoc()); $Ntf->free;
                                }

                            }else{

                                echo $this->err( $__cnx->c_p->error );

                            }

                            $__cnx->_clsr($Ntf);

                            if(!isN( $___datprcs )){

                                foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

                                    echo $this->li( 'Notification id:'.$___datprcs_v['id_ntf'].' from us:'.$___datprcs_v['id_us'] );

                                    $__snd = $this->_ntf->send([ 'id'=>$___datprcs_v['id_ntf'] ]);

                                    if($__snd->e == 'ok'){
                                        echo $this->scss('Sended sucessfull');
                                    }else{
                                        echo $this->err('WS not sended '.compress_code($__snd->w));
                                    }
                                    //print_r( $__snd );e
                                }

                            }

                        }else{
                            echo $this->h1($_cl_v->nm.' - Users '.$this->Spn('Send Notifications'), 'Auto_Tme_Prg');
                        }

                    }else{
						echo $this->nallw($_cl_v->nm.' Send Notifications Off');
					}

                }

            }

        } catch (Exception $e) {

			echo 'Error Proceso Automation: ',  $e->getMessage(), "\n";

		}

	}

}else{

	echo $this->nallw('Global Monitor Upload - Campaña de Envio - Off');

}

?>