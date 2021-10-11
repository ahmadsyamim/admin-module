@if (class_exists('Theme') && Theme::exists(Theme::get()))
    @include(Theme::get().".modules.auth.register")
@else
    @include('voyager-frontend::modules.auth.register')
@endif