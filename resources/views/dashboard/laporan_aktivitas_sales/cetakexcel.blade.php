<p style="font-weight: bold;">Laporan Aktivitas Sales {{ General::ubahDBKeBulan($hasil_bulan_mulai).' '.$hasil_tahun_mulai.' sampai '.General::ubahDBKeBulan($hasil_bulan_selesai).' '.$hasil_tahun_selesai }}</p>
@if(!empty($lihat_laporan_aktivitas_sales))
@foreach($lihat_laporan_aktivitas_sales as $section)
<table border="1" style="border-collapse: collapse; margin-bottom: 20px; width: 100%;">
    <tr>
        <td colspan="11" style="background: #5a6c7d; color: #fff; font-weight: bold; padding: 8px;">{{ strtoupper($section['unit_name']) }} SALES TARGET</td>
    </tr>
    <tr style="background: #e8e8e8; font-weight: bold;">
        <td>BULAN</td>
        <td>NAMA</td>
        <td>SEGMENTATION</td>
        <td>ROOM REVENUE</td>
        <td>BANQUET REVENUE</td>
        <td style="background: #f9e79f;">TOTAL TARGET REVENUE</td>
        <td style="background: #d5d8dc;">W 1</td>
        <td style="background: #d5d8dc;">W 2</td>
        <td style="background: #d5d8dc;">W 3</td>
        <td style="background: #d5d8dc;">W 4</td>
        <td>RESULT</td>
    </tr>
    @foreach($section['rows'] as $idx => $row)
    @php
        $total = (float) ($row['total'] ?? 0);
        $w1 = (float) ($row['w1'] ?? 0);
        $w2 = (float) ($row['w2'] ?? 0);
        $w3 = (float) ($row['w3'] ?? 0);
        $w4 = (float) ($row['w4'] ?? 0);
    @endphp
    <tr>
        <td>{{ $row['month_label'] ?? '—' }}</td>
        <td>{{ $row['name'] }}</td>
        <td>@if($idx === 0)Total akumulasi SEGMENTATION, G, SE, NA, DLL@endif</td>
        <td style="text-align:right">Rp {{ number_format(0, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format(0, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($total, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($w1, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($w2, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($w3, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($w4, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($total, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</table>
@endforeach
@else
<table><tr><td>Tidak ada data</td></tr></table>
@endif
