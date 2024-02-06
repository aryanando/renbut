<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($pegawai->nama) ? $pegawai->nama : ''}}" >
    {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
    <label for="gender" class="control-label">{{ 'Gender' }}</label>
    {{-- <input class="form-control" name="gender" type="text" id="gender" value="{{ isset($pegawai->gender) ? $pegawai->gender : ''}}" > --}}
    <select class="form-control" name="gender" id="gender">
        <option value="Laki-laki" {{ isset($pegawai->gender) ? $pegawai->gender == 'Laki-laki' ? 'selected': '' : ''}}>Laki-laki</option>
        <option value="Perempuan" {{ isset($pegawai->gender) ? $pegawai->gender == 'Perempuan' ? 'selected': '' : ''}}>Perempuan</option>
    </select>
    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('unit_id') ? 'has-error' : ''}}">
    <label for="unit_id" class="control-label">{{ 'Unit Id' }}</label>
    <select class="form-control" name="unit_id" id="unit_id">
        @foreach ($unit as $item)
            <option value="{{ $item->id }}" {{ isset($pegawai->unit_id) ? $pegawai->unit_id == $item->id ? 'selected': '' : ''}}>{{ ucfirst($item->keterangan) }}</option>
        @endforeach
    </select>
    {!! $errors->first('unit_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('cuti') ? 'has-error' : ''}}">
    <label for="cuti" class="control-label">{{ 'Tgl terakhir Cuti' }}</label>
    <input class="form-control" name="cuti" type="date" id="cuti" value="{{ isset($pegawai->cuti) ? $pegawai->cuti : ''}}" >
    {!! $errors->first('cuti', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('tmt_kerja') ? 'has-error' : ''}}">
    <label for="cuti" class="control-label">{{ 'Terhitung Mulai Tanggal' }}</label>
    <input class="form-control" name="tmt_kerja" type="date" id="tmt_kerja" value="{{ isset($pegawai->tmt_kerja) ? $pegawai->tmt_kerja : ''}}" >
    {!! $errors->first('tmt_kerja', '<p class="help-block">:message</p>') !!}


</div>

<!-- <div class="form-group {{ $errors->has('pendidikan') ? 'has-error' : ''}}">
    <label for="pendidikan" class="control-label">{{ 'pendidikan' }}</label>
    <input class="form-control" name="pendidikan" type="text" id="pendidikan" value="{{ isset($pegawai->pendidikan) ? $pegawai->pendidikan : ''}}" >
    {!! $errors->first('pendidikan', '<p class="help-block">:message</p>') !!}
</div> -->

<div class="form-group {{ $errors->has('pendidikan') ? 'has-error' : ''}}">
    <label for="pendidikan" class="control-label">{{ 'pendidikan' }}</label>
    {{-- <input class="form-control" name="pendidikan" type="text" id="pendidikan" value="{{ isset($pegawai->pendidikan) ? $pegawai->pendidikan : ''}}" > --}}
    <select class="form-control" name="pendidikan" id="pendidikan">
        <option value="SD" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'SD' ? 'selected': '' : ''}}>SD</option>
        <option value="SMP" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'SMP' ? 'selected': '' : ''}}>SMP</option>
        <option value="SMA" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'SMA' ? 'selected': '' : ''}}>SMA</option>
        <option value="SMK" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'SMK' ? 'selected': '' : ''}}>SMK</option>
        <option value="D3" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'S3' ? 'selected': '' : ''}}>D3 </option>
        <option value="S1" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'S1' ? 'selected': '' : ''}}>D4 / S1</option>
        <option value="S2" {{ isset($pegawai->pendidikan) ? $pegawai->pendidikan == 'S2' ? 'selected': '' : ''}}>S2</option>
    </select>
    {!! $errors->first('pendidikan', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('rekening') ? 'has-error' : ''}}">
    <label for="rekening" class="control-label">{{ 'No Rekening' }}</label>
    <input class="form-control" name="rekening" type="number" id="rekening" value="{{ isset($pegawai->rekening) ? $pegawai->rekening : ''}}" >
    {!! $errors->first('rekening', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'E-mail' }}</label>
    <input class="form-control" name="email" type="email" id="email" value="{{ isset($pegawai->user->email) ? $pegawai->user->email : ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('remun') ? 'has-error' : ''}}">
    <label for="remun" class="control-label">{{ 'Dapat remun' }}</label>
    <select class="form-control" name="remun" id="remun">
        <option value="1" {{ isset($pegawai->remun) ? ($pegawai->remun == 1 ? 'selected' : '') : ''}}>Iya</option>
        <option value="0" {{ isset($pegawai->remun) ? ($pegawai->remun == 0 ? 'selected' : '') : ''}}>Tidak</option>
    </select>
    {!! $errors->first('remun', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('renbut') ? 'has-error' : ''}}">
    <label for="renbut" class="control-label">{{ 'Akses renbut' }}</label>
    <select class="form-control" name="renbut" id="renbut">
        <option value="1" {{ isset($pegawai->user->unit_id) ? ($pegawai->user->unit_id == $pegawai->unit_id ? 'selected' : '') : ''}}>Iya</option>
        <option value="0" {{ isset($pegawai->user->unit_id) ? ($pegawai->user->unit_id == $pegawai->unit_id ? 'selected' : '') : ''}}>Tidak</option>
    </select>
    {!! $errors->first('renbut', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('atasan') ? 'has-error' : ''}}">
    <label for="atasan" class="control-label">{{ 'Jabatan' }}</label>
    <select class="form-control" name="atasan" id="atasan" >
        <option value="0" {{ isset($pegawai->atasan) ? ($pegawai->atasan == 0 ? 'selected' : '') : ''}}>Blu</option>
        <option value="2" {{ isset($pegawai->atasan) ? ($pegawai->atasan == 2 ? 'selected' : '') : ''}}>Karu</option>
        <option value="3" {{ isset($pegawai->atasan) ? ($pegawai->atasan == 3 ? 'selected' : '') : ''}}>Kasubag</option>
        <option value="4" {{ isset($pegawai->atasan) ? ($pegawai->atasan == 4 ? 'selected' : '') : ''}}>Kaur</option>
    </select>
    {!! $errors->first('atasan', '<p class="help-block">:message</p>') !!}
</div>


<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">