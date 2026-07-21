@extends('admin_panel.layout.app')

@section('content')
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --info: #06b6d4;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-glass: rgba(255, 255, 255, 0.9);
            --radius-lg: 12px;
            --shadow-subtle: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .customer-listing-area {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }

        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: #ffffff;
            padding: 20px 25px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-subtle);
            border: 1px solid #e2e8f0;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title p {
            font-size: 0.85rem;
            color: var(--secondary);
            margin: 5px 0 0 0;
        }

        /* Premium Table */
        .table-container {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid #e2e8f0;
            box-shadow: var(--shadow-subtle);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table-premium {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-premium th {
            background: #f1f5f9;
            padding: 15px 20px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        .table-premium td {
            padding: 18px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .table-premium tr:hover td {
            background: #f8fafc;
        }

        /* Info Groups */
        .identity-group .name {
            font-weight: 800;
            color: #0f172a;
            font-size: 0.95rem;
            display: block;
        }

        .identity-group .id-tag {
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 700;
            background: #e0e7ff;
            padding: 2px 8px;
            border-radius: 4px;
            margin-top: 4px;
            display: inline-block;
        }

        .contact-group .item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .contact-group i {
            width: 16px;
            color: var(--secondary);
        }

        .legal-group {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            max-width: 250px;
        }

        .legal-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }

        .legal-badge.active {
            background: #ecfdf5;
            color: #059669;
            border-color: #6ee7b7;
        }

        .financial-group .balance {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .balance-debit { color: var(--danger); }
        .balance-credit { color: var(--success); }

        .limit-info {
            font-size: 0.7rem;
            color: var(--secondary);
            margin-top: 4px;
        }

        /* Badges */
        .badge-premium {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }

        .action-flex {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        /* Toggle Button Custom Styling */
        .btn-status-toggle {
            padding: 6px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .btn-status-toggle.active { color: var(--success); background: #f0fdf4; }
        .btn-status-toggle.inactive { color: var(--secondary); background: #f8fafc; }

        .btn-status-toggle i { font-size: 1.25rem; }

        /* Urdu Text Support */
        .text-urdu {
            font-family: 'Noto Nastaliq Urdu', serif;
            font-size: 0.8rem;
            color: var(--secondary);
        }
    </style>

    <div class="customer-listing-area">
        <div class="container-fluid p-0">
            <!-- Dynamic Header -->
            <div class="listing-header">
                <div class="header-title">
                    <h1><i class="fa fa-users"></i> Customer Directory</h1>
                    <p>Financial oversight and identification records for all registered customers</p>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <a href="{{ route('customer.payments') }}" class="btn btn-outline-info fw-bold" style="border-radius:10px;">
                        <i class="fa fa-money-bill-wave me-2"></i> Payments
                    </a>
                    <a href="{{ route('customers.ledger') }}" class="btn btn-outline-primary fw-bold" style="border-radius:10px;">
                        <i class="fa fa-book-open me-2"></i> General Ledger
                    </a>
                    <button type="button" id="openImportCustomerModal" class="btn btn-outline-success fw-bold" style="border-radius:10px; padding: 10px 18px;" data-bs-toggle="modal" data-bs-target="#importCustomerModal" data-toggle="modal" data-target="#importCustomerModal">
                        <i class="fa fa-file-excel me-2"></i> Import Customers
                    </button>
                    <a href="{{ route('parties.create', ['type' => 'Customer']) }}" class="btn btn-primary fw-bold" style="border-radius:10px; padding: 10px 20px;">
                        <i class="fa fa-plus-circle me-2"></i> Register Customer
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:12px; border-left: 5px solid var(--success) !important;">
                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Main Table Wrapper -->
            <div class="table-container">
                <table class="table-premium">
                    <thead>
                        <tr>
                            <th>Identity & Type</th>
                            <th>Contact Node</th>
                            <th>Location & Zone</th>
                            <th>Legal / Tax / Licenses</th>
                            <th>Financial Summary</th>
                            <th class="text-center">Account</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <!-- Identity -->
                                <td>
                                    <div class="identity-group">
                                        <span class="name">{{ $customer->customer_name }}</span>
                                        @if($customer->customer_name_ur)
                                            <span class="text-urdu">{{ $customer->customer_name_ur }}</span>
                                        @endif
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="id-tag">ID: {{ $customer->customer_id }}</span>
                                            <span class="badge bg-light text-muted border" style="font-size:0.65rem;">{{ $customer->category ?? 'General' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact -->
                                <td>
                                    <div class="contact-group">
                                        <div class="item"><i class="fa fa-phone-alt"></i> <b>{{ $customer->mobile }}</b></div>
                                        @if($customer->contact_person)
                                            <div class="item"><i class="fa fa-user"></i> {{ $customer->contact_person }}</div>
                                        @endif
                                        @if($customer->email_address)
                                            <div class="item"><i class="fa fa-envelope"></i> <small>{{ $customer->email_address }}</small></div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Location -->
                                <td>
                                    <div style="font-size:0.85rem;">
                                        <div class="mb-1 fw-bold text-dark">{{ $customer->zone ?? '(No Zone)' }}</div>
                                        <div class="text-muted" style="line-height:1.4; max-width: 200px;">
                                            {{ Str::limit($customer->address, 60) }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Legal / Tax -->
                                <td>
                                    <div class="legal-group">
                                        @if($customer->cnic)
                                            <span class="legal-badge active" title="CNIC Number">ID: {{ $customer->cnic }}</span>
                                        @endif
                                        @if($customer->ntn_no)
                                            <span class="legal-badge active" title="NTN Number">NTN: {{ $customer->ntn_no }}</span>
                                        @endif
                                        @if($customer->gst_no)
                                            <span class="legal-badge" title="GST Number">GST: {{ $customer->gst_no }}</span>
                                        @endif
                                        @if($customer->dsl_no)
                                            <span class="legal-badge" title="Drug Sale License">DSL: {{ $customer->dsl_no }}</span>
                                        @endif
                                        @if($customer->drap_no)
                                            <span class="legal-badge" title="Medical Registration">DRAP: {{ $customer->drap_no }}</span>
                                        @endif
                                        <span class="legal-badge text-uppercase">{{ $customer->filer_type ?? 'Non-Filer' }}</span>
                                    </div>
                                </td>

                                <!-- Financial -->
                                <td>
                                    <div class="financial-group">
                                        @php
                                            $ob = floatval($customer->opening_balance ?? 0);
                                            $dr = floatval($customer->debit ?? 0);
                                            $cr = floatval($customer->credit ?? 0);
                                            $bal = $ob + $dr - $cr;
                                        @endphp
                                        @if($bal > 0)
                                            <div class="balance balance-debit">RS. {{ number_format($bal, 2) }} <small>(Dr)</small></div>
                                        @elseif($bal < 0)
                                            <div class="balance balance-credit">RS. {{ number_format(abs($bal), 2) }} <small>(Cr)</small></div>
                                        @else
                                            <div class="balance text-muted">RS. 0.00</div>
                                        @endif

                                        <div class="limit-info">
                                            Limit: RS. {{ number_format($customer->balance_range ?? 0, 0) }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Status & Branch -->
                                <td class="text-center">
                                    <div class="mb-2">
                                        <span class="badge-premium status-{{ strtolower($customer->status) }}">
                                            {{ $customer->status }}
                                        </span>
                                    </div>
                                    <span class="text-muted" style="font-size:0.65rem; font-weight:700;">
                                        {{ $customer->branch?->abr ?? 'HO' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="action-flex">
                                        @can('customers.edit')
                                            <a href="{{ route('customers.toggleStatus', $customer->id) }}"
                                                class="btn-status-toggle {{ $customer->status === 'active' ? 'active' : 'inactive' }}"
                                                title="Toggle Active Status">
                                                <i class="fa-solid {{ $customer->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </a>
                                        @endcan

                                        @include('admin_panel.partials.action_buttons', [
                                            'editRoute' => route('parties.edit', [$customer->id, 'type' => 'Customer']),
                                            'deleteRoute' => route('customers.destroy', $customer->id),
                                            'editIsLink' => true,
                                            'permissions' => ['edit' => 'customers.edit', 'delete' => 'customers.delete'],
                                            'dataId' => $customer->id,
                                        ])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer Meta -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small fw-bold">
                    Showing {{ $customers->count() }} registered customers
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.inactive') }}" class="btn btn-sm btn-light border fw-bold text-secondary" style="border-radius:8px;">
                        <i class="fa fa-eye-slash me-1"></i> View Inactive Archive
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Import Modal -->
    <div class="modal fade" id="importCustomerModal" tabindex="-1" aria-labelledby="importCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 18px 24px;">
                    <h5 class="modal-title fw-bold text-white mb-0" id="importCustomerModalLabel">
                        <i class="fa fa-file-excel me-2"></i> Import Customers via Spreadsheet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="customerImportForm" action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                    @csrf
                    <div class="modal-body p-4">
                        <!-- Step 1: Download Template -->
                        <div class="p-3 mb-4 rounded-3 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-success mb-1"><i class="fa fa-info-circle me-1"></i> Step 1: Download Standard Template</h6>
                                    <p class="small text-muted mb-0">Use our pre-formatted Excel template for maximum compatibility.</p>
                                </div>
                                <a href="{{ route('customers.download-template') }}" class="btn btn-success btn-sm fw-bold shadow-sm" style="border-radius: 8px;">
                                    <i class="fa fa-download me-1"></i> Download Template (.xlsx)
                                </a>
                            </div>
                        </div>

                        <!-- Auto-Fill Dummy Data Toggle Switch -->
                        <div class="form-check form-switch p-3 mb-4 rounded-3 border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                            <div class="d-flex align-items-center gap-2">
                                <input class="form-check-input ms-0 me-2" type="checkbox" id="customer_auto_fill_dummy" name="auto_fill_dummy" value="1" style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                <label class="form-check-label fw-bold text-dark mb-0" for="customer_auto_fill_dummy" style="cursor: pointer;">
                                    Auto-Fill missing Customer Name &amp; required fields with editable dummy data
                                </label>
                            </div>
                            <p class="small text-muted mt-1 mb-0 ms-5">
                                When enabled, rows missing required customer names will automatically be populated with editable dummy names like <code>[DUMMY] Customer Row 1</code> so the import completes without errors.
                            </p>
                        </div>

                        <!-- Step 2: Upload File -->
                        <div class="mb-3">
                            <label for="customer_import_file" class="form-label fw-bold text-dark">
                                Step 2: Upload Excel / CSV File <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control form-control-lg" id="customer_import_file" name="file" accept=".csv, .xlsx, .xls" required style="border-radius: 10px;">
                            <small class="text-muted mt-1 d-block">Supported file formats: <strong>.xlsx, .xls, .csv</strong></small>
                        </div>
                    </div>

                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="button" class="btn btn-success fw-bold px-4 shadow-sm" id="btnCustomerImportSubmit" onclick="doCustomerImport()" style="border-radius: 8px;">
                            <i class="fa fa-file-import me-1"></i> Import Customers
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Use window.onload so jQuery & Bootstrap are fully available
        window.addEventListener('load', function () {

            // ─── Open Modal ──────────────────────────────────────────────────────
            var openBtn = document.getElementById('openImportCustomerModal');
            if (openBtn) {
                openBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Bootstrap 4 uses jQuery .modal('show')
                    try {
                        $('#importCustomerModal').modal('show');
                    } catch(err) {
                        // Fallback for Bootstrap 5
                        if (typeof bootstrap !== 'undefined') {
                            new bootstrap.Modal(document.getElementById('importCustomerModal')).show();
                        }
                    }
                });
            }
        });

        // ─── AJAX Import (plain JS, no jQuery dependency) ─────────────────────
        function doCustomerImport() {
            var form = document.getElementById('customerImportForm');
            var fileInput = document.getElementById('customer_import_file');

            if (!fileInput || !fileInput.files.length) {
                Swal.fire({ icon: 'warning', title: 'No File Selected', text: 'Please select a CSV or Excel file first.', confirmButtonColor: '#f59e0b' });
                return;
            }

            var btn = document.getElementById('btnCustomerImportSubmit');
            var origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Importing...';

            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (response) {
                var status = response.status;
                return response.text().then(function (text) {
                    var data;
                    try { data = JSON.parse(text); } catch (e) { data = null; }
                    return { ok: response.ok, status: status, data: data, raw: text };
                });
            })
            .then(function (result) {
                btn.disabled = false;
                btn.innerHTML = origHtml;

                if (result.ok) {
                    // ── Close modal (Bootstrap 4 = jQuery, Bootstrap 5 = bootstrap.Modal) ──
                    try {
                        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined' && typeof bootstrap.Modal.getInstance === 'function') {
                            // Bootstrap 5
                            var bsModal = bootstrap.Modal.getInstance(document.getElementById('importCustomerModal'));
                            if (bsModal) bsModal.hide();
                        } else {
                            // Bootstrap 4 (jQuery)
                            $('#importCustomerModal').modal('hide');
                        }
                    } catch(me) {
                        try { $('#importCustomerModal').modal('hide'); } catch(e2) {}
                    }
                    form.reset();

                    var res       = result.data;
                    var imported  = res.imported_count  || 0;
                    var skipped   = res.skipped_count   || 0;
                    var dummy     = res.dummy_count     || 0;
                    var duplicate = res.duplicate_count || 0;

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
                        '<b>⛔ Duplicates Skipped:</b> ' + duplicate + ' row(s) already exist by name, ID or mobile and were not imported again.' +
                        '</div>' : '') +

                        (dummy > 0 ?
                        '<div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;font-size:0.78rem;color:#1d4ed8;margin-top:6px">' +
                        '<b>ℹ️ Note:</b> ' + dummy + ' row(s) auto-filled with dummy names — edit from Customer Directory.' +
                        '</div>' : '') +

                        (res.errors && res.errors.length ?
                        '<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:0.75rem;color:#475569;margin-top:6px;max-height:100px;overflow-y:auto;text-align:left">' +
                        '<b>Details:</b><ul style="margin:4px 0 0 12px;padding:0">' +
                        res.errors.map(function(e){ return '<li>' + e + '</li>'; }).join('') +
                        '</ul></div>' : '');


                    Swal.fire({
                        icon: 'success',
                        title: '<span style="font-size:1.15rem;font-weight:800;color:#065f46">✅ Import Successful!</span>',
                        html: statsHtml,
                        confirmButtonText: 'Great, Refresh Page!',
                        confirmButtonColor: '#059669',
                        customClass: { confirmButton: 'btn btn-success fw-bold px-5' }
                    }).then(function () { location.reload(); });

                } else {
                    // ── Error response ──
                    var errRes  = result.data;
                    var errMsg;

                    if (errRes && errRes.message) {
                        errMsg = errRes.message;
                        if (errRes.errors && Array.isArray(errRes.errors) && errRes.errors.length) {
                            errMsg += '<br><div class="text-start mt-2 p-2 bg-light rounded text-danger small" style="max-height:150px;overflow-y:auto"><ul>' +
                                errRes.errors.map(function (e) { return '<li>' + e + '</li>'; }).join('') +
                                '</ul></div>';
                        }
                    } else {
                        // Server returned non-JSON (e.g., HTML error page)
                        var snippet = (result.raw || '').replace(/<[^>]+>/g, '').trim().substring(0, 300);
                        errMsg = 'Server returned HTTP ' + result.status + '.<br><small class="text-muted">' + (snippet || 'No details available.') + '</small>';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Import Failed (HTTP ' + result.status + ')',
                        html: errMsg,
                        showCancelButton: true,
                        confirmButtonText: '⚡ Auto-Fill Dummy & Retry',
                        cancelButtonText: 'Close',
                        confirmButtonColor: '#d97706',
                        customClass: {
                            confirmButton: 'btn btn-warning fw-bold text-dark px-3',
                            cancelButton:  'btn btn-secondary px-3'
                        }
                    }).then(function (r) {
                        if (r.isConfirmed) {
                            document.getElementById('customer_auto_fill_dummy').checked = true;
                            doCustomerImport();
                        }
                    });
                }
            })
            .catch(function (err) {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                Swal.fire({ icon: 'error', title: 'Connection Error', html: 'Could not reach server.<br><small class="text-muted">' + (err.message || '') + '</small>', confirmButtonColor: '#ef4444' });
            });
        }
    </script>
@endsection

