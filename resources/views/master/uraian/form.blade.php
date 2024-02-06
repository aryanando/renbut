<div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    <label for="keterangan" class="control-label">{{ 'Keterangan' }}</label>
    <input class="form-control" name="keterangan" type="text" id="keterangan" value="{{ isset($uraian->keterangan) ? $uraian->keterangan : ''}}" >
    {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('satuan') ? 'has-error' : ''}}">
    <label for="satuan" class="control-label">{{ 'Satuan' }}</label>
    <input class="form-control" name="satuan" type="text" id="satuan" value="{{ isset($uraian->satuan) ? $uraian->satuan : ''}}" >
    {!! $errors->first('satuan', '<p class="help-block">:message</p>') !!}
</div>


<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">