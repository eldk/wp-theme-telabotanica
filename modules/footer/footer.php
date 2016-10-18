<?php function telabotanica_module_footer($data) { ?>
  <footer class="footer" role="contentinfo">
    <!-- <div class="site-info">
      <span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
    </div> -->
    <div class="footer-about layout-2-col">
      <div class="layout-wrapper">
        <div class="footer-about-tela layout-column">
          <div class="footer-about-tela-logo">Tela Botanica</div>
          <div class="footer-about-tela-coordonnees">
            <div class="footer-about-tela-coordonnees-adresse">4 rue de Belfort, 34000 Montpellier, France</div>
            <div class="footer-about-tela-coordonnees-tel">Téléphone : +33 (4) 67 52 41 225</div>
            <div class="footer-about-tela-coordonnees-mail"><a href="mailto:accueil@tela-botanica.org">accueil@tela-botanica.org</a></div>
          </div>

          <ul class="footer-about-tela-social-items">
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-facebook"></i> Facebook</a></li>
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-twitter"></i> Twitter</a></li>
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-pinterest"></i> Pinterest</a></li>
          </ul>
        </div>

        <?php the_telabotanica_module('form-newsletter', array('modifiers' => 'layout-column')); ?>
      </div>
    </div>

    <?php if ( has_nav_menu( 'pied-de-page-colonnes' ) ) : ?>
      <nav class="footer-nav" role="navigation" aria-label="<?php esc_attr_e( 'Plan du site', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'pied-de-page-colonnes',
            'menu_class'     => 'footer-nav-items layout-wrapper',
          ) );
        ?>
      </nav>
    <?php endif; ?>

    <?php if ( has_nav_menu( 'pied-de-page-bandeau' ) ) : ?>
      <nav class="footer-nav-bandeau" role="navigation" aria-label="<?php esc_attr_e( 'Menu de pied de page', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'pied-de-page-bandeau',
            'menu_class'     => 'footer-nav-bandeau-items',
            'depth'          => 1,
          ) );
        ?>
        <a href="http://creativecommons.org/licenses/by-sa/2.0/fr/" target="_blank" rel="nofollow" class="footer-nav-licence">CC BY-SA 2.0</a>
      </nav>
    <?php endif; ?>
  </footer><!-- .site-footer -->
<?php }