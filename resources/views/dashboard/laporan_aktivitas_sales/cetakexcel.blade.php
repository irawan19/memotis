<p style="font-weight: bold;">Laporan Aktivitas Sales {{ General::ubahDBKeBulan($hasil_bulan_mulai).' '.$hasil_tahun_mulai.' sampai '.General::ubahDBKeBulan($hasil_bulan_selesai).' '.$hasil_tahun_selesai }}</p>
@if(!empty($lihat_laporan_aktivitas_sales))
@foreach($lihat_laporan_aktivitas_sales as $section)
<table border="1" style="border-collapse: collapse; margin-bottom: 20px; width: 100%;">
    <tr>
        <td colspan="19" style="background: #5a6c7d; color: #fff; font-weight: bold; padding: 8px;">{{ strtoupper($section['unit_name']) }} SALES TARGET</td>
    </tr>
    <tr style="background: #e8e8e8; font-weight: bold;">
        <td>BULAN</td>
        <td>NAMA</td>
        <td>ROOM REVENUE</td>
        <td>BANQUET REVENUE</td>
        <td style="background: #f9e79f;">TOTAL REVENUE</td>
        <td>TOTAL SALES TARGET</td>
        <td style="background: #d5d8dc;">W1</td>
        <td>BUDGET W1</td>
        <td>% W1</td>
        <td style="background: #d5d8dc;">W2</td>
        <td>BUDGET W2</td>
        <td>% W2</td>
        <td style="background: #d5d8dc;">W3</td>
        <td>BUDGET W3</td>
        <td>% W3</td>
        <td style="background: #d5d8dc;">W4</td>
        <td>BUDGET W4</td>
        <td>% W4</td>
        <td>% RESULT</td>
    </tr>
    @foreach($section['rows'] as $idx => $row)
    @php
        $total = (float) ($row['total'] ?? 0);
        $room_revenue = (float) ($row['room_revenue'] ?? 0);
        $banquet_revenue = (float) ($row['banquet_revenue'] ?? 0);
        $w1 = (float) ($row['w1'] ?? 0);
        $w2 = (float) ($row['w2'] ?? 0);
        $w3 = (float) ($row['w3'] ?? 0);
        $w4 = (float) ($row['w4'] ?? 0);
    @endphp
    <tr>
        <td>{{ $row['month_label'] ?? '—' }}</td>
        <td>{{ $row['name'] }}</td>
        <td style="text-align:right">Rp {{ number_format($room_revenue, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($banquet_revenue, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($total, 0, ',', '.') }}</td>
        <td style="text-align:right">@if(!empty($row['total_sales_target'])) Rp {{ number_format($row['total_sales_target'], 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($w1, 0, ',', '.') }}</td>
        <td style="text-align:right">@if(!empty($row['budget_w1'])) Rp {{ number_format($row['budget_w1'], 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if(isset($row['pct_w1'])) {{ number_format($row['pct_w1'], 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($w2, 0, ',', '.') }}</td>
        <td style="text-align:right">@if(!empty($row['budget_w2'])) Rp {{ number_format($row['budget_w2'], 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if(isset($row['pct_w2'])) {{ number_format($row['pct_w2'], 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($w3, 0, ',', '.') }}</td>
        <td style="text-align:right">@if(!empty($row['budget_w3'])) Rp {{ number_format($row['budget_w3'], 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if(isset($row['pct_w3'])) {{ number_format($row['pct_w3'], 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($w4, 0, ',', '.') }}</td>
        <td style="text-align:right">@if(!empty($row['budget_w4'])) Rp {{ number_format($row['budget_w4'], 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if(isset($row['pct_w4'])) {{ number_format($row['pct_w4'], 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:center; font-weight:bold">@if(isset($row['pct_result'])) {{ number_format($row['pct_result'], 0, ',', '') }}% @else — @endif</td>
    </tr>
    @endforeach
</table>
@endforeach
@else
<table><tr><td>Tidak ada data</td></tr></table>
@endif
