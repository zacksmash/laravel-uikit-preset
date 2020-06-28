<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
  </head>

  <body>
    <nav class="uk-navbar-container" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="#">Logo</a>
      </div>

      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          @guest
            <li>
              <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>

            @if (Route::has('register'))
              <li>
                <a href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li>
              <a href="#">{{ Auth::user()->name }} <span uk-icon="triangle-down"></span></a>
              <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                  <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </nav>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
