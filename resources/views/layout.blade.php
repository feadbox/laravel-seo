<title>{{ $title }}</title>

@if ($description)
    <meta name="description" content="{{ $description }}">
@endif

@if ($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endif

@foreach ($langs as $iso => $url)
    @if ($app->getLocale() !== $iso)
        <link rel="alternate" hreflang="{{ $iso }}" href="{{ $url }}">
    @endif
@endforeach

@if ($langs['en'] ?? null)
    <link rel="alternate" hreflang="x-default" href="{{ $langs['en'] }}">
@endif