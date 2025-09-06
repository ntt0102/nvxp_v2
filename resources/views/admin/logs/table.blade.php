<?php
$deleteLink = route('admin::logs.delete');
?>
<div class=" table-responsive">
    <table class="table table-hover">
        @if($myUser->role == 2)
        <th style="width: 10px;">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="all-id">
                <label class="custom-control-label" for="all-id"></label>
            </div>
        </th>
        @endif
        <th>#</th>
        <th>Loại</th>
        <th>Thành viên</th>
        <th>Tạo lúc</th>
        <th style="min-width: 180px;">Tạo bởi</th>


        @foreach ($records as $record)
        <?php
        $tableCounter++;
        $userLink = route('admin::members.index', ['id' => $record->member_id]);
        $modifiedLink = route('admin::members.index', ['id' => $record->modified_by]);
        ?>
        <tr>
            @if($myUser->role == 2)
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="del-id-{{ $record->id }}" user-id="{{ $record->id }}">
                    <label class="custom-control-label" for="del-id-{{ $record->id }}"></label>
                </div>
            </td>
            @endif
            <td>{{ $tableCounter }}</td>
            <td>
                @switch($record->type)
                @case(1)
                <span class="badge bg-primary">
                    @break
                    @case(2)
                    <span class="badge bg-success">
                        @break
                        @case(3)
                        <span class="badge bg-danger">
                            @break
                            @case(4)
                            <span class="badge bg-secondary">
                                @break
                                @endswitch
                                {{ $record->type_name }}
                            </span>
            </td>
            <td>
                @if($record->member_name)
                <a href="{{ $userLink }}">{{ $record->member_name }}</a>
                @else
                {{ $record->note }}
                @endif
            </td>
            <td>{{ date("H:i d/m/Y", strtotime($record->created_at)) }}</td>
            <td><a href="{{ $userLink }}">{{ $record->modified_name }}</a></td>
        </tr>
        @endforeach
    </table>
    @if($myUser->role == 2)
    <form id="formMultiDelete" action="{{ $deleteLink }}" method="POST" style="display: none;" class="hidden form-inline">
        {{ csrf_field() }}
        <input type="hidden" id="multiDeleteId" name="id">
    </form>
    @endif
</div>