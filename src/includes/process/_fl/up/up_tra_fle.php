<?php 

    //@ini_set('display_errors', true); 
    //error_reporting(E_ALL);

    $_id_mdlcnt = Php_Ls_Cln($_POST['_mdl_cnt']);

    $__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
    $_aws = new API_CRM_Aws();
    $__CntIn->mdlcnt->attch = $_FILES;

    if( !isN($_id_mdlcnt) ){ 
        
        $__dtmdlcnt = GtMdlCntDt([ 'id'=>$_id_mdlcnt, 'bd'=>$__cl_v->bd, 't'=>'enc' ]);

        $__CntIn->nw_id_mdlcnt = $__dtmdlcnt->id;
	
        $_in_mdlcnt_attch = $__CntIn->MdlCntAttch();  

        if($_in_mdlcnt_attch->e != 'ok'){ 
            
            $rsp['w'][] = 'Problems on save schedule';
        
        }else{
            
            $rsp['e'] = 'ok';
            $rsp['attch'] = [];

            if(!isN($_in_mdlcnt_attch->fle)){
                
                foreach($_in_mdlcnt_attch->fle as $_attch_k=>$_attch_v){

                    $_pth = $_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_ATTCH.$_attch_v->u ]);
                    if(in_array($_attch_v->e, ['jpg','png','jpeg'])){ $is_img='ok'; }else{ $is_img=''; }

                    $rsp['attch'][] = [
                        'id'=>$_attch_v->id,
                        'img'=>$is_img,
                        'fle'=>[
                            'e'=>$_attch_v->e,
                            'n'=>$_attch_v->n,
                            'u'=>$_pth->uri
                        ]
                    ];

                }
            }
        }
    }

    Hdr_JSON();
    $rtrn = json_encode($rsp); 
    echo $rtrn;

?>