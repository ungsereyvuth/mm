<div class="datalist" data-loadmode="loadmore" id="<?=$cmd?>">
    <div class="loaded_data"></div>
    <div class="txtCenter"><span class="totalLoadedRows fs11" data-unit="<?=$item_unit?>"></span></div>
    <div class="txtCenter"><button type="button" class="btn btn-default btn-xs nav_next"><i class="fa fa-angle-double-down"></i> Load More</button></div>    
    <input type="hidden" class="nav_currentPage" />
    <?php if(isset($input))foreach($input as $key=>$value){echo '<input type="hidden" class="searchinputs" id="'.$key.'" value="'.$value.'" />';}?>
</div> 