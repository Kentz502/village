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
                    <tbody>
                        @foreach ($residents as $item)
                        <tr>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->birth_place }}, {{ $item->birth_date }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->marital_status }}</td>
                            <td>{{ $item->occupation }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item-status }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="/resident/{{ item->id }}" class="d-inline-block mr-2 btn btn-sm btn-warning mr-2">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="/resident/{{ item->id }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-eraser"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
