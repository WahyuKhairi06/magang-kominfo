<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ChatbotSetting;
use Illuminate\Support\Facades\Storage;

class ChatbotSettingController extends Controller
{
    public function index()
    {
        $setting = ChatbotSetting::firstOrCreate(['id' => 1], [
            'ai_name' => 'Asisten Puskesmas',
            'puskesmas_display_name' => 'Puskesmas Marunggi',
            'greeting_message' => 'Halo! Saya adalah Asisten Virtual. Ada yang bisa saya bantu hari ini?',
            'primary_color' => '#1e6b4d',
            'status' => 'active',
        ]);

        return view('admin.chatbot-setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = ChatbotSetting::first();

        $request->validate([
            'ai_name' => 'required|string|max:100',
            'puskesmas_display_name' => 'required|string|max:150',
            'greeting_message' => 'nullable|string',
            'primary_color' => 'required|string|max:20',
            'logo_chatbot' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except(['_token', '_method', 'logo_chatbot']);

        if ($request->hasFile('logo_chatbot')) {
            // Delete old file if exists
            if ($setting->logo_chatbot && file_exists(public_path($setting->logo_chatbot))) {
                unlink(public_path($setting->logo_chatbot));
            }

            $file = $request->file('logo_chatbot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/chatbot'), $filename);
            $data['logo_chatbot'] = 'uploads/chatbot/' . $filename;
        }

        $setting->update($data);

        return redirect()->route('chatbot-setting.index')->with('success', 'Pengaturan Chatbot berhasil diperbarui!');
    }
}
