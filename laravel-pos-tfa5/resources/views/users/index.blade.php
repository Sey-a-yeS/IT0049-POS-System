@extends('layouts.app')

@section('title', 'User Accounts')

@section('content')
<section class="page-heading">
    <p class="eyebrow">DIRECTORY / 04</p>
    <div class="heading-row">
        <div>
            <h1>User Accounts<span class="accent">.</span></h1>
            <p class="lede">Fictional point-of-sale staff accounts retrieved through Eloquent.</p>
        </div>
        <span class="count-label">{{ $users->count() }} RECORDS</span>
    </div>
</section>
<section class="directory-panel" aria-labelledby="user-table-title">
    <div class="panel-heading">
        <div><p class="eyebrow">TEAM REGISTER</p><h2 id="user-table-title">Staff directory</h2></div>
        <span>DATABASE RECORDS</span>
    </div>
    <div class="table-scroll" tabindex="0" role="region" aria-label="User accounts table; scroll horizontally on small screens">
        <table>
            <thead><tr><th scope="col">User ID</th><th scope="col">Username</th><th scope="col">Full name</th></tr></thead>
            <tbody>
                @if($users->isEmpty())
                    <tr><td colspan="3">No user accounts are available yet.</td></tr>
                @else
                    @foreach($users as $user)
                        <tr>
                            <td class="mono">{{ $user->id }}</td>
                            <td class="mono">{{ $user->username }}</td>
                            <td><strong>{{ $user->full_name }}</strong></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</section>
@endsection
