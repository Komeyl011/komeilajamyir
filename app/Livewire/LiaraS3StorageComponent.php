<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class LiaraS3StorageComponent extends Component
{
    use WithFileUploads;

    public array $files;
    public $upload_file;
    public string $make_dir;

    public function mount()
    {
        $this->loadFiles();
    }

    #[Layout('components.layouts.chatbot')]
    public function render()
    {
        return view('liara.storage.userinterface');
    }

    public function uploadFile()
    {
        $this->validate([
            'upload_file' => 'required|max:2048', // 2MB limit
        ]);
        // dd($this->upload_file);

        $uploaded = $this->upload_file->store('', 'liara');

        if ($uploaded) {
            session()->flash('success', 'File uploaded successfully');
        } else {
            session()->flash('error', 'There was an error while uploading the file');
        }

        // Reload files after upload
        $this->loadFiles();
    }

    public function makeDir()
    {
        $this->validate([
            'make_dir' => 'required|max:2048',
        ]);

        $made = Storage::disk('liara')->makeDirectory($this->make_dir);

        if ($made)
            session()->flash('success', 'Directory has been created successfully');
        else
            session()->flash('error', 'Something went wrong');

        $this->loadFiles();
    }

    public function downloadFile($download_file)
    {
        return Storage::disk('liara')->download($download_file);
    }

    public function deleteFile($delete_file)
    {
        // dd(Storage::disk('liara')->delete($delete_file));
        if (Storage::disk('liara')->delete($delete_file))
            session()->flash('success', 'File deleted successfully');
        else
            session()->flash('error', 'Something went wrong');

        $this->loadFiles();
    }

    public function deleteDir($delete_dir)
    {
        dd(Storage::disk('liara')->delete($delete_dir));
        if (Storage::disk('liara')->deleteDirectory($delete_dir))
            session()->flash('success', 'Directory deleted successfully');
        else
            session()->flash('error', 'Something went wrong');

        $this->loadFiles();
    }

    public function loadFiles()
    {
        // Reset the property on each call
        $this->files = [];

        $directories = Storage::disk('liara')->allDirectories('');
        $objects = Storage::disk('liara')->allFiles('');

        // Get all directories
        foreach ($directories as $dir) {
            $this->files['dirs'][] = [
                'name' => $dir,
            ];
        }

        // Get all objects(files)
        foreach ($objects as $object) {
            $this->files['files'][] = [
                'name' => $object,
                'download_link' => Storage::disk('liara')->temporaryUrl($object, now()->addMinutes(5)),
            ];
        }

        // dd($this->files);

        // return view('liara.storage.userinterface', ['files' => $files]);
        return $this->files;
    }
}
