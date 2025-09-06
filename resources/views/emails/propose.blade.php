<!DOCTYPE html>
<html>

<head>
	<title>Sao lưu dữ liệu</title>
</head>

<body>
	<p>Xin chào {{ $data['to'] }}</p>
	<p>
		Mail này được gửi từ trang web của Nguyễn Văn Xuân Phú để thông báo có một đề xuất sửa đổi.
		</br>
		Vui lòng sửa đổi nó bằng cách nhấn vào đường dẫn bên dưới:
	</p>

	<p>
		<a href="{{ $data['route'] }}">Sửa đề xuất</a>
	</p>

	<p>Sau khi sửa xong hãy đổi trạng thái đề xuất thành "Đã sửa". Xin cảm ơn!</p>
</body>

</html>