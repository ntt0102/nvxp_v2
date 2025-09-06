@if($myUser->role == 2)
<?php
if ($record->member_id) {
    $info = \App\Models\Member::find($record->member_id);
} else if (isset($classifies['member'])) {
    $info = \App\Models\Member::find($classifies['member']);
} else {
    $info = null;
}
?>
@if($info)
<div class="col-md-12">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="id" class="form-control-label">Họ và tên</label>
                <div class="form-control"><span>{{ $info->name }}</span>
                    <a class="float-right" href=" {{ route('map').'?view='.$info->id }}"><i class="fas fa-sitemap"></i>
                        Xem</a>
                </div>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="id" class="form-control-label">Hệ</label>
                <div class="form-control"><span>{{ $info->pedigree }}</span>
                </div>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="role" class="form-control-label">Vai trò</label>
                <select id="role" name="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" changed="{{ $record && $myUser->id == $record->id ? '0' : '1' }}">
                    <option value="">&nbsp;</option>
                    @foreach ($classifies['roles'] as $role)
                    <option value="{{ $role->value }}" {{ old('role', isset($classifies['role']) ? $classifies['role'] : $record->role ) == $role->value ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('role'))
                <div class="invalid-feedback">Vai trò {{ $errors->first('role') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="username" class="form-control-label">Tên đăng nhập <i class="far fa-question-circle" title="Tên đăng nhập không được có dấu cách"></i></label>
                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username', $record->username) }}">
                @if ($errors->has('username'))
                <div class="invalid-feedback">Tên đăng nhập {{ $errors->first('username') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="email" class="form-control-label">Email</label>
                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $record->email) }}">
                @if ($errors->has('email'))
                <div class="invalid-feedback">Email {{ $errors->first('email') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="password" class="form-control-label">Mật khẩu</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" placeholder="&nbsp;Nhập lần 1">
                @if ($errors->has('password'))
                <div class="invalid-feedback">Mật khẩu {{ $errors->first('password') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="password-confirm" class="form-control-label d-none d-md-block">&nbsp;</label>
                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="&nbsp;Nhập lần 2">
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- row -->
</div>
<!-- /.col-md-12 -->
<input type="hidden" name="member_id" value="{{ $info->id }}" />
<input type="hidden" name="classifies" />
<input type="hidden" id="page" value="{{ $classifies['page'] }}" />
<input type="hidden" id="isDelete" value="{{ Auth::user()->id == $record->id ? '1' : '0' }}" />
@else
<div>
    <a href="{{route('filter').'?filterMode=manager'}}">Hãy chọn Quản trị viên</a>
</div>
@endif
@else
<p>Không được phép truy cập</p>
@endif