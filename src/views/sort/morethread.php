
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