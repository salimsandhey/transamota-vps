<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        // Get the current admin email from config
        $adminEmail = config('mail.from.address', 'admin@example.com');
        
        return view('admin.settings.index', compact('adminEmail'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email|max:255',
        ]);

        // Update the .env file
        $this->updateEnvFile('MAIL_FROM_ADDRESS', $request->admin_email);

        return back()->with('success', 'Settings updated successfully!');
    }

    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        
        if (File::exists($path)) {
            $content = File::get($path);
            
            // Check if key exists
            if (strpos($content, $key) !== false) {
                // Update existing key
                $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
            } else {
                // Add new key
                $content .= "\n{$key}={$value}";
            }
            
            File::put($path, $content);
        }
    }
}
