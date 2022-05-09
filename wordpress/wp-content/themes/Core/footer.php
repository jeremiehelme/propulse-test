<?php
$mentions =
  get_field('mentions_globales', 'option');
if ($mentions) :
?>
  <div class='max-site-width  mx-auto  px-5 xl:px-0 mt-10 mb-5 xl:mb-10'>
    <div class=' line  mb-5'></div>
    <div class='text'>
      <div class='mentions'>
        <?= $mentions; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
</div>
</div>
<footer class=' mt-5 lg:mt-10 py-5 lg:py-10 '>
  <nav id="footer-navigation" class="footer-navigation max-site-width mx-auto px-5 lg:px-0">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'footer-links',
    ));
    ?>
  </nav>
</footer>
<?php wp_footer(); ?>
</body>

</html>