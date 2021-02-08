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

                    //---------- Lets Build Client Colors ----------//

                        if(!isN($__cl_clr->main->v)){ $__cl_root_css .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__cl_root_css .= ' --main-bg-color:#4f006f;'; }
                        if(!isN($__cl_clr->second->v)){ $__cl_root_css .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__cl_root_css .= ' --second-bg-color:#de86d4; '; }

                    //---------- Lets Build Modules ----------//

                    $MdlToS3Qry = "	SELECT id_mdl, mdl_enc
                                    FROM "._BdStr($_cl_v->bd).TB_MDL."
                                    WHERE mdl_s3=2
                                    ORDER BY id_mdl DESC
                                    LIMIT {$_g_alw->lmt}
                                ";

                    //echo $this->li( compress_code($MdlToS3Qry) );

                    $MdlToS3 = $__cnx->_qry($MdlToS3Qry);

                    if($MdlToS3){

                        $rwMdlToS3 = $MdlToS3->fetch_assoc();
                        $TotMdlToS3 = $MdlToS3->num_rows;

                        echo $this->h2($this->ttFgr($_cl_v).$TotMdlToS3.' modules '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );

                        if($TotMdlToS3 > 0){

                            do{

                                echo $this->li( 'Process modules '.$rwMdlToS3['id_mdl'].' on '.$_cl_v->bd );

                                $__mdl->id_mdl = $rwMdlToS3['id_mdl'];
                                $__mdl->cl->bd = $_cl_v->bd;
                                $__mdl->cl->sbd = $_cl_v->sbd;
                                $__mdl->cl->nm = $_cl_v->nm;
                                $__mdl->cl->clr = $__cl_root_css;
                                $_w_sve = $__mdl->sve_json([ 't'=>'mdl' ]);

                                if($_w_sve->e == 'ok'){

                                    echo $this->li( compress_code($updateSQL) );

                                    $updateSQL = sprintf("UPDATE "._BdStr($_cl_v->bd).TB_MDL." SET mdl_s3='1' WHERE mdl_enc=%s",
                                                        GtSQLVlStr($rwMdlToS3['mdl_enc'], 'text'));

                                    $Result = $__cnx->_prc($updateSQL);

                                    if($Result){
                                        echo $this->scss('Process OK!');
                                    }else{

                                        echo $this->err('Not process $_w_sve '.print_r($_w_sve, true));

                                    }

                                }

                            } while ($rwMdlToS3 = $MdlToS3->fetch_assoc());

                        }

                    }else{

                        echo $this->err($__cnx->c_r->error);

                    }

                    $__cnx->_clsr($MdlToS3);

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