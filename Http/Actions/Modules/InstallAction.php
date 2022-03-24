<?php

namespace Modules\Admin\Http\Actions\Modules;

use Modules\Admin\Http\Actions\AbstractAction;
use Modules\Admin\Entities\Module;
use Illuminate\Support\Str;

class InstallAction extends AbstractAction
{
    public function __construct($dataType, $data)
    {
        $this->dataType = $dataType;
        $this->data = $data;
        $this->data = $data;
        $this->isBulk = false;
        $this->isSingle = true;
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
                } else if ($moduleInfo && !$moduleInfo->isStatus(true)) {
                    return 'Enable';        
                }
            }
            if ($module->isValid()) {
                return 'Install';
            }
            return 'Invalid Module';
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
                'class' => 'ui primary button right floated btn-loading'
            ];
        } else if ($type == 'widget') {
            return [
                'class' => 'ui button item btn-loading'
            ];
        }
        return [
            'class' => 'btn btn-primary btn-loading',
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
                if (!$moduleInfo) {
                    if ($module->url && ($this->isUrl($module->url))) {
                        // if url, use url 
                    } else {
                        // not url, try to module:install @ composer require
                        \Artisan::call("module:install", ['name' => $module->url]);
                    }
                }
                if ($moduleInfo) {
                    if ($moduleInfo->isStatus(true)) {
                        \Artisan::call("module:migrate-rollback", ['module' => $moduleInfo->getName()]);
                        $moduleInfo->disable();
                    } else {
                        \Artisan::call("module:migrate", ['module' => $moduleInfo->getName()]);
                        $moduleInfo->enable();

                        // Run postEnable if available
                        $moduleServiceProvider = "Modules\\{$moduleInfo->getName()}\Providers\ModuleServiceProvider";
                        if ((int)method_exists($moduleServiceProvider, 'postEnable')) {
                            $moduleService = new $moduleServiceProvider($moduleInfo->getName());
                            $moduleService->postEnable();
                        }
                    }
                    \Artisan::call("cache:clear");
                } 
            }
        }
        return redirect($comingFrom);
    }

    private function isUrl($url){
        return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
    }
}