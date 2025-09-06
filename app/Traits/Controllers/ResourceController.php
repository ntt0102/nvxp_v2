<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Debugbar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

trait ResourceController
{
    use ResourceHelper;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->checkAccess()) {
            $paginatorData = [];
            $show = (int) $request->input('show', '');
            $show = (is_numeric($show) && $show > 0 && $show <= 100) ? $show : 10;
            if ($show != 10) {
                $paginatorData['show'] = $show;
            }
            $search = trim($request->input('search', ''));
            if (!empty($search)) {
                $paginatorData['search'] = $search;
            }
            $records = $this->getSearchRecords($request, $show, $search);
            $records->appends($paginatorData);
            //
            $classifies = $this->getFilterClassifies($request);
            $classifies['show'] = $show;

            // Debugbar::addMessage($records, 'mylabel');

            return view('_resources.index', $this->filterSearchViewData($request, [
                'records' => $records,
                'search' => $search,
                'resourceAlias' => $this->getResourceAlias(),
                'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
                'resourceTitle' => $this->getResourceTitle(),
                'indexSubtitle' => $this->getIndexSubtitle(),
                'createButtonName' => $this->getCreateButtonName(),
                'classifies' => $classifies,
            ]));
        } else return view('errors.404');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($this->checkAccess()) {
            $classifies = $this->getFormClassifies($request);
            $class = $this->getResourceModel();
            return view('_resources.create', $this->filterCreateViewData([
                'record' => new $class(),
                'resourceAlias' => $this->getResourceAlias(),
                'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
                'resourceTitle' => $this->getResourceTitle(),
                'createSubtitle' => $this->getCreateSubtitle(),
                'listButtonName' => $this->getListButtonName(),
                'classifies' => $classifies,
            ]));
        } else return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($this->checkStore($request)) {
            DB::beginTransaction();
            $this->resourceValidate($request, 'store');
            $valuesToSave = $this->getValuesToSave($request);
            $request->merge($valuesToSave);
            //
            $record = $this->getResourceModel()::create($this->alterValuesToSave($request, $valuesToSave));
            $successSts = $this->doStoreSuccess($record, $request);
            if ($record && $successSts) {
                flash()->success($this->getCreateSubtitle() . ' thành công.');
                DB::commit();
            } else {
                flash()->error($this->getCreateSubtitle() . ' thất bại.');
                DB::rollBack();
            }
        }
        //
        $urlParameter =  $request->input('classifies', '');
        // return redirect(route($this->getResourceRoutesAlias() . '.create') . '?' . $urlParameter);
        // return redirect()->back();
        return redirect(route($this->getResourceRoutesAlias() . '.edit', $record->id) . '?' . $urlParameter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     return redirect(route($this->getResourceRoutesAlias().'.edit', $id));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $id)
    {
        if ($this->checkAccess()) {
            $record = $this->getResourceModel()::findOrFail($id);
            $classifies = $this->getFormClassifies($request, $record);
            return view('_resources.edit', $this->filterEditViewData($record, [
                'record' => $record,
                'resourceAlias' => $this->getResourceAlias(),
                'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
                'resourceTitle' => $this->getResourceTitle(),
                'editSubtitle' => $this->getEditSubtitle(),
                'listButtonName' => $this->getListButtonName(),
                'createButtonName' => $this->getCreateButtonName(),
                'classifies' => $classifies,
            ]));
        } else return view('errors.404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $record = $this->getResourceModel()::findOrFail($id);
        if ($this->checkUpdate($record, $request)) {
            DB::beginTransaction();
            $this->resourceValidate($request, 'update', $record);
            $valuesToSave = $this->getValuesToSave($request, $record);
            $request->merge($valuesToSave);
            //
            $old = $record;
            $updateSts = $record->update($this->alterValuesToSave($request, $valuesToSave));
            $successSts = $this->doUpdateSuccess($record, $old);

            if ($updateSts && $successSts) {
                flash()->success($this->getEditSubtitle() . ' thành công.');
                DB::commit();
            } else {
                flash()->error($this->getEditSubtitle() . ' thất bại.');
                DB::rollBack();
            }
        }
        //
        $urlParameter =  $request->input('classifies', '');
        // return redirect(route($this->getResourceRoutesAlias().'.index').'?'.$urlParameter);
        // return redirect()->back();
        return redirect(route($this->getResourceRoutesAlias() . '.edit', $record->id) . '?' . $urlParameter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        $record = $this->getResourceModel()::findOrFail($id);
        $urlParameter =  $request->input('classifies', '');
        //
        if ($this->checkDeleted($record)) {
            $old = $record;
            $destroySts = $this->doDestroy($record);
            $successSts = $this->doDestroySuccess($record, $old);
            if ($destroySts && $successSts) {
                flash()->success('Xóa thành công.');
                DB::commit();
            } else {
                flash()->error('Xóa thất bại.');
                DB::rollBack();
            }
        }
        //
        return redirect(route($this->getResourceRoutesAlias() . '.index') . '?' . $urlParameter);
    }
}
