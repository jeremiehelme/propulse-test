<?php
$youtubeId = get_field('id_video_youtube');
$youtubeId = strpos($youtubeId, 'http') === 0 ? youtube_id_from_url($youtubeId) : $youtubeId;
?>
<iframe id="youtubeIframe" type="text/html" src="https://www.youtube.com/embed/<?= $youtubeId; ?>" frameborder="0" style="width:100%;margin:auto;padding-bottom:0px;" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>