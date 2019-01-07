<div class="page_content">
<div class="clearfix">	
	<div class="col-md-8 bg-blacklight">
		<form class="ajaxfrm sky-form" role="form" id="updateemailtemplate-form" data-func="submit_form" data-reset="1" action="" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label>Title</label>
                    	<input type="text" name="title" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Template Code <i class="fa fa-info-circle tooltips" title="for technical use only"></i></label>
                    	<input type="text" class="form-control" name="code" disabled>
					</div>
				</div>                 	
            </div>
            <div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label>Subject</label>
                    	<input type="text" class="form-control" name="subject">
					</div>
					<div class="col-md-6">
						<label>Content Codes [{code}] <i class="fa fa-info-circle tooltips" title="this code is used for dynamic data. Ex: [{name}] automatically displays the name of user in email content where it's actually placed in the email message"></i></label>
                    	<input type="text" class="form-control" name="content_codes" disabled>
					</div>
				</div>                 	
            </div>
            <div class="form-group">
                	<label>Content Text <i class="fa fa-info-circle tooltips" title="Email content with dynamic data code."></i></label>
                	<textarea class="form-control richtext" name="content"></textarea>
            </div>            	
	        <div class="form-group">
	        	<input type="hidden" name="recordid" value="" />
        		<input type="hidden" name="cmd" value="updateemailtemplate" />
                <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
                <div id="updateemailtemplate_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
	        </div>	
	    </form>
	</div>
	<div class="col-md-4">
		<?=$pageData->data->content->template_list?>
	</div>
</div>

</div>