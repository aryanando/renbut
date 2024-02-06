<html>
    <head>
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <style>
            td th {
                padding-top:0px !important;
                padding-bottom:0px !important;
                padding-left:2px !important;
                padding-right:2px !important;
            }
        </style>
    </head>
    <body>
        <div style="font-size: 12px">
            <div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;POLRI DAERAH JAWA TIMUR<br>
                BIDANG KEDOKTERAN DAN KESEHATAN<br>
                &nbsp;RS. BHAYANGKARA HASTA BRATA BATU
            </div>
        </div>
        <div class="table-responsive">
            <div style="text-align: center; font-size: 12px !important">
                <b>DAFTAR KEBUTUHAN ALAT TULIS KANTOR (ATK) BULAN {{ 'JUNI 2021' }}</b>
            </div>
            <table class="table" style="font-size: 12px !important; width:100%;" border="1">
                <tr style="height: 100px">
                    <th style="text-align: center; width: 20px;">NO</th><th>Uraian</th><th>Satuan</th>
                    @foreach($unit as $item)
                        <th style="writing-mode: vertical-rl;transform: rotate(180deg);">{{ $item->keterangan }}</th>
                    @endforeach
                    <th style="text-align: right">Harga</th><th style="text-align: right">Total</th>
                </tr>
                @foreach($atk as $key => $item)
                @php                    
                    $item = (array) $item;
                @endphp
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td>{{ $item["uraian"] }}</td>
                    <td>{{ $item["satuan"] }}</td>
                    @foreach($unit as $val)
                        {{-- @php
                        try {
                            //code...
                            $item[str_replace(' ','_',$val->keterangan)];
                        } catch (\Throwable $th) {
                            dd($val);
                        }
                        @endphp --}}
                        <td style="text-align: right">{{ number_format($item[str_replace(' ','_',$val->keterangan)],0,",",".") }}</td>
                    @endforeach
                    <td style="text-align: right">{{ 'Rp ' . number_format($item["harga"],0,",",".") }}</td>
                    <td style="text-align: right">{{ 'Rp ' . number_format($item["total"],0,",",".") }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>