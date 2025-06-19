@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registered Residence Account</h1>
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
                            <th>Status</th>
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
                                @if ($item->status == 'approved')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Non-Active</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex" style="gap: 10px">
                                @if ($item->status == 'approved')
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                        Deactivate Account
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                        Activate Account
                                    </button>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @include('pages.account-list.confirmation-approve')
                        @include('pages.account-list.confirmation-reject')
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
