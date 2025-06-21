@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Residence</h1>
        <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> Add Data </a>
    </div>

     <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Birth Date & Place</th>
                            <th>Address</th>
                            <th>Marital Status</th>
                            <th>Occupation</th>
                            <th>Phone</th>
                            <th>Residence Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if (count($residents) < 1)
                        <tbody>
                            <tr>
                                <td colspan="11">
                                    <p class="pt-3 text-center">No Data Found</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                        @foreach ($residents as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->birth_place }}, {{ $item->birth_date }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->marital_status }}</td>
                            <td>{{ $item->occupation }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <a href="/resident/{{ $item->id }}" class="d-inline-block mr-2 btn btn-sm btn-warning mr-2">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                    @if (!is_null($item->user_id))
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailAccount-{{ $item->id }}">
                                        Check Account
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @include('pages.resident.confirmation-delete')
                        @include('pages.resident.detail-account')
                        @endforeach
                    </tbody>
                    @endif
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
