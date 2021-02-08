<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'mdl_rsp' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('Queue for Module Responsable');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                if( $this->tallw_cl([ 't'=>'key', 'id'=> 'mdl_rsp', 'cl'=>$_cl_v->id ])->est == 'ok' ){
                    if(!isN($_cl_v->bd)){

                        $__mdl = new CRM_Mdl();
                        $__mdl->cl = $_cl_v->bd;

                        //---------- Lets Build Modules ----------//

                        $MdlRspQry = "
                                        SELECT
                                            id_mdl, mdl_enc, mdl_nm
                                        FROM
                                            "._BdStr($_cl_v->bd).TB_MDL."
                                        WHERE  mdl_est='"._CId('ID_SISMDLEST_ACTV')."' AND
                                               (
                                                   mdl_chk_rsp = 2
                                                )
                                        ORDER BY RAND()
                                        LIMIT {$_g_alw->lmt}
                                    ";

                        $MdlRsp = $__cnx->_qry($MdlRspQry); //echo compress_code( $MdlRspQry );

                        if($MdlRsp){

                            $rwMdlRsp = $MdlRsp->fetch_assoc();
                            $TotMdlRsp = $MdlRsp->num_rows;

                            echo $this->h2($this->ttFgr($_cl_v).$TotMdlRsp.' module '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                            if($TotMdlRsp > 0){

                                do{

                                    echo $this->h2( 'Process Module '.$rwMdlRsp['id_mdl'] );

                                    //--------- Set First Data and Main Vars ---------//

                                        $__prc_all = 'ok';
                                        $_rsp_sme = '';
                                        $__w = '';
                                        $rspnw = 0;
                                        $__mdl->id_mdl = $rwMdlRsp['id_mdl'];
                                        $__rsp = $__mdl->GtMdlGrp([ 'cl'=>$_cl_v->bd ]);
                                        $__rsp_us = $__mdl->GtMdlUs([ 'cl'=>$_cl_v->bd ]);

                                        $__cnx->c_p->autocommit(FALSE);

                                    //--------- Process If Has Column Asignment or MdlSTp User Default ---------//

                                        //$c = (object)array_merge((array)$__rsp->us, (array)$__rsp_us->us);
                                        //echo json_encode($c);

                                        if($__rsp->tot > 0 && (!isN($__rsp->us))){
                                            echo $this->li('Desde los grupos');
                                            echo $this->li('It has user responsable for this module '.$rwMdlRsp['mdl_nm']);
                                            include('rsp/grp.php');
                                        }

                                        if($__rsp_us->tot > 0 && (!isN($__rsp_us->us))){
                                            echo $this->li('Desde los usuarios');
                                            $__rsp = $__rsp_us;
                                            echo $this->li('It has user responsable for this module '.$rwMdlRsp['mdl_nm']);
                                            include('rsp/grp.php');
                                        }

                                    //--------- If there is not problem, update main record ---------//

                                        if($__prc_all == 'ok' && ($rspnw > 0 || $_rsp_sme == 'ok') && (!isN($__mdlstp->us) || $__rsp->tot > 0)){
                                            $SqlUpdChkRsp = sprintf("UPDATE "._BdStr($_cl_v->bd).TB_MDL." SET mdl_chk_rsp='1' WHERE mdl_enc=%s", GtSQLVlStr($rwMdlRsp['mdl_enc'], 'text'));
                                            $Result = $__cnx->_prc($SqlUpdChkRsp);
                                            if(!$Result){ $__prc_all = 'no'; $__w .= 'Problem on update module '.$__cnx->c_p->error; }
                                        }else{
                                            if($__rsp->tot == 0){ $__w .= 'No rsp total ('.$__rsp->tot.') '.$__rsp->w; }
                                        }

                                    //--------- If there is not problem, process the commit ---------//

                                        if($__prc_all == 'ok' && isN($__w)){

                                            if($__cnx->c_p->commit()){

                                                $_r['e'] = 'ok';

                                                echo $this->scss('Process '.$rwMdlRsp['id_mdl'].' OK!');

                                                if(isN($SqlUpdChkRsp)){
                                                    echo $this->err('PROBLEM: Not update field mdl_chk_rsp');
                                                    echo $this->err('$rspnw:'.$rspnw);
                                                    echo $this->err('$_rsp_sme:'.$_rsp_sme);
                                                    echo $this->err('$__mdlstp->us:'.$__mdlstp->us);
                                                    echo $this->err('$__rsp->tot:'.$__rsp->tot);
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

                                } while ($rwMdlRsp = $MdlRsp->fetch_assoc());
                            }
                        }else{
                            echo $this->err($__cnx->c_r->error);
                        }
                        $__cnx->_clsr($MdlRsp);
                    }
                }else{
                    echo $this->nallw(' Module - Responsables - Off - '.$_cl_v->nm);
                }
			}
		}
	}else{
		echo $this->err('AUTO_CHK_EML:off');
	}
}else{
	echo $this->nallw('Global - Module Responsables Off');
}

?>