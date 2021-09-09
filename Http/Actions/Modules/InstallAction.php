<?php

namespace Modules\Admin\Http\Actions\Modules;

use Modules\Admin\Http\Actions\AbstractAction;
use Modules\Admin\Entities\Module;

class InstallAction extends AbstractAction
{  
    public function __construct($dataType, $data)
    {
        $this->dataType = $dataType;
        $this->data = $data;
        $this->isBulk=false;
        $this->isSingle=true;
    }

    public function getTitle($actionParams = ['type'=>false, 'id'=>false])
    {
        if ($actionParams['type']) {
            if (isset($actionParams['id']) && $actionParams['id']) {
                $id = $actionParams['id'];
                $module = Module::find($id);
                $moduleInfo = \Module::find($module->slug);
                if ($moduleInfo && $moduleInfo->isStatus(true)) {
                    return 'Disable';
                } else {
                    return 'Enable';        
                }
            }
            return 'Install';
        }
        return 'Bulk Install';
    }

    public function getIcon()
    {
        return 'fas fa-plug';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes($actionParams = ['type'=>false])
    {
        $type = $actionParams['type'] ?? ['type'=>false];
        if ($type == 'single') {
            return [
                'class' => 'ui primary button right floated'
            ];
        } else if ($type == 'widget') {
            return [
                'class' => 'ui button item'
            ];
        }
        return [
            'class' => 'btn btn-primary',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.modules.index');
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'modules';
    }

    public function massAction($ids, $comingFrom)
    {
        if (is_array($ids) && $ids[0]) {
            foreach ($ids as $id) {
                $module = Module::find($id);
                $moduleInfo = \Module::find($module->slug);
                if ($moduleInfo) {
                    if ($moduleInfo->isStatus(true)) {
                        \Artisan::call("module:migrate-rollback", ['module' => $moduleInfo->getName()]);
                        $moduleInfo->disable();
                    } else {
                        \Artisan::call("module:migrate", ['module' => $moduleInfo->getName()]);
                        $moduleInfo->enable();
                    }
                    \Artisan::call("cache:clear");
                }
            }
        }
        return redirect($comingFrom);
    }

}