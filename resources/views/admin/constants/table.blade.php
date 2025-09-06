<div class=" table-responsive"> 
    <table class="table table-hover">
        <th>#</th>
        <th style="min-width: 180px;">Tên</th>
        <th style="min-width: 130px;">Giá trị</th>
        <th>Kiểu mảng</th>
        <th>Cập nhật lúc</th>
        <th style="min-width: 100px;"><div class="text-right">Thao tác</div></th>

        @foreach ($records as $record)
            <?php
                $tableCounter++;
                //
                $classifyLink = route('admin::classifies.index', ['constant' => $record->id]);
                $editLink = route($resourceRoutesAlias.'.edit', $record->id);
                $deleteLink = route($resourceRoutesAlias.'.destroy', $record->id);
                $formDeleteId = 'formDestroyToggle_'.$record->id;
            ?>
            <tr>
                <td>{{ $tableCounter }}</td>
                <td>
                    @if($record->array)
                        <a class="load-none" href="{{ $classifyLink }}">{{ $record->name }}</a>
                    @else
                        {{ $record->name }}
                    @endif
                </td>
                <td>{{ is_numeric($record->value) && $record->value >= 1000000 ? currency_format($record->value, 1) : $record->value }}</td>
                <td><i class="fas {{ $record->array ? 'fa-check text-success' : 'fa-times text-danger' }}"></i></td>
                <td>{{ date("H:i d/m/Y", strtotime($record->updated_at)) }}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <div class="float-right input-group-append">
                        <button class="ml-1 btn btn-sm btn-primary btnEdit" data-url="{{ $editLink }}" ><i class="fas fa-edit"></i> Sửa</button>
                        <button class="ml-1 btn btn-sm btn-danger btnDelete" data-form-id="{{ $formDeleteId }}" data-name="{{ $record->name }}" ><i class="fas fa-trash-alt"></i> Xóa</button>
                    </div>
                    <form id="{{ $formDeleteId }}" action="{{ $deleteLink }}" method="POST" class="hide form-inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="classifies" />
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
