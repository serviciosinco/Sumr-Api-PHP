<?php $pageNum = 0; $startRow_LsRd = $pageNum * 8; mysql_select_db(DB, CnRd()); $query_LsRd = "SELECT * FROM por_rd ORDER BY id_rd DESC"; $query_limit_LsRd = sprintf("%s LIMIT %d, %d", $query_LsRd, $startRow_LsRd, 8); $LsRd = mysql_query($query_limit_LsRd, CnRd()); $row_LsRd = mysql_fetch_assoc($LsRd); $totalRows_LsRd = mysql_num_rows($LsRd); 
?>
<article>
    <div class="rd_lst">
<?php $i=1; $l=1; do{ ?>
        <?php if($i==1){ ?><div class="ln<?php echo $l ?>"><?php } ?>	
            <div class="col<?php echo $i ?>">
                <div class="cov"><img src="<?php echo DIR_IMG_RD.$row_LsRd['rd_img'] ?>" height="100"/></div>
                <strong><a href="<?php echo Lnk(1,enCad($row_LsRd['rd_dir']),'','rD') ?>" target="_blank"><?php echo ShortTx(ctjTx($row_LsRd['rd_tt'],'in'),25,'Pt') ?></a></strong><p><?php echo ShortTx(ctjTx($row_LsRd['rd_dsc'],'in'),100,'Pt') ?></p>
                <a href="<?php echo Lnk(1,enCad($row_LsRd['rd_dir']),'','rD') ?>" class="button" target="_blank">ver</a>
            </div>
        
        <?php if($i==4){ ?></div><?php } ?>
        <?php if($i==4){$l++; $i=0;} $i++; } while ($row_LsRd = mysql_fetch_assoc($LsRd)); ?> 
    </div>
</article>                  
<?php mysql_free_result($LsRd); ?>