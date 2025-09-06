<?php
	$pagesCounter = 0;
	if (count($records) > 0) {
	    $pagesCounter = ceil($records->total()/$records->perPage());
	}
?>
<div class="card-footer clearfix">
	<div class="pagination float-left pt-1">
		<input type="text" id="show" class="text-center" value="{{ $show }}" link="{{ $link }}"/>
		<span>&nbsp;/&nbsp;{{ $records->total().' '.$_pageTitleLower }}</span>
	</div>
	@if ($records->hasPages())
	    <ul class="pagination pagination-sm m-0 float-right">
	        {{-- Previous Page Link --}}
	        @if ($records->onFirstPage())
	            <li class="page-item disabled"><span class="page-link">@lang('pagination.previous')</span></li>
	        @else
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() - 1 }}" href="#" rel="prev">@lang('pagination.previous')</a></li>
	        @endif

	        @if ($records->currentPage() > 3)
	            <li class="page-item"><a class="page-link" data-page="1" href="#">1</a></li>
	        @endif
	        @if ($records->currentPage() > 4)
	            <li class="page-item disabled"><span class="page-link">...</span></li>
	        @endif
	        @if ($records->currentPage() > 2)
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() - 2 }}" href="#">{{ $records->currentPage() - 2 }}</a></li>
	        @endif
	        @if ($records->currentPage() > 1)
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() - 1 }}" href="#">{{ $records->currentPage() - 1 }}</a></li>
	        @endif
	        <li class="page-item active"><span class="page-link">{{ $records->currentPage() }}</span></li>
	        @if ($records->currentPage() < $pagesCounter)
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() + 1 }}" href="#">{{ $records->currentPage() + 1 }}</a></li>
	        @endif
	        @if ($records->currentPage() < $pagesCounter - 1)
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() + 2 }}" href="#">{{ $records->currentPage() + 2 }}</a></li>
	        @endif
	        @if ($records->currentPage() < $pagesCounter - 3)
	            <li class="page-item disabled"><span class="page-link">...</span></li>
	        @endif
	        @if ($records->currentPage() < $pagesCounter - 2)
	            <li class="page-item"><a class="page-link" data-page="{{ $pagesCounter }}" href="#"">{{ $pagesCounter }}</a></li>
	        @endif

	        {{-- Next Page Link --}}
	        @if ($records->hasMorePages())
	            <li class="page-item"><a class="page-link" data-page="{{ $records->currentPage() + 1 }}" href="#" rel="next">@lang('pagination.next')</a></li>
	        @else
	            <li class="page-item disabled"><span class="page-link">@lang('pagination.next')</span></li>
	        @endif
	    </ul>
	@endif
</div>
