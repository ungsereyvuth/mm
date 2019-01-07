<div class="form-group txtCenter fullwidth v_mgn5 listnav hidden">
	<button type="submit" class="btn btn-info btn-xs nav_first"><?=$pageData->label->label->first->icon?> <?=$pageData->label->label->first->title?></button>
	<button type="submit" class="btn btn-info btn-xs nav_prev"><?=$pageData->label->label->previous->icon?> <?=$pageData->label->label->previous->title?></button>
	<select class="nav_pageNum btn btn-info btn-xs nav_currentPage" id=""></select>
	<button type="submit" class="btn btn-info btn-xs nav_next" ><?=$pageData->label->label->next->title?> <?=$pageData->label->label->next->icon?></button>
	<button type="submit" class="btn btn-info btn-xs nav_last"><?=$pageData->label->label->last->title?> <?=$pageData->label->label->last->icon?></button>
	<?php if(isset($insert_btn) and $insert_btn){ ?><button type="button" class="btn btn-info btn-xs btn_insert"><i class="fa fa-plus-square"></i></button><?php }?>
</div>