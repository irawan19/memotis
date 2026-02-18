<table>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center">Laporan Aktivitas Sales {{General::ubahDBKeBulan($hasil_bulan_mulai).' '.$hasil_tahun_mulai.' sampai '.General::ubahDBKeBulan($hasil_bulan_selesai).' '.$hasil_tahun_selesai}}</td>
        <td style="display:none"></td>
        <td style="display:none"></td>
        <td style="display:none"></td>
        <td style="display:none"></td>
    </tr>
</table>
<table border="1px">
    <thead>
        <tr>
			<th>Sales</th>
			<th>Segmentasi</th>
			<th>Project</th>
			<th>Status</th>
			<th>Total</th>
        </tr>
    </thead>
    <tbody>
	    @if(!$lihat_laporan_aktivitas_sales->isEmpty())
	    	@foreach($lihat_laporan_aktivitas_sales as $laporan_aktivitas_sales)
	        	<tr>
	    			@php($nama = $laporan_aktivitas_sales->nama_level_sistems.' - '.$laporan_aktivitas_sales->name)
	    			@if(!empty($laporan_aktivitas_sales->id_divisis))
	    				@php($nama = $laporan_aktivitas_sales->nama_level_sistems.' - '.$laporan_aktivitas_sales->nama_divisis.' - '.$laporan_aktivitas_sales->name)
	    			@endif
	        		<td>{{$nama}}</td>
	        		<td>{{$laporan_aktivitas_sales->nama_segmentasi_sales}}</td>
	        		<td>{{$laporan_aktivitas_sales->nama_project_sales}}</td>
	        		<td>{{$laporan_aktivitas_sales->nama_status_sales}}</td>
	        		<td style="text-align:right">{{General::ubahDBKeHarga($laporan_aktivitas_sales->total)}}</td>
	        	</tr>
	        @endforeach
	    @else
	    	<tr>
	    		<td colspan="5" style="text-align:center;">Tidak ada data ditampilkan</td>
	    		<td style="display:none"></td>
	    		<td style="display:none"></td>
	    		<td style="display:none"></td>
	    		<td style="display:none"></td>
	    	</tr>
	    @endif
    </tbody>
</table>
