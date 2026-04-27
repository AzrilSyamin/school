@php
    $siteTitle = \App\Models\Setting::get('site_title', config('app.name'));
    $logo = \App\Models\Setting::get('site_logo');
    $logoPath = null;

    if ($logo) {
        $candidate = \Illuminate\Support\Str::startsWith($logo, 'settings/')
            ? storage_path('app/public/'.$logo)
            : public_path($logo);

        $logoPath = file_exists($candidate) ? $candidate : null;
    }
@endphp

<div class="document-header">
    <table class="header-table">
        <tr>
            <td class="header-logo-cell">
                @if ($logoPath)
                    <img src="{{ $logoPath }}" alt="{{ $siteTitle }}" class="header-logo">
                @else
                    <div class="header-logo-fallback">EF</div>
                @endif
            </td>
            <td class="header-copy">
                <div class="school-name">{{ strtoupper($siteTitle) }}</div>
                <div class="school-meta">Sistem Pengurusan Akademik dan Kehadiran</div>
                <div class="school-meta">Laporan rasmi dijana melalui sistem</div>
            </td>
        </tr>
    </table>

    <div class="header-rule"></div>

    <table class="report-title-table">
        <tr>
            <td>
                <div class="report-eyebrow">Laporan</div>
                <h1>{{ $title }}</h1>
                @isset($subtitle)
                    <div class="report-subtitle">{{ $subtitle }}</div>
                @endisset
            </td>
            <td class="report-meta">
                <div><strong>Tarikh Jana:</strong> {{ $generatedAt->format('d/m/Y') }}</div>
                <div><strong>Masa:</strong> {{ $generatedAt->format('H:i') }}</div>
            </td>
        </tr>
    </table>
</div>
