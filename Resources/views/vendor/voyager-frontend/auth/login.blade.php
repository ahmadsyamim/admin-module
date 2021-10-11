@if (class_exists('Theme') && Theme::exists(Theme::get()) && View::exists(Theme::get().".modules.auth.login"))
    @include(Theme::get().".modules.auth.login")
@else
    @include('voyager-frontend::modules.auth.login')
@endif