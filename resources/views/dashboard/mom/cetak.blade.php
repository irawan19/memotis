
<link href="{{URL::asset('template/back/css/style.css')}}" rel="stylesheet">
<style>
    table {border-collapse: collapse;}
    @media print 
    {
        @page
        {
            size: A4;
			margin: 0;
        }
		html, body {
			color: black;
		}
    }
    table
    {
        border-collapse : collapse;
        font-size       : 14px;
    }
    .page {
        page-break-before: always;
    }
    .page:first-child {
        page-break-before: avoid;
    }
    .right-align{
        text-align:right;
    }
</style>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <p class="judulsurat">{{$lihat_moms->judul_moms}}</p>
                </div>
                <div class="col-sm-6 right-align">
                    <p class="judultanggal">{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_moms)}}</p>
                    <p class="nosurat">{{$lihat_moms->no_moms}}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <table class="table table-responsive-sm">
                <tr>
                    <th>Dari</th>
                    <th>:</th>
                    <td>{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_mulai_moms)}}</td>
                </tr>
                <tr>
                    <th>Sampai</th>
                    <th>:</th>
                    <td>{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_selesai_moms)}}</td>
                </tr>
                <tr>
                    <th width="50px">Venue</th>
                    <th width="1px">:</th>
                    <td>{{$lihat_moms->venue_moms}}</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">
            <hr/>
        </div>
        <div class="col-sm-12">
            <h4>Peserta</h4>
            @php($lihat_pesertas = \App\Models\Mom_user::join('users','users_id','=','users.id')
                                                        ->where('moms_id',$lihat_moms->id_moms)
                                                        ->orderBy('users.name')
                                                        ->get())
            @foreach($lihat_pesertas as $pesertas)
                - {{$pesertas->name}}<br/>
            @endforeach
        </div>
        <div class="col-sm-12">
            <hr/>
        </div>
        <div class="col-sm-12">
            <h4>Deskripsi</h4>
            <br/>
            {!! $lihat_moms->deskripsi_moms !!}	
        </div>
    </div>
</div>
<script type="text/javascript">
	window.onload=function(){
		window.print();
		setTimeout(function(){
			window.close(window.location = "{{URL('/dashboard/mom')}}");
		}, 1);
		return false;
	}
</script>