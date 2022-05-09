<div class='premium-list grid mt-5'>
    <?php
    if (isset($premiumsList)) {
        foreach ($premiumsList as $i => $premium) :
            if (isset($reinsurance) && checkArray($reinsurance, 'text') && !empty($reinsurance['text']) && ($i != 0 && $i % 3 == 0)) {
                include(locate_template('/components/reinsurance.php'));
            }
            $pFields = get_fields($premium);
            include(locate_template('/components/premium_small.php'));
        endforeach;
        if (isset($reinsurance) && checkArray($reinsurance, 'text') && !empty($reinsurance['text']) && (count($premiumsList) % 3 == 0)) {
            include(locate_template('/components/reinsurance.php'));
        }
    }
    ?>
</div>