<div class="page_content">
    <div class="datalist txtLeft pad10" id="<?=$pageData->fileview?>">
		<?=$pageData->data->content->search_inputs?>
        <?php include("app/view/frontend/layout/pagination_info.php"); ?>
        <table width="100%" class="" >
            <tbody class="profile"></tbody>
        </table> 
        <?php include("app/view/frontend/layout/listPagination.php");?>  
    </div> 	
</div>