@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Account Request</h1>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif

     <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div style="overflow-x: auto;">
                    <table class="table table-bordered table-hover" style="min-width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if (count($users) < 1)
                        <tbody>
                            <tr>
                                <td colspan="11">
                                    <p class="pt-3 text-center">No Data Found</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <div class="d-flex" style="gap: 10px">
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                        Reject
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                        Approve
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @include('pages.account-request.confirmation-approve')
                        @include('pages.account-request.confirmation-reject')
                        @endforeach
                    </tbody>
                    @endif
                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
