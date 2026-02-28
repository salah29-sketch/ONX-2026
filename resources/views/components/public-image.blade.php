@props(['key', 'default' => '', 'class' => ''])

@php
    use App\EditableContent;

    $record = EditableContent::where('key', $key)->first();
    $url = $record && $record->content ? asset($record->content) : asset($default);
@endphp

<img src="{{ secure_asset($url) }}"
     alt="Image"
     class="img-fluid {{ $class }}"
     style="max-width: 100%;">
