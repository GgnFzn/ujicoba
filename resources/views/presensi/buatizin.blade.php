@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
</style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }
        .datepicker-date-display {
            background-color: #0f3a7f !important; 
        }
    </style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/presensi/storeizin" id="FrmIzin">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <input type="text" id="tgl_izin" name="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value=""> Izin / Sakit</option>    
                    <option value="i">Izin</option>
                    <option value="s">Sakit</option>
                    </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"
                placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });

        $("#tgl_izin").change(function(e){
            var tgl_izin = $(this).val();
            $.ajax({
                type:'POST',
                url:'/presensi/cekpengajuanizin',
                data:{
                    _token:"{{ csrf_token() }}",
                    tgl_izin:tgl_izin
                },
                cache:false,
                success:function(respond){
                    if(respond == 1){
                            Swal.fire({
                            title: 'Opps !',
                            text: 'Anda Sudah Melakukan Input Pengajuan Izin Pada Tanggal Tersebut',
                            icon: 'warning'
                        }).then((result) => {
                            $("#tgl_izin").val("");
                        });
                    }
                }
            });
        });

        $("#FrmIzin").submit(function(){
            var tgl_izin = $("#tgl_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();
            if(tgl_izin==""){
                Swal.fire({
                        title: 'Opps !',
                        text: 'Tanggal Harus Diisi',
                        icon: 'warning'
                    });
                return false;
            } else if(status==""){
                Swal.fire({
                        title: 'Opps !',
                        text: 'Status Harus Diisi',
                        icon: 'warning'
                    });
                return false;
            } else if(keterangan==""){
                Swal.fire({
                        title: 'Opps !',
                        text: 'Keterangan Harus Diisi',
                        icon: 'warning'
                    });
                return false;
            }
        });

    });
</script>
@endpush
