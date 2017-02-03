<script type="text/template" id="tmpl-dropdown-menu">
  <div class="aa-dropdown-menu-wrapper">
    <div class="aa-dataset aa-dataset-0"></div>
    <div class="aa-dataset aa-dataset-1"></div>
    <div class="aa-dataset aa-dataset-2"></div>
    <div class="aa-dataset aa-dataset-3"></div>
    <div class="aa-dataset aa-dataset-4"></div>
    <div class="aa-dataset aa-dataset-5"></div>
  </div>
</script>

<script type="text/html" id="tmpl-autocomplete-header">
	<a href="{{{ data.resultsUrl }}}" class="autocomplete-header">
		<div class="autocomplete-header-title">{{{ data.label }}}</div>
		<div class="autocomplete-header-count">{{{ data.nbHits }}}</div>
		<div class="autocomplete-header-more"><?php _e( 'voir plus', 'telabotanica' ); ?></div>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-post-suggestion">
	<a class="suggestion-link" href="{{ data.permalink }}" title="{{ data.post_title }}">
		<# if ( data.images.thumbnail ) { #>
		<img class="suggestion-post-thumbnail" src="{{ data.images.thumbnail.url }}" alt="{{ data.post_title }}">
		<# } #>
		<div class="suggestion-post-attributes">
			<span class="suggestion-post-title">{{{ data._highlightResult.post_title.value }}}</span>

			<#
			var attributes = ['content', 'title6', 'title5', 'title4', 'title3', 'title2', 'title1'];
			var attribute_name;
			var relevant_content = '';
			for ( var index in attributes ) {
			attribute_name = attributes[ index ];
			if ( data._highlightResult[ attribute_name ].matchedWords.length > 0 ) {
			relevant_content = data._snippetResult[ attribute_name ].value;
			break;
			} else if( data._snippetResult[ attribute_name ].value !== '' ) {
			relevant_content = data._snippetResult[ attribute_name ].value;
			}
			}
			#>
			<span class="suggestion-post-content">{{{ relevant_content }}}</span>
		</div>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-taxon-suggestion">
	<a class="suggestion-link" href="{{ data.bdtfx.url }}"  title="{{ data.bdtfx.scientific_name }}">
		<span class="suggestion-taxon-title">{{{ data._highlightResult.bdtfx.scientific_name.value }}}</span>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-syntaxon-suggestion">
	<a class="suggestion-link" href="{{ data.url }}"  title="{{ data.commonName }}">
		<span class="suggestion-syntaxon-title">{{{ data._highlightResult.syntaxon.value }}}</span>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-term-suggestion">
	<a class="suggestion-link" href="{{ data.permalink }}"  title="{{ data.name }}">
		<svg viewBox="0 0 21 21" width="21" height="21"><svg width="21" height="21" viewBox="0 0 21 21"><path d="M4.662 8.72l-1.23 1.23c-.682.682-.68 1.792.004 2.477l5.135 5.135c.7.693 1.8.688 2.48.005l1.23-1.23 5.35-5.346c.31-.31.54-.92.51-1.36l-.32-4.29c-.09-1.09-1.05-2.06-2.15-2.14l-4.3-.33c-.43-.03-1.05.2-1.36.51l-.79.8-2.27 2.28-2.28 2.27zm9.826-.98c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25z" fill-rule="evenodd"></path></svg></svg>
		<span class="suggestion-post-title">{{{ data._highlightResult.name.value }}}</span>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-user-suggestion">
	<a class="suggestion-link user-suggestion-link" href="{{ data.posts_url }}"  title="{{ data.display_name }}">
		<# if ( data.avatar_url ) { #>
		<img class="suggestion-user-thumbnail" src="{{ data.avatar_url }}" alt="{{ data.display_name }}">
		<# } #>

		<span class="suggestion-post-title">{{{ data._highlightResult.display_name.value }}}</span>
	</a>
</script>

<script type="text/html" id="tmpl-autocomplete-footer">
	<div class="autocomplete-footer">
		<div class="autocomplete-footer-branding">
			<?php esc_html_e( 'Powered by', 'algolia' ); ?>
			<a href="#" class="algolia-powered-by-link" title="Algolia">
				<img class="algolia-logo" src="https://www.algolia.com/assets/algolia128x40.png" alt="Algolia" />
			</a>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-autocomplete-empty">
	<div class="autocomplete-empty">
		<?php esc_html_e( 'Aucun résultat pour ', 'telabotanica' ); ?>
		<span class="empty-query">"{{ data.query }}"</span>
	</div>
</script>
