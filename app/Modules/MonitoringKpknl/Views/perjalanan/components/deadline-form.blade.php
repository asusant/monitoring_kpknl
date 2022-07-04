<div class="col-md-5 text-end">
    <label for="sts_permohonan">Status Permohonan</label>
</div>
<div class="col-md-3">
    <div class="form-group">
        {{ Form::select('sts_permohonan', $ref_sts_permohonan, NULL, ['class' => 'form-control', 'placeholder' => ':: Pilih Status Permohonan ::', 'id' => 'sts_permohonan']) }}
        @if ($errors->has('sts_permohonan'))
            <div class="invalid-feedback">{{ implode(' | ', $errors->get('sts_permohonan')) }}</div>
            <script>(function() { document.getElementById('sts_permohonan').classList.add('is-invalid')})();</script>
        @endif
    </div>
</div>
<div class="col-md-5 text-end">
    <label for="next_tahap">Tahap Selanjutnya</label>
</div>
<div class="col-md-7">
    <div class="form-group">
        {{ Form::text('', (@$next_tahap->nm_tahap ? $next_tahap->nm_tahap : '- Selesai -'), ['class' => 'form-control', 'disabled' => true]) }}
        <small><strong>Sekitar {!! $help->strHighlight($help->parseDateTime( (@$next_deadline ? $next_deadline : $now) ), 'info') !!} (*deadline berubah menyesuaikan lama input data)</strong></small>
    </div>
</div>
<div class="col-md-5 text-end">
    <label for="is_deadline_manual">Ubah Deadline Manual?</label>
</div>
<div class="col-md-2">
    <div class="form-group">
        {{ Form::select('is_deadline_manual', config('bobb.str_boolean.ya_tidak'), NULL, ['class' => 'form-control', 'id' => 'is_deadline_manual', 'onchange' => 'change_deadline()']) }}
        @if ($errors->has('is_deadline_manual'))
            <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_deadline_manual')) }}</div>
            <script>(function() { document.getElementById('is_deadline_manual').classList.add('is-invalid')})();</script>
        @endif
    </div>
</div>
<div class="col-md-5"></div>
<div class="col-md-5 deadline_manual text-end">
    <label for="tgl_deadline">Atur Deadline Manual</label>
</div>
<div class="col-md-3 deadline_manual">
    <div class="form-group">
        {{ Form::text('tgl_deadline', NULL, ['class' => 'form-control', 'placeholder' => 'Tanggal', 'data-datepicker' => '', 'id' => 'tgl_deadline']) }}
        @if ($errors->has('tgl_deadline'))
            <div class="invalid-feedback">{{ implode(' | ', $errors->get('tgl_deadline')) }}</div>
            <script>(function() { document.getElementById('tgl_deadline').classList.add('is-invalid')})();</script>
        @endif
    </div>
</div>
<div class="col-md-2 deadline_manual">
    <div class="form-group">
        {{ Form::number('jam_deadline', NULL, ['class' => 'form-control', 'placeholder' => 'Jam (0 s.d. 24)', 'id' => 'jam_deadline']) }}
        @if ($errors->has('jam_deadline'))
            <div class="invalid-feedback">{{ implode(' | ', $errors->get('jam_deadline')) }}</div>
            <script>(function() { document.getElementById('jam_deadline').classList.add('is-invalid')})();</script>
        @endif
    </div>
</div>
<div class="col-md-2 deadline_manual"></div>
<div class="col-md-5 text-end">
    <label for="catatan">Catatan</label>
</div>
<div class="col-md-7">
    <div class="form-group">
        {{ Form::textarea('catatan', NULL, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Perubahan Deadline dikarenakan.....', 'id' => 'catatan']) }}
        @if ($errors->has('catatan'))
            <div class="invalid-feedback">{{ implode(' | ', $errors->get('catatan')) }}</div>
            <script>(function() { document.getElementById('catatan').classList.add('is-invalid')})();</script>
        @endif
    </div>
</div>
<!-- Include DatePicker JS -->
<script src="{{ asset('vendors/datepicker/js/datepicker.min.js') }}"></script>
<script>
    function change_deadline()
    {
        deadline_manual = document.getElementById('is_deadline_manual');
        if(deadline_manual.value == '1')
        {
            for (let el of document.querySelectorAll('.deadline_manual'))
            {
                el.style.display = 'block';
            }
        }
        else
        {
            for (let el of document.querySelectorAll('.deadline_manual'))
            {
                el.style.display = 'none';
            }
        }
    }
    change_deadline();
</script>
