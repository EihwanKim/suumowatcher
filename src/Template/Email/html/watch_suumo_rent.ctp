total : <?= count($vars);?>
<table>
    <tr>
        <th>ID</th>
        <th>タイトル</th>
        <th>URL</th>
        <th>価格</th>
        <th>管理費</th>
        <th>敷金</th>
        <th>礼金</th>
        <th>所在地</th>
        <th>サクセス</th>
        <th>広さ</th>
        <th>間取り</th>
        <th>築年月</th>
        <th>建階</th>
        <th>抽出日</th>
</tr>
<?php
foreach ($vars as $rent):
?>
    <tr>
            <td><?= h($rent->id); ?>
            <td><?= h($rent->title); ?>
            <td><?= h($rent->url); ?>
            <td><?= h($rent->price); ?>
            <td><?= h($rent->place); ?>
            <td><?= h($rent->access); ?>
            <td><?= h($rent->width); ?>
            <td><?= h($rent->room_type); ?>
            <td><?= h($rent->build_date); ?>
            <td><?= h($rent->floor); ?>
            <td><?= h($rent->created); ?>
        </tr>
<?php
endforeach;
?>
</table>