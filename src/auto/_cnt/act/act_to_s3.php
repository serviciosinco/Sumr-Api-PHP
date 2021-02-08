<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'act_to_s3' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('SEND STATIC DATA ACTIVITIES TO S3');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                if($this->tallw_cl([ 't'=>'key', 'id'=>'act_to_s3', 'cl'=>$_cl_v->id ])->est == 'ok' && !isN($_cl_v->bd)){

                    $__act = new CRM_Act([ 'cl'=>$_cl_v->id ]);
                    $__cl = __Cl([ 'id'=>$_cl_v->id ]);
                    $__cl_tag = $__cl->tag;
			        $__cl_clr = $__cl_tag->clr;

                    //---------- Lets Build Modules ----------//

                    $ActToS3Qry = "	SELECT id_act, act_enc
                                    FROM "._BdStr(DBM).TB_ACT."
                                    WHERE act_s3=2 AND act_cl='".$_cl_v->id."'
                                    ORDER BY RAND()
                                    LIMIT {$_g_alw->lmt}
                                ";

                    $ActToS3 = $__cnx->_qry($ActToS3Qry);

                    if($ActToS3){

                        $rwActToS3 = $ActToS3->fetch_assoc();
                        $TotActToS3 = $ActToS3->num_rows;

                        echo $this->h2($this->ttFgr($_cl_v).$TotActToS3.' activities '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                        if($TotActToS3 > 0){

                            do{

                                echo $this->li( 'Process activities '.$rwActToS3['id_act'].' on '.$_cl_v->nm );

                                $__act->id_act = $rwActToS3['id_act'];
                                $__act->cl->bd = $_cl_v->bd;
                                $__act->cl->sbd = $_cl_v->sbd;
                                $__act->cl->nm = $_cl_v->nm;
                                $__act->cl->clr = $__cl_root_css;
                                $_w_sve = $__act->sve_json([ 't'=>'act' ]);

                                if($_w_sve->e == 'ok'){

                                    echo $this->li( compress_code($updateSQL) );

                                    $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ACT." SET act_s3='1' WHERE act_enc=%s",
                                                        GtSQLVlStr($rwActToS3['act_enc'], 'text'));

                                    $Result = $__cnx->_prc($updateSQL);

                                    if($Result){
                                        echo $this->scss('Process OK!');
                                    }else{
                                        echo $this->err('Not process');
                                    }

                                }else{

                                    echo $this->err('Not process $_w_sve '.print_r($_w_sve, true));

                                }

                            } while ($rwActToS3 = $ActToS3->fetch_assoc());

                        }

                    }else{

                        echo $this->err($__cnx->c_r->error.' on '.compress_code($ActToS3Qry));

                    }

                    $__cnx->_clsr($ActToS3);

                }

			}

		}

	}else{

		echo $this->err('AUTO_CHK_EML:off');

	}

}else{

	echo $this->nallw('Global - Module to S3 Off');

}

?>