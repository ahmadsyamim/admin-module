@if (class_exists('Theme') && Theme::exists(Theme::get()))
    @include(Theme::get().".modules.auth.login")
@else
    @include('voyager-frontend::modules.auth.login')
@endif