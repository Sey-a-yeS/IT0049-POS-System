@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero" aria-labelledby="home-title">
    <div class="hero-copy"><p class="eyebrow">THE RETAIL DESK / 01</p><h1 id="home-title">A clearer view of the people behind every sale<span class="accent">.</span></h1><p class="lede">Counterpoint is a small point-of-sale demonstration built in Laravel. Browse the customer and staff account directories, now backed by Eloquent.</p><div class="hero-actions"><a class="button button-primary" href="{{ route('customers.index') }}">Explore customers <span aria-hidden="true">↗</span></a><a class="button button-secondary" href="{{ route('users.index') }}">View staff accounts</a></div></div>
    <div class="hero-note" aria-label="Project scope"><span class="note-index">IT0049 / TFA6</span><div class="record-lines"><span></span><span></span><span></span><span></span><span></span></div><p><strong>Four pages.</strong><br>One familiar MVC pattern.<br>Real database records.</p><span class="note-footer">BUILT FOR LEARNING · 2026</span></div>
</section>
<section class="home-links" aria-label="Account directories"><a href="{{ route('customers.index') }}"><span class="eyebrow">DIRECTORY 01</span><strong>Customer Accounts</strong><span>Five fictional customer records <span aria-hidden="true">↗</span></span></a><a href="{{ route('users.index') }}"><span class="eyebrow">DIRECTORY 02</span><strong>User Accounts</strong><span>Five fictional POS staff records <span aria-hidden="true">↗</span></span></a></section>
@endsection
