<?php
$vimeoId = get_field('id_video_vimeo');
//si le champ video_vimeo_url a été rempli à la place (les anciens site l'utilisent parfois)
if (empty($vimeoId)) {
  $vimeoId =
    get_field('video_vimeo_url');
}
$vimeoId = strpos($vimeoId, 'http') === 0 ? vimeo_id_from_url($vimeoId) : $vimeoId;
?>
<iframe id="vimeoIframe" src="https://player.vimeo.com/video/<?= $vimeoId; ?>" style="width:100%;margin:auto;padding-bottom:0px;" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>