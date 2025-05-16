<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiaraS3StroageController extends Controller
{
    public function showUserInterface()
    {
        return view('liara.storage.userinterface', ['files' => $this->showObjects()]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'upload_file' => 'required|max:2048', // Adjust the file size validation as needed
        ]);

        $file = $request->file('upload_file');
        $fileName = $file->getClientOriginalName();

        $uploaded = Storage::disk('liara')->put($fileName, file_get_contents($file));

        if($uploaded)
          return redirect()->route('user.interface')->with('success', 'File uploaded successfully');
        else
          return redirect()->route('user.interface')->with('error', 'Something went wrong');

    }

    public function makeDir(Request $request)
    {
        $request->validate([
            'make_dir' => 'required|max:2048',
        ]);

        $dir = $request->input('make_dir');

        $made = Storage::disk('liara')->makeDirectory($dir);

        return $made
            ? redirect()->route('user.interface')->with('success', 'Directory has been created successfully')
            : redirect()->route('user.interface')->with('error', 'Something went wrong');
    }

    private function showObjects()
    {
        $directories = Storage::disk('liara')->allDirectories('');
        $objects = Storage::disk('liara')->allFiles('');

        $files = [];

        // Get all directories
        foreach ($directories as $dir) {
            $files['dirs'] = [
                'name' => $dir,
            ];
        }

        // Get all objects(files)
        foreach ($objects as $object) {
            $files['files'] = [
                'name' => $object,
                'download_link' => Storage::disk('liara')->temporaryUrl($object, now()->addMinutes(5)),
            ];
        }

        // dd($files);

        // return view('liara.storage.userinterface', ['files' => $files]);
        return $files;
    }


    public function downloadFile(Request $request)
    {
        $fileName = $request->input('download_file');
        return Storage::disk('liara')->download($fileName);
    }

    public function deleteFile(Request $request)
    {
        $fileName = $request->input('delete_file');
        Storage::disk('liara')->delete($fileName);

        return redirect()->route('user.interface')->with('success', 'File deleted successfully');
    }

    public function deleteDir(Request $request)
    {
        $dirName = $request->input('delete_dir');
        Storage::disk('liara')->delete($dirName);

        return redirect()->route('user.interface')->with('success', 'Directory deleted successfully');
    }
}
