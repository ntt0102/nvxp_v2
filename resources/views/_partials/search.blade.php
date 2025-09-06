@if ($link)
	<?php
		if(!isset($placeholder)) $placeholder = 'Tìm kiếm';
	?>
    <input type="text" id="search" class="form-control float-right" value="{{ $value }}" placeholder="{{ $placeholder }}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" link="{{ $link }}">
@endif
