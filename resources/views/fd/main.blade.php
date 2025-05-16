@push('style')
<style>
    #description_wrapper ul {
        list-style: disc;
    }
</style>
@endpush
<section dir='ltr' class="my-24 flex flex-col justify-around items-center">
    @if($show_table)
        <table class="w-3/4 border-collapse border border-gray-300 shadow-md rounded-lg bg-white table-auto lg:table-fixed">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 text-center py-2 text-center w-12">#</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Topic</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Type</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($topics as $index => $topic)
                    <tr>
                        <td class="border border-gray-300 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic['name'] }}</td>
                        <td class="border border-gray-300 pl-8 pr-5 py-2">
                            <div id="description_wrapper">
                                {!! $topic['description'] !!}
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $allowed_types[$topic['type']] }}</td>
                        <td class="border border-gray-300 py-2">
                            <div class="flex justify-around items-center">
                                <button type="button" wire:click="delete({{ $topic['id'] }})">@svg('heroicon-c-x-circle', ['class' => 'text-red-500 w-8 h-8'])</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Empty!</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="px-4 py-2">{{ $topics->links() }}</td>
                </tr>
            </tfoot>
        </table>
        @session('del_success')
            <div class="mt-5">
                <p class="text-red-500 text-lg">{{ session('del_success') }}</p>
            </div>
        @endsession
        <div class="w-3/4 mt-10 flex flex-col">
            <h4 class="text-2xl font-extrabold">Add topic</h4>
            <div class="w-full">
                <form wire:submit.prevent="add()" method="POST" class="bg-white p-6 shadow-md rounded-lg">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Topic Name</label>
                        <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        @error('name')
                            <div>
                                <p class="text-red-500">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4" wire:ignore>
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea id="description" wire:model="description" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                        @error('description')
                            <div>
                                <p class="text-red-500">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                        <select id="type" wire:model="type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            @php $counter = 1; @endphp
                            @foreach ($allowed_types as $key => $value)
                                <option value="{{ $key }}" {{ $counter === 1 ? 'default' : '' }}>{{ $value }}</option>
                                @php $counter++ @endphp
                            @endforeach
                        </select>
                        @error('type')
                            <div>
                                <p class="text-red-500">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    @session('success')
                        <div>
                            <p class="text-green-500">{{ session('success') }}</p>
                        </div>
                    @endsession

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Add Topic</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <form wire:submit.prevent="auth()" method="post">
            @csrf
            <div class="mb-4">
                <label for="token" class="block text-gray-700 font-medium mb-2">Enter code</label>
                <input type="text" id="token" wire:model="token" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Submit</button>
            </div>
        </form>
    @endif
    {{-- toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist outdent indent | link image | alignleft aligncenter alignright alignjustify | removeformat | help', --}}
</section>
@push('javascript')
    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/ac5legsdxzxv4f1y8z6cr1iagnvif0hktwy2m4wcp5m15rtw/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initTinyMCE(); // Initialize on page load

            window.addEventListener('tinymce:reinit', function () {
                setTimeout(initTinyMCE, 300); // Small delay to ensure DOM updates
            });

            function initTinyMCE() {
                tinymce.remove(); // Remove previous instances

                setTimeout(() => {
                    if (document.getElementById('description')) { // Ensure textarea exists
                        tinymce.init({
                            selector: '#description',
                            plugins: 'lists link image table code help wordcount',
                            toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist outdent indent | removeformat | help',
                            menubar: false,
                            height: 300,
                            setup: function (editor) {
                                editor.on('change', function () {
                                    @this.set('description', editor.getContent());
                                });
                            }
                        });
                    }
                }, 100); // Delay to avoid race conditions
            }
        });
    </script>
@endpush