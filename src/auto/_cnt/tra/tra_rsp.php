<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'tra_rsp' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('Queue for Task Responsable');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                if( $this->tallw_cl([ 't'=>'key', 'id'=> 'tra_rsp', 'cl'=>$_cl_v->id ])->est == 'ok' ){

                    if(!isN($_cl_v->bd)){

                        $__tra = new CRM_Tra();
                        $__tra->bd = $_cl_v->bd;

                        //---------- Lets Build Modules ----------//

                        $TraRspQry = "
                                        SELECT id_tra, tra_enc, tra_col, id_mdl, id_mdlstp, tracol_tt
                                        FROM "._BdStr(DBM).TB_TRA."
                                            INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
                                            INNER JOIN "._BdStr(DBM).TB_TRA_COL_US." ON tracolus_tracol = id_tracol
                                            INNER JOIN "._BdStr(DBM).TB_CL." ON tra_cl = id_cl
                                            LEFT JOIN "._BdStr($_cl_v->bd).TB_MDL_CNT_TRA." ON mdlcnttra_tra = id_tra
                                            LEFT JOIN "._BdStr($_cl_v->bd).TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
                                            LEFT JOIN "._BdStr($_cl_v->bd).TB_MDL." ON mdlcnt_mdl = id_mdl
                                            LEFT JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                            LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                        WHERE  tra_est='"._CId('ID_TRAEST_PRC')."' AND
                                               id_cl = '".$_cl_v->id."' AND
                                               tra_mnl_rsp = 2 AND
                                               tracol_chk_tck = 2 AND
                                               (
                                                   tra_chk_rsp = 2 OR

                                                   (
                                                        NOT EXISTS(
                                                                SELECT trarsp_tra
                                                                FROM "._BdStr(DBM).TB_TRA_RSP."
                                                                WHERE trarsp_tra = id_tra AND trarsp_tp='"._CId('ID_USROL_RSP')."'
                                                        ) AND

                                                        tracolus_tp = '"._CId('ID_USROL_RSP_DFT')."'

                                                   )
                                                )
                                                AND
                                                (
                                                    tracolus_tp = '"._CId('ID_USROL_RSP_DFT')."' || tracolus_tp = '"._CId('ID_USROL_OBS_DFT')."'
                                                )
                                        GROUP BY id_tra
                                        ORDER BY id_tra DESC
                                        LIMIT {$_g_alw->lmt}
                                    ";

                        $TraRsp = $__cnx->_qry($TraRspQry); //echo compress_code( $TraRspQry );

                        if($TraRsp){

                            $rwTraRsp = $TraRsp->fetch_assoc();
                            $TotTraRsp = $TraRsp->num_rows;

                            echo $this->h2($this->ttFgr($_cl_v).$TotTraRsp.' tasks '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                            if($TotTraRsp > 0){

                                do{

                                    echo $this->h2( 'Process task '.$rwTraRsp['id_tra'] );

                                    //--------- Set First Data and Main Vars ---------//

                                        $__prc_all = 'ok';
                                        $_rsp_sme = '';
                                        $SqlUpdChkRsp = '';
                                        $ResultUpdChkRsp = null;
                                        $__w = '';
                                        $rspnw = 0;
                                        $__tra->tra_col = $rwTraRsp['tra_col'];
                                        $__rsp = $__tra->GtTraColRsp();
                                        $__mdlstp = GtMdlSTpTraLs([ 'id'=>$rwTraRsp['id_mdlstp'], 'cl'=>$_cl_v->id ]);

                                        $__cnx->c_p->autocommit(FALSE);

                                    //--------- Process If Has Column Asignment or MdlSTp User Default ---------//

                                        if($__rsp->tot > 0 && !isN($__rsp->us)){
                                            echo $this->li('It has user responsable / observator for this column '.$rwTraRsp['tracol_tt']);
                                            echo $this->li('It has user responsable:'. (!isN($__rsp->us->rsp_dft->tot)?$__rsp->us->rsp_dft->tot:0 ));
                                            echo $this->li('It has user observator:'. (!isN($__rsp->us->obs_dft->tot)?$__rsp->us->obs_dft->tot:0) );
                                            include('rsp/col.php');
                                        }elseif(!isN($__mdlstp->us)){
                                            echo $this->li('Problem, has not user responsable / observator for this column');
                                            include('rsp/mdlstp.php');
                                        }else{
                                            echo $this->err('Problem, no data for responsable on this task');
                                        }

                                    //--------- If there is not problem, update main record ---------//

                                        if( $__prc_all == 'ok' &&
                                            ($rspnw > 0 || $_rsp_sme == 'ok' || $__rsp->us->rsp_dft->tot == 0 || isN($__rsp->us->rsp_dft->tot)) &&
                                            (!isN($__mdlstp->us) || $__rsp->tot > 0)
                                        ){
                                            $SqlUpdChkRsp = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_chk_rsp='1' WHERE tra_enc=%s", GtSQLVlStr($rwTraRsp['tra_enc'], 'text'));
                                            $ResultUpdChkRsp = $__cnx->_prc($SqlUpdChkRsp);
                                            if(!$ResultUpdChkRsp){ $__prc_all = 'no'; $__w .= 'Problem on update tra '.$__cnx->c_p->error; }
                                        }else{
                                            //$__prc_all = 'no';
                                            if($__rsp->tot == 0){ $__w .= 'No rsp total ('.$__rsp->tot.') '.$__rsp->w; }
                                            if(isN($__mdlstp->us)){ $__w .= 'No us default for mdlstp as alternative'; }
                                        }

                                    //--------- If there is not problem, process the commit ---------//

                                        if($__prc_all == 'ok' && isN($__w)){

                                            if($__cnx->c_p->commit()){

                                                $_r['e'] = 'ok';

                                                echo $this->scss('Process '.$rwTraRsp['id_tra'].' OK!');

                                                if(isN($SqlUpdChkRsp)){
                                                    echo $this->err('PROBLEM: Not update field tra_chk_rsp');
                                                    echo $this->err('$rspnw:'.$rspnw);
                                                    echo $this->err('$__rsp->us->rsp_dft->tot:'.$__rsp->us->rsp_dft->tot);
                                                    echo $this->err('$_rsp_sme:'.$_rsp_sme);
                                                    echo $this->err('$__mdlstp->us:'.$__mdlstp->us);
                                                    echo $this->err('$__rsp->tot:'.$__rsp->tot);
                                                }else{
                                                    if($ResultUpdChkRsp){
                                                        echo $this->scss('Process '.$rwTraRsp['id_tra'].' ChkRsp reset to 1 OK!');
                                                    }else{
                                                        echo $this->err('Not ChkRsp reset to 1');
                                                        echo $this->err( 'Query error:'.$__cnx->c_p->error );
                                                        echo $this->err( print_r($__w, true) );
                                                    }
                                                }

                                            }else{
                                                $__w .= 'Commit fails';
                                                $_r['e'] = 'no';
                                                echo $this->err('Not process:'.$__cnx->c_p->error);
                                            }

                                        }else{

                                            echo $this->err('Not process');
                                            $__w .= 'Has to do rollback';
                                            echo $this->err( $__w );
                                            echo $this->err( '$__prc_all:'.$__prc_all );
                                            $__cnx->c_p->rollback();

                                        }

                                    //--------- Set the autocommit to true again ---------//


                                    $__cnx->c_p->autocommit(TRUE);



                                } while ($rwTraRsp = $TraRsp->fetch_assoc());

                            }

                        }else{

                            echo $this->err($__cnx->c_r->error);

                        }

                        $__cnx->_clsr($TraRsp);

                    }

                }else{

                    echo $this->nallw(' Tasks - Responsables - Off - '.$_cl_v->nm);

                }


			}

		}

	}else{

		echo $this->err('AUTO_CHK_EML:off');

	}

}else{

	echo $this->nallw('Global - Task Responsables Off');

}

?>