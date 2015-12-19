
	<div class="menubar-fixed-panel">
            <div>
                <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="expanded">
                <a href="dashboard">
                    <span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
                </a>
            </div>

	</div>
	<div class="menubar-scroll-panel">
            <ul id="main-menu" class="gui-controls gui-controls-tree">
		<li>
                    <a href="#" class="active">
                        <div class="gui-icon"><i class="fa fa-home"></i></div>
                        <span class="title">Home</span>
                    </a>
		</li>
		<li>
                    <a href="#">
                        <div class="gui-icon"><i class="fa fa-dashboard"></i></div>
                        <span class="title">Dashboard</span>
                    </a>
		</li>
                <li>
                    <a href="#">
                        <div class="gui-icon"><i class="fa fa-play-circle-o"></i></div>
                        <span class="title">Push Notification</span>
                    </a>
                    <!--start submenu -->
                    <ul>
                        <li>
                            <a href="<?php echo site_url('push_notification')?>">
                                <span class="title">Send Notification</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('push_notification/notification_user')?>">
                                <span class="title">User</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('push_notification/notification_history')?>">
                                <span class="title">History</span>
                            </a>
                        </li>
                    </ul>
                    <!--end /submenu -->
		</li>
                <li>
                    <a href="#">
                        <div class="gui-icon"><i class="fa fa-book"></i></div>
                        <span class="title">Catalog</span>
                    </a>
                    <!--start submenu -->
                    <ul>
                        <li>
                            <a href="<?php echo site_url('product')?>">
                                <span class="title">Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('category')?>">
                                <span class="title">Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('product_attribute_group')?>">
                                <span class="title">Product Attributes</span>
                            </a>
                        </li>
                    </ul>
                    <!--end /submenu -->
		</li>
                <li>
                    <a href="#">
                        <div class="gui-icon"><i class="fa fa-credit-card"></i></div>
                        <span class="title">Order</span>
                    </a>
                    <!--start submenu -->
                    <ul>
                        <li>
                            <a href="<?php echo site_url('order')?>">
                                <span class="title">Orders</span>
                            </a>
                        </li>
                    </ul>
                    <!--end /submenu -->
		</li>
            </ul>
	</div>