<form action="{{ route('language.change') }}" method="post"
        class="wrapper {!! app()->getLocale() === 'fa' ? 'flex-row-reverse' : 'flex-row' !!}">
    @csrf
    <input onchange="this.form.submit()" type="radio" name="lang" id="en" value="en" {!! app()->getLocale() === 'en' ? 'checked' : '' !!}>
    <input onchange="this.form.submit()" type="radio" name="lang" id="farsi" value="fa" {!! app()->getLocale() === 'fa' ? 'checked' : '' !!}>
    <label for="en" class="option en hover:cursor-pointer">
        <div class="dot"></div>
        <span>{!! __('langbtn.english') !!}</span>
    </label>
    <label for="farsi" class="option farsi hover:cursor-pointer">
        <div class="dot"></div>
        <span>{!! __('langbtn.persian') !!}</span>
    </label>
</form>