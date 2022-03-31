<?php

namespace Modules\Admin\Http\Actions\Modules;

use Modules\Admin\Http\Actions\AbstractAction;
use Modules\Admin\Entities\Module;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module as LaravelModule;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
                if (LaravelModule::find($module->title) && $module->sha && $module->sha != $module->current_sha) {                
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
                if ($module->url) {
                    $updatePackage = $this->updatePackage($module);
                    $output = $this->checkOutdatedPackages();
                    $success = true;
                    foreach ($output as $o) {
                        if ($o->name == $module->url) {
                            $success = false;
                        } 
                    }
                    if ($success) {
                        $module->current_sha = $module->sha;
                        $module->last_update_at = \Carbon\Carbon::now();
                        $module->save();
                    }
                }                
            }
        } else {
            // Mass Action (all)
            $output = $this->checkOutdatedPackages();
            $modules = Module::all();
            foreach ($modules as $module) {
                if ($module->url) {
                    // Check if installed
                    if (!\Composer\InstalledVersions::isInstalled($module->url)) {
                        \Artisan::call("module:install", ['name' => $module->url]);
                    }
                    foreach ($output as $o) {
                        if ($o->name == $module->url) {
                            $module->sha = $o->latest;
                            $module->save();   
                        } 
                    }
                }
            }
        }
        return redirect($comingFrom);
    }

    private function isUrl($url){
        return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
    }

    private function checkOutdatedPackages(){
        $process = Process::fromShellCommandline(sprintf(
            'cd %s && composer outdated --format=json',
            base_path()
        ), null, ['COMPOSER_HOME' => getenv('COMPOSER_HOME')]);
        $process->setTimeout(240);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = json_decode($process->getOutput());    
        return $output->installed;
    }

    private function updatePackage($module){
        $process = Process::fromShellCommandline(sprintf(
            'cd %s && composer update %s',
            base_path(),
            $module->url
        ), null, ['COMPOSER_HOME' => getenv('COMPOSER_HOME')]);
        $process->setTimeout(240);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = json_decode($process->getOutput());    
        return $output;
    }

}