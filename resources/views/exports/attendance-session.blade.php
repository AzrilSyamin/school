<!doctype html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Rekod Kehadiran</title>
    <style>
        @page { margin: 28px 32px 42px; }
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 11px; }
        .document-header { margin-bottom: 18px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { border: 0; padding: 0; vertical-align: middle; }
        .header-logo-cell { width: 72px; }
        .header-logo { width: 58px; max-height: 58px; object-fit: contain; }
        .header-logo-fallback { width: 58px; height: 58px; line-height: 58px; text-align: center; border-radius: 8px; background: #228260; color: #fff; font-weight: bold; font-size: 17px; }
        .school-name { font-size: 17px; font-weight: bold; letter-spacing: .05em; color: #0f172a; }
        .school-meta { margin-top: 2px; color: #475569; font-size: 10px; }
        .header-rule { height: 3px; background: #228260; margin: 14px 0 10px; border-bottom: 1px solid #94a3b8; }
        .report-title-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .report-title-table td { border: 0; padding: 0; vertical-align: top; }
        .report-eyebrow { color: #228260; font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: .12em; }
        h1 { margin: 2px 0 0; font-size: 18px; }
        .report-subtitle { margin-top: 4px; color: #64748b; font-size: 10px; }
        .report-meta { text-align: right; color: #475569; font-size: 10px; line-height: 1.6; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .summary td { border: 1px solid #d1d5db; padding: 8px; }
        .label { background: #f3f4f6; width: 140px; font-weight: bold; text-transform: uppercase; font-size: 9px; color: #374151; }
        table.records { width: 100%; border-collapse: collapse; }
        .records th { background: #111827; color: #ffffff; text-transform: uppercase; font-size: 9px; letter-spacing: .04em; }
        .records th, .records td { border: 1px solid #d1d5db; padding: 8px; vertical-align: top; }
        .records tr:nth-child(even) td { background: #f3f4f6; }
        .status { font-weight: bold; text-transform: uppercase; }
        .muted { color: #6b7280; }
        .footer { position: fixed; bottom: -24px; left: 0; right: 0; color: #94a3b8; font-size: 9px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 8px; }
    </style>
</head>
<body>
    @include('exports.partials.document-header', [
        'title' => 'Rekod Kehadiran',
        'subtitle' => 'Senarai kehadiran pelajar bagi sesi terpilih.',
        'generatedAt' => $generatedAt,
    ])

    <table class="summary">
        <tr>
            <td class="label">Mata Pelajaran</td>
            <td>{{ $session['subject']?->name }} @if($session['subject']?->code) ({{ $session['subject']->code }}) @endif</td>
            <td class="label">Kelas</td>
            <td>{{ $session['classroom']?->name }}</td>
        </tr>
        <tr>
            <td class="label">Tarikh</td>
            <td>{{ \Illuminate\Support\Carbon::parse($session['date'])->format('d/m/Y') }}</td>
            <td class="label">Direkod Oleh</td>
            <td>{{ trim(($session['recorder']?->first_name ?? '') . ' ' . ($session['recorder']?->last_name ?? '')) ?: '-' }}</td>
        </tr>
    </table>

    <table class="records">
        <thead>
            <tr>
                <th>Nama Pelajar</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student?->name }}</td>
                    <td>{{ $attendance->student?->student_id ?: '-' }}</td>
                    <td class="status">{{ $attendance->status }}</td>
                    <td>{{ $attendance->remarks ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Dokumen ini dijana secara automatik oleh sistem.</div>
</body>
</html>
