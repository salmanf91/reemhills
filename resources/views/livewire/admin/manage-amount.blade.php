@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="inner-page-head">Manage Amount </h2>

            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" wire:submit.prevent="submit">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="buyers_name">Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" wire:model="amount" placeholder="Enter amount" id="amount" name="amount" class="form-control ">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-submit">Save</button>
                                {{-- @if (session()->has('message'))
                                    <div>{{ session('message') }}</div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
