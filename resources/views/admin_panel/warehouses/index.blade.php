@extends('admin_panel.layout.app')
@section('content')
    <style>
        .type-badge-shop {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            color: #fff;
            border-radius: 6px;
            padding: 3px 10px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .03em;
        }
        .type-badge-warehouse {
            background: linear-gradient(135deg, #0891b2, #0369a1);
            color: #fff;
            border-radius: 6px;
            padding: 3px 10px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .03em;
        }
    </style>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="container-fluid">

                <div class="page-header row">
                    <div class="page-title col-lg-6">
                        <h4>Locations — Shops &amp; Warehouses</h4>
                        <h6>Manage all stock locations: Shops (Retail) and Warehouses (Storage)</h6>
                    </div>
                    <div class="page-btn d-flex justify-content-end col-lg-6 gap-2">
                        @can('warehouse.create')
                            <button class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="#warehouseModal"
                                onclick="clearWarehouse()">
                                <i class="las la-plus-circle me-1"></i> Add Location
                            </button>
                        @endcan
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Created By</th>
                                    @if (auth()->user()->hasRole('Super Admin'))
                                        <th>Branch</th>
                                    @endif
                                    <th>Name</th>
                                    <th>Location / Address</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $key => $w)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($w->type === 'shop')
                                                <span class="type-badge-shop">🏪 Shop</span>
                                            @else
                                                <span class="type-badge-warehouse">🏭 Warehouse</span>
                                            @endif
                                        </td>
                                        <td>{{ $w->user->name ?? 'N/A' }}</td>
                                        @if (auth()->user()->hasRole('Super Admin'))
                                            <td>{{ $w->branch->name ?? ('Branch #' . $w->branch_id) }}</td>
                                        @endif
                                        <td>{{ $w->warehouse_name }}</td>
                                        <td>{{ $w->location ?? '—' }}</td>
                                        <td>{{ $w->remarks ?? '—' }}</td>
                                        <td>
                                            @can('warehouse.edit')
                                                @if($w->type !== 'shop')
                                                    <button class="btn btn-primary btn-sm edit-warehouse-btn"
                                                        data-id="{{ $w->id }}"
                                                        data-name="{{ $w->warehouse_name }}"
                                                        data-location="{{ $w->location }}"
                                                        data-remarks="{{ $w->remarks }}"
                                                        data-branch="{{ $w->branch_id }}"
                                                        data-type="{{ $w->type }}"
                                                        data-toggle="modal"
                                                        data-target="#warehouseModal">
                                                        Edit
                                                    </button>
                                                @else
                                                    <span class="text-muted small">Auto-managed</span>
                                                @endif
                                            @endcan
                                            @can('warehouse.delete')
                                                @if($w->type !== 'shop')
                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                        data-url="{{ url('warehouse/delete/' . $w->id) }}"
                                                        data-msg="Are you sure you want to delete this warehouse?" data-method="get"
                                                        onclick="logoutAndDeleteFunction(this)">
                                                        Delete
                                                    </button>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="warehouseModal">
        <div class="modal-dialog">
            <form action="{{ url('warehouse/store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="warehouse_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add / Edit Warehouse</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-600">Location Type</label>
                            <select class="form-control" name="type" id="wh_type" required>
                                <option value="warehouse">🏭 Warehouse (Storage)</option>
                                <option value="shop">🏪 Shop (Retail)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <input class="form-control" name="warehouse_name" id="warehouse_name"
                                placeholder="Name" required>
                        </div>
                        <div class="mb-2 d-none">
                            <input class="form-control" name="creater_id" id=""
                                value="{{ Auth()->user()->id }}" placeholder="Name" required>
                        </div>
                        @if (auth()->user()->hasRole('Super Admin'))
                            <div class="mb-2">
                                <select class="form-control" name="branch_id" id="branch_id" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="mb-2">
                            <input class="form-control" name="location" id="location"
                                placeholder="Physical location / address">
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @canany(['warehouse.create', 'warehouse.edit'])
                            <button class="btn btn-primary">Save</button>
                        @endcanany
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
