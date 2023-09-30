@extends('dashboard.layouts.app')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong>File Manager</strong>
                </div>
                <div class="card-body">
                    <div id="elfinder"></div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/barryvdh/elfinder/css/elfinder.min.css') }}">
    <script src="{{ URL::asset('packages/barryvdh/elfinder/js/elfinder.full.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function () {
            $('#elfinder').elfinder({
                customData: { 
                    _token: '{{ csrf_token() }}',
                },
                url : '{{ route("elfinder.connector") }}',
                soundPath: '{{ URL::asset("packages/barryvdh/elfinder/sounds/") }}',
                baseUrl : '../packages/barryvdh/elfinder/',
                height : '450px',
            });
        });
    </script>
@endsection
