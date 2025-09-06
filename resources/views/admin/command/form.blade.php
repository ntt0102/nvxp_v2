@if($myUser->role == 2)
    <div class="col-md-9">
        <form id="formCommand" role="form" method="POST" action="{{ $commandLink }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="command" class="form-control-label">Lệnh</label>
                        <select id="command" name="command" class="form-control{{ $errors->has('command') ? ' is-invalid' : '' }}">
                            <option value="">&nbsp;</option>
                            @foreach ($commands as $command)
                                <option value="{{ $command->value }}" {{ old('command') == $command->value ? 'selected' : '' }}>{{ $command->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('command'))
                            <div class="invalid-feedback">Lệnh {{ $errors->first('command') }}</div>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- col-md-6 -->
            </div>
            <!-- row -->
        </form>
    </div>
    <!-- /.col-md-9 -->
@else
    <p>Không được phép truy cập</p>
@endif
