<?php
use zunxiang\fenlei\assets\SortAssets;


SortAssets::register($this);

//exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="keywords" content="分类聚合">
    <meta name="description" content="化龙巷-手机移动版">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="blank" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php $this->head();?>
<!--    <link rel="stylesheet" type="text/css" href="/sort/css/style.css">-->
<!--    --><?php //SortAssets::addCss($this,'/sort/css/style.css');?>
<!--    --><?php //SortAssets::addScript($this,'/sort/js/jquery-1.11.2.min.js');?>
<!--    --><?php //SortAssets::addScript($this,'/sort/js/swiper.js');?>
<!--    <script type="text/javascript" src="/sort/js/jquery-1.11.2.min.js"></script>-->
<!--    <script type="text/javascript" src="/sort/js/swiper.js"></script>-->
    <script>
        //JS监听浏览器文字大小代码
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth > 750) clientWidth = 750;
                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                };

            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
</head>
<body>
    <div class="main">
        <!-- banner begin -->
        <div class="banner-img swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($top_ad as $activity){?>
                <a href="javascript:void(0)" class="swiper-slide jump_type" data-url="<?=$activity['']?>" data-tid="" data-fid="">
                    <img src="<?=$activity['']?>" />
                    <p><?=$activity['name']?></p></a>
                <?php }?>
            </div>
            <div class="banner-loop swiper-pagination"></div>
        </div>
        <!--banner end-->
        <!-- nav begin -->
        <div class="banner-icon swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($forum_info as $key => $forums){?>
                    <?php if($key == 0){?>
                <a href="javascript:void(0)" class="swiper-slide">
                        <?php foreach($forums as $forum){?>
                    <div class="nav clearfix">
                        <div class="nav-a jump_type"  data-url="<?=$forum['direct_url']?>" data-tid="" data-fid="<?=$forum['fid']?>">
                            <img class="lazy_entrance" src="<?=$forum['logo']?>" />
                            <span><?=$forum['default_name']?></span>
                        </div>
                    </div>
                        <?php }?>
                </a>

                    <?php }else{?>

                <a href="javascript:void(0)" class="swiper-slide" >
                        <?php foreach($forums as $forum){?>
                    <div class="nav clearfix">
                        <div class="nav-a jump_type"  data-url="<?=$forum['direct_url']?>" data-tid="" data-fid="<?=$forum['fid']?>">
                            <img class="lazy_entrance" src="<?=$forum['logo']?>" />
                            <span><?=$forum['default_name']?></span>
                        </div>
                    </div>
                        <?php }?>
                </a>

                <?php }}?>
            </div>

            <div class="nav-loop swiper-pagination"></div>
        </div>
        <!-- nav end -->
        <!-- main begin -->
        <div class="content">
            <div class="content-title">最新发布</div>
            <div class="content-list">
                <ul>
                    <?php foreach($threads as $thread){?>
                    <li>
                        <a href="javascript:void(0)" class="jump_type" data-url="" data-tid="<?=$thread['tid']?>" data-fid="" >
                            <div class="news <?php if($thread['attnum'] == 1) echo 'only-one'?>">
                                <p><?=$thread['subject']?></p>
                                <div class="news-img photos">
                                    <?php if($thread['attnum'] == 3){ foreach($thread['attachs'] as $val){?>
                                    <span><img src="<?=$val['attach']?>"></span>
                                    <?php }}?>
                                </div>
                                <div class="news-review">
                                    <span><?=$thread['author']?></span>
                                    <span><i><?=$thread['views']?></i>阅读</span>
                                    <?php if($thread['attnum'] != 1){?> <span class="fr"><?=$thread['time']?></span><?php }?>
                                </div>
                            </div>
                            <?php if($thread['attnum'] == 1){?>
                                <div class="news-img photo">
                                    <img src="<?php if($thread['attachs'][0]) echo $thread['attachs'][0]; ?>">
                                </div>
                            <?php }?>
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- main end -->
    </div>
    <script type="text/javascript">
        //跳转。。。。。
        $(".jump_type").click(function(){
            var url = $(this).attr('data-url');
            var tid = $(this).attr('data-tid');
            var fid = $(this).attr('data-fid');

            if(url != '' && tid == '') QFWap.openUrl(url);
            if(tid != '' && url == '' && fid == '') QFH5.jumpThread(parseInt(tid));
            if(fid != '' && tid == '' && url == '') QFH5.jumpThreadList(parseInt(fid));

        }
        //轮播图
        $(".banner-img").swiper({
            loop: false,
            autoplay: 3000,
            autoplayDisableOnInteraction : false
        });
        $(".banner-icon").swiper({
            loop: false,
        });

        // 加载刷新。
        function refresh() {
        //function refresh(loadmore) {
            $(window).scroll(function(){
                console.log('正在滑动');

                var scrollTop = $(this).scrollTop();    //滚动条距离顶部的高度
                var scrollHeight = $(document).height();   //当前页面的总高度
                var clientHeight = $(this).height();    //当前可视的页面高度
                console.log("top:"+scrollTop+",doc:"+scrollHeight+",client:"+clientHeight);
                if(scrollTop + clientHeight >= scrollHeight){   //距离顶部+当前高度 >=文档总高度 即代表滑动到底部 
                    // count++;         //每次滑动count加1
                    // filterData(serviceTypeId,industryId,cityId,count); //调用筛选方法，count为当前分页数
                    //alert('下拉');

                    $.ajax({
                        type: "POST",
                        url: window.location.href,
                        data: {page:page,fids:'ajax'},
                        dataType: 'json',
                        success: function(data) {
                            var html;
                            html = $('#post_list');
                            if(data){
                                html.append(node);
                            } else {
                                pullUpEl.find('.pullUpLabel').html("");
                                pullUpEl.unbind('click');
                            }
                            pullUpEl.removeClass("loading");
                        }
                    });

                }else if(scrollTop<=0){
                    //滚动条距离顶部的高度小于等于0 TODO
                    //alert("下拉刷新，要在这调用啥方法？");
      
                    alert('上拉');
                    // if(refresh){
                    //     refresh();
                    // }

                }

            });
        }

        //调用
        refresh();
        //refresh(loadmore);
    </script>
</body>
</html>