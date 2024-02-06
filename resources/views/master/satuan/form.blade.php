<div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    <label for="keterangan" class="control-label">{{ 'Keterangan' }}</label>
    <input class="form-control" name="keterangan" type="text" id="keterangan" value="{{ isset($satuan->keterangan) ? $satuan->keterangan : ''}}" >
    {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
</div>


<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">