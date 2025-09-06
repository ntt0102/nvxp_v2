<?php
$isAdmin = Auth::user()->role == 2;
?>
<div class=" table-responsive">
    <table class="table table-hover">
        <th>#</th>
        <th style="min-width: 100px;">Trạng thái</th>
        <th style="min-width: 150px;">Đối tượng</th>
        <th style="min-width: 200px;">Mô tả</th>
        <th style="min-width: 100px;">Hình ảnh</th>
        <th>Thời gian gửi</th>
        @if($isAdmin)
        <th style="min-width: 100px;">Người sửa</th>
        @endif
        <th>
            <div class="text-right">Thao tác<div>
        </th>

        @foreach ($records as $record)
        <?php
        $tableCounter++;
        //
        $memberLink = route('admin::members.index', ['id' => $record->member_id]);
        if ($isAdmin) {
            $editedUserLink = route('admin::users.index', ['id' => $record->edited_by]);
        }
        //
        if (!$record->edited_by) {
            $processLink = route('admin::proposes.process', $record->id);
            $formProcessId = 'formProcess_' . $record->id;
            $statusName = 'Chưa sửa';
            $statusColor = 'danger';
        } else {
            if ($isAdmin) {
                $deleteLink = route('admin::proposes.delete', $record->id);
                $formDeleteId = 'formDelete_' . $record->id;
            }
            $statusName = 'Đã sửa';
            $statusColor = 'secondary';
        }
        ?>
        <tr>
            <td>{{ $tableCounter }}</td>
            <td><span class="badge badge-{{ $statusColor }}">{{ $statusName }}</span></td>
            <td>
                @if($record->member_name)
                <a href="{{ $memberLink }}">{{ $record->member_name }}</a>
                @else
                <span>Không có</span>
                @endif
            </td>
            <td>{!! preg_replace("/[\n\r]/", '
                <div />', $record->description) !!}
            </td>
            <td>
                @if ($record->image)
                <img src="{{ asset('images/proposes/'.$record->image) }}" height="40" class="zoom-in">
                @else
                <i class="fas fa-times"></i>
                @endif
            </td>
            <td>{{ date("d/m/Y H:i", strtotime($record->created_at)) }}</td>
            @if($isAdmin)
            <td><a href="{{ $editedUserLink }}">{{ $record->editor_name }}</a></td>
            @endif
            <td>
                <div class="float-right input-group-append">
                    @if(!$record->edited_by)
                    <button class="btn btn-sm btn-success btnProcess" data-form-id="{{ $formProcessId }}" data-name="đề xuất này"><i class="fas fa-edit"></i> Đánh dấu đã sửa</button>
                    @elseif($isAdmin)
                    <button class="btn btn-sm btn-danger btnDelete" data-form-id="{{ $formDeleteId }}" data-name="đề xuất này"><i class="fas fa-trash-alt"></i> Xóa</button>
                    @endif
                </div>
                @if(!$record->edited_by)
                <form id="{{ $formProcessId }}" action="{{ $processLink }}" method="POST" class="hide form-inline">
                    {{ csrf_field() }}
                    <input type="hidden" name="classifies" />
                </form>
                @elseif($isAdmin)
                <form id="{{ $formDeleteId }}" action="{{ $deleteLink }}" method="POST" class="hide form-inline">
                    {{ csrf_field() }}
                    <input type="hidden" name="classifies" />
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>