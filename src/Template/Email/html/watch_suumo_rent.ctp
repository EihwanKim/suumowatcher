total : <?php count($vars);?>
<table>
    <tr>
        <th>ID</th>
        <th>タイトル</th>
        <th>URL</th>
        <th>価格</th>
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
        <td><?php echo $rent['id']; ?>
        <td><?php echo $rent['title']; ?>
        <td><?php echo $rent['url']; ?>
        <td><?php echo $rent['price']; ?>
        <td><?php echo $rent['place']; ?>
        <td><?php echo $rent['access']; ?>
        <td><?php echo $rent['width']; ?>
        <td><?php echo $rent['room_type']; ?>
        <td><?php echo $rent['build_date']; ?>
        <td><?php echo $rent['floor']; ?>
        <td><?php echo $rent['created']; ?>
    </tr>
    <tr>
            <td><?php echo $rent->id; ?>
            <td><?php echo $rent->title; ?>
            <td><?php echo $rent->url; ?>
            <td><?php echo $rent->price; ?>
            <td><?php echo $rent->place; ?>
            <td><?php echo $rent->access; ?>
            <td><?php echo $rent->width; ?>
            <td><?php echo $rent->room_type; ?>
            <td><?php echo $rent->build_date; ?>
            <td><?php echo $rent->floor; ?>
            <td><?php echo $rent->created; ?>
        </tr>
<?
endforeach;
?>
</table>
