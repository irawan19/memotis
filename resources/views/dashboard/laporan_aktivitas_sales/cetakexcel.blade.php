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
    @php
        $sum_room = 0; $sum_banquet = 0; $sum_total = 0; $sum_target = 0;
        $sum_w1 = 0; $sum_w2 = 0; $sum_w3 = 0; $sum_w4 = 0;
        $sum_b1 = 0; $sum_b2 = 0; $sum_b3 = 0; $sum_b4 = 0;
        foreach ($section['rows'] as $r) {
            $sum_room += (float)($r['room_revenue'] ?? 0);
            $sum_banquet += (float)($r['banquet_revenue'] ?? 0);
            $sum_total += (float)($r['total'] ?? 0);
            $sum_target += (float)($r['total_sales_target'] ?? 0);
            $sum_w1 += (float)($r['w1'] ?? 0);
            $sum_w2 += (float)($r['w2'] ?? 0);
            $sum_w3 += (float)($r['w3'] ?? 0);
            $sum_w4 += (float)($r['w4'] ?? 0);
            $sum_b1 += (float)($r['budget_w1'] ?? 0);
            $sum_b2 += (float)($r['budget_w2'] ?? 0);
            $sum_b3 += (float)($r['budget_w3'] ?? 0);
            $sum_b4 += (float)($r['budget_w4'] ?? 0);
        }
        $foot_pct_w1 = $sum_b1 > 0 ? round($sum_w1 / $sum_b1 * 100, 2) : null;
        $foot_pct_w2 = $sum_b2 > 0 ? round($sum_w2 / $sum_b2 * 100, 2) : null;
        $foot_pct_w3 = $sum_b3 > 0 ? round($sum_w3 / $sum_b3 * 100, 2) : null;
        $foot_pct_w4 = $sum_b4 > 0 ? round($sum_w4 / $sum_b4 * 100, 2) : null;
        $foot_pct_result = $sum_target > 0 ? round($sum_total / $sum_target * 100, 2) : null;
    @endphp
    <tr style="font-weight: bold; background: #e8e8e8;">
        <td colspan="2" style="text-align:right; padding: 6px;">TOTAL</td>
        <td style="text-align:right">Rp {{ number_format($sum_room, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($sum_banquet, 0, ',', '.') }}</td>
        <td style="text-align:right">Rp {{ number_format($sum_total, 0, ',', '.') }}</td>
        <td style="text-align:right">@if($sum_target > 0) Rp {{ number_format($sum_target, 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($sum_w1, 0, ',', '.') }}</td>
        <td style="text-align:right">@if($sum_b1 > 0) Rp {{ number_format($sum_b1, 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if($foot_pct_w1 !== null) {{ number_format($foot_pct_w1, 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($sum_w2, 0, ',', '.') }}</td>
        <td style="text-align:right">@if($sum_b2 > 0) Rp {{ number_format($sum_b2, 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if($foot_pct_w2 !== null) {{ number_format($foot_pct_w2, 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($sum_w3, 0, ',', '.') }}</td>
        <td style="text-align:right">@if($sum_b3 > 0) Rp {{ number_format($sum_b3, 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if($foot_pct_w3 !== null) {{ number_format($foot_pct_w3, 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:right">Rp {{ number_format($sum_w4, 0, ',', '.') }}</td>
        <td style="text-align:right">@if($sum_b4 > 0) Rp {{ number_format($sum_b4, 0, ',', '.') }} @else — @endif</td>
        <td style="text-align:center">@if($foot_pct_w4 !== null) {{ number_format($foot_pct_w4, 0, ',', '') }}% @else — @endif</td>
        <td style="text-align:center">@if($foot_pct_result !== null) {{ number_format($foot_pct_result, 0, ',', '') }}% @else — @endif</td>
    </tr>
</table>
@endforeach
@else
<table><tr><td>Tidak ada data</td></tr></table>
@endif
