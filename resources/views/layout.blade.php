<title>{{ $title }}</title>
<meta property="og:title" content="{{ $title }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">
<meta property="og:site_name" content="{{ $siteName }}">

@if ($description)
    <meta name="description" content="{{ $description }}">
    <meta property="og:description" content="{{ $description }}">
@endif

@if ($canonical)
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:url" content="{{ $canonical }}">
@endif

@foreach ($langs as $iso => $url)
    @if ($app->getLocale() !== $iso)
        <link rel="alternate" hreflang="{{ $iso }}" href="{{ $url }}">
    @endif
@endforeach

@if ($langs['en'] ?? null)
    <link rel="alternate" hreflang="x-default" href="{{ $langs['en'] }}">
@endif

@foreach ($images as $image)
    <meta property="og:image" content="{{ $image }}">
@endforeach

@foreach ($schemes as $scheme)
    <script type="application/ld+json">@json($scheme)</script>
@endforeach
