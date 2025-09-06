<?php

namespace App\Traits\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Utils;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

trait ResourceHelper
{
    /**
     * @return string
     */
    private function setResourceTitle()
    {
    }

    /**
     * @return string
     */
    private function getResourceAlias()
    {
        if (property_exists($this, 'resourceAlias') && ! empty($this->resourceAlias)) {
            return $this->resourceAlias;
        } else {
            throw new \InvalidArgumentException('The property "resourceAlias" is not defined');
        }
    }

    /**
     * @return string
     */
    private function getResourceRoutesAlias()
    {
        if (property_exists($this, 'resourceRoutesAlias') && ! empty($this->resourceRoutesAlias)) {
            return $this->resourceRoutesAlias;
        } else {
            return $this->getResourceAlias();
        }
    }

    /**
     * @return string
     */
    private function getResourceTitle()
    {
        if (property_exists($this, 'resourceTitle') && ! empty($this->resourceTitle)) {
            $this->setResourceTitle();
            return $this->resourceTitle;
        } else {
            return $this->getResourceAlias();
        }
    }

    /**
     * @return mixed
     */
    private function getResourceModel()
    {
        if (property_exists($this, 'resourceModel') && ! empty($this->resourceModel)) {
            return $this->resourceModel;
        } else {
            throw new \InvalidArgumentException('The property "resourceModel" is not defined');
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param \Illuminate\Http\Request $request
     * @param $action
     * @param null $record
     * @throws \Illuminate\Validation\ValidationException
     */
    private function resourceValidate(Request $request, $action, $record = null)
    {
        if ($action == 'store') {
            $validation = $this->resourceStoreValidationData($request);
        } else {
            $validation = $this->resourceUpdateValidationData($record, $request);
        }
        $validation['rules'] = is_array($validation['rules']) ? $validation['rules'] : [];
        $validation['messages'] = is_array($validation['messages']) ? $validation['messages'] : [];
        $validation['attributes'] = is_array($validation['attributes']) ? $validation['attributes'] : [];
        if (! isset($validation['advanced']) || ! is_array($validation['advanced'])) {
            $validation['advanced'] = [];
        }

        if (count($validation['advanced'])) {
            $v = Validator::make(
                $request->all(),
                $validation['rules'],
                $validation['messages'],
                $validation['attributes']
            );

            // DOC: https://laravel.com/docs/5.6/validation
            foreach ($validation['advanced'] as $data) {
                if (isset($data['attribute']) && isset($data['rules']) && is_callable($data['callback'])) {
                    $v->sometimes($data['attribute'], $data['rules'], $data['callback']);
                }
            }

            $v->validate();
        } else {
            $this->validate($request, $validation['rules'], $validation['messages'], $validation['attributes']);
        }
    }

    /**
     * Classes using this trait have to implement this method.
     * Used to validate store.
     *
     * @return array
     */
    private function resourceStoreValidationData(Request $request = null)
    {
        return [
            'rules' => [],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    /**
     * Classes using this trait have to implement this method.
     * Used to validate update.
     *
     * @param $record
     * @return array
     */
    private function resourceUpdateValidationData($record, Request $request = null)
    {
        return [
            'rules' => [],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    /**
     * Classes using this trait have to implement this method.
     *
     * @param \Illuminate\Http\Request $request
     * @param null $record
     * @return array
     */
    private function getValuesToSave(Request $request, $record = null)
    {
        return $request->only($this->getResourceModel()::getFillableFields());
    }

    private function alterValuesToSave(Request $request, $values) {
        return $values;
    }

    /**
     * @param $request
     * @return bool
     */
    private function checkAccess($record = null)
    {
        return true;
    }

    /**
     * @return $record
     * @return bool
     */
    private function checkRole($record = null)
    {
        $myUser = Auth::user();
        if (!$myUser->role) {
            flash()->error('Hành động này bị ngăn chặn.');
            return false;
        }
        return true;
    }

    /**
     * @return $record
     * @return bool
     */
    private function checkDeleted($record = null)
    {
        return true;
    }

    /**
     * @param $request
     * @return bool
     */
    private function checkStore(Request $request = null)
    {
        return true;
    }

    /**
     * @param $record
     * @param $request
     * @return bool
     */
    private function checkUpdate($record, Request $request = null)
    {
        return true;
    }

    /**
     * @param $record
     * @return bool
     */
    private function checkDestroy($record)
    {
        return true;
    }

    /**
     * Classes using this trait have to implement this method.
     * Retrieve the list of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $show
     * @param string|null $search
     * @return \Illuminate\Support\Collection
     */
    private function getSearchRecords(Request $request, $show = 15, $search = null)
    {
        return $this->getResourceModel()::paginate($show);
    }

    /**
     * @param $record
     * @return \Illuminate\Http\Response
     */
    private function getRedirectAfterSave($record)
    {
        return redirect(route($this->getResourceRoutesAlias().'.index'));
    }

    /**
     * @param array $data
     * @return array
     */
    private function filterCreateViewData($data = [])
    {
        return $data;
    }

    /**
     * @param $record
     * @param array $data
     * @return array
     */
    private function filterEditViewData($record, $data = [])
    {
        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return array
     */
    private function filterSearchViewData(Request $request, $data = [])
    {
        return $data;
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getFilterClassifies(Request $request)
    {
        $classifies = [];
        return $classifies;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getFormClassifies(Request $request, $record = null)
    {
        $classifies = [];
        return $classifies;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $record
     */
    private function doStoreSuccess($record = null, Request $request = null)
    {
        return true;
    }

    /**
     * @param $record
     * @param $old
     */
    private function doUpdateSuccess($record = null, $old = null)
    {
        return true;
    }

    /**
     * @param $record
     */
    private function doDestroySuccess($record = null)
    {
        return true;
    }

    /**
     * @param $record
     * @param $valuesToSave
     */
    private function doDestroy($record)
    {
        return $record->delete();
    }

    /**
     * @return string
     */
    private function getIndexSubtitle()
    {
        if (property_exists($this, 'indexSubtitle') && ! empty($this->indexSubtitle)) {
            return $this->indexSubtitle;
        } else {
            return 'Danh sách';
        }
    }

    /**
     * @return string
     */
    private function getEditSubtitle()
    {
        if (property_exists($this, 'editSubtitle') && ! empty($this->editSubtitle)) {
            return $this->editSubtitle;
        } else {
            return 'Sửa';
        }
    }

    /**
     * @return string
     */
    private function getCreateSubtitle()
    {
        if (property_exists($this, 'createSubtitle') && ! empty($this->createSubtitle)) {
            return $this->createSubtitle;
        } else {
            return 'Thêm mới';
        }
    }

    /**
     * @return string
     */
    private function getListButtonName()
    {
        if (property_exists($this, 'listButtonIcon') && ! empty($this->listButtonIcon)) {
            return $this->listButtonIcon.' '.$this->getIndexSubtitle();
        } else {
            return '<i class="fas fa-list-ul"></i> '.$this->getIndexSubtitle();
        }
    }

    /**
     * @return string
     */
    private function getCreateButtonName()
    {
        if (property_exists($this, 'createButtonIcon') && ! empty($this->createButtonIcon)) {
            return $this->createButtonIcon.' '.$this->getCreateSubtitle();;
        } else {
            return '<i class="fas fa-plus-square"></i> '.$this->getCreateSubtitle();
        }
    }
}
