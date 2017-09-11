<div id="Dashboard_SideBar" class="t3-sidebar" >







    <div id="Dashboard_SideBar_Header" style="background-color: #253136">



        <div id="space_below_header">
            <br><br>
        </div>



        <div id="Sidebar_Header_Image" style=" height: 96px;">
            <center><img src='<?php echo "$IMAGE_FOLDER_LINK_PATH/restaurant_logo.png" ;?>' alt='<?php echo "$ROOT_FOLDER_PATH/images/restaurant_logo.png" ;?>' class="img-fluid" style="height: 100%;width: 70%" ></center>
        </div>


        <br>


        <div id="Sidebar_Header_Text">
            <center>
                <h6 style="color: palegoldenrod">
                    <span><i class="fa fa-user" aria-hidden="true"></i></span>
                    &nbsp; Rafique Gagneja</h6>
            </center>
        </div>



        <br><br>

        <div style="background-color: white; height: 1px; "></div>
        <br>


    </div>





    <div id ="Dashboard_Sidebar_MainContent"  style="background-color: #253136; overflow-y: auto ; ">



        <ul class="t3-list">

<!--            <li >-->
<!--                <a href="#"><span><i class="fa fa-home" aria-hidden="true"></i></span>&nbsp;Home</a>-->
<!--            </li>-->





            <li>
                <a id="link_sublist_collapse_list_Menu" href='#collapse_list_Menu'  data-toggle="collapse">
                    <span><i class="fa fa-book"></i></span>&nbsp; Menu
                </a>
            </li>
            <div id="collapse_list_Menu" class="collapse">

                <ul class="t3-sublist">
                    <li>
                        <a class="" id="link_all-menuitems" href='<?php echo "$RootLinkPath/frontend/menu/menu_items/all-menuitems.php" ; ?>' >
                            <span><i class="fa fa-book"></i></span>&nbsp;Menu Items
                        </a>
                    </li>
                    <li>
                        <a class="" id="link_all-addons" href='<?php echo "$RootLinkPath/frontend/menu/addons/all-addons.php" ; ?>' >
                            <span><i class="fa fa-picture-o"></i></span>&nbsp; Addons
                        </a>
                    </li>
                    <li>
                        <a class="" id="link_all-subcat" href='<?php echo "$RootLinkPath/frontend/menu/subcat_addon_management/all-subcat.php" ; ?>' >
                            <span><i class="fa fa-phone"></i></span>&nbsp; Category Management
                        </a>
                    </li>
                </ul>

            </div>







            <li >
                <a id="link_sublist_analytics_collapse_list" href="#analytics_collapse_list" data-toggle="collapse">
                    <span><i class="fa fa-bar-chart"></i></span>&nbsp; Analytics
                </a>
            </li>

            <div id="analytics_collapse_list" class="collapse">

                <ul class="t3-sublist">
                    <li>
                        <a id="link_daily_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/day.php" ; ?>' >
                            <span><i class="fa fa-line-chart"></i></span>&nbsp; Daily Analytics
                        </a>
                    </li>
                    <li>
                        <a id="link_monthly_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/month.php" ; ?>' >
                            <span><i class="fa fa-pie-chart"></i></span>&nbsp; Monthly Analytics
                        </a>
                    </li>
                    <li>
                        <a id="link_yearly_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/year.php" ; ?>' >
                            <span><i class="fa fa-area-chart"></i></span>&nbsp; Yearly Analytics
                        </a>
                    </li>
                    <li>
                        <a id="link_user_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/user.php" ; ?>' >
                            <span><i class="fa fa-bar-chart"></i></span>&nbsp; User Analytics</a>
                    </li>
                    <li>
                        <a id="link_comp_daily_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/compare_day.php" ; ?>' >
                            <span><i class="fa fa-line-chart"></i></span>&nbsp; Compare Daily Analytics
                        </a>
                    </li>
                    <li>
                        <a id="link_comp_monthly_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/compare_month.php" ; ?>' >
                            <span><i class="fa fa-pie-chart"></i></span>&nbsp; Compare Monthly Analytics
                        </a>
                    </li>
                    <li>
                        <a id="link_comp_yearly_analytics" href='<?php echo "$RootLinkPath/frontend/analytics/compare_year.php" ; ?>' >
                            <span><i class="fa fa-area-chart"></i></span>&nbsp; Compare Yearly Analytics
                        </a>
                    </li>

                </ul>

            </div>





            <li>
                <a href="<?php echo "$RootLinkPath/frontend/order/order_management.php" ; ?>" >
                    <span><i class="fa fa-opera"></i></span>&nbsp; Orders
                </a>
            </li>





            <li>
                <a id="link_sublist_collapse_list_restaurantInfo" href="#collapse_list_restaurantInfo" class="" data-toggle="collapse">
                    <span><i class="fa fa-cutlery"></i></span>&nbsp; Restaurant Info
                </a>
            </li>

            <div id="collapse_list_restaurantInfo" class="collapse">

                <ul class="t3-sublist">
                    <li>
                        <a class="" id="link_contact_info" href='<?php echo "$RootLinkPath/frontend/restaurant_info/contact/read_contact_info.php" ; ?>' >
                            <span><i class="fa fa-info-circle"></i></span>&nbsp; Contact Info
                        </a>
                    </li>
                    <li>
                        <a class="" id="link_gallery" href='<?php echo "$RootLinkPath/frontend/restaurant_info/gallery/all-gallery-items.php" ; ?>' >
                            <span><i class="fa fa-picture-o"></i></span>&nbsp; Gallery
                        </a>
                    </li>
                    <li>
                        <a class="" id="link_about_us" href='<?php echo "$RootLinkPath/frontend/restaurant_info/about/read_about_us.php" ; ?>' >
                            <span><i class="fa fa-phone"></i></span>&nbsp; About Us
                        </a>
                    </li>
                    <li>
                        <a class="" id="link_openingScr_Images" href='<?php echo "$RootLinkPath/frontend/restaurant_info/opening_screen/all-openscr-images.php" ; ?>' >
                            <span><i class="fa fa-archive"></i></span>&nbsp; Welcome Images
                        </a>
                    </li>
                </ul>

            </div>







            <li>
                <a href='<?php echo "$RootLinkPath/frontend/blog/all-blogpost.php" ; ?>' ><span><i class="fa fa-newspaper-o"></i></span>&nbsp; Blog</a>
            </li>





            <li>
                <a href='<?php echo "$RootLinkPath/frontend/notification/all-notifications.php" ; ?>' ><span><i class="fa fa-commenting"></i></span>&nbsp; Push Notification</a>
            </li>





<!--            <li>-->
<!--                <a href="#" ><span><i class="fa fa-calendar"></i></span>&nbsp; Events</a>-->
<!--            </li>-->
<!---->
<!---->
<!---->
<!--            <li>-->
<!--                <a href="#" ><span><i class="fa fa-registered"></i></span>&nbsp; Reservations</a>-->
<!--            </li>-->

            <li>
                <a href='<?php echo "$RootLinkPath/frontend/coupon/all-coupons.php" ; ?>' ><span><i class="fa fa-registered"></i></span>&nbsp; Coupons</a>
            </li>

<!--            <li>-->
<!--                <a href="#" ><span><i class="fa fa-cog"></i></span>&nbsp; Settings</a>-->
<!--            </li>-->


        </ul>



        <br><br><br><br>




    </div>


</div>
