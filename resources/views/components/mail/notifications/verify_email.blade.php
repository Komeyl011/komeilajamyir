@extends('components.mail.layout')

@section('content')
    {{-- Email header --}}
    @if(!isset($header))
        <h1 class="notification_header">@lang("mail.notification.header")</h1>
    @else
        <h1 class="notification_header">{{ $header }}</h1>
    @endif
    {{-- Email main content --}}
    @if(!isset($content))
        <p class="notification_content">@lang('mail.notification.request_recieved')</p>
    @else
        <p class="notification_content">{{ $content }}</p>
    @endif
    {{-- Email action btn --}}
    @if(isset($action_btn))
        @include('components.mail.action_btn')
    @endif
@endsection
