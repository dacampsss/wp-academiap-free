<?php
function postHTML($post_id)
{

    $meu_post = get_post($post_id);
    return apply_filters('the_content', $meu_post->post_content);
}
?>

<script>
    window.cidadesData = {
        "santa-maria": { "content": `<?= postHTML(341); ?>`, "title": `<?= get_the_title(341); ?>` },
        "natal": { "content": `<?= postHTML(346); ?>`, "title": `<?= get_the_title(346); ?>` },
        "joao-pessoa": { "content": `<?= postHTML(344); ?>`, "title": `<?= get_the_title(344); ?>` },
        "rio-de-janeiro": { "content": `<?= postHTML(347); ?>`, "title": `<?= get_the_title(347); ?>` },
    };

</script>