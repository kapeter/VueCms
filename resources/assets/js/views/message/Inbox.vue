<template>
	<!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-sm-5 col-lg-3">
                <!-- Collapsible Inbox Navigation (using Bootstrap collapse functionality) -->
                <button class="btn btn-block btn-primary visible-xs push" data-toggle="collapse" data-target="#inbox-nav" type="button">Navigation</button>
                <div class="collapse navbar-collapse remove-padding" id="inbox-nav">
                    <!-- Inbox Menu -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button data-toggle="modal" data-target="#modal-compose" type="button"><i class="fa fa-pencil"></i> 新建邮件</button>
                                </li>
                            </ul>
                            <h3 class="block-title">收件箱</h3>
                        </div>
                        <div class="block-content">
                            <ul class="nav nav-pills nav-stacked push">
                                <li class="active">
                                    <a href="/">
                                        <span class="badge pull-right">3</span><i class="fa fa-fw fa-inbox push-5-r"></i> 收件箱
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="badge pull-right">48</span><i class="fa fa-fw fa-star push-5-r"></i> 星标邮件
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="badge pull-right">1480</span><i class="fa fa-fw fa-send push-5-r"></i> 发件箱
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="badge pull-right">2</span><i class="fa fa-fw fa-pencil push-5-r"></i> 草稿
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="badge pull-right">1987</span><i class="fa fa-fw fa-folder push-5-r"></i> 存档
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="badge pull-right">10</span><i class="fa fa-fw fa-trash push-5-r"></i> 回收站
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END Inbox Menu -->
                </div>
                <!-- END Collapsible Inbox Navigation -->
            </div>
            <div class="col-sm-7 col-lg-9">
                <!-- Message List -->
                <div class="block">
                    <div class="block-header">
                        <ul class="block-options">
                            <li>
                                <button class="js-tooltip" title="Previous 15 Messages" type="button" data-toggle="block-option"><i class="si si-arrow-left"></i></button>
                            </li>
                            <li>
                                <button class="js-tooltip" title="Next 15 Messages" type="button" data-toggle="block-option"><i class="si si-arrow-right"></i></button>
                            </li>
                            <li>
                                <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                            </li>
                            <li>
                                <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                            </li>
                        </ul>
                        <div class="block-title text-normal">
                            <strong>15-30</strong> <span class="font-w400">from</span> <strong>700</strong>
                        </div>
                    </div>
                    <div class="block-content">
                        <!-- Messages Options -->
                        <div class="push">
                            <button class="btn btn-default pull-right" type="button"><i class="fa fa-times text-danger push-5-l push-5-r"></i> <span class="hidden-xs">移至回收站</span></button>
                            <div class="btn-group">
                                <button class="btn btn-default" type="button"><i class="fa fa-archive text-primary push-5-l push-5-r"></i> <span class="hidden-xs">移至存档</span></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-star text-warning push-5-l push-5-r"></i> <span class="hidden-xs">标记为星标邮件</span></button>
                            </div>
                        </div>
                        <!-- END Messages Options -->

                        <!-- Messages & Checkable Table (.js-table-checkable class is initialized in App() -> uiHelperTableToolsCheckable()) -->
                        <div class="pull-r-l">
                            <table class="js-table-checkable table table-hover table-vcenter">
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 70px;">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600" style="width: 140px;">Evelyn Willis</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Welcome to our service</a>
                                            <div class="text-muted push-5-t">It's a pleasure to have you on our service..</div>
                                        </td>
                                        <td class="visible-lg text-muted" style="width: 80px;">
                                            <i class="fa fa-paperclip"></i> (3)
                                        </td>
                                        <td class="visible-lg text-muted" style="width: 120px;">
                                            <em>2 min ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Bruce Edwards</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Your subscription was updated</a>
                                            <div class="text-muted push-5-t">We are glad you decided to go with a vip..</div>
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <i class="fa fa-paperclip"></i> (2)
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <em>10 min ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">George Stone</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Update is available</a>
                                            <div class="text-muted push-5-t">An update is under way for your app..</div>
                                        </td>
                                        <td class="visible-lg text-muted"></td>
                                        <td class="visible-lg text-muted">
                                            <em>25 min ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Evelyn Willis</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">New Sale!</a>
                                            <div class="text-muted push-5-t">You had a new sale and earned..</div>
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <i class="fa fa-paperclip"></i> (1)
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <em>30 min ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Dennis Ross</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Action Required for your account!</a>
                                            <div class="text-muted push-5-t">Your account is inactive for a long time and..</div>
                                        </td>
                                        <td class="visible-lg text-muted"></td>
                                        <td class="visible-lg text-muted">
                                            <em>1 hour ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Lisa Gordon</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">New Photo Pack!</a>
                                            <div class="text-muted push-5-t">Our new photo pack is available now! You..</div>
                                        </td>
                                        <td class="visible-lg text-muted"></td>
                                        <td class="visible-lg text-muted">
                                            <em>2 hrs ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Rebecca Reid</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Product is released!</a>
                                            <div class="text-muted push-5-t">This is a notification about our new product..</div>
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <i class="fa fa-paperclip"></i> (1)
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <em>1 day ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">John Parker</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Now on Sale!</a>
                                            <div class="text-muted push-5-t">Our Book is out! You can buy a copy and..</div>
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <i class="fa fa-paperclip"></i> (9)
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <em>1 day ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Amy Hunter</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Monthly Report</a>
                                            <div class="text-muted push-5-t">The monthly report you requested for..</div>
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <i class="fa fa-paperclip"></i> (6)
                                        </td>
                                        <td class="visible-lg text-muted">
                                            <em>3 days ago</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox"><span></span>
                                            </label>
                                        </td>
                                        <td class="hidden-xs font-w600">Rebecca Gray</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#modal-message" href="#">Trial Started!</a>
                                            <div class="text-muted push-5-t">You 30-day trial has now started and..</div>
                                        </td>
                                        <td class="visible-lg text-muted"></td>
                                        <td class="visible-lg text-muted">
                                            <em>3 days ago</em>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- END Messages -->
                    </div>
                </div>
                <!-- END Message List -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->	
</template>
