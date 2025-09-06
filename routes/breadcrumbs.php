<?php

// Dashboard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('<i class="fas fa-tachometer-alt"></i> Tổng quan', route('dashboard::index'));
});


// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push('<i class="fas fa-tachometer-alt"></i> Tổng quan', route('admin::index'));
});

// Admin / {Resource} / {List|Edit|Create}
$resources = [
    'users' => [],
    'members' => [],
    'constants' => [],
    'classifies' => [],
];
foreach ($resources as $resource => $data) {
    $parent = 'admin';
    $title = isset($data['title']) ? $data['title'] : '';
    $parameter = isset($data['parameter']) && $data['parameter'] ? $data['parameter'] : '?status=' . default_index();
    $createTitle = isset($data['createTitle']) && $data['createTitle'] ? $data['createTitle'] : 'Thêm';
    $editTitle = isset($data['editTitle']) && $data['editTitle'] ? $data['editTitle'] : 'Sửa';
    //
    $resource = $parent . '::' . $resource;
    // List
    Breadcrumbs::register($resource, function ($breadcrumbs, $name) use ($resource, $title, $parent, $parameter) {
        $breadcrumbs->parent($parent);
        $breadcrumbs->push($name ? $name : $title, route($resource . '.index') . $parameter);
    });
    // Create
    Breadcrumbs::register($resource . '.create', function ($breadcrumbs, $name) use ($resource, $createTitle) {
        $breadcrumbs->parent($resource, $name);
        $breadcrumbs->push($createTitle, route($resource . '.create'));
    });
    // Edit
    Breadcrumbs::register($resource . '.edit', function ($breadcrumbs, $name, $id) use ($resource, $editTitle) {
        $breadcrumbs->parent($resource, $name);
        $breadcrumbs->push($editTitle, route($resource . '.edit', $id));
    });
}
// Admin > Proposes
Breadcrumbs::register('admin::proposes', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Đề xuất', route('admin::proposes'));
});

// Admin > Proposes > Detail
Breadcrumbs::register('admin::proposes.detail', function ($breadcrumbs) {
    $breadcrumbs->parent('admin::proposes');
    $breadcrumbs->push('Chi tiết', route('admin::proposes.detail'));
});

// Admin > Logs
Breadcrumbs::register('admin::logs', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Nhật ký', route('admin::logs'));
});

// Admin > Export
Breadcrumbs::register('admin::export', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Sao lưu', route('admin::export'));
});

// Admin > Import
Breadcrumbs::register('admin::import', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Khôi phục', route('admin::import'));
});

// Admin > Command
Breadcrumbs::register('admin::command', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Chạy lệnh', route('admin::command'));
});

// Admin > Command
Breadcrumbs::register('admin::users.change-password', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Đổi mật khẩu', route('admin::users.change-password'));
});
