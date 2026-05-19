<?php

add_action('acf/save_post', 'sincronizar_acf_titulo_por_tipo_post', 20);

function sincronizar_acf_titulo_por_tipo_post($post_id)
{
    remove_action('acf/save_post', 'sincronizar_acf_titulo_por_tipo_post', 20);

    if (wp_is_post_revision($post_id)) {
        add_action('acf/save_post', 'sincronizar_acf_titulo_por_tipo_post', 20);
        return;
    }

    $tipo_post_desejado = 'pessoa';

    if (get_post_type($post_id) !== $tipo_post_desejado) {
        add_action('acf/save_post', 'sincronizar_acf_titulo_por_tipo_post', 20);
        return;
    }

    $nome_do_campo = 'nome_participante';
    $novo_titulo = get_field($nome_do_campo, $post_id);

    if (!empty($novo_titulo)) {
        $post_data = array(
            'ID' => $post_id,
            'post_title' => wp_strip_all_tags($novo_titulo),
            'post_name' => sanitize_title($novo_titulo)
        );
        wp_update_post($post_data);
    }

    add_action('acf/save_post', 'sincronizar_acf_titulo_por_tipo_post', 20);
}


add_action('admin_print_footer_scripts', 'forcar_reload_gutenberg_por_cpt');

function forcar_reload_gutenberg_por_cpt()
{
    if (!function_exists('get_current_screen'))
        return;
    $screen = get_current_screen();

    if (!$screen || !$screen->is_block_editor)
        return;

    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof wp !== 'undefined' && wp.data) {
                let estavaSalvando = false;

                const TIPO_POST_ALVO = 'pessoa';

                wp.data.subscribe(function () {
                    const editor = wp.data.select('core/editor');
                    if (!editor) return;

                    const tipoPostAtual = editor.getCurrentPostType();

                    if (tipoPostAtual !== TIPO_POST_ALVO) {
                        return;
                    }
                    const estaSalvando = editor.isSavingPost();
                    const eSalvamentoAutomatico = editor.isAutosavingPost();
                    const salvouComSucesso = editor.didPostSaveRequestSucceed();

                    if (estaSalvando && !eSalvamentoAutomatico) {
                        estavaSalvando = true;
                    }

                    if (estavaSalvando && !estaSalvando && salvouComSucesso) {
                        estavaSalvando = false;

                        setTimeout(function () {
                            window.location.reload();
                        }, 800);
                    }
                });
            }
        });
    </script>

    <?php
}
