<?php

function renderizaAcordeoesExtensao()
{
    $args = array(
        'post_type' => 'projeto-de-extensao',
        'posts_per_page' => -1,
    );

    $busca_posts = new WP_Query($args);

    $accordeonHead = <<<HTML
	
<!-- wp:kadence/accordion {"uniqueID":"a4325234","startCollapsed":true,"contentBgColor":"#ffffff","contentBorderStyle":[{"top":["","",0],"right":["","",0],"bottom":["","",0],"left":["","",0],"unit":"px"}],"titleStyles":[{"size":["","",""],"sizeType":"px","lineHeight":["","",""],"lineType":"","letterSpacing":"","family":"Inter Tight","google":true,"style":"normal","weight":"400","variant":"regular","subset":"latin","loadGoogle":true,"padding":[14,10,6,16],"marginTop":8,"color":"#444444","background":"rgba(0,0,0,0)","border":["","","",""],"borderRadius":["","","",""],"borderWidth":["","","",""],"colorHover":"#111111","backgroundHover":"rgba(0,0,0,0)","borderHover":["","","",""],"colorActive":"#111111","backgroundActive":"rgba(0,0,0,0)","borderActive":["","","",""],"textTransform":""}],"titleBorder":[{"top":["#949494","",0],"right":["#949494","",0],"bottom":["#949494","",4],"left":["#949494","",0],"unit":"px"}],"titleBorderHover":[{"top":["#474747","",""],"right":["#474747","",""],"bottom":["#474747","",""],"left":["#474747","",""],"unit":"px"}],"titleBorderActive":[{"top":["#111111","",""],"right":["#111111","",""],"bottom":["#111111","",""],"left":["#111111","",""],"unit":"px"}],"titleBorderRadius":[0,0,0,0],"iconStyle":"arrow","iconSide":"left"} -->
<div class="wp-block-kadence-accordion alignnone">
    <div class="kt-accordion-wrap kt-accordion-ida4325234 kt-accordion-has-2-panes kt-active-pane-0 kt-accordion-block kt-pane-header-alignment-left kt-accodion-icon-style-arrow kt-accodion-icon-side-left"
        style="max-width:none">
        <div class="kt-accordion-inner-wrap" data-allow-multiple-open="false" data-start-open="none">

HTML;

    $accordeonEnd = <<<HTML
</div>
    </div>
</div>
<!-- /wp:kadence/accordion -->
HTML;

    if ($busca_posts->have_posts()) {
        $projetos = array();

        while ($busca_posts->have_posts()) {
            $busca_posts->the_post();

            $nomeProjeto = get_the_title();

            $fotoParticipante = get_field('foto_participante');
            $idProjeto = get_the_ID();
            $tagProjeto = ($tag = get_term_by('name', get_field('tag_projeto'), 'post_tag')) ? $tag->term_id : false;
            $textoProjeto = apply_filters('the_content', get_the_content());

            $projeto = <<<HTML
<!-- wp:kadence/pane {"uniqueID":"{$idProjeto}_pane"} -->
<div class="wp-block-kadence-pane kt-accordion-pane kt-accordion-pane-1 kt-pane{$idProjeto}_pane">
    <div class="kt-accordion-header-wrap"><button class="kt-blocks-accordion-header kt-acccordion-button-label-show"
            type="button"><span class="kt-blocks-accordion-title-wrap"><span
                    class="kt-blocks-accordion-title">{$nomeProjeto}</span></span><span
                class="kt-blocks-accordion-icon-trigger"></span></button>
    </div>
    <div class="kt-accordion-panel">
        <div class="kt-accordion-panel-inner">
            <!-- wp:group {"className":"projeto-post","layout":{"type":"constrained"}} -->
            <div class="wp-block-group projeto-post">
                {$textoProjeto}
            </div>
            <!-- /wp:group -->
			<!-- projeto-has-news -->
			
<!-- wp:spacer {"height":"4rem"} -->
<div style="height:6rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
	        </div>
    </div>
</div>
<!-- /wp:kadence/pane -->
HTML;

            $secaoNoticias = '';
            if ($tagProjeto !== false) {
                $secaoNoticias = <<<HTML
<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50","bottom":"0"}}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity"
                style="margin-top:var(--wp--preset--spacing--50);margin-bottom:0" />
            <!-- /wp:separator -->

            <!-- wp:heading {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"0","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"right":"0","left":"0"}}}} -->
            <h2 class="wp-block-heading"
                style="margin-right:0;margin-left:0;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--50);padding-bottom:0;padding-left:var(--wp--preset--spacing--50)">
                notícias vinculadas</h2>
            <!-- /wp:heading -->

            <!-- wp:query {"queryId":27,"query":{"perPage":6,"pages":0,"offset":0,"postType":"noticia","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"post_tag":[{$tagProjeto}]},"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grade"},"layout":{"type":"default"}} -->
            <div class="wp-block-query">
                <!-- wp:post-template {"style":{"spacing":{"margin":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"layout":{"type":"grid","columnCount":3}} -->
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","right":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}},"border":{"top":{"width":"1px","color":"var:preset|color|contrast"},"right":{"width":"3px","color":"var:preset|color|contrast"},"bottom":{"width":"3px","color":"var:preset|color|contrast"},"left":{"width":"1px","color":"var:preset|color|contrast"}}},"layout":{"inherit":false}} -->
                <div class="wp-block-group"
                    style="border-top-color:var(--wp--preset--color--contrast);border-top-width:1px;border-right-color:var(--wp--preset--color--contrast);border-right-width:3px;border-bottom-color:var(--wp--preset--color--contrast);border-bottom-width:3px;border-left-color:var(--wp--preset--color--contrast);border-left-width:1px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
                    <!-- wp:post-featured-image {"aspectRatio":"1"} /-->

                    <!-- wp:post-title {"isLink":true,"linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"fontSize":"medium"} /-->

                    <!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0"}}}} /-->
                </div>
                <!-- /wp:group -->
                <!-- /wp:post-template -->
            </div>
            <!-- wp:query-no-results -->
            <!-- wp:html -->
            <p style="opacity: 0;">tag-created-but-no-results</p>
            <!-- /wp:html -->
            <!-- /wp:query-no-results -->
            <!-- /wp:query -->				
HTML;
            }


            $projeto = str_replace('<!-- projeto-has-news -->', $secaoNoticias, $projeto);

            $projetos[] = $projeto;
        }


        wp_reset_postdata();

        $projetosCode = '';
        foreach ($projetos as $individualProjeto) {
            $projetosCode .= $individualProjeto;
        }

        $acordeaoCode = ($accordeonHead . $projetosCode . $accordeonEnd);
        $acordeaoCode = apply_filters('the_content', do_blocks($acordeaoCode));

        return $acordeaoCode;
    } else {
        echo "<script>console.log('Algo deu errado na obtenção de dados!');</script>";
    }
}

add_shortcode('renderizaAcordeoesExtensao', 'renderizaAcordeoesExtensao');
