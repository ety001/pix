<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <ul>
            <?php foreach ($all as $k => $v):?>
            <li>
                <?php if($v['type']==1):?>
                <h5><a href="/pix/createWorld?id=<?php echo $v['id'];?>" target="_blank"><?php echo $v['name'];?></a></h5><br>
                <?php else:?>
                <h5><a href="/pix/createAnimation?id=<?php echo $v['id'];?>" target="_blank"><?php echo $v['name'];?></a></h5><br>
                <?php endif;?>
                <img src="<?php echo _createPNGPath($v['thumb_name']);?>" style="width:60px;height:60px;"><br>
                <?php echo $v['thumb_name'];?><br>
                <a href="/pix/yuyecaho_del/<?php echo $v['id'];?>" onclick="javascript:return confirm('确认删除');">Del</a><br>
            </li>
            <?php endforeach;?>
        </ul>
    </body>
</html>