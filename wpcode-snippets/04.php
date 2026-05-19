<?php
function ordenaSlides($array_html, $nome_da_tag = 'h2')
{
    $array_resultado = array();


    libxml_use_internal_errors(true);

    foreach ($array_html as $indice => $html_string) {
        $dom = new DOMDocument();


        $dom->loadHTML(mb_convert_encoding($html_string, 'HTML-ENTITIES', 'UTF-8'));
        $tags = $dom->getElementsByTagName($nome_da_tag);

        if ($tags->length > 0) {

            $texto_extraido = trim($tags->item(0)->nodeValue);


            $chave = $texto_extraido;
            $contador = 1;


            while (isset($array_resultado[$chave])) {
                $chave = $texto_extraido . '-' . $contador;
                $contador++;
            }

            $array_resultado[$chave] = $html_string;

        } else {

            $array_resultado['sem-tag-' . $indice] = $html_string;
        }
    }


    libxml_clear_errors();


    ksort($array_resultado);

    $alvo = null;


    foreach ($array_resultado as $k => $v) {
        if (stripos($k, 'principal') !== false) {
            $alvo = $k;
            break;
        }
    }


    if ($alvo && count($array_resultado) > 1) {
        $valor_alvo = $array_resultado[$alvo];
        unset($array_resultado[$alvo]);

        $novo_array = [];
        $posicao = 0;


        foreach ($array_resultado as $k => $v) {
            if ($posicao === 1) {

                $novo_array[$alvo] = $valor_alvo;
            }
            $novo_array[$k] = $v;
            $posicao++;
        }


        if (!isset($novo_array[$alvo])) {
            $novo_array[$alvo] = $valor_alvo;
        }

        $array_resultado = $novo_array;
    }

    return $array_resultado;
}
function renderizaSlides()
{
    $args = array(
        'post_type' => 'pessoa',
        'posts_per_page' => -1,


        'meta_query' => array(
            'relation' => 'OR',


            array(
                'key' => 'funcao_tags',
                'value' => 'pesq_principal',
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'funcao_tags',
                'value' => 'pesq_proponente',
                'compare' => 'LIKE'
            )
        )
    );

    $busca_posts = new WP_Query($args);


    if ($busca_posts->have_posts()) {
        $slides = array();

        while ($busca_posts->have_posts()) {
            $busca_posts->the_post();


            $nomeParticipante = get_the_title();


            $funcaoParticipante = get_field('funcao_participante');
            $fotoParticipante = get_field('foto_participante');
            $linkPost = get_permalink();

            $slide = <<<HTML

<!-- wp:cb/slide-v2 -->
                <div class="wp-block-cb-slide-v2 cb-slide swiper-slide"><a href="$linkPost">
                    <!-- wp:group {"className":"slide-card","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"padding":{"right":"0","left":"0"},"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
                    <div class="wp-block-group slide-card"
                        style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40);padding-right:0;padding-left:0">
                        <!-- wp:group {"style":{"border":{"top":{"width":"1px","color":"var:preset|color|contrast"},"right":{"width":"1px","color":"var:preset|color|contrast"},"bottom":{"width":"3px","color":"var:preset|color|contrast"},"left":{"width":"3px","color":"var:preset|color|contrast"}},"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
                        <div class="wp-block-group has-base-background-color has-background"
                            style="border-top-color:var(--wp--preset--color--contrast);border-top-width:1px;border-right-color:var(--wp--preset--color--contrast);border-right-width:1px;border-bottom-color:var(--wp--preset--color--contrast);border-bottom-width:3px;border-left-color:var(--wp--preset--color--contrast);border-left-width:3px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
                            <!-- wp:image {"id":198,"sizeSlug":"large","linkDestination":"none"} -->
                            <figure class="wp-block-image size-large"><img
                                    src="$fotoParticipante"
                                    alt="" class="wp-image-198" /></figure>
                            <!-- /wp:image -->

                            <!-- wp:heading {"textAlign":"center","className":"is-style-default","style":{"typography":{"fontStyle":"normal","fontWeight":"700","textTransform":"none"},"spacing":{"padding":{"right":"0","left":"0"}}},"fontSize":"medium","fontFamily":"inter-tight"} -->
                            <h2 class="wp-block-heading has-text-align-center is-style-default has-inter-tight-font-family has-medium-font-size"
                                style="padding-right:0;padding-left:0;font-style:normal;font-weight:700;text-transform:none">$nomeParticipante</h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0.33rem","bottom":"0.33rem"}},"typography":{"fontStyle":"normal","fontWeight":"500","textTransform":"uppercase"},"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}}},"textColor":"accent-4","fontSize":"small"} -->
                            <p class="has-text-align-center has-accent-4-color has-text-color has-link-color has-small-font-size"
                                style="margin-top:0.33rem;margin-bottom:0.33rem;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-style:normal;font-weight:500;text-transform:uppercase">$funcaoParticipante</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:spacer {"height":"30px"} -->
                            <div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
                            <!-- /wp:spacer -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                </div></a>
<!-- /wp:cb/slide-v2 -->

HTML;
            $slide = do_blocks($slide);
            $slide = apply_filters('the_content', $slide);

            $slides[] = $slide;
        }


        wp_reset_postdata();


        $slides = ordenaSlides($slides);
        $slidesCode = '';
        foreach ($slides as $individualSlide) {
            $slidesCode .= $individualSlide;
        }

        return $slidesCode;
    } else {
        echo "<script>console.log('Algo deu errado na obtenção de dados!');</script>";
    }
}
add_shortcode('renderizaSlides', 'renderizaSlides');
