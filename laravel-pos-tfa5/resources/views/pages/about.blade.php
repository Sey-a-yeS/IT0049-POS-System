@extends('layouts.app')

@section('title', 'About')

@section('content')
<section class="page-heading"><p class="eyebrow">THE PROJECT / 02</p><h1>About Counterpoint<span class="accent">.</span></h1><p class="lede">A focused rebuild of the original four-page POS exercise, now using Laravel.</p></section>
<div class="about-grid"><section class="paper-panel"><h2>Why it exists</h2><p>Counterpoint was developed for IT0049 Technical Formative Assessments 5 and 6 by Isaiah Ezekiel P. Vicencio. It demonstrates a landing page, an About page, and two account directories.</p><p>The directories are examples for learning. Names and contact details are fictional; this site does not process sales or hold real customer accounts.</p></section><section class="paper-panel"><h2>How it works</h2><p>Laravel routes call controller methods. TFA5 used local PHP arrays; TFA6 replaces them with migrations, a seeder, and Customer and User Eloquent models. The controllers retrieve database records and pass them to Blade views, which render them with <code>@@foreach</code>.</p><p>The account pages now require a configured database. The project remains focused on Laravel MVC, without authentication or sales features.</p></section></div>
@endsection
