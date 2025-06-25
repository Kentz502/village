@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN ? 'Report' : 'Complaint' }}</h1>
        @if (isset(auth()->user()->resident))
        <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> Add Report </a>
        @endif
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

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error",
                text: "{{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif

     <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                <th>Resident Name</th>
                                @endif
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Photo Proof</th>
                                <th>Report Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @if (count($complaints) < 1)
                            <tbody>
                                <tr>
                                    <td colspan="11">
                                        <p class="pt-3 text-center">No Data Found</p>
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                            @foreach ($complaints as $item)
                            <tr>
                                <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                <td>{{ $item->resident->name }}</td>
                                @endif
                                <td>{{ $item->title }}</td>
                                <td>{!!  wordwrap($item->content, 50, "<br>\n") !!}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status_color }}">{{ $item->status_label }}</span>
                                </td>
                                <td>
                                @if (isset($item->photo_proof))
                                @php
                                    $filePath = 'storage/' . $item->photo_proof;
                                @endphp
                                    <a href="{{ $filePath }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $filePath }}" alt="Photo Proof" style="max-width: 300px">
                                    </a>
                                @else
                                    No Photo
                                @endif</td>
                                <td>{{ $item->report_date_label }}</td>
                                <td>
                                    @if (auth()->user()->role_id == \App\Models\Role::ROLE_USER && isset(auth()->user()->resident) && $item->status == 'new')
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <a href="/complaint/{{ $item->id }}" class="d-inline-block mr-2 btn btn-sm btn-warning mr-2">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </div>
                                    @elseif (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                    <div>
                                        <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div>
                                            <select name="status" id="status" class="form-control" style="min-width: 150px" oninput="document.getElementById('formChangeStatus-{{ $item->id }}').submit()">
                                                @foreach ([
                                                    (object) [
                                                        'label' => 'New',
                                                        'value' => 'new',
                                                    ],
                                                (object) [
                                                        'label' => 'Processing',
                                                        'value' => 'processing',
                                                    ],
                                                (object) [
                                                        'label' => 'Completed',
                                                        'value' => 'completed',
                                                    ],
                                                ] as $status)
                                                    <option value="{{ $status->value }}" @selected($item->status == $status->value)>{{ $status->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @include('pages.complaint.confirmation-delete')
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
                @if ($complaints->lastPage() > 1)
                <div class="card-footer">
                    {{ $residents->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
