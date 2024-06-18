<?php

function get_button_back() {
    echo '<a href="/" class="btn-back">На главную</a>';
}

function get_button_reg() {
    echo '<a href="/register" class="auth-btn register-btn">Регистрация</a>';
}

function get_button_log() {
    echo '<a href="/login" class="auth-btn login-btn">Вход</a>';
}

function get_button_logout() {
    echo '<a href="/logout" class="auth-btn login-btn">Выход</a>';
}

function get_upload_btn() {
    echo '<a href="/upload" class="btn">Загрузить файл</a>';
}

function get_snippet($snippet_name) {
    $snippet_path = THEME_SNIPPET_PATH . 'snippet_' . $snippet_name . '.php';
    if (file_exists($snippet_path)) {
        require_once($snippet_path);
    } else {
        send_error('Ошибка загрузки снипета!');
    }
}
//function get_list_files() {
//    require_once(THEME_PATH . "snippet/snippet_list_files.php");
//}

function get_manager_uploader() {
    include_once(THEME_PATH . 'snippet/snippet_upload_manager_file_form.php');
}

function get_metrika() {
    include_once(THEME_PATH . 'snippet/snippet_metrika.php');
}

function get_statistic() {
    include_once(THEME_PATH . 'snippet/snippet_statistics.php');
}
