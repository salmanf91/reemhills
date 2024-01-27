@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="inner-page-head">Manage Resale Requests </h2>

                <div class="card">
                    <div class="card-header">
                        <div class="card-essentials d-flex align-items-center">
                            {{-- <div>
                                <select wire:model="perPage" id="perPage">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                                <label for="perPage" class="ml-2"> Entries </label>
                            </div>
                            <div class="ml-auto">
                                <input wire:model="search" class="card-search" type="text" placeholder="Search...">
                            </div> --}}
                        </div>
                    </div>


                    <div class="card-body">
                        <!-- Your custom datatable code goes here -->
                        <table class="table">
                            <!-- Table headers -->
                            <thead class="card-thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Project</th>
                                    <th>Phase</th>
                                    <th>Unit No</th>
                                    <th>Buyer Type</th>
                                    <th>Action</th>
                                    <!-- Add more headers as needed -->
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody>
                                @foreach ($buyers as $buyer)
                                    <tr class="{{ $buyer->is_primary_buyer ? 'primary-buyer-row' : '' }}">
                                        <td>{{ $buyer->buyer_id }}</td>
                                        <td>{{ $buyer->buyers_name }}</td>
                                        <td>{{ $buyer->email_id }}</td>
                                        <td>{{ $buyer->project }}</td>
                                        <td>{{ $buyer->phase }}</td>
                                        <td>{{ $buyer->unit_no }}</td>
                                        <td>
                                            {{ $buyer->buyer_type == 1 ? 'National' : ($buyer->buyer_type == 2 ? 'International' : 'Company' ) }}
                                        </td>
                                        <td>
                                            @if($buyer->is_primary_buyer)
                                                <a href="{{ route('buyer.details', ['id' => $buyer->buyer_id]) }}" class="btn btn-info">View Details</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- @livewire('pagination') --}}
                        {{-- @livewire('pagination') --}}
                    </div>

                    <div class="float-right">
                        {{ $buyers->links('pagination::bootstrap-4') }}
                    </div>

                    {{-- <div class="card-footer">
                        <div class="float-left">
                            {{ $data->links() }}
                        </div>
                        <div class="float-right">
                            <!-- Add pagination controls (left arrow, page number, right arrow) -->
                            {{ $data->links() }}
                        </div>
                    </div> --}}
                </div>

            </div>
        </div>
    </div>
@endsection
