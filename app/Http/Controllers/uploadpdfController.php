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

          
            $path = $request->file('pdf')->store();

            
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

    public function download($id)
{   

    $user = Auth::user();
    if(!$user){
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    $file = DB::table('files')->where('id',$id)->first();

    $url = Storage::download($file->file_path);

    return Storage::download($file->file_path);
    // return response()->json(['url' => $url], 200);

}




}
