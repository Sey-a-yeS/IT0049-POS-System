@extends('layouts.app')

@section('title', 'Customer Accounts')

@section('content')
<section class="page-heading"><p class="eyebrow">DIRECTORY / 03</p><div class="heading-row"><div><h1>Customer Accounts<span class="accent">.</span></h1><p class="lede">A sample retail customer directory supplied by the controller.</p></div><span class="count-label">{{ count($customers) }} RECORDS</span></div></section>
<section class="directory-panel" aria-labelledby="customer-table-title"><div class="panel-heading"><div><p class="eyebrow">ACCOUNT REGISTER</p><h2 id="customer-table-title">Customer directory</h2></div><span>STATIC SAMPLE DATA</span></div><div class="table-scroll" tabindex="0" role="region" aria-label="Customer accounts table; scroll horizontally on small screens"><table><thead><tr><th scope="col">Customer ID</th><th scope="col">Full name</th><th scope="col">Email</th><th scope="col">Phone</th><th scope="col">Date joined</th></tr></thead><tbody>@foreach($customers as $customer)<tr><td class="mono">{{ $customer['id'] }}</td><td><strong>{{ $customer['full_name'] }}</strong></td><td><a href="mailto:{{ $customer['email'] }}">{{ $customer['email'] }}</a></td><td>{{ $customer['phone'] }}</td><td>{{ $customer['joined'] }}</td></tr>@endforeach</tbody></table></div></section>
@endsection
