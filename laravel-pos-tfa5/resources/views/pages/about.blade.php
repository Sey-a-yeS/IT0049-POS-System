@extends('layouts.app')

@section('title', 'About')

@section('content')
<section class="page-heading"><p class="eyebrow">THE PROJECT / 02</p><h1>About Counterpoint<span class="accent">.</span></h1><p class="lede">A focused rebuild of the original four-page POS exercise, now using Laravel.</p></section>
<div class="about-grid"><section class="paper-panel"><h2>Why it exists</h2><p>Counterpoint was developed for IT0049 Technical Formative Assessment 5 by Isaiah Ezekiel P. Vicencio. It demonstrates a landing page, an About page, and two account directories.</p><p>The directories are examples for learning. Names, contact details, and account states are fictional; this site does not process sales or hold real customer accounts.</p></section><section class="paper-panel"><h2>How it works</h2><p>Laravel routes call controller methods. Those controllers select Blade views and provide their data. The Customer and User controllers each define a local PHP array of five records; the views render them with <code>@@foreach</code>.</p><p>No database connection is required for these four pages. This keeps the assessment centered on routes, controllers, views, and the MVC responsibilities shared with CodeIgniter.</p></section></div>
@endsection
