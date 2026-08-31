@php($favicon = config('village.favicon') ?: config('village.logo_desa'))
@if($favicon)
<link rel="icon" href="{{ asset('storage/' . $favicon) }}">
@endif
