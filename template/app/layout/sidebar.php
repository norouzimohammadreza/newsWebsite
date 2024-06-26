</div>
                    <div class="col-lg-4">
                        <div class="sidebars-area">
                            <div class="single-sidebar-widget editors-pick-widget">
                                <h6 class="title">انتخاب سردبیر</h6>
                                <?php foreach ($SelectedPosts as $SelectedP) { ?>
                                <div class="editors-pick-post">
                                    <div class="feature-img-wrap relative">
                                        <div class="feature-img relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="<?= asset($SelectedP['image']); ?>" alt="">
                                        </div>
                                        <ul class="tags">
                                            <li><a href="<?= url('category'.'/'.$SelectedP['cat_id']) ?>"><?= $SelectedP['cat_title']  ?> </a></li>
                                        </ul>
                                    </div>
                                    <div class="details">
                                        <a href="<?= url('post'.'/'.$SelectedP['id']) ?>">
                                            <h4 class="mt-20"><?= $SelectedP['title']  ?></h4>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="<?= url('post'.'/'.$SelectedP['id']) ?>"><span class="lnr lnr-user"></span><?= $SelectedP['username']  ?></a></li>
                                            <li><a href="<?= url('post'.'/'.$SelectedP['id']) ?>"><?= $SelectedP['created_time']  ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="<?= url('post'.'/'.$SelectedP['id']) ?>"><?= $SelectedP['comment_count']  ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- ads -->
                            <div class="single-sidebar-widget ads-widget">
                                <img class="img-fluid" src="<?= asset($sideBanner['image'])?>" alt="">
                            </div>
                            <!-- end ads -->
                            <div class="single-sidebar-widget most-popular-widget">
                                <h6 class="title">پر بحث ترین ها</h6>
                                <?php foreach ($mostComments as $mC) {  ?>
                                <div class="single-list flex-row d-flex">
                                    <div class="thumb">
                                        <img class="img-fluid" src="<?= asset($mC['image']); ?>" width="120px" height="85px" alt="">
                                    </div>
                                    <div class="details">
                                        <a href="<?= url('post'.'/'.$mC['id']) ?>">
                                            <h6><?= $mC['title']  ?></h6>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="<?= url('post'.'/'.$mC['id']) ?>"><?= $mC['created_time']  ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="<?= url('post'.'/'.$mC['id']) ?>"><?= $mC['comment_count']  ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                             <?php } ?>
                            </div>

                        </div>
                    </div>