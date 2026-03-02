@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">✉️ Send Invitation</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Add more people to your shared household.</p>
    </div>
</div>

<div class="card" style="max-width: 600px; margin: 2rem auto;">
    <form action="{{ route('invitations.store') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="colocation_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">House/Colocation</label>
            <select name="colocation_id" id="colocation_id" class="form-control" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                @foreach($colocations as $colocation)
                    <option value="{{ $colocation->id }}" {{ request('colocation_id') == $colocation->id ? 'selected' : '' }}>
                        {{ $colocation->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Member Email</label>
            <input type="email" name="email" id="email" class="form-control" required placeholder="example@coloc.com" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
            <small style="color: var(--text-light); display: block; margin-top: 0.5rem;">The person must already have an account.</small>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">SEND INVITATION</button>
            <a href="{{ url()->previous() }}" class="btn" style="flex: 1; justify-content: center; background: var(--bg); border: 1px solid var(--border);">CANCEL</a>
        </div>
    </form>
</div>
@endsection
