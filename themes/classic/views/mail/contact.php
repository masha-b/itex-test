<h2>следующие данные были отправлены:</h2>
<?php if($name) { ?>
    <p><b>Имя:</b> <?php echo $name ?></p>
<? } ?>
<?php if($subject) { ?>
    <p><b>Тема сообщения:</b> <?php echo $subject ?></p>
<? } ?>
<?php if($body) { ?>
    <p><b>Текст сообщения:</b> <?php echo $body ?></p>
<? } ?>