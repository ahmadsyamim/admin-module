<?php

namespace Modules\Admin\Http\Actions\Modules;

use Modules\Admin\Http\Actions\AbstractAction;
use Modules\Admin\Entities\Module;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module as LaravelModule;

class ModuleUpdateAction extends AbstractAction
{
    public function __construct($dataType, $data)
    {
        $this->dataType = $dataType;
        $this->data = $data;
        $this->isBulk = true;
        $this->isSingle = true;
    }

    public function getTitle($actionParams = ['type'=>false, 'id'=>false])
    {
        if ($actionParams['type']) {
            if (isset($actionParams['id']) && $actionParams['id']) {
                $id = $actionParams['id'];
                $module = Module::find($id);
                if ($module->sha && $module->sha != $module->current_sha) {
                    return 'Update available';
                }
            }
            return false;
        }
        return 'Check for Updates';
    }

    public function getIcon()
    {
        return 'fas fa-sync';
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
                LaravelModule::update($module->title);
                $module->current_sha = $module->sha;
                $module->save();
            }
        } else {
            // Mass Action (all)
            $modules = Module::all();
            foreach ($modules as $module) {
                $url = false;
                if ($module->url) {
                    $url = $module->url;
                }
                if ($url) {
                    $responseGH = \Http::get("https://api.github.com/repos/{$url}/commits/master")->collect();
                    if ($responseGH->count() && $responseGH->get('sha')) {
                        $module->sha = $responseGH->get('sha');
                        $module->save();
                    }
                }
            }
        }
        return redirect($comingFrom);
    }

    private function isUrl($url){
        return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
    }
}