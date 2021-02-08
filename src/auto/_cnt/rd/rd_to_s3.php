<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'rd_to_s3' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('SEND STATIC DATA DIGITAL MAGAZINES TO S3');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                if($this->tallw_cl([ 't'=>'key', 'id'=>'rd_to_s3', 'cl'=>$_cl_v->id ])->est == 'ok' && !isN($_cl_v->bd)){

                    $__rd = new CRM_Rd([ 'cl'=>$_cl_v->id ]);

                    //---------- Lets Build Magazine ----------//

                    $RdToS3Qry = "	SELECT id_rd, rd_enc
                                    FROM "._BdStr(DBM).TB_RD."
                                    WHERE rd_s3=2 AND
                                          rd_cl='".$_cl_v->id."' AND
                                          rd_fle IS NOT NULL AND
                                          rd_fle != ''
                                    ORDER BY RAND()
                                    LIMIT {$_g_alw->lmt}
                                ";

                    //echo $this->li( compress_code($RdToS3Qry) );

                    $RdToS3 = $__cnx->_qry($RdToS3Qry);

                    if($RdToS3){

                        $rwRdToS3 = $RdToS3->fetch_assoc();
                        $TotRdToS3 = $RdToS3->num_rows;

                        echo $this->h2($this->ttFgr($_cl_v).$TotRdToS3.' magazine '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                        if($TotRdToS3 > 0){

                            do{

                                echo $this->li( 'Process magazine '.$rwRdToS3['id_rd'].' on '.$_cl_v->bd );

                                $__rd->id_rd = $rwRdToS3['id_rd'];
                                $_w_sve = $__rd->sve_json([ 't'=>'rd' ]);

                                if($_w_sve->e == 'ok'){

                                    echo $this->li( compress_code($updateSQL) );

                                    $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_RD." SET rd_s3='1' WHERE rd_enc=%s",
                                                        GtSQLVlStr($rwRdToS3['rd_enc'], 'text'));

                                    $Result = $__cnx->_prc($updateSQL);

                                    if($Result){
                                        echo $this->scss('Process OK!');
                                    }else{

                                        echo $this->err('Not process $_w_sve '.print_r($_w_sve, true));

                                    }

                                }

                            } while ($rwRdToS3 = $RdToS3->fetch_assoc());

                        }

                    }else{

                        echo $this->err($__cnx->c_r->error);

                    }

                    $__cnx->_clsr($RdToS3);

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