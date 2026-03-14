<?php


if (!function_exists('editable')) {
    function editable($key, $default = '') {
        $locale = app()->getLocale();
        $record = \App\Models\EditableContent::where('key', $key)->where('locale', $locale)->first();
        $text = $record ? $record->content : $default;

        return $text === null || trim($text) === ''
            ? '<i class="bi bi-pencil-fill text-muted" style="cursor:pointer;"> Modifier</i>'
            : e($text);
    }
}
