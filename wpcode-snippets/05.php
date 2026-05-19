<?php
function renderizar_campos()
{

    $post_id = get_the_ID();


    $link_lattes = get_field('lattes_participante', $post_id);
    $link1 = get_field('link1_participante', $post_id);
    $link2 = get_field('link2_participante', $post_id);

    if (empty($link_lattes) && empty($link1) && empty($link2)) {
        return '';


    } else {
        $output = '<div class="single-people-links">';
        $links = [$link_lattes, $link1, $link2];
        foreach ($links as $i => $link) {
            if (!empty($link)) {
                $rotulo = get_field('rotulolink' . $i . '_participante', $post_id);

                if ($i == 0) {
                    $output .= <<<HTML
					<p class="lattes"><a target="_blank" href="$link_lattes">
						<img src="/wp-content/uploads/2026/04/lattes.png" />Currículo Lattes
					</a></p>
					HTML;
                } elseif ($rotulo) {
                    $output .= <<<HTML
					<p><a target="_blank" href="$link">
						<img src="/wp-content/uploads/2026/04/link.png" />$rotulo
					</a></p>
					HTML;
                }
            }
        }
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('singlepeople_links_bio', 'renderizar_campos');
