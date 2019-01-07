<div class="page_content">
<div class="clearfix">	
	<div class="col-md-8 bg-blacklight">
        <div class="datalist txtLeft pad10" id="<?=$pageData->fileview?>">
            <?=$pageData->data->content->search_inputs?>
            <?php include("app/view/frontend/layout/pagination_info.php"); ?>
            <table width="100%" class="mytable" >
                <thead>
                    <tr><th style="width:50px;" class="txtCenter">No.</th><th>Name</th><th>Email</th><th>Date</th></tr>
                </thead>
                <tbody></tbody>
            </table> 
            <?php include("app/view/frontend/layout/listPagination.php");?>  
        </div> 	
    </div>
    <div class="col-md-4">
    
    </div>
</div>
</div>