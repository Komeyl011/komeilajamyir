<section class="flex flex-col justify-start items-center w-full h-screen bg-gray-300">
    <h1 class="my-5 text-xl font-bold">S3 Controller User Interface</h1>

    @if(session('success'))
        <div class="text-green-500">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="text-red-400">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="uploadFile()" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" wire:model="upload_file">
        <button type="submit" class="bg-green-400 px-4 py-2 text-white rounded hover:bg-green-500">Upload File</button>
        @error('upload_file')
            <div class="text-red-400 mt-2">{{ $message }}</div>
        @enderror
    </form>

    <form wire:submit.prevent="makeDir()" method="post" class="my-5">
        @csrf
        <input type="text" wire:model="make_dir" placeholder="Enter directory name"
            class="px-4 py-2 mr-5 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 placeholder-gray-400">
        <button type="submit" class="bg-green-400 px-4 py-2 text-white rounded hover:bg-green-500">Make Directory</button>
    </form>

    {{-- <form action="{{ route('show.objects') }}" method="post" style="margin-top: 20px;">
        @csrf
        <button type="submit">Show Objects</button>
    </form> --}}

    @if(isset($files) && count($files) > 0)
        <ul class="w-full px-4">
            @foreach($files['dirs'] as $dir)
                <li class="w-full bg-white border border-gray-500 my-3 p-4 rounded-lg flex justify-between items-center">
                    <span class="flex justify-center items-center">
                        <i class="fa-solid fa-folder mr-5 text-cyan-500 text-lg"></i>
                        <a href="#" class="hover:underline">{{ $dir['name'] }}</a>
                    </span>
                    <div>
                        <button wire:click="deleteDir('{{ $dir['name'] }}')" class="bg-red-400 px-4 py-2 text-white rounded hover:bg-red-500">Delete</button>
                    </div>
                </li>
            @endforeach
            @foreach ($files['files'] as $file)
                <li class="w-full bg-white border border-gray-500 my-3 p-4 rounded-lg flex justify-between items-center">
                    <span class="flex justify-center items-center"><i class="fa-solid fa-file mr-5 text-green-400 text-lg"></i>{{ $file['name'] }}</span>
                    <div>
                        <button wire:click="downloadFile('{{ $file['name'] }}')" class="bg-green-400 px-4 py-2 text-white rounded hover:bg-green-500">Download</button>
                        <button wire:click="deleteFile('{{ $file['name'] }}')" type="submit" class="bg-red-400 px-4 py-2 text-white rounded hover:bg-red-500">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</section>
