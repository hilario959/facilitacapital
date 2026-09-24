@extends('site.layout')

@section('content')
    @include('site.partials.nav')
    <main>
        @include('site.partials.hero')
        @include('site.partials.problem')
        @include('site.partials.benefits')
        @include('site.partials.steps')
        @include('site.partials.cases')
        @include('site.partials.calculator')
        @include('site.partials.qualify')
    </main>
    @include('site.partials.footer')
    <div class="mobile-cta">
        <a class="btn btn-primary btn-block" href="#calculadora">{{ $site['mobile_cta'] }}</a>
    </div>
@endsection
