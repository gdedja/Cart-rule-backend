@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    <div class="flex">
        <!-- BEGIN: Content -->
        <div class="wrapper">
            @include('../layout/components/top-bar')
            <div class="content">
                @yield('subcontent')
            </div>
        </div>
        <!-- END: Content -->
    </div>
@endsection
