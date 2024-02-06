<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Tiga60 as ModelsTiga60;
use App\Models\Unit;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Tiga60;

class RemunBaruController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (($request->path() == 'remun/tiga60') && isset(Auth::user()->pegawai_id)) {
                if (empty(Auth::user()->pegawai_id)) {
                    abort(403);
                }

                return $next($request);
            }

            if ($request->path() == 'remun/tiga60/gendef' && Auth::user()->unit != 999) {
                abort(403);
            }

            if (empty(Auth::user()->unit)) {
                abort(403);
            }
            elseif (empty(Auth::user()->atas)) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $date = $request->get('periode') ?? date('Y-m-t');
        // $remun = DB::select("call sp_remun('" . htmlspecialchars(date('Y-m-t', strtotime($date))) . "')");
        $remun = DB::select("call sp_remunbaru('" . htmlspecialchars(date('Y-m-t', strtotime($date))) . "')");

        return view('transaksi.remun.remunbaru', compact('remun'));
    }

    public function index2(Request $request)
    {
        $date = $request->get('periode') ?? date('Y-m-t');
        $remun = DB::select("call sp_remun('" . htmlspecialchars(date('Y-m-t', strtotime($date))) . "')");
        // $remun = DB::select("call sp_remun_360('" . htmlspecialchars(date('Y-m-t', strtotime($date))) . "')");

        return view('transaksi.remun.index', compact('remun'));
    }

    public function target(Request $request)
    {
        $requestData = $request->all();

        $unit_id = Auth::user()->unit;
        $unit = Unit::where('id', $unit_id)->first();
        $periode = $requestData['periode'] ?? date('Y-m');
        if ($unit_id == 999) {
            $units = Unit::leftjoin('target_unit', ['units.id' => 'target_unit.unit_id', "target_unit.periode" => DB::raw('\'' . date('Y-m-t', strtotime($periode)) . '\'')])
                ->select(['units.id', 'target_unit.target', 'target_unit.realisasi', 'units.keterangan'])
                ->where('units.id', '<>', 999)
                ->where('units.target', 1)
                ->orderby('keterangan')
                ->get();
            $unit_target = DB::table('target_unit')->where(["periode" => date('Y-m-t')])->get();
            return view('transaksi.remun.target', compact('unit', 'units', 'unit_target', 'periode'));
        }
        $unit_target = DB::table('target_unit')->where(["unit_id" => $unit_id, "periode" => date('Y-m-t')])->first();

        if (!$unit || $unit->target != 1) {
            abort(403);
        }

        return view('transaksi.remun.target', compact('unit', 'unit_target', 'periode'));
    }

    public function savetarget(Request $request)
    {
        $unit_id = Auth::user()->unit;

        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode']));

        if ($unit_id == 999) {
            foreach ($requestData['unit'] as $key => $value) {
                DB::table('setting_target_unit')->updateOrInsert(
                    [
                        "unit_id" => $key,
                    ],
                    [
                        "target" => $value['target'] ?? 0,
                    ]
                );
                DB::table('target_unit')->updateOrInsert(
                    [
                        "periode" => $periode,
                        "unit_id" => $key,
                    ],
                    [
                        "target" => $value['target'] ?? 0,
                        "realisasi" => $value['realisasi'],
                        "user_id" => Auth::user()->id,
                    ]
                );
            }
            return redirect('remun')->with('flash_message', 'Target Tersimpan!');
        }

        DB::table('setting_target_unit')->updateOrInsert(
            [
                "unit_id" => $unit_id,
            ],
            [
                "target" => $requestData['target'] ?? 0,
            ]
        );
        DB::table('target_unit')->updateOrInsert(
            [
                "periode" => $periode,
                "unit_id" => $unit_id,
            ],
            [
                "target" => $requestData['target'] ?? 0,
                "realisasi" => $requestData['realisasi'],
                "user_id" => Auth::user()->id,
            ]
        );

        return redirect('remun')->with('flash_message', 'Target Tersimpan!');
    }

    public function ibadah(Request $request)
    {
        $unit_id = Auth::user()->unit;
        $unit_target = Unit::where('id', $unit_id)->first();
        $requestData = $request->all();

        $periode = date('Y-m', strtotime($requestData['periode'] ?? date('Y-m')));
        // $periode = date('Y-m-t');
        $pegawai = DB::select("call sp_ibadah('" . $periode . "', " . $unit_id . ")");
        // dd($pegawai);

        return view('transaksi.remun.ibadah', compact('pegawai', 'unit_target', 'periode'));
    }

    public function saveibadah(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));

        foreach ($requestData['pegawai'] as $key => $item) {
            Pegawai::where('id', $item['id'])->update(['cuti' => $item['cuti']]);
            DB::table('ibadah')->updateOrInsert(
                [
                    "periode" => $periode,
                    "pegawai_id" => $item['id'],
                ],
                [
                    "absen" => $item['absen'],
                    "haid" => $item['haid'] ?? 0,
                    "target" => (date('t') * 5) - ($item['haid'] ?? 0),
                    "user_id" => Auth::user()->id,
                ]
            );
        }

        return redirect('remun')->with('flash_message', 'Ibadah Tersimpan!');
    }

    public function ibadah_print(Request $request)
    {
        $date = $request->get('periode') ?? date('Y-m-t');
        $remun = DB::select("call sp_remun('" . htmlspecialchars(date('Y-m-t', strtotime($date))) . "')");
        // $remun = DB::select("call sp_remun('$date')");
        // dd($remun);
        return view('transaksi.remun.ibadah_print', compact('remun', 'date'));
    }

    public function rater(Request $request)
    {
        $unit_id = Auth::user()->unit;
        $unit_target = Unit::where('id', $unit_id)->first();

        $periode = date('Y-m-t');
        $pegawai = DB::select("call sp_rater('" . $periode . "', " . $unit_id . ")");

        return view('transaksi.remun.rater', compact('pegawai', 'unit_target'));
    }

    public function saverater(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode']));

        foreach ($requestData['pegawai'] as $key => $item) {
            DB::table('rater')->updateOrInsert(
                [
                    "periode" => $periode,
                    "pegawai_id" => $item['id'],
                ],
                [
                    "reliabity" => $item['reliabity'],
                    "assurance" => $item['assurance'],
                    "tangbles" => $item['tangbles'],
                    "empaty" => $item['empaty'],
                    "responsivenes" => $item['responsivenes'],
                    "user_id" => Auth::user()->id,
                ]
            );
        }

        return redirect('remun')->with('flash_message', 'Target Tersimpan!');
    }

    public function des(Request $request)
    {
        $unit_id = Auth::user()->unit;
        $unit_target = Unit::where('id', $unit_id)->first();

        $periode = date('Y-m-t');
        $pegawai = DB::select("call sp_des('" . $periode . "', " . $unit_id . ")");

        return view('transaksi.remun.des', compact('pegawai', 'unit_target'));
    }

    public function savedes(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode']));

        foreach ($requestData['pegawai'] as $key => $item) {
            DB::table('des')->updateOrInsert(
                [
                    "periode" => $periode,
                    "pegawai_id" => $item['id'],
                ],
                [
                    "disiplin" => $item['disiplin'],
                    "etika" => $item['etika'],
                    "skill" => $item['skill'],
                    "user_id" => Auth::user()->id,
                ]
            );
        }

        return redirect('remun')->with('flash_message', 'Target Tersimpan!');
    }

    public function tiga60(Request $request)
    {
        $pegawai = Auth::user()->pegawai;
        $unit_target = $pegawai->unit;

        $periode = date('Y-m-t');

        $rekan = $this->genrekan();

        $resisi = DB::table('tiga60')->where(['periode' => $periode, 'user_id' => Auth::user()->id])->get();
        $isi = [];
        foreach ($resisi as $value) {
            $isi[$value->user_target_id][$value->komponen][$value->point] = $value->nilai;
        }

        $ibadah = DB::table('ibadah')->where(
            [
                "periode" => $periode,
                "pegawai_id" => $pegawai->id,
            ]
        )->first();

        return view('transaksi.remun.tiga60', compact('pegawai','rekan', 'unit_target', 'isi', 'ibadah'));
    }

    public function genrekan($pegawai_id = null, $user_id = null)
    {
        $pegawai_id = $pegawai_id ?? Auth::user()->pegawai_id;
        $user_id = $user_id ?? Auth::user()->id;
        $unit = Pegawai::select('units.*')->join('units', 'units.id', '=', 'pegawai.unit_id')->where('pegawai.id', $pegawai_id)->first();

        $pegawai = Pegawai::where(['id' => $pegawai_id])->orderby('nama')->first();
        $pangkat = $pegawai->atasan;
        $unit_id = $pegawai->unit_id;

        //berapa banyak anggota
        if ($pangkat != 2 && $pangkat != 4) {
            $b = Pegawai::join('users', 'users.pegawai_id', '=', 'pegawai.id')->select(DB::raw('pegawai.*'))->where('atasan', '<', 2)
            ->where(['unit_id' => $unit_id])->orderby('nama')->get();
        } else {
            $b = Pegawai::join('users', 'users.pegawai_id', '=', 'pegawai.id')->join('units', 'units.id', '=', 'pegawai.unit_id')->select(DB::raw('pegawai.*'))
                ->where(['atasan' => 2, 'units.remun' => $unit->remun])->orderby('nama')->get();
        }

        $periode = date('Y-m-t');
        // $c = DB::table('tiga60_rumus')->where('periode', '<', $periode)->where('user_id', $user_id)->count(); //berapa kali di nilai
        // $c = 0; //berapa kali di nilai
        $c = date('m'); //berapa kali di nilai

        //a = 2c+1
        $a = 2 * $c + 1; //0=1 1=3 2=5 3=7 4=9 5=11 6=13 7=15 8=17 9=19 10=21 11=23 12=25
        //a >= b
        try {
            if ($a >= count($b)) {
                // DB::table('tiga60_rumus')->where('user_id', $user_id)->delete();
                // $c = $c - $a;
                $c = $c % ceil((count($b) - 1) / 2);
                $a = 2 * $c + 1;
            }
        } catch (\Throwable $th) {
            // dd($b);
        }

        // initial b'
        // urutan diri sendiri
        $bb = 0;
        foreach ($b as $key => $value) {
            if ($value->id == $pegawai_id) {
                $bb = $key;
            }
        }

        //x = a + b'
        $x = $a + $bb;
        $x1 = $a + $bb + 1;

        if ($x >= count($b)) {
            //x = a + b' - b
            $x = $a + $bb - count($b);
        }

        if ($x1 >= count($b)) {
            //x = a + b' - b + 1
            $x1 = ($a + $bb + 1 - count($b));
        }

        if ($x == $bb) {
            $x++;
            $x1++;
        }
        if ($x1 == $bb) {
            $x1++;
        }

        // dd($b->pluck('nama'));
        $atasan = Pegawai::where(['atasan' => 2, 'unit_id' => $unit_id])->orderby('nama')->first();
        $rekan1 = $b[$x] ?? $b[0] ?? null;
        $rekan2 = $b[$x1] ?? $b[0] ?? null;
        $diri = $b[$bb] ?? $b[0] ?? null;

        switch ($pangkat) {
            case 1:
                return [
                    "atasan" => $atasan,
                    "rekan1" => $rekan1,
                    "rekan2" => $rekan2,
                    "diri" => $diri,
                    "bawahan" => null,
                    "karu" => null,
                ];
                break;
            case 2:
                $bawahan = Pegawai::where('atasan', '<', 2)->where(['unit_id' => $unit_id])->orderby('nama')->get();
                return [
                    "atasan" => null,
                    "rekan1" => $rekan1,
                    "rekan2" => $rekan2,
                    "diri" => $diri,
                    "bawahan" => $bawahan,
                    "karu" => null,
                ];
                break;

            case 3:
                $unit_karu = DB::table('kaur')->where('pegawai_id', $pegawai_id)->pluck('unit_id');
                $karu = Pegawai::where('atasan', '=', 2)->whereIn('unit_id', $unit_karu)->orderby('nama')->get();
                return [
                    "atasan" => null,
                    "rekan1" => null,
                    "rekan2" => null,
                    "diri" => null,
                    "bawahan" => null,
                    "karu" => $karu,
                ];
                break;
            case 4:
                $bawahan = Pegawai::where('atasan', '<', 2)->where(['unit_id' => $unit_id])->orderby('nama')->get();
                return [
                    "atasan" => null,
                    "rekan1" => null,
                    "rekan2" => null,
                    "diri" => null,
                    "bawahan" => $bawahan,
                    "karu" => null,
                ];
                break;

            default:
                return [
                    "atasan" => null,
                    "rekan1" => $rekan1,
                    "rekan2" => $rekan2,
                    "diri" => $diri,
                    "bawahan" => null,
                    "karu" => null,
                ];
                break;
        }

    }

    public function savetiga60(Request $request)
    {
        $requestData = $request->all();

        $rekan = $this->genrekan();
        $periode = date('Y-m-t');

        DB::table('ibadah')->updateOrInsert(
            [
                "periode" => $periode,
                "pegawai_id" => Auth::user()->pegawai->id,
            ],
            [
                "absen" => $requestData['absen'],
                "haid" => $requestData['haid'] ?? 0,
                "target" => (date('t') * 5) - ($requestData['haid'] ?? 0),
                "user_id" => Auth::user()->id,
            ]
        );

        // dd($requestData['bawahan']);
        $nilai = [];
        if ($rekan['atasan']) {
            foreach ($requestData['atasan'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => Auth::user()->id,
                        'user_target_id' => $rekan['atasan']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        if ($rekan['rekan1']) {
            foreach ($requestData['rekan1'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => Auth::user()->id,
                        'user_target_id' => $rekan['rekan1']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        if ($rekan['rekan2']) {
            foreach ($requestData['rekan2'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => Auth::user()->id,
                        'user_target_id' => $rekan['rekan2']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        if ($rekan['diri']) {
            foreach ($requestData['diri'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => Auth::user()->id,
                        'user_target_id' => $rekan['diri']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }
        
        if ($rekan['bawahan']) {
            foreach ($requestData['bawahan'] as $bk => $bawah) {
                foreach ($bawah as $key => $items) {
                    foreach ($items as $kv => $value) {
                        $nilai[] = [
                            'periode' => $periode,
                            'user_id' => Auth::user()->id,
                            'user_target_id' => $rekan['bawahan'][$bk]->id, // id pegawai
                            'komponen' => $key,
                            'point' => $kv,
                            'nilai' => $value,
                        ];
                    }
                }
            }
        }

        if ($rekan['karu']) {
            foreach ($requestData['karu'] as $bk => $bawah) {
                foreach ($bawah as $key => $items) {
                    foreach ($items as $kv => $value) {
                        $nilai[] = [
                            'periode' => $periode,
                            'user_id' => Auth::user()->id,
                            'user_target_id' => $rekan['karu'][$bk]->id, // id pegawai
                            'komponen' => $key,
                            'point' => $kv,
                            'nilai' => $value,
                        ];
                    }
                }
            }
        }

        DB::table('tiga60_rumus')->where(['periode' => $periode, 'user_id' => Auth::user()->id])->delete();
        DB::table('tiga60_rumus')->insert([
            'periode' => $periode,
            'user_id' => Auth::user()->id,
            'user_target_id_1' => $rekan['rekan1']->id ?? 0,
            'user_target_id_2' => $rekan['rekan2']->id ?? 0,
        ]);

        DB::table('tiga60')->where(['periode' => $periode, 'user_id' => Auth::user()->id])->delete();
        DB::table('tiga60')->insert($nilai);

        return redirect('remun/tiga60')->with('flash_message', 'Penilaian Tersimpan!');
    }

    public function hasil360() //bawahan

    {
        $periode = date('Y-m-t');
        //atasan 40
        // $atasan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id])->where('atasan', '>', 1)->sum('nilai');
        $atasan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'atasan' => 2])->sum('nilai') / 15 * 40;
        //rekan 50
        $rekan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'atasan' => 1])->sum('nilai') / 30 * 50;
        //diri 10
        $diri = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'user_target_id' => Auth::user()->id])->sum('nilai') / 15 * 10;

        return ($atasan + $rekan + $diri) / 100 * 50;
    }

    public function hasil360atasan() //bawahan

    {
        $periode = date('Y-m-t');
        //atasan 40
        // $atasan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id])->where('atasan', '>', 1)->sum('nilai');
        $atasan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'atasan' => 3])->sum('nilai') / 15 * 40;
        //rekan 50
        $rekan = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'atasan' => 2])->sum('nilai') / 30 * 50;
        //diri 10
        $diri = ModelsTiga60::where(['periode' => $periode, 'user_id' => Auth::user()->id, 'user_target_id' => Auth::user()->id])->sum('nilai') / 15 * 10;

        return ($atasan + $rekan + $diri) / 100 * 50;
    }

    public function gendef360(Request $request)
    {

        $pegawai = DB::table('users')->select('users.*')->join('pegawai', 'users.pegawai_id', '=', 'pegawai.id')->whereNotNull('users.pegawai_id')->get();

        $set = [];
        foreach ($pegawai as $key => $value) {
            // if (!DB::table('tiga60_rumus')->where('user_id', $value->id)->where('periode', date('Y-m-t'))->exists()) {
            $set[] = $value;
            // }
        }

        $log = [];
        foreach ($set as $key => $value) {
            $log[] = $this->genconsolesave($value->pegawai_id, $value->id);
        }

        // return $log;
        return redirect('remun/tiga60')->with('flash_message', 'Default value 360 sudah di generate!');

    }

    public function gentarget(Request $request)
    {

        $periode = date('Y-m-t');
        $dariperiode = date('Y-m-t', strtotime("-2 months", strtotime($periode)));

        $units = DB::table('units')->where('target', 1)->get();

        $set = [];
        foreach ($units as $key => $value) {
            $target = DB::table('target_unit')->where('unit_id', $value->id)
                ->where('periode', '>=', $dariperiode)
                ->where('periode', '<=', $periode)
                ->average('realisasi');
            $realisasi = DB::table('target_unit')->where('unit_id', $value->id)
                ->where('periode', $periode)
                ->sum('realisasi');

            $set[] = $save = [
                "target" => number_format($target, 0, '.', ''), //3 bulan
                "realisasi" => $realisasi,
                "user_id" => Auth::user()->id,
            ];

            DB::table('target_unit')->updateOrInsert([
                "periode" => $periode,
                "unit_id" => $value->id
            ], $save);
        }

        // return $set;
        return redirect('remun/tiga60')->with('flash_message', 'Default value terget sudah di generate!');

    }

    public function genconsolesave($pegawai_id, $user_id)
    {
        $rekan = $this->genrekan($pegawai_id, $user_id);
        $periode = date('Y-m-t');

        $requestData = [
            "rekan1" => ["reliability" => ["2"],
                "assurance" => ["2", "2"],
                "tangibility" => ["2"],
                "empathy" => ["2", "2"],
                "responsiveness" => ["2", "2"],
                "disiplin" => ["2", "2", "2"],
                "etika" => ["2"],
                "skill" => ["2", "2", "2"],
            ],
            "rekan2" => ["reliability" => ["2"],
                "assurance" => ["2", "2"],
                "tangibility" => ["2"],
                "empathy" => ["2", "2"],
                "responsiveness" => ["2", "2"],
                "disiplin" => ["2", "2", "2"],
                "etika" => ["2"],
                "skill" => ["2", "2", "2"],
            ],
            "diri" => ["reliability" => ["0"],
                "assurance" => ["0", "0"],
                "tangibility" => ["0"],
                "empathy" => ["0", "0"],
                "responsiveness" => ["0", "0"],
                "disiplin" => ["0", "0", "0"],
                "etika" => ["1"],
                "skill" => ["0", "0", "0"],
            ],
        ];
        // $bawahan = [
        //     "reliability" => ["5"],
        //     "assurance" => ["5", "5"],
        //     "tangibility" => ["5"],
        //     "empathy" => ["5", "5"],
        //     "responsiveness" => ["5", "5"],
        //     "disiplin" => ["5", "5", "5"],
        //     "etika" => ["5"],
        //     "skill" => ["5", "5", "5"],
        // ];
        $nilai = [];
        if ($rekan['rekan1']) {
            foreach ($requestData['rekan1'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => 0 ? null : $user_id,
                        'user_target_id' => $rekan['rekan1']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        if ($rekan['rekan2']) {
            foreach ($requestData['rekan2'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => 0 ? null : $user_id,
                        'user_target_id' => $rekan['rekan2']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        if ($rekan['diri']) {
            foreach ($requestData['diri'] as $key => $items) {
                foreach ($items as $kv => $value) {
                    $nilai[] = [
                        'periode' => $periode,
                        'user_id' => 0 ? null : $user_id,
                        'user_target_id' => $rekan['diri']->id, // id pegawai
                        'komponen' => $key,
                        'point' => $kv,
                        'nilai' => $value,
                    ];
                }
            }
        }

        // if (!DB::table('tiga60_rumus')->where(['periode' => $periode, 'user_id' => $user_id])->exists()) {
        DB::table('tiga60_rumus')->where(['periode' => $periode, 'user_id' => $user_id])->delete();
        DB::table('tiga60_rumus')->insert([
            'periode' => $periode,
            'user_id' => $user_id == 0 ? null : $user_id,
            'user_target_id_1' => $rekan['rekan1']->id ?? 0,
            'user_target_id_2' => $rekan['rekan2']->id ?? 0,
        ]);

        DB::table('tiga60')->where(['periode' => $periode, 'user_id' => $user_id])->delete();
        DB::table('tiga60')->insert($nilai);

        return 'Penilaian pegawai_id:' . $pegawai_id . ' Tersimpan!';

        // }

        return 'Penilaian pegawai_id:' . $pegawai_id . ' sudah terisi!';

    }

}
