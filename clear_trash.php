<?php
// Đường dẫn thư mục .trash
$trashDir = '/home/fmdabhrf/.trash';

// Hàm xóa thư mục đệ quy
function deleteDir($dirPath)
{
    if (!is_dir($dirPath)) {
        echo "Không phải thư mục: $dirPath<br>";
        return;
    }

    $items = array_diff(scandir($dirPath), array('.', '..'));
    foreach ($items as $item) {
        $path = $dirPath . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDir($path); // Đệ quy xóa thư mục con
        } else {
            if (!unlink($path)) {
                echo "Không thể xóa file: $path<br>";
            }
        }
    }

    if (rmdir($dirPath)) {
        echo "Đã xóa thư mục: $dirPath<br>";
    } else {
        echo "Không thể xóa thư mục: $dirPath<br>";
    }
}

// Quét toàn bộ thư mục con trong .trash và xóa
$items = array_diff(scandir($trashDir), array('.', '..'));
foreach ($items as $item) {
    $path = $trashDir . DIRECTORY_SEPARATOR . $item;
    if (is_dir($path)) {
        deleteDir($path);
    }
}

echo "Hoàn tất xóa tất cả thư mục con trong .trash.";
