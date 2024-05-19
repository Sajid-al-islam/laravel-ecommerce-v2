<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function get()
    {
        return Setting::first();
    }
    public function update()
    {
        $setting = Setting::first();
        $key = request()->key;
        if(request()->hasFile($key)){
            $file = request()->file($key);
            if($setting->$key && file_exists(public_path().'/'.$setting->$key)){
                unlink(public_path().'/'.$setting->$key);
            }
            $setting->$key = Storage::put('uploads/settings', $file);
        }else{
            $setting->$key = request()->get($key);
        }

        $setting->save();

        return response()->json($setting);
    }
}
