<form action="{{ route('language.change') }}" method="post">
    @csrf
    <select onchange="this.form.submit()" name="lang"
        class="block w-30 mt-1 p-2 border border-gray-300 bg-gray-800 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        {{--    <option value="" disabled selected>Select a language</option>--}}
        <option value="en" {{ app()->currentLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="fa" dir="rtl" {{ app()->currentLocale() == 'fa' ? 'selected' : '' }}>فارسی</option>
    </select>
</form>
