@extends('admin_panel.layout.app')
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_length select {
            width: 75px !important
        }
        .btn-xs {
            padding: 2px 7px;
            font-size: 0.72rem;
            line-height: 1.4;
            border-radius: 4px;
        }
        /* More Dropdown Styling */
        .more-btn {
            padding: 5px 12px;
            font-size: 0.78rem;
            font-weight: 600;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #475569;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .more-btn:hover, .more-btn.active, .more-btn[aria-expanded="true"] {
            background: #4f46e5 !important;
            color: #ffffff !important;
            border-color: #4f46e5 !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
        }
        .more-dropdown-menu {
            display: none;
            min-width: 180px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            padding: 6px;
            background: #ffffff;
            z-index: 10050 !important;
            list-style: none;
            margin: 0;
        }
        .more-dropdown-menu.show {
            display: block !important;
        }
        .more-dropdown-menu .dropdown-item {
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.83rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            transition: background 0.15s ease, color 0.15s ease;
            text-decoration: none;
        }
        .more-dropdown-menu .dropdown-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .more-dropdown-menu .dropdown-item .di-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        /* Hide DataTables default search - we use custom */
        .dataTables_filter { display: none !important; }
        /* Fix horizontal scroll */
        #productTable { width: 100% !important; }
        #productTable thead th {
            white-space: nowrap;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            padding: 10px 8px;
        }
        #productTable tbody td {
            font-size: 0.82rem;
            padding: 8px 8px;
            vertical-align: middle;
            border-color: #f3f4f6;
        }
        #productTable tbody tr:hover {
            background: #f8faff;
        }
        .product-search-bar {
            position: relative;
        }
        .product-search-bar .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.9rem;
        }
        .product-search-bar input {
            padding-left: 36px;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            font-size: 0.85rem;
            height: 38px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .product-search-bar input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .table-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0;
        }
        .product-count-badge {
            background: #ede9fe;
            color: #6d28d9;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }
    </style>




    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <!-- Card Header -->
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center" style="padding: 14px 20px;">
            <div class="d-flex align-items-center gap-2">
                <div style="width:38px;height:38px;background:#ede9fe;border-radius:10px;display:grid;place-items:center;">
                    <span style="font-size:1.1rem;">📦</span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark" style="font-size:0.95rem;">Product List</h6>
                    <small class="text-muted" style="font-size:0.75rem;">Manage all products &amp; inventory</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if (auth()->user()->can('discount.products.view') || auth()->user()->email === 'admin@admin.com')
                    <a href="{{ route('discount.index') }}" class="btn btn-sm btn-outline-success" style="font-size:0.78rem;">
                        🏷 Discounts
                    </a>
                @endif
                @if (auth()->user()->can('products.create') || auth()->user()->email === 'admin@admin.com')
                    <button type="button" id="openImportTemplateBtn" class="btn btn-sm btn-outline-secondary" style="font-size:0.78rem;" data-toggle="modal" data-target="#importTemplateModal" data-bs-toggle="modal" data-bs-target="#importTemplateModal">
                        📄 Import
                    </button>
                    <a href="create_prodcut" class="btn btn-sm btn-primary" style="font-size:0.78rem;">+ Add Product</a>
                @endif
                @if (auth()->user()->can('discount.products.create') || auth()->user()->email === 'admin@admin.com')
                    <button id="createDiscountBtn" class="btn btn-sm btn-success" style="font-size:0.78rem;">
                        ➡ Create Discount
                    </button>
                @endif
            </div>
        </div>

        <!-- Toolbar -->
        <div class="table-toolbar">
            <div class="product-search-bar flex-grow-1" style="max-width:420px;">
                <span class="search-icon">🔍</span>
                <input type="text" id="search_all" class="form-control"
                    placeholder="Search by name, code, category, brand...">
            </div>
            <span class="product-count-badge">{{ $products->total() }} Products</span>
        </div>

        <div class="card-body p-0">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show m-3 mb-0">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; overflow-y: visible;">
                <table id="productTable" class="table table-hover align-middle mb-0" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:30px;"><input type="checkbox" id="selectAll"></th>
                            <th style="width:35px;">#</th>
                            <th style="width:65px;">Code</th>
                            <th style="width:55px;">Image</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th style="width:80px;">Packing</th>
                            <th style="width:65px;">Pcs/Box</th>
                            <th style="width:95px;">Sale Price</th>
                            <th style="width:90px;">Sale Total</th>
                            <th style="width:90px;">Company</th>
                            <th style="width:80px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td><input type="checkbox" class="selectProduct" value="{{ $product->id }}"></td>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $product->item_code }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Product"
                                            width="50" height="50" class="rounded border">
                                    @else
                                        <span class="badge bg-secondary">No Img</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->category_relation->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $product->sub_category_relation->name ?? '-' }}</small>
                                </td>
                                <td>{{ $product->item_name }}</td>
                                <td>
                                    @if ($product->packings->count() > 0)
                                        @foreach ($product->packings as $packing)
                                            <span class="badge bg-light text-primary border border-primary">{{ $packing->name }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $product->pieces_per_box ?? '-' }}</td>
                                <td class="fw-bold">Rs.
                                    @php
                                        $displayPrice = 0;
                                        if ($product->size_mode === 'by_size') {
                                            $displayPrice = $product->price_per_m2 ?? 0;
                                        } else {
                                            // Prefer piece price if > 0, else fallback to box price (which is pc price in by_pieces mode)
                                            $displayPrice = ($product->sale_price_per_piece > 0) 
                                                ? $product->sale_price_per_piece 
                                                : ($product->sale_price_per_box ?? 0);
                                        }
                                    @endphp
                                    {{ number_format($displayPrice, 2) }}
                                </td>
                                <td class="text-success fw-bold">Rs. {{ number_format($product->total_price, 2) }}</td>
                                <td>{{ $product->brand->name ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- More Dropdown --}}
                                    <div class="btn-group position-relative">
                                        <button type="button" class="more-btn more-dropdown-btn">
                                            ⋯ More
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end more-dropdown-menu">
                                            <li>
                                                <a class="dropdown-item viewProductBtn" href="#" data-id="{{ $product->id }}">
                                                    <span class="di-icon" style="background:#eff6ff; color:#3b82f6;">👁</span>
                                                    View Details
                                                </a>
                                            </li>
                                            @if (auth()->user()->can('products.edit') || auth()->user()->email === 'admin@admin.com')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                    <span class="di-icon" style="background:#f0fdf4; color:#16a34a;">✏️</span>
                                                    Edit Product
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('product.batches', $product->id) }}">
                                                    <span class="di-icon" style="background:#fef9c3; color:#ca8a04;">📦</span>
                                                    View Batches
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end px-3 py-3 border-top bg-white" style="border-radius: 0 0 12px 12px;">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- add product modal --}}

    <div class="modal fade bd-example-modal-lg" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Please use the main "Add Product" page for the new per-m² flow.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Detail View Modal (Modern Bootstrap 5) -->
    <div class="modal fade" id="productViewModal" tabindex="-1" aria-labelledby="productViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">

                <!-- Header -->
                <div class="modal-header bg-light pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white p-2 rounded-circle"
                            style="width:40px;height:40px;display:grid;place-items:center;">
                            <i class="las la-box fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="view_item_name">Product Name</h5>
                            <div class="d-flex gap-2 align-items-center mt-1">
                                <span class="badge bg-secondary" id="view_item_code">CODE</span>
                                <span class="badge bg-dark" id="view_barcode_path">BARCODE</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <!-- Body -->
                <div class="modal-body bg-light p-4">

                    <!-- Loading Spinner -->
                    <div id="modalLoadingSpinner" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row g-4" id="modalContentRow">

                        <!-- Panel 1: Identity -->
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <h6 class="text-uppercase text-primary fw-bold small mb-4 border-bottom pb-2">
                                        <i class="las la-info-circle fs-5 align-text-bottom"></i> 1. Identity & Details
                                    </h6>

                                    <div class="text-center mb-4">
                                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                            style="width: 140px; height: 140px; overflow: hidden; border: 1px solid #e2e8f0;">
                                            <img id="view_image_preview" src="" class="img-fluid d-none"
                                                style="object-fit: contain; width:100%; height:100%;">
                                            <div id="view_image_placeholder" class="text-center">
                                                <i class="las la-image text-muted" style="font-size: 3rem;"></i>
                                                <small class="d-block text-muted mt-2">No Image</small>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush small">
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Category</span>
                                            <strong class="text-dark text-end" id="view_cat_sub">-</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Company</span>
                                            <strong class="text-dark" id="view_brand_name">-</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Model</span>
                                            <strong class="text-dark" id="view_model_name">-</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Colors</span>
                                            <strong class="text-dark text-end" id="view_color">-</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">HS Code</span>
                                            <strong class="text-dark" id="view_hs_code">-</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Registered</span>
                                            <strong class="text-dark" id="view_created_at">-</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 2: Measurement & Stock -->
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                                        <h6 class="text-uppercase text-info fw-bold small mb-0">
                                            <i class="las la-ruler-combined fs-5 align-text-bottom"></i> 2. Specs & Stock
                                        </h6>
                                        <span class="badge" id="view_size_mode_badge">Mode</span>
                                    </div>

                                    <div style="min-height: 180px;">
                                        <!-- By Size -->
                                        <div id="sec_by_size" class="d-none h-100 flex-column justify-content-between">
                                            <div>
                                                <div class="row text-center mb-3">
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Dimensions (cm)</small>
                                                        <strong class="text-dark fs-6" id="view_dimensions">-</strong>
                                                    </div>
                                                </div>
                                                <div class="bg-light p-3 rounded-3 border mb-3">
                                                    <div class="row text-center">
                                                        <div class="col-6 border-end">
                                                            <strong class="text-dark fs-5"
                                                                id="view_boxes_qty_size">-</strong>
                                                            <small class="text-muted d-block text-uppercase"
                                                                style="font-size: 0.7rem">Boxes</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong class="text-dark fs-5"
                                                                id="view_pcs_box_size">-</strong>
                                                            <small class="text-muted d-block text-uppercase"
                                                                style="font-size: 0.7rem">Pcs/Box</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center bg-info bg-opacity-10 p-2 rounded-3">
                                                <small class="text-info fw-bold d-block text-uppercase">Total Area
                                                    (m²)</small>
                                                <div class="fs-4 fw-bold text-info" id="view_total_m2">-</div>
                                            </div>
                                        </div>

                                        <!-- By Box/Carton -->
                                        <div id="sec_packing" class="d-none">
                                            <div class="row text-center g-2 mb-3">
                                                <div class="col-12">
                                                    <div class="bg-light p-3 rounded-3 border">
                                                        <small class="text-muted d-block text-uppercase fw-bold"
                                                            style="font-size: 0.7rem;">Pieces per Carton</small>
                                                        <strong class="text-dark fs-4" id="view_pcs_box">-</strong>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div
                                                        class="bg-primary bg-opacity-10 p-3 rounded-3 border border-primary border-opacity-25">
                                                        <strong class="text-primary fs-4" id="view_boxes_qty">-</strong>
                                                        <small class="d-block text-primary fw-bold text-uppercase"
                                                            style="font-size: 0.7rem;">Full Cartons</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div
                                                        class="bg-warning bg-opacity-10 p-3 rounded-3 border border-warning border-opacity-25">
                                                        <strong class="text-warning fs-4" id="view_loose_pcs">-</strong>
                                                        <small class="d-block text-warning fw-bold text-uppercase"
                                                            style="font-size: 0.7rem;">Loose Pieces</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- By Piece -->
                                        <div id="sec_by_piece"
                                            class="d-none text-center d-flex flex-column justify-content-center h-100">
                                            <div class="p-4 bg-light rounded-4 border">
                                                <i class="las la-layer-group text-primary mb-2"
                                                    style="font-size: 3rem;"></i>
                                                <h5 class="fw-bold text-dark">Unit Tracking</h5>
                                                <p class="text-muted small mb-0">Item is tracked and sold as individual
                                                    units.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Stock Footer -->
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted fw-bold text-uppercase"
                                                style="letter-spacing: 1px;">Total Inventory</span>
                                            <div>
                                                <span class="fs-3 fw-bold text-success" id="view_total_stock_qty">0</span>
                                                <span class="text-success small fw-bold ms-1">PCS</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Panel 3: Financial -->
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 bg-dark text-white">
                                <!-- Background subtle pattern could go here -->
                                <div class="card-body p-4 position-relative" style="z-index: 1;">
                                    <h6
                                        class="text-uppercase text-light fw-bold small mb-4 border-bottom border-secondary pb-2">
                                        <i class="las la-wallet fs-5 align-text-bottom text-success"></i> 3. Financials
                                    </h6>

                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <span class="text-light opacity-75 small fw-bold" id="lbl_price_unit">Sale
                                                Price</span>
                                            <span class="fw-bold fs-5 text-success" id="view_price_unit">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <span class="text-light opacity-75 small fw-bold" id="lbl_purch_unit">Purch
                                                Price</span>
                                            <span class="text-light fs-6" id="view_purch_unit">-</span>
                                        </div>
                                    </div>

                                    <div class="p-3 mb-3 mt-4 rounded-3 border border-success border-opacity-50"
                                        style="background: linear-gradient(145deg, rgba(25,135,84,0.1) 0%, rgba(25,135,84,0.05) 100%);">
                                        <span class="d-block text-success opacity-75 fw-bold text-uppercase mb-1"
                                            style="font-size: 0.75rem; letter-spacing: 1px;">Est. Sales Value</span>
                                        <div class="fw-bold text-white fs-2 lh-1" id="view_sale_total">-</div>
                                    </div>

                                    <div
                                        class="p-3 rounded-3 border border-secondary border-opacity-50 bg-secondary bg-opacity-25">
                                        <span class="d-block text-light opacity-75 fw-bold text-uppercase mb-1"
                                            style="font-size: 0.75rem; letter-spacing: 1px;">Est. Cost Value</span>
                                        <div class="fw-bold text-white fs-4 lh-1" id="view_purch_total">-</div>
                                        <div class="mt-2 text-end">
                                            <span
                                                class="badge bg-success bg-opacity-25 text-success border border-success px-2 py-1"
                                                id="view_profit_margin">Margin: -</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-top-0 bg-light rounded-bottom pb-3 pe-4">
                    <button type="button" class="btn btn-secondary px-4 fw-bold shadow-sm"
                        data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Product Import Modal (Bootstrap 5) -->
    <div class="modal fade" id="importTemplateModal" tabindex="-1" aria-labelledby="importTemplateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark"><i class="las la-file-excel fs-4 align-text-bottom text-success"></i> Import Products from CSV / Excel</h5>
                    <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="importProductsForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">

                        {{-- Step 1: Download Template --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <span class="badge bg-primary me-1">Step 1</span> Download Template
                            </h6>
                            <p class="text-muted small mb-2">
                                Download the CSV template, fill in your product data, then upload below.
                                Your existing <code>products_raw.csv</code> format is also supported directly.
                            </p>
                            <a href="{{ route('products.download-template') }}" class="btn btn-success btn-sm fw-bold">
                                <i class="las la-file-excel"></i> Download Excel Template (.xlsx)
                            </a>
                        </div>

                        <hr class="my-3 text-muted">

                        {{-- Step 2: Upload --}}
                        <div class="mb-3">
                            <h6 class="fw-bold text-secondary mb-2">
                                <span class="badge bg-primary me-1">Step 2</span> Upload Your File
                            </h6>
                            <label for="importFile" class="form-label fw-bold text-secondary">Select CSV or Excel File</label>
                            <input type="file" class="form-control" id="importFile" name="file" accept=".csv, .xlsx" required>
                            <div class="form-text text-muted mt-1 small">
                                ✅ Accepts <strong>CSV</strong> (.csv) and <strong>Excel</strong> (.xlsx) files.<br>
                                ✅ Compatible with your existing <strong>products_raw.csv</strong> format.<br>
                                ✅ Categories, Subcategories & Brands auto-created if not found.<br>
                                ✅ Data saved in: <strong>products</strong>, <strong>product_uoms</strong>, <strong>warehouse_stocks</strong>
                            </div>
                        </div>

                        {{-- Step 3: Dummy Data Options --}}
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="autoFillDummyCheck" name="auto_fill_dummy" value="1">
                                <label class="form-check-label fw-bold text-dark" for="autoFillDummyCheck">
                                    <i class="las la-magic text-warning me-1"></i> Auto-fill missing Brand / Category with Editable Dummy Data
                                </label>
                            </div>
                            <div class="text-muted small ms-4">
                                If enabled, empty Brand or Category values will automatically be filled as <code>Unspecified Brand (Dummy)</code> or <code>Unspecified Category (Dummy)</code> so you can import without errors and edit later.
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-warning fw-bold text-dark" id="importWithDummyBtn">
                            <i class="las la-magic"></i> Auto-Fill Dummy &amp; Import
                        </button>
                        <div>
                            <button type="button" class="btn btn-secondary me-1" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="importSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="importSpinner" role="status" aria-hidden="true"></span>
                                <span id="importBtnText">Upload &amp; Import</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

@endsection

@section('js')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Fix: Dropdown single-active management, positioning & auto-close on click-outside/scroll --}}
    <script>
        $(document).ready(function() {
            function closeAllMoreDropdowns() {
                $('.more-dropdown-menu').removeClass('show');
                $('.more-dropdown-btn').removeClass('active').attr('aria-expanded', 'false');
            }

            $(document).on('click', '.more-dropdown-btn', function(e) {
                e.stopPropagation();
                let $btn = $(this);
                let $menu = $btn.next('.more-dropdown-menu');
                let isOpen = $menu.hasClass('show');

                // Close ALL open dropdowns first so multiple rows don't stack
                closeAllMoreDropdowns();

                if (!isOpen) {
                    $menu.addClass('show');
                    $btn.addClass('active').attr('aria-expanded', 'true');

                    let rect = this.getBoundingClientRect();
                    let menuWidth = $menu.outerWidth() || 180;
                    let left = rect.right - menuWidth;
                    let top = rect.bottom + 4;
                    if (left < 4) left = 4;

                    $menu.css({
                        'position': 'fixed',
                        'top': top + 'px',
                        'left': left + 'px',
                        'z-index': '10050',
                        'transform': 'none'
                    });
                }
            });

            $(document).on('click', '.more-dropdown-menu .dropdown-item', function() {
                closeAllMoreDropdowns();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.btn-group').length) {
                    closeAllMoreDropdowns();
                }
            });

            $(window).add('.table-responsive, .main-content, body, div').on('scroll', function() {
                closeAllMoreDropdowns();
            });
        });
    </script>

    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Delete Product?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/products/' + productId,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message || 'Product deleted.', 'success')
                                .then(() => window.location.reload());
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Could not delete product.', 'error');
                        }
                    });
                }
            });
        }
    </script>

    {{-- product model --}}
    <script>
        $(document).on('click', '.viewProductBtn', function() {
            let productId = $(this).data('id');

            // 1. Reset & Loading State
            $('#modalContentRow').addClass('d-none');
            $('#modalLoadingSpinner').removeClass('d-none');

            // Bootstrap modal show
            $('#productViewModal').modal('show');

            $.ajax({
                url: "{{ url('productview') }}/" + productId,
                type: "GET",
                success: function(product) {

                    // 2. Hide Spinner, Show Content
                    $('#modalLoadingSpinner').addClass('d-none');
                    $('#modalContentRow').removeClass('d-none');

                    // --- Basic ---
                    $('#view_item_name').text(product.item_name ?? 'Unknown Product');
                    $('#view_item_code').text('Code: ' + (product.item_code ?? 'N/A'));
                    $('#view_barcode_path').text('Barcode: ' + (product.barcode_path ?? 'N/A'));

                    $('#view_cat_sub').text((product.category_relation?.name ?? '') + (product
                        .sub_category_relation ? ' • ' + product.sub_category_relation.name : ''
                    ));

                    $('#view_brand_name').text(product.brand?.name ?? '-');
                    $('#view_model_name').text(product.model ?? '-');

                    $('#view_hs_code').text(product.hs_code ?? '-');
                    $('#view_created_at').text(product.created_at ? new Date(product.created_at)
                        .toLocaleDateString() : '-');

                    // --- Image ---
                    if (product.image) {
                        $('#view_image_preview').attr('src', '/uploads/products/' + product.image)
                            .removeClass('d-none');
                        $('#view_image_placeholder').addClass('d-none');
                    } else {
                        $('#view_image_preview').addClass('d-none');
                        $('#view_image_placeholder').removeClass('d-none');
                    }

                    // --- Colors ---
                    if (product.color) {
                        try {
                            let colors = JSON.parse(product.color);
                            $('#view_color').text(Array.isArray(colors) ? colors.join(', ') : colors);
                        } catch (e) {
                            $('#view_color').text(product.color);
                        }
                    } else {
                        $('#view_color').text('-');
                    }

                    // --- Mode & Layout Switching ---
                    let mode = product.size_mode ?? 'by_size';

                    // Defaults
                    $('#sec_by_size, #sec_packing, #sec_by_piece').addClass('d-none').removeClass(
                        'd-flex');

                    let calcBoxes = product.calculated_boxes_quantity ?? 0;
                    let calcLoose = product.calculated_loose_pieces ?? 0;
                    let calcTotal = product.calculated_total_stock_qty ?? 0;

                    let salePrice = 0;
                    let purchPrice = 0;
                    let estSaleVal = 0;
                    let estPurchVal = 0;

                    if (mode === 'by_size') {
                        $('#view_size_mode_badge').text('By Size').removeClass(
                                'bg-info bg-warning border-info border-warning text-dark text-white')
                            .addClass('bg-primary bg-opacity-10 text-primary border border-primary');
                        $('#sec_by_size').removeClass('d-none').addClass('d-flex');

                        // Fill Size Data
                        let h = parseFloat(product.height ?? 0);
                        let w = parseFloat(product.width ?? 0);
                        $('#view_dimensions').text(h + ' x ' + w);

                        let m2Piece = (h * w) / 10000;

                        $('#view_boxes_qty_size').text(calcBoxes); // Box count for Size mode
                        $('#view_pcs_box_size').text(product.pieces_per_box ?? 0);

                        let m2Box = m2Piece * (product.pieces_per_box > 0 ? product.pieces_per_box : 1);
                        let totalArea = m2Box * calcBoxes;
                        $('#view_total_m2').text(totalArea.toFixed(4));

                        // Stock
                        $('#view_total_stock_qty').text(calcTotal);

                        // Price Labels
                        $('#lbl_price_unit').text('Price per m²');
                        $('#lbl_purch_unit').text('Cost per m²');
                        salePrice = parseFloat(product.price_per_m2 ?? 0);
                        purchPrice = parseFloat(product.purchase_price_per_m2 ?? 0);

                        estSaleVal = totalArea * salePrice;
                        estPurchVal = totalArea * purchPrice;

                    } else if (mode === 'by_cartons') {
                        $('#view_size_mode_badge').text('By Carton').removeClass(
                                'bg-primary bg-warning border-primary border-warning text-primary text-dark bg-opacity-10 border'
                            )
                            .addClass('bg-info text-dark');
                        $('#sec_packing').removeClass('d-none');

                        $('#view_boxes_qty').text(calcBoxes);
                        $('#view_loose_pcs').text(calcLoose);
                        $('#view_pcs_box').text(product.pieces_per_box ?? '-');

                        // Stock
                        $('#view_total_stock_qty').text(calcTotal);

                        // Price Labels
                        $('#lbl_price_unit').text('Price per Unit (Pc)');
                        $('#lbl_purch_unit').text('Cost per Unit (Pc)');
                        salePrice = parseFloat(product.sale_price_per_box ?? 0);
                        purchPrice = parseFloat(product.purchase_price_per_piece ?? 0);

                        // In cartons mode, calculation is purely based on piece qty directly
                        estSaleVal = calcTotal * salePrice;
                        estPurchVal = calcTotal * purchPrice;

                    } else { // by_pieces
                        $('#view_size_mode_badge').text('By Piece').removeClass(
                                'bg-primary bg-info border-primary border-info text-primary text-white bg-opacity-10 border'
                            )
                            .addClass('bg-warning text-dark');
                        $('#sec_by_piece').removeClass('d-none');

                        // Stock
                        $('#view_total_stock_qty').text(calcTotal);

                        // Price Labels
                        $('#lbl_price_unit').text('Price per Piece');
                        $('#lbl_purch_unit').text('Cost per Piece');
                        salePrice = parseFloat(product.sale_price_per_box ?? 0);
                        purchPrice = parseFloat(product.purchase_price_per_piece ?? 0);

                        estSaleVal = calcTotal * salePrice;
                        estPurchVal = calcTotal * purchPrice;
                    }

                    // Format Financials
                    const formatCurrency = (val) => 'Rs. ' + val.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $('#view_price_unit').text(formatCurrency(salePrice));
                    $('#view_purch_unit').text(formatCurrency(purchPrice));
                    $('#view_sale_total').text(formatCurrency(estSaleVal));
                    $('#view_purch_total').text(formatCurrency(estPurchVal));

                    // Margin calculation
                    if (estPurchVal > 0) {
                        let margin = ((estSaleVal - estPurchVal) / estPurchVal) * 100;
                        $('#view_profit_margin').text('Margin: ' + margin.toFixed(2) + '%').show();
                    } else if (estSaleVal > 0) {
                        $('#view_profit_margin').text('Margin: 100%').show();
                    } else {
                        $('#view_profit_margin').hide();
                    }

                },
                error: function() {
                    $('#modalLoadingSpinner').addClass('d-none');
                    $('#productViewModal').modal('hide');
                    Swal.fire('Error', 'Could not fetch product details', 'error');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Open Import Modal
            $('#openImportTemplateBtn').click(function() {
                $('#importTemplateModal').modal('show');
            });

            // Select/Deselect all checkboxes
            $('#selectAll').click(function() {
                $('.selectProduct').prop('checked', this.checked);
            });

            // On "Create Discount" click
            $('#createDiscountBtn').click(function() {
                var selected = [];
                $('.selectProduct:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please select at least one product!",

                    });
                    return;
                }

                // Redirect with product IDs as query param
                window.location.href = "{{ route('discount.create') }}" + "?products=" + selected.join(
                    ',');
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            function debounce(func, delay) {
                let timer;
                return function(...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                }
            }

            let table = $('#productTable').DataTable({
                responsive: false,
                paging: false,
                ordering: true,
                info: false,
                order: [[1, 'asc']],
                dom: 'rt',
                scrollX: false,
                columnDefs: [{
                    targets: [0, 11],
                    searchable: false,
                    orderable: false
                }]
            });

        });
    </script>

    <!-- DataTables CSS -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cartonQuantityInput = document.getElementById("carton_quantity");
        let piecesPerCartonInput = document.getElementById("pieces_per_carton");
        let initialStockInput = document.getElementById("initial_stock");

        if (cartonQuantityInput && piecesPerCartonInput && initialStockInput) {
            function updateInitialStock() {
                let cartonQuantity = parseInt(cartonQuantityInput.value) || 0;
                let piecesPerCarton = parseInt(piecesPerCartonInput.value) || 0;
                initialStockInput.value = cartonQuantity * piecesPerCarton;
            }

            cartonQuantityInput.addEventListener("input", updateInitialStock);
            piecesPerCartonInput.addEventListener("input", updateInitialStock);
        }
    });


    $(document).ready(function() {
        // Add Product Modal: Fetch Subcategories on Category Change
        $('#categorySelect').change(function() {
            var categoryId = $(this).val();

            $('#subCategorySelect').html('<option value="">Loading...</option>');

            if (categoryId) {
                $.ajax({
                    url: "{{ url('get-subcategories') }}/" + categoryId,

                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#subCategorySelect').html(
                            '<option value="">Select Sub-Category</option>');
                        $.each(data, function(key, subCategory) {
                            $('#subCategorySelect').append('<option value="' +
                                subCategory.id + '">' +
                                subCategory.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subCategorySelect').html('<option value="">Select Sub-Category</option>');
            }
        });

        // Edit Product Modal: Fetch Subcategories when Category is Changed
        $('#edit_category').change(function() {
            var categoryId = $(this).val();
            $('#edit_sub_category').html('<option value="">Loading...</option>');

            if (categoryId) {
                $.ajax({
                    url: "{{ url('get-subcategories') }}/" + categoryId,

                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#edit_sub_category').html(
                            '<option value="">Select Sub-Category</option>');
                        $.each(data, function(key, subCategory) {
                            $('#edit_sub_category').append('<option value="' +
                                subCategory.sub_category_name + '">' +
                                subCategory.sub_category_name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            } else {
                $('#edit_sub_category').html('<option value="">Select Sub-Category</option>');
            }
        });

        // Click handler for direct "Auto-Fill Dummy & Import" button in modal
        $(document).on('click', '#importWithDummyBtn', function(e) {
            $('#autoFillDummyCheck').prop('checked', true);
            $('#importProductsForm').submit();
        });

        // Handle import form submission
        $(document).on('submit', '#importProductsForm', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let submitBtn = $('#importSubmitBtn');
            let dummyBtn  = $('#importWithDummyBtn');
            let spinner   = $('#importSpinner');
            let btnText   = $('#importBtnText');

            // Set loading state
            submitBtn.prop('disabled', true);
            dummyBtn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('Importing...');

            $.ajax({
                url: "{{ route('products.import') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    dummyBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('Upload & Import');
                    $('#importTemplateModal').modal('hide');
                    $('#importProductsForm')[0].reset();

                    var imported  = response.imported_count  || 0;
                    var skipped   = response.skipped_count   || 0;
                    var dummy     = response.dummy_count     || 0;
                    var duplicate = response.duplicate_count || 0;

                    var statsHtml =
                        '<div style="display:flex;gap:10px;justify-content:center;margin:18px 0 10px;flex-wrap:wrap">' +

                        '<div style="flex:1;min-width:80px;background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1.5px solid #6ee7b7;border-radius:12px;padding:14px 10px;text-align:center">' +
                        '<div style="font-size:2rem;font-weight:900;color:#059669;line-height:1">' + imported + '</div>' +
                        '<div style="font-size:0.72rem;font-weight:700;color:#065f46;text-transform:uppercase;letter-spacing:.04em;margin-top:4px">✅ Imported</div>' +
                        '</div>' +

                        (duplicate > 0 ?
                        '<div style="flex:1;min-width:80px;background:linear-gradient(135deg,#fef2f2,#fecaca);border:1.5px solid #f87171;border-radius:12px;padding:14px 10px;text-align:center">' +
                        '<div style="font-size:2rem;font-weight:900;color:#dc2626;line-height:1">' + duplicate + '</div>' +
                        '<div style="font-size:0.72rem;font-weight:700;color:#7f1d1d;text-transform:uppercase;letter-spacing:.04em;margin-top:4px">⛔ Duplicates</div>' +
                        '</div>' : '') +

                        (skipped > 0 ?
                        '<div style="flex:1;min-width:80px;background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1.5px solid #fbbf24;border-radius:12px;padding:14px 10px;text-align:center">' +
                        '<div style="font-size:2rem;font-weight:900;color:#d97706;line-height:1">' + skipped + '</div>' +
                        '<div style="font-size:0.72rem;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:.04em;margin-top:4px">⏭ Skipped</div>' +
                        '</div>' : '') +

                        (dummy > 0 ?
                        '<div style="flex:1;min-width:80px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1.5px solid #93c5fd;border-radius:12px;padding:14px 10px;text-align:center">' +
                        '<div style="font-size:2rem;font-weight:900;color:#2563eb;line-height:1">' + dummy + '</div>' +
                        '<div style="font-size:0.72rem;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.04em;margin-top:4px">🤖 Dummy</div>' +
                        '</div>' : '') +

                        '</div>' +

                        (duplicate > 0 ?
                        '<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:8px 12px;font-size:0.78rem;color:#b91c1c;margin-top:6px">' +
                        '<b>⛔ Duplicates Skipped:</b> ' + duplicate + ' product(s) already exist by item code or name+brand and were not imported again.' +
                        '</div>' : '') +

                        (response.errors && response.errors.length ?
                        '<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:0.75rem;color:#475569;margin-top:6px;max-height:100px;overflow-y:auto;text-align:left">' +
                        '<b>Details:</b><ul style="margin:4px 0 0 12px;padding:0">' +
                        response.errors.map(function(e){ return '<li>' + e + '</li>'; }).join('') +
                        '</ul></div>' : '');

                    Swal.fire({
                        icon: 'success',
                        title: '<span style="font-size:1.15rem;font-weight:800;color:#065f46">✅ Import Successful!</span>',
                        html: statsHtml,
                        confirmButtonText: 'Great, Refresh Page!',
                        confirmButtonColor: '#059669',
                        customClass: { confirmButton: 'btn btn-success fw-bold px-5' }
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    dummyBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('Upload & Import');

                    let response = xhr.responseJSON || {};
                    let message = response.message || 'An error occurred while importing products.';

                    if (response.type === 'column_mismatch') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Column Mismatch',
                            html: `Your CSV file is missing required columns:<br><strong class="text-danger">${message}</strong>.<br><br>Please download the CSV template for reference.`,
                            confirmButtonText: 'Understood',
                            customClass: {
                                confirmButton: 'btn btn-warning'
                            }
                        });
                    } else if (response.can_auto_fill) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Import Validation Errors',
                            html: message,
                            showCancelButton: true,
                            confirmButtonText: '<i class="las la-magic me-1"></i> Auto-Fill Missing Fields & Import Now',
                            cancelButtonText: 'Cancel',
                            customClass: {
                                confirmButton: 'btn btn-warning fw-bold me-2',
                                cancelButton: 'btn btn-secondary'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#autoFillDummyCheck').prop('checked', true);
                                $('#importProductsForm').submit();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Import Failed',
                            html: message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
