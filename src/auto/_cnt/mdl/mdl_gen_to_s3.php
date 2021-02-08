<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'mdl_to_s3' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('SEND STATIC DATA MODULES TO S3');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

                if($this->tallw_cl([ 't'=>'key', 'id'=>'mdl_to_s3', 'cl'=>$_cl_v->id ])->est == 'ok' && !isN($_cl_v->bd)){

                    $__mdl = new CRM_Mdl([ 'cl'=>$_cl_v->id ]);
                    $__cl = __Cl([ 'id'=>$_cl_v->id ]);
                    $__cl_tag = $__cl->tag;
			        $__cl_clr = $__cl_tag->clr;

                    //---------- Lets Build General Modules ----------//

                    $MdlGenToS3Qry = "	SELECT id_mdlgen, mdlgen_enc
                                    FROM "._BdStr($_cl_v->bd).TB_MDL_GEN."
                                    WHERE mdlgen_s3=2
                                    LIMIT {$_g_alw->lmt}
                                ";

                    $MdlGenToS3 = $__cnx->_qry($MdlGenToS3Qry);

                    if($MdlGenToS3){

                        $rwMdlGenToS3 = $MdlGenToS3->fetch_assoc();
                        $TotMdlGenToS3 = $MdlGenToS3->num_rows;

                        echo $this->h2($this->ttFgr($_cl_v).$TotMdlGenToS3.' general modules '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                        if($TotMdlGenToS3 > 0){

                            do{

                                echo $this->li( 'Process general module '.$rwMdlGenToS3['id_mdlgen'].' on '.$_cl_v->bd );

                                $__mdl->id_mdlgen = $rwMdlGenToS3['id_mdlgen'];
                                $__mdl->cl->bd = $_cl_v->bd;
                                $__mdl->cl->sbd = $_cl_v->sbd;
                                $__mdl->cl->nm = $_cl_v->nm;
                                $_w_sve = $__mdl->sve_json([ 't'=>'mdl_gen' ]);

                                if($_w_sve->e == 'ok'){

                                    $updateSQL = sprintf("UPDATE "._BdStr($_cl_v->bd).TB_MDL_GEN." SET mdlgen_s3='1' WHERE mdlgen_enc=%s",
                                                        GtSQLVlStr($rwMdlGenToS3['mdlgen_enc'], 'text'));

                                    $Result = $__cnx->_prc($updateSQL);

                                    if($Result){
                                        echo $this->scss('Process OK!');
                                    }else{
                                        echo $this->err('Not process');
                                    }

                                }else{

                                    echo $this->err('Not sve_json '.print_r($_w_sve, true));

                                }

                            } while ($rwMdlGenToS3 = $MdlGenToS3->fetch_assoc());

                        }

                    }else{

                        echo $this->err($__cnx->c_r->error);

                    }

                    $__cnx->_clsr($MdlGenToS3);



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