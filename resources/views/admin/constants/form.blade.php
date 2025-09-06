@if ($myUser->role == 2)
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="custom-control custom-checkbox mt-1">
                        <input type="checkbox" class="custom-control-input" id="array" name="array" {{ old('array', $record->array) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="array">Kiểu mảng</label>
                    </div>
                    <!-- /.custom-control -->
                    @if ($errors->has('array'))
                        <div class="invalid-feedback">{{ $errors->first('array') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name" class="form-control-label">Tên</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $record->name) }}" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">Tên {{ $errors->first('name') }}</div>
                    @endif
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="_value" class="form-control-label">Giá trị</i></label>
                    <input id="_value" type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" value="{{ is_numeric(old('value', $record->value)) && $record->value >= 1000000 ? currency_format(old('value', $record->value)) : $record->value }}" required>
                    <input id="value" type="hidden" name="value" value="{{ old('value', $record->value) }}">
                    @if ($errors->has('value'))
                        <div class="invalid-feedback">Giá trị {{ $errors->first('value') }}</div>
                    @endif
                </div>
                <!-- /.form-group --> 
            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="expand" name="expand" {{ old('description', $record->description) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="expand">Mô tả</label>
                    </div>
                    <!-- /.custom-control -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
        <div class="row {{ old('description', $record->description) ? '' : 'hide' }}">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">
                      {{ old('description', $record->description) }}
                    </textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">Mô tả {{ $errors->first('description') }}</div>
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