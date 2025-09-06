@if(!($myUser->role == 1 && (empty($record) && ($record->constant_id != 4 || $record->modified_by != $myUser->id))))
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6 {{ $myUser->role == 2 ? '' : 'hide' }}">
                <div class="form-group">
                    <label for="constant" class="form-control-label">Định danh</label>
                    <select id="constant" name="constant" class="form-control{{ $errors->has('constant') ? ' is-invalid' : '' }}">
                        <option value="">&nbsp;</option>
                        @foreach ($classifies['constants'] as $constant)
                            <option value="{{ $constant->id }}" {{ ($myUser->role == 1 ? 4 : old('constant', isset($record->constant_id) ? $record->constant_id : $classifies['constant'])) == $constant->id ? 'selected' : '' }}>{{ $constant->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('constant'))
                        <div class="invalid-feedback">Nhóm {{ $errors->first('constant') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="display-no" class="form-control-label">Thứ tự hiển thị</i></label>
                    <input id="display-no" type="number" min="1" class="form-control{{ $errors->has('display_no') ? ' is-invalid' : '' }}" name="display_no" value="{{ old('display_no', $record->display_no) }}" {{ $myUser->role == 2 ? '' : 'autofocus' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                    @if ($errors->has('display_no'))
                        <div class="invalid-feedback">Thứ tự hiển thị {{ $errors->first('display_no') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">Tên hiển thị</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $record->name) }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">Tên hiển thị {{ $errors->first('name') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="value" class="form-control-label">Giá trị</i></label>
                    <input id="value" type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" value="{{ old('value', $record->value) }}">
                    @if ($errors->has('value'))
                        <div class="invalid-feedback">Giá trị {{ $errors->first('value') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
    </div>
    <!-- /.col-md-9 -->
    <input type="hidden" name="classifies" />
@else
    <p>Không được phép truy cập</p>
@endif
