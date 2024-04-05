<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class uploadpdfController extends Controller
{
    //
    public function uploadpdf(Request $request) {
        
        $user = Auth::user();
        $guestId = $user->guest_token;

        if ($user || $guestId) {
            $request->validate([
                'pdf' => 'required|mimes:pdf|max:2048' // Adjust file size as needed
            ]);

            // Save file to storage/app/files directory
            $path = $request->file('pdf')->store('files');

            
            DB::table('files')->insert([
                'user_id' => $user ? $user->id : null,
                'guest_id' => $guestId,
                'file_name' => $request->file('pdf')->getClientOriginalName(),
                'file_path' => $path,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['message' => 'File uploaded successfully'], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function show($filename)
{
    $path = storage_path('app/files/' . $filename);

    if (!Storage::exists($path)) {
        abort(404);
    }

    return response()->file($path);
}




}
