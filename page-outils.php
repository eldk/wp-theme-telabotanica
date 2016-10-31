<?php
/**
 * Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', array()); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('toc', array()); ?>
          </aside>
          <div class="layout-content">
            <article class="article">
              <?php
              // Si la page utilise des composants
              if( have_rows('components') ):

                  // On boucle sur les composants
                  while ( have_rows('components') ) : the_row();

                    the_telabotanica_component(get_row_layout(), array());

                  endwhile;

              else :

                  // no layouts found

              endif;

              $taxonomy_name = 'tb_outils_category';
              $tools_categories = get_terms(array(
                'taxonomy'   => $taxonomy_name,
                'hide_empty' => false,
                'fields'     => 'all',
                'parent'     => 0
              ));

              function term_title_and_description($term) {
                global $taxonomy_name;

                the_telabotanica_component( 'title', array(
                  "level" => $term->parent === 0 ? 2 : 3,
                  "anchor" => "titre-niveau-2",
                  "title" => $term->name
                ));

                if ( !empty( $term->description ) ) {
                  the_telabotanica_component( 'text', array(
                    "text" => sprintf( "<p>%s</p>", $term->description )
                  ));
                }

                $tools = get_posts(array(
                  'post_type' => 'tb_outil',
                  'tax_query' => array(
                    array(
                      'taxonomy' => $taxonomy_name,
                      'field' => 'term_id',
                      'terms' => $term->term_id,
                      'include_children' => false
                    )
                  ),
                  'numberposts' => -1
                ));
                the_telabotanica_component('tools', array(
                  'items' => $tools
                ));

              }

              foreach ( $tools_categories as $term ) :

                term_title_and_description($term);

                foreach ( get_term_children( $term->term_id, $taxonomy_name ) as $child ) :
                  $term_child = get_term_by( 'id', $child, $taxonomy_name );
                  term_title_and_description($term_child);
                endforeach;

              endforeach;

              ?>
            </article>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>