@extends('admin_panel.layout.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .vch-page {
            background: #f0f4f8;
            min-height: 100vh;
            padding: 28px 0 40px;
        }

        .vch-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .vch-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: #1a2340;
            letter-spacing: -.3px;
        }

        .vch-badge {
            display: inline-block;
            background: #fff0e8;
            color: #f59e0b;
            font-size: .72rem;
            font-weight: 600;
            border-radius: 20px;
            padding: 2px 10px;
            margin-left: 8px;
            vertical-align: middle;
        }

        .btn-vch-new {
            background: linear-gradient(135deg, #f59e0b, #ef6c00);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: .92rem;
            box-shadow: 0 4px 14px rgba(245, 158, 11, .35);
            transition: all .22s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .btn-vch-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, .45);
            color: #fff;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 24px;
            border: 1px solid #e8ecf4;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.orange {
            background: #fff4e6;
            color: #f59e0b;
        }

        .stat-icon.red {
            background: #fff0f0;
            color: #ef4444;
        }

        .stat-icon.blue {
            background: #e8edff;
            color: #4f6ef7;
        }

        .stat-val {
            font-size: 1.45rem;
            font-weight: 700;
            color: #1a2340;
            line-height: 1;
        }

        .stat-lbl {
            font-size: .78rem;
            color: #8897b0;
            font-weight: 500;
            margin-top: 4px;
        }

        .vch-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e8ecf4;
            box-shadow: 0 2px 18px rgba(0, 0, 0, .05);
            overflow: hidden;
            margin-top: 24px;
        }

        .vch-card-header {
            background: linear-gradient(135deg, #f59e0b 0%, #ef6c00 100%);
            padding: 18px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vch-card-header h5 {
            color: #fff;
            font-weight: 600;
            font-size: 1.05rem;
            margin: 0;
        }

        .vch-search {
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 8px;
            color: #fff;
            padding: 7px 14px;
            font-size: .88rem;
            width: 220px;
        }

        .vch-search::placeholder {
            color: rgba(255, 255, 255, .7);
        }

        .vch-search:focus {
            outline: none;
            background: rgba(255, 255, 255, .28);
        }

        .vch-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .vch-table thead th {
            background: #f7f9fc;
            color: #8897b0;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 12px 16px;
            border-bottom: 1px solid #e8ecf4;
            white-space: nowrap;
        }

        .vch-table tbody tr {
            transition: background .15s;
        }

        .vch-table tbody tr:hover {
            background: #fffdf5;
        }

        .vch-table tbody td {
            padding: 13px 16px;
            font-size: .9rem;
            color: #3c4a6b;
            vertical-align: middle;
            border-bottom: 1px solid #f0f4f8;
        }

        .vch-no {
            font-weight: 700;
            color: #f59e0b;
            font-size: .92rem;
        }

        .party-name {
            font-weight: 600;
            color: #1a2340;
            font-size: .9rem;
        }

        .amount-cell {
            font-weight: 700;
            color: #1a2340;
            font-size: .95rem;
            font-family: 'Consolas', monospace;
        }

        .badge-type {
            background: #fff4e6;
            color: #f59e0b;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: .74rem;
            font-weight: 600;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #fff4e6;
            border: 1.5px solid #fde68a;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #d97706;
            font-size: 1rem;
            transition: all .2s;
            text-decoration: none;
        }

        .action-btn:hover {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, .3);
        }

        .row-num {
            color: #b0bac9;
            font-size: .82rem;
            font-weight: 600;
        }

        .empty-state {
            padding: 60px;
            text-align: center;
            color: #b0bac9;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 12px;
            display: block;
        }

        /* ── Filter card ── */
        .filter-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            margin-bottom: 22px;
            border: 1px solid #e8ecf4;
        }

        .filter-title {
            font-size: .82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #ef6c00;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            font-size: .84rem;
            padding: 6px 12px;
            height: 36px;
            transition: border-color .2s, box-shadow .2s;
            background-color: #fff;
            width: 100% !important;
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, .12);
            outline: none;
        }

        .btn-srp {
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: .84rem;
            padding: 8px 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            height: 36px;
        }

        .btn-srp.orange {
            background: linear-gradient(135deg, #f59e0b, #ef6c00);
            color: #fff;
            box-shadow: 0 4px 12px rgba(245, 158, 11, .25);
        }

        .btn-srp.orange:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, .35);
        }

        .btn-srp.ghost {
            background: #f0f4f8;
            color: #6b7a99;
            border: 1.5px solid #e2e8f0;
        }

        .btn-srp.ghost:hover {
            background: #e2e8f0;
            color: #3c4a6b;
        }

        label.form-label {
            font-size: .75rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
            display: block;
        }
    </style>

    <div class="vch-page">
        <div class="container-fluid px-4">
            <div class="vch-header">
                <div>
                    <div class="vch-title">Expense Vouchers <span class="vch-badge">{{ count($receipts) }} Records</span>
                    </div>
                    <div style="color:#8897b0;font-size:.85rem;margin-top:4px;">Track and manage all business expense
                        payments</div>
                </div>
                @can('expense.voucher.create')
                    <a class="btn-vch-new" href="{{ route('expense_vochers') }}">
                        <i class="bi bi-plus-lg"></i> New Expense Voucher
                    </a>
                @endcan
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center gap-2 mb-3" style="background:#e6f9f1;border:1px solid #a7f3d0;color:#065f46;padding:12px 18px;font-weight:500;">
                    <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:#065f46;line-height:1;">&times;</button>
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="bi bi-file-earmark-text"></i></div>
                        <div>
                            <div class="stat-val">{{ count($receipts) }}</div>
                            <div class="stat-lbl">Total Expense Vouchers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon red"><i class="bi bi-arrow-up-circle"></i></div>
                        <div>
                            @php
                                $total = collect($receipts)->sum(function ($item) {
                                    $a = json_decode($item->total_amount, true);
                                    return is_array($a) ? collect($a)->sum() : (float) $item->total_amount;
                                });
                            @endphp
                            <div class="stat-val">{{ number_format($total, 0) }}</div>
                            <div class="stat-lbl">Total Expenses</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-calendar-week"></i></div>
                        <div>
                            <div class="stat-val">
                                {{ collect($receipts)->where('entry_date', now()->toDateString())->count() }}</div>
                            <div class="stat-lbl">Today's Vouchers</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="filter-card">
                <div class="filter-title"><i class="bi bi-funnel-fill"></i> Advanced Filters & Actions</div>
                <!-- Row 1: Filters -->
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Voucher No</label>
                        <input type="text" id="filterVoucherNo" class="form-control" placeholder="e.g. EVID-0001">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type (Paid From Head)</label>
                        <select id="filterType" class="form-select">
                            <option value="">All Types</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Party (Source Account)</label>
                        <select id="filterParty" class="form-select">
                            <option value="">All Parties / Accounts</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account Head (Line Item)</label>
                        <select id="filterAccountHead" class="form-select">
                            <option value="">All Account Heads</option>
                            @foreach($allHeads as $head)
                                <option value="{{ $head->id }}">{{ $head->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 2: Parameters & Action Buttons inline -->
                <div class="d-flex flex-wrap align-items-end" style="gap: 10px !important;">
                    <div style="flex: 1 1 120px; max-width: 150px;">
                        <label class="form-label">Bank Accounts</label>
                        <select id="filterBank" class="form-select">
                            <option value="">All Accounts</option>
                            <option value="bank">Bank Accounts Only</option>
                            <option value="cash">Cash Accounts Only</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 110px; max-width: 135px;">
                        <label class="form-label">Start Date</label>
                        <input type="date" id="filterStartDate" class="form-control">
                    </div>
                    <div style="flex: 1 1 110px; max-width: 135px;">
                        <label class="form-label">End Date</label>
                        <input type="date" id="filterEndDate" class="form-control">
                    </div>
                    
                    <div class="d-flex justify-content-end align-items-center flex-grow-1 ms-auto" style="min-width: 200px; gap: 15px !important;">
                        <button type="button" id="btnSearch" class="btn-srp orange" title="Search Ledger">
                            <i class="bi bi-search me-1"></i> Search
                        </button>
                        <button type="button" id="btnResetFilters" class="btn-srp ghost" title="Reset Filters">
                            <i class="bi bi-sync me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="vch-card">
                <div class="vch-card-header">
                    <h5><i class="bi bi-table me-2"></i>Expense Vouchers List</h5>
                    <input type="text" class="vch-search" id="vchSearch" placeholder="🔍 Search expenses...">
                </div>
                <div style="overflow-x:auto;">
                    <table class="vch-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voucher No</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Party</th>
                                <th>Account Head</th>
                                <th>Reference</th>
                                <th>Remarks</th>
                                <th style="text-align:right;">Amount</th>
                                <th style="text-align:right;">Total</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="vchBody">
                            @forelse ($receipts as $item)
                                @php
                                    $amounts = json_decode($item->amount, true);
                                    $amount = is_array($amounts) ? (float) ($amounts[0] ?? 0) : (float) $item->amount;
                                    $refs = json_decode($item->reference_no, true);
                                    $reference = is_array($refs) ? implode(', ', $refs) : $item->reference_no;
                                @endphp
                                <tr data-heads="{{ $item->row_account_head ?? '[]' }}" data-accounts="{{ $item->row_account_id ?? '[]' }}">
                                    <td class="row-num">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="vch-no">{{ $item->evid }}</span>
                                        @if($item->voucherMaster && $item->voucherMaster->createdBy)
                                            <div class="mt-1">
                                                <span class="badge bg-light text-muted fw-bold" style="font-size: 0.65rem; border: 1px dashed #e2e8f0; padding: 2px 6px; border-radius: 4px;">
                                                    <i class="bi bi-person me-1"></i>{{ $item->voucherMaster->createdBy->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="color:#6b7a99;font-size:.86rem;"><i
                                            class="bi bi-calendar3 me-1"></i>{{ $item->entry_date }}</td>
                                    <td><span class="badge-type">{{ $item->type_label }}</span></td>
                                    <td>
                                        <div class="party-name">{{ $item->party_name }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #1a2340; font-size: .9rem;">{{ $item->line_account_heads }}</div>
                                    </td>
                                    <td style="color:#6b7a99;font-size:.86rem;">{{ $reference }}</td>
                                    <td style="color:#6b7a99;font-size:.86rem;max-width:160px;">
                                        {{ Str::limit($item->remarks, 40) }}</td>
                                    <td style="text-align:right;"><span
                                            class="amount-cell">{{ number_format($amount, 2) }}</span></td>
                                    <td style="text-align:right;"><span class="amount-cell"
                                            style="color:#ef4444;">{{ number_format((float) $item->total_amount, 2) }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('expenseprint', $item->id) }}" target="_blank" class="action-btn"
                                            title="Print Voucher">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="empty-state"><i class="bi bi-inbox"></i>No expense vouchers found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            // Client-side text search (original header search)
            document.getElementById('vchSearch').addEventListener('input', function() {
                let q = this.value.toLowerCase();
                document.querySelectorAll('#vchBody tr').forEach(function(row) {
                    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
            });

            // Advanced filters logic
            function applyFilters() {
                let voucherNo = $('#filterVoucherNo').val().toLowerCase().trim();
                let type = $('#filterType').val();
                let party = $('#filterParty').val();
                let accountHead = $('#filterAccountHead').val();
                let bankFilter = $('#filterBank').val();
                let startDate = $('#filterStartDate').val();
                let endDate = $('#filterEndDate').val();

                $('#vchBody tr').each(function() {
                    let row = $(this);
                    
                    if (row.find('.empty-state').length > 0) return;

                    let rowVoucherNo = row.find('td:nth-child(2)').text().toLowerCase().trim();
                    let dateMatch = row.find('td:nth-child(3)').text().match(/\d{4}-\d{2}-\d{2}/);
                    let rowDate = dateMatch ? dateMatch[0] : '';
                    let rowType = row.find('td:nth-child(4)').text().trim();
                    let rowParty = row.find('td:nth-child(5) .party-name').text().trim();

                    // Parse heads and accounts from data attributes
                    let rowHeads = row.data('heads') || [];
                    let rowAccounts = row.data('accounts') || [];

                    if (typeof rowHeads === 'string') {
                        try { rowHeads = JSON.parse(rowHeads); } catch(e) { rowHeads = []; }
                    }
                    if (typeof rowAccounts === 'string') {
                        try { rowAccounts = JSON.parse(rowAccounts); } catch(e) { rowAccounts = []; }
                    }

                    if (!Array.isArray(rowHeads)) rowHeads = [];
                    if (!Array.isArray(rowAccounts)) rowAccounts = [];

                    rowHeads = rowHeads.map(String);
                    rowAccounts = rowAccounts.map(String);

                    let match = true;

                    if (voucherNo && !rowVoucherNo.includes(voucherNo)) match = false;
                    if (type && rowType !== type) match = false;
                    if (party && rowParty !== party) match = false;
                    
                    // Filter by Account Head ID
                    if (accountHead) {
                        if (!rowHeads.includes(String(accountHead))) {
                            match = false;
                        }
                    }
                    
                    // Filter by Bank Account / Sub-Account
                    if (bankFilter) {
                        if (bankFilter === 'bank') {
                            if (!rowParty.toLowerCase().includes('bank')) match = false;
                        } else if (bankFilter === 'cash') {
                            if (rowParty.toLowerCase().includes('bank')) match = false;
                        } else {
                            // Specific Account ID selected
                            if (!rowAccounts.includes(String(bankFilter))) {
                                match = false;
                            }
                        }
                    }

                    if (startDate && rowDate) {
                        if (rowDate < startDate) match = false;
                    }
                    if (endDate && rowDate) {
                        if (rowDate > endDate) match = false;
                    }

                    if (match) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }

            $(document).ready(function() {
                let types = new Set();
                let parties = new Set();

                $('#vchBody tr').each(function() {
                    let row = $(this);
                    if (row.find('.empty-state').length > 0) return;

                    let t = row.find('td:nth-child(4)').text().trim();
                    let p = row.find('td:nth-child(5) .party-name').text().trim();

                    if (t) types.add(t);
                    if (p) parties.add(p);
                });

                types.forEach(val => $('#filterType').append(new Option(val, val)));
                parties.forEach(val => $('#filterParty').append(new Option(val, val)));

                // Event bindings
                $('#btnSearch').on('click', applyFilters);
                $('#btnResetFilters').on('click', function() {
                    $('#filterVoucherNo').val('');
                    $('#filterType').val('');
                    $('#filterParty').val('');
                    $('#filterAccountHead').val('');
                    $('#filterBank').html(`
                        <option value="">All Accounts</option>
                        <option value="bank">Bank Accounts Only</option>
                        <option value="cash">Cash Accounts Only</option>
                    `);
                    $('#filterStartDate').val('');
                    $('#filterEndDate').val('');
                    $('#vchBody tr').show();
                });

                $('#filterVoucherNo').on('keypress', function(e) {
                    if (e.which === 13) applyFilters();
                });

                // When Account Head changes, fetch sub-accounts
                $('#filterAccountHead').on('change', function() {
                    let headId = $(this).val();
                    let $bankSel = $('#filterBank');
                    
                    if (headId) {
                        $bankSel.html('<option value="">Loading...</option>');
                        $.ajax({
                            url: '{{ url("get-accounts-by-head") }}/' + headId,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $bankSel.html('<option value="">All Accounts</option>');
                                if (data && data.length > 0) {
                                    data.forEach(function(acc) {
                                        $bankSel.append('<option value="' + acc.id + '">' + acc.title + '</option>');
                                    });
                                }
                                applyFilters();
                            },
                            error: function() {
                                $bankSel.html('<option value="">All Accounts</option>');
                                applyFilters();
                            }
                        });
                    } else {
                        // Restore default options
                        $bankSel.html(`
                            <option value="">All Accounts</option>
                            <option value="bank">Bank Accounts Only</option>
                            <option value="cash">Cash Accounts Only</option>
                        `);
                        applyFilters();
                    }
                });

                // Trigger applyFilters when selecting option
                $('#filterType, #filterParty, #filterBank, #filterStartDate, #filterEndDate').on('change', applyFilters);
            });
        </script>
    @endsection
@endsection
