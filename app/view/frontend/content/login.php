

<section class="section section-xs bg-default">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6 col-xl-5">
          <!-- RD Mailform-->
          <form class="rd-form rd-mailform ajaxfrm" id="login">
          	<div id="login_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
            <div class="form-wrap form-wrap-icon">
              <input class="form-input" id="email" type="text" name="email" data-constraints="@Required">
              <label class="form-label" for="email"><?=$pageData->label->label->username->title?></label>
              <div class="icon form-icon mdi mdi-account-outline"></div>
            </div>
            <div class="form-wrap form-wrap-icon">
              <input class="form-input" id="password" type="password" name="password" data-constraints="@Required">
              <label class="form-label" for="password"><?=$pageData->label->label->password->title?></label>
              <div class="icon form-icon mdi mdi-key"></div>
            </div>
            <div class="form-wrap form-wrap-checkbox">
              <a href="/<?=$pageData->lang->selected.$pageData->label->label->account_resetpwd->url?>"><?=$pageData->label->label->forget_pwd->icon.' '.$pageData->label->label->forget_pwd->title?></a>
            </div>
            <div class="form-wrap form-wrap-group group-1">
              <button class="button button-lg button-primary" type="submit"><?=$pageData->label->label->login->icon.' '.$pageData->label->label->login->title?> </button>
              <a class="button button-lg button-default-outline" href="/<?=$pageData->lang->selected.$pageData->label->label->register->url?>"><?=$pageData->label->label->register->icon.' '.$pageData->label->label->register->title?> </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
