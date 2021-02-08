<?php $pageNum = 0; $startRow_LsRd = $pageNum * 8; mysql_select_db(DB, CnRd()); $query_LsRd = "SELECT * FROM por_rd ORDER BY id_rd DESC"; $query_limit_LsRd = sprintf("%s LIMIT %d, %d", $query_LsRd, $startRow_LsRd, 8); $LsRd = mysql_query($query_limit_LsRd, CnRd()); $row_LsRd = mysql_fetch_assoc($LsRd); $totalRows_LsRd = mysql_num_rows($LsRd); 
?>

                        
<?php $i=1; $l=1; do{ ?>
                           	
                                <div class="rd_item">
                                    <div class="rd_cov">
                                    <div>
                                    	<img src="<?php echo DIR_IMG_RD.$row_LsRd['rd_img'] ?>" width="100%"/>
                                    </div>	
                                        <div>
                                        <a href="<?php echo Lnk(1,enCad($row_LsRd['rd_dir']),'','rD') ?>" data-role="button" target="_blank" data-inline="true" data-icon="plus" data-iconpos="right">ver</a>
                                        </div>
                                     </div>
                                    <strong><a href="<?php echo Lnk(1,enCad($row_LsRd['rd_dir']),'','rD') ?>" target="_blank" class="rd_lnk"><?php echo ShortTx(ctjTx($row_LsRd['rd_tt'],'in'),30,'Pt') ?></a></strong><br><?php echo ShortTx(ctjTx($row_LsRd['rd_dsc'],'in'),170,'Pt') ?>
                                   
                                </div>
                            
                            
                            <?php if($i==4){$l++; $i=0;} $i++; } while ($row_LsRd = mysql_fetch_assoc($LsRd)); ?> 
                                          
<?php mysql_free_result($LsRd); ?>