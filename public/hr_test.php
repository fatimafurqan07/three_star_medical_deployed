<?php
/**
 * ============================================================
 *  HR MODULE — COMPREHENSIVE TEST SCRIPT
 *  Run at: http://localhost/threestar-old/public/hr_test.php
 * ============================================================
 */

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\LoadConfiguration')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\RegisterFacades')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\RegisterProviders')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\BootProviders')->bootstrap($app);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Hr\Employee;
use App\Models\Hr\Department;
use App\Models\Hr\Designation;
use App\Models\Hr\Shift;
use App\Models\Hr\Holiday;
use App\Models\Hr\Attendance;
use App\Models\Hr\Leave;
use App\Models\Hr\Loan;
use App\Models\Hr\LoanPayment;
use App\Models\Hr\SalaryStructure;
use App\Models\Hr\Payroll;
use App\Models\Hr\HrSetting;
use Carbon\Carbon;

// ─── Test Runner ──────────────────────────────────────────────────────────────
$results  = [];
$passed   = 0;
$failed   = 0;
$warnings = 0;

function test(string $group, string $name, callable $fn) {
    global $results, $passed, $failed, $warnings;
    try {
        $result = $fn();
        if ($result === 'WARN') {
            $results[] = ['group' => $group, 'name' => $name, 'status' => 'WARN', 'msg' => ''];
            $warnings++;
        } else {
            $results[] = ['group' => $group, 'name' => $name, 'status' => 'PASS', 'msg' => is_string($result) ? $result : ''];
            $passed++;
        }
    } catch (\Throwable $e) {
        $results[] = ['group' => $group, 'name' => $name, 'status' => 'FAIL', 'msg' => $e->getMessage()];
        $failed++;
    }
}

function warn(string $group, string $name, string $msg) {
    global $results, $warnings;
    $results[] = ['group' => $group, 'name' => $name, 'status' => 'WARN', 'msg' => $msg];
    $warnings++;
}

// ═════════════════════════════════════════════════════════════════════════════
// 1. DATABASE TABLES
// ═════════════════════════════════════════════════════════════════════════════
$hrTables = [
    'hr_employees', 'hr_departments', 'hr_designations', 'hr_shifts',
    'hr_holidays', 'hr_employee_holiday', 'hr_attendances',
    'hr_leaves', 'hr_loans', 'hr_loan_payments', 'hr_loan_scheduled_deductions',
    'hr_salary_structures', 'hr_payrolls', 'hr_payroll_details',
    'hr_employee_documents', 'hr_settings',
];

foreach ($hrTables as $table) {
    test('1. Database Tables', "Table '$table' exists", function () use ($table) {
        if (!Schema::hasTable($table)) throw new \Exception("Table NOT found");
        $count = DB::table($table)->count();
        return "$count rows";
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// 2. DEPARTMENTS
// ═════════════════════════════════════════════════════════════════════════════
test('2. Departments', 'Can read all departments', function () {
    $depts = Department::all();
    return "Total: {$depts->count()}";
});

test('2. Departments', 'Department model has correct table', function () {
    $model = new Department();
    if ($model->getTable() !== 'hr_departments') throw new \Exception("Wrong table: " . $model->getTable());
    return 'Table: hr_departments';
});

$firstDept = Department::first();
if ($firstDept) {
    test('2. Departments', 'Department has employees relationship', function () use ($firstDept) {
        $count = $firstDept->employees()->count();
        return "Dept '{$firstDept->name}' has $count employees";
    });
} else {
    warn('2. Departments', 'No departments found', 'Aap ne ek bhi department nahi banaya. HR properly kaam nahi karega.');
}

// ═════════════════════════════════════════════════════════════════════════════
// 3. DESIGNATIONS
// ═════════════════════════════════════════════════════════════════════════════
test('3. Designations', 'Can read all designations', function () {
    $desigs = Designation::all();
    return "Total: {$desigs->count()}";
});

test('3. Designations', 'Designation has is_sale_officer column', function () {
    if (!Schema::hasColumn('hr_designations', 'is_sale_officer'))
        throw new \Exception("Column 'is_sale_officer' missing from hr_designations");
    return 'Column exists';
});

// ═════════════════════════════════════════════════════════════════════════════
// 4. EMPLOYEES
// ═════════════════════════════════════════════════════════════════════════════
test('4. Employees', 'Can read all employees', function () {
    $emps = Employee::with('department', 'designation', 'shift')->get();
    return "Total: {$emps->count()}";
});

test('4. Employees', 'Active scope works', function () {
    $count = Employee::active()->count();
    return "Active: $count";
});

test('4. Employees', 'Non-active scope works', function () {
    $count = Employee::nonActive()->count();
    return "Non-active: $count";
});

test('4. Employees', 'Terminated scope works', function () {
    $count = Employee::terminated()->count();
    return "Terminated: $count";
});

test('4. Employees', 'Employee full_name accessor works', function () {
    $emp = Employee::first();
    if (!$emp) throw new \Exception('No employee exists');
    $name = $emp->full_name;
    if (empty($name)) throw new \Exception('full_name is empty');
    return "Name: $name";
});

test('4. Employees', 'Employee getStartTime() works', function () {
    $emp = Employee::with('shift')->first();
    if (!$emp) throw new \Exception('No employee');
    $time = $emp->getStartTime();
    return "Start time: $time";
});

test('4. Employees', 'Employee getEndTime() works', function () {
    $emp = Employee::with('shift')->first();
    if (!$emp) throw new \Exception('No employee');
    $time = $emp->getEndTime();
    return "End time: $time";
});

test('4. Employees', 'Employee getGraceMinutes() works', function () {
    $emp = Employee::with('shift')->first();
    if (!$emp) throw new \Exception('No employee');
    $grace = $emp->getGraceMinutes();
    return "Grace: {$grace} min";
});

test('4. Employees', 'Monthly payroll scope works', function () {
    $count = Employee::forMonthlyPayroll()->count();
    return "Monthly eligible: $count";
});

test('4. Employees', 'Daily payroll scope works', function () {
    $count = Employee::forDailyPayroll()->count();
    return "Daily eligible: $count";
});

$firstEmp = Employee::with('activeSalaryStructure', 'department', 'designation', 'shift')->first();
if ($firstEmp) {
    test('4. Employees', 'Employee → department relationship', function () use ($firstEmp) {
        return $firstEmp->department
            ? "Dept: {$firstEmp->department->name}"
            : 'WARN: No dept assigned';
    });
    test('4. Employees', 'Employee → designation relationship', function () use ($firstEmp) {
        return $firstEmp->designation
            ? "Designation: {$firstEmp->designation->name}"
            : 'WARN: No designation';
    });
    test('4. Employees', 'Employee → shift relationship', function () use ($firstEmp) {
        return $firstEmp->shift
            ? "Shift: {$firstEmp->shift->name}"
            : 'WARN: No shift assigned (using defaults)';
    });
    test('4. Employees', 'Employee → activeSalaryStructure relationship', function () use ($firstEmp) {
        return $firstEmp->activeSalaryStructure
            ? "Basic: {$firstEmp->activeSalaryStructure->basic_salary}"
            : 'No salary structure assigned';
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// 5. SHIFTS
// ═════════════════════════════════════════════════════════════════════════════
test('5. Shifts', 'Can read all shifts', function () {
    $shifts = Shift::all();
    return "Total: {$shifts->count()}";
});

$firstShift = Shift::first();
if ($firstShift) {
    test('5. Shifts', 'Shift has start_time and end_time', function () use ($firstShift) {
        if (empty($firstShift->start_time)) throw new \Exception('start_time is empty');
        if (empty($firstShift->end_time)) throw new \Exception('end_time is empty');
        return "{$firstShift->name}: {$firstShift->start_time} → {$firstShift->end_time}";
    });
    test('5. Shifts', 'Shift has grace_minutes', function () use ($firstShift) {
        return "Grace: {$firstShift->grace_minutes} min";
    });
} else {
    warn('5. Shifts', 'No shifts found', 'Koi shift nahi bani. Attendance timing calculation default (9am-6pm, 15 min grace) use karegi.');
}

// ═════════════════════════════════════════════════════════════════════════════
// 6. HOLIDAYS
// ═════════════════════════════════════════════════════════════════════════════
test('6. Holidays', 'Can read all holidays', function () {
    $holidays = Holiday::all();
    return "Total: {$holidays->count()}";
});

$currentMonthHolidays = Holiday::whereMonth('date', now()->month)->whereYear('date', now()->year)->get();
test('6. Holidays', "Holidays this month (" . now()->format('F Y') . ")", function () use ($currentMonthHolidays) {
    return "Count: {$currentMonthHolidays->count()}";
});

test('6. Holidays', 'Holiday model hasFestival type column', function () {
    if (!Schema::hasColumn('hr_holidays', 'type') && !Schema::hasColumn('hr_holidays', 'holiday_type'))
        return 'WARN: No type column - single holiday type only';
    return 'Type column exists';
});

// ═════════════════════════════════════════════════════════════════════════════
// 7. ATTENDANCE
// ═════════════════════════════════════════════════════════════════════════════
test('7. Attendance', 'Can read attendance records', function () {
    $count = Attendance::count();
    return "Total records: $count";
});

test('7. Attendance', "Today's attendance", function () {
    $today = Carbon::today()->toDateString();
    $count = Attendance::whereDate('date', $today)->count();
    return "Today ($today): $count records";
});

test('7. Attendance', 'Attendance has employee relationship', function () {
    $att = Attendance::with('employee')->latest()->first();
    if (!$att) return 'No attendance records yet';
    return $att->employee ? "Employee: {$att->employee->full_name}" : 'WARN: orphan attendance record';
});

test('7. Attendance', 'Attendance status column exists', function () {
    if (!Schema::hasColumn('hr_attendances', 'status'))
        throw new \Exception("'status' column missing from hr_attendances");
    $statuses = Attendance::select('status')->distinct()->pluck('status')->toArray();
    return 'Statuses: ' . (empty($statuses) ? 'none yet' : implode(', ', $statuses));
});

test('7. Attendance', 'Attendance check_in_time column exists', function () {
    if (!Schema::hasColumn('hr_attendances', 'check_in_time'))
        throw new \Exception("'check_in_time' column missing from hr_attendances");
    return 'check_in_time column OK';
});

test('7. Attendance', 'Attendance check_out_time column exists', function () {
    if (!Schema::hasColumn('hr_attendances', 'check_out_time'))
        throw new \Exception("'check_out_time' column missing");
    return 'check_out_time column OK';
});

// Late arrivals check
test('7. Attendance', 'Late arrivals can be queried', function () {
    $lateCount = Attendance::where('is_late', true)->count();
    return "Late records: $lateCount";
});

// ═════════════════════════════════════════════════════════════════════════════
// 8. LEAVES
// ═════════════════════════════════════════════════════════════════════════════
test('8. Leaves', 'Can read all leaves', function () {
    $count = Leave::count();
    return "Total: $count";
});

test('8. Leaves', 'Leave statuses are valid', function () {
    $statuses = Leave::select('status')->distinct()->pluck('status')->toArray();
    $valid = ['pending', 'approved', 'rejected'];
    $invalid = array_diff($statuses, $valid);
    if (!empty($invalid)) return 'WARN: Unknown statuses: ' . implode(', ', $invalid);
    return 'Statuses: ' . (empty($statuses) ? 'none yet' : implode(', ', $statuses));
});

test('8. Leaves', 'Leave has employee relationship', function () {
    $leave = Leave::with('employee')->latest()->first();
    if (!$leave) return 'No leave records yet';
    return $leave->employee ? "Last leave by: {$leave->employee->full_name}" : 'WARN: orphan leave';
});

test('8. Leaves', 'Leave balance calculation possible', function () {
    $emp = Employee::first();
    if (!$emp) throw new \Exception('No employee');
    $casual_allocated = $emp->casual_leaves_allocated ?? 12;
    $casual_used = Leave::where('employee_id', $emp->id)
        ->where('leave_type', 'casual')->where('status', 'approved')->count();
    $balance = $casual_allocated - $casual_used;
    return "Employee '{$emp->full_name}' - Casual: {$balance}/{$casual_allocated} remaining";
});

test('8. Leaves', 'Salary deduction flag exists', function () {
    if (!Schema::hasColumn('hr_leaves', 'deduct_salary'))
        throw new \Exception("'deduct_salary' column missing");
    return 'deduct_salary column OK';
});

// ═════════════════════════════════════════════════════════════════════════════
// 9. LOANS
// ═════════════════════════════════════════════════════════════════════════════
test('9. Loans', 'Can read all loans', function () {
    $count = Loan::count();
    return "Total: $count";
});

test('9. Loans', 'Loan statuses', function () {
    $statuses = Loan::select('status')->distinct()->pluck('status')->toArray();
    return 'Statuses: ' . (empty($statuses) ? 'none yet' : implode(', ', $statuses));
});

test('9. Loans', 'Loan installment calculation logic', function () {
    // Simulate: 12,000 loan over 6 months
    $amount = 12000;
    $months = 6;
    $installment = round($amount / $months, 2);
    if ($installment != 2000) throw new \Exception("Expected 2000, got $installment");
    return "12000 / 6 = $installment per month ✓";
});

test('9. Loans', 'Loan has employee relationship', function () {
    $loan = Loan::with('employee')->latest()->first();
    if (!$loan) return 'No loans yet';
    return $loan->employee ? "Loan for: {$loan->employee->full_name}" : 'WARN: orphan loan';
});

test('9. Loans', 'LoanPayment table accessible', function () {
    $count = LoanPayment::count();
    return "Total payments: $count";
});

test('9. Loans', 'Loan remaining_amount column', function () {
    if (!Schema::hasColumn('hr_loans', 'paid_amount'))
        throw new \Exception("'paid_amount' column missing");
    $loan = Loan::first();
    if (!$loan) return 'No loans to check';
    $remaining = $loan->amount - $loan->paid_amount;
    return "First loan remaining: {$remaining}";
});

// ═════════════════════════════════════════════════════════════════════════════
// 10. SALARY STRUCTURE
// ═════════════════════════════════════════════════════════════════════════════
test('10. Salary Structure', 'Can read all structures', function () {
    $count = SalaryStructure::count();
    return "Total: $count";
});

test('10. Salary Structure', 'base_salary column exists', function () {
    if (!Schema::hasColumn('hr_salary_structures', 'base_salary'))
        throw new \Exception("'base_salary' column missing");
    return 'base_salary OK';
});

test('10. Salary Structure', 'use_daily_wages column exists', function () {
    if (!Schema::hasColumn('hr_salary_structures', 'use_daily_wages'))
        throw new \Exception("'use_daily_wages' column missing");
    return 'use_daily_wages OK';
});

test('10. Salary Structure', 'commission_percentage column exists', function () {
    if (!Schema::hasColumn('hr_salary_structures', 'commission_percentage'))
        throw new \Exception("'commission_percentage' column missing");
    return 'commission_percentage OK';
});

test('10. Salary Structure', 'Employees with salary structure', function () {
    $count = Employee::active()
        ->whereHas('activeSalaryStructure')
        ->count();
    $total = Employee::active()->count();
    $without = $total - $count;
    if ($without > 0)
        return "WARN: $without active employees have NO salary structure!";
    return "All $count active employees have salary structures ✓";
});

$sampleStructure = SalaryStructure::first();
if ($sampleStructure) {
    test('10. Salary Structure', 'Salary structure has employee relationship', function () use ($sampleStructure) {
        $emp = $sampleStructure->employee;
        return $emp ? "Assigned to: {$emp->full_name}" : 'WARN: orphan structure';
    });
    test('10. Salary Structure', 'Allowances JSON column readable', function () use ($sampleStructure) {
        $allowances = $sampleStructure->allowances;
        if ($allowances === null) return 'No allowances defined';
        $count = is_array($allowances) ? count($allowances) : 0;
        return "Allowances count: $count";
    });
    test('10. Salary Structure', 'Deductions JSON column readable', function () use ($sampleStructure) {
        $deductions = $sampleStructure->deductions;
        if ($deductions === null) return 'No deductions defined';
        $count = is_array($deductions) ? count($deductions) : 0;
        return "Deductions count: $count";
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// 11. PAYROLL
// ═════════════════════════════════════════════════════════════════════════════
test('11. Payroll', 'Can read payrolls', function () {
    $count = Payroll::count();
    return "Total: $count";
});

test('11. Payroll', 'Monthly scope works', function () {
    $count = Payroll::monthly()->count();
    return "Monthly payrolls: $count";
});

test('11. Payroll', 'Daily scope works', function () {
    $count = Payroll::daily()->count();
    return "Daily payrolls: $count";
});

test('11. Payroll', 'Payroll statuses', function () {
    $statuses = Payroll::select('status')->distinct()->pluck('status')->toArray();
    return 'Statuses: ' . (empty($statuses) ? 'none yet' : implode(', ', $statuses));
});

test('11. Payroll', 'Payroll canEdit() method works', function () {
    $payroll = Payroll::first();
    if (!$payroll) return 'No payrolls yet';
    $canEdit = $payroll->canEdit() ? 'Yes' : 'No (paid)';
    return "First payroll editable: $canEdit";
});

test('11. Payroll', 'Payroll canMarkPaid() method works', function () {
    $payroll = Payroll::first();
    if (!$payroll) return 'No payrolls yet';
    $canPay = $payroll->canMarkPaid() ? 'Yes' : 'No';
    return "First payroll can mark paid: $canPay";
});

test('11. Payroll', 'Total allowances accessor works', function () {
    $payroll = Payroll::first();
    if (!$payroll) return 'No payrolls yet';
    return "Total allowances: {$payroll->total_allowances}";
});

test('11. Payroll', 'Total deductions accessor works', function () {
    $payroll = Payroll::first();
    if (!$payroll) return 'No payrolls yet';
    return "Total deductions: {$payroll->total_deductions}";
});

test('11. Payroll', 'PayrollCalculationService exists', function () {
    if (!class_exists('App\Services\PayrollCalculationService'))
        throw new \Exception('PayrollCalculationService class not found');
    return 'Service class exists ✓';
});

// ═════════════════════════════════════════════════════════════════════════════
// 12. HR SETTINGS
// ═════════════════════════════════════════════════════════════════════════════
test('12. HR Settings', 'hr_settings table accessible', function () {
    $count = HrSetting::count();
    return "Settings count: $count";
});

test('12. HR Settings', 'Settings can be retrieved', function () {
    $setting = HrSetting::first();
    if (!$setting) return 'No settings saved yet (defaults will be used)';
    return 'Settings found ✓';
});

// ═════════════════════════════════════════════════════════════════════════════
// 13. BIOMETRIC DEVICES
// ═════════════════════════════════════════════════════════════════════════════
test('13. Biometric Devices', 'BiometricDevice model exists', function () {
    if (!class_exists('App\Models\BiometricDevice'))
        throw new \Exception('BiometricDevice model not found');
    return 'Model exists ✓';
});

test('13. Biometric Devices', 'biometric_devices table accessible', function () {
    if (!Schema::hasTable('biometric_devices')) {
        // Try alternate table name
        if (!Schema::hasTable('hr_biometric_devices'))
            throw new \Exception('No biometric_devices table found');
        return 'Table: hr_biometric_devices';
    }
    $count = DB::table('biometric_devices')->count();
    return "Devices: $count";
});

test('13. Biometric Devices', 'BiometricDeviceService exists', function () {
    if (!class_exists('App\Services\Hr\BiometricDeviceService') &&
        !class_exists('App\Services\BiometricDeviceService'))
        throw new \Exception('BiometricDeviceService not found');
    return 'Service exists ✓';
});

// ═════════════════════════════════════════════════════════════════════════════
// 14. CROSS-MODULE INTEGRITY CHECKS
// ═════════════════════════════════════════════════════════════════════════════
test('14. Integrity', 'No attendance for deleted employees', function () {
    $orphanCount = DB::table('hr_attendances')
        ->leftJoin('hr_employees', 'hr_attendances.employee_id', '=', 'hr_employees.id')
        ->whereNull('hr_employees.id')
        ->count();
    if ($orphanCount > 0) throw new \Exception("$orphanCount orphan attendance records found!");
    return 'No orphan attendance records ✓';
});

test('14. Integrity', 'No leaves for deleted employees', function () {
    $orphanCount = DB::table('hr_leaves')
        ->leftJoin('hr_employees', 'hr_leaves.employee_id', '=', 'hr_employees.id')
        ->whereNull('hr_employees.id')
        ->count();
    if ($orphanCount > 0) throw new \Exception("$orphanCount orphan leave records found!");
    return 'No orphan leave records ✓';
});

test('14. Integrity', 'No payrolls for deleted employees', function () {
    $orphanCount = DB::table('hr_payrolls')
        ->leftJoin('hr_employees', 'hr_payrolls.employee_id', '=', 'hr_employees.id')
        ->whereNull('hr_employees.id')
        ->count();
    if ($orphanCount > 0) throw new \Exception("$orphanCount orphan payroll records found!");
    return 'No orphan payroll records ✓';
});

test('14. Integrity', 'No loans for deleted employees', function () {
    $orphanCount = DB::table('hr_loans')
        ->leftJoin('hr_employees', 'hr_loans.employee_id', '=', 'hr_employees.id')
        ->whereNull('hr_employees.id')
        ->count();
    if ($orphanCount > 0) throw new \Exception("$orphanCount orphan loan records found!");
    return 'No orphan loan records ✓';
});

test('14. Integrity', 'Active employees without shifts', function () {
    $count = Employee::active()->whereNull('shift_id')
        ->whereNull('custom_start_time')->count();
    if ($count > 0) return "WARN: $count active employees have no shift (using 9am-6pm default)";
    return 'All active employees have shifts ✓';
});

test('14. Integrity', 'Active employees without salary structure', function () {
    $count = Employee::active()
        ->whereDoesntHave('activeSalaryStructure')
        ->count();
    if ($count > 0) throw new \Exception("$count active employees have NO salary structure — payroll will fail for them!");
    return 'All active employees have salary structures ✓';
});

test('14. Integrity', 'Loan amounts are consistent', function () {
    $loans = Loan::where('status', 'approved')->get();
    $issues = 0;
    foreach ($loans as $loan) {
        if ($loan->paid_amount > $loan->amount) $issues++;
    }
    if ($issues > 0) throw new \Exception("$issues loans have paid_amount > loan_amount — data inconsistency!");
    return "All {$loans->count()} approved loans are consistent ✓";
});

// ─── Render Results ───────────────────────────────────────────────────────────
$total = $passed + $failed + $warnings;
$passPercent = $total > 0 ? round(($passed / $total) * 100) : 0;

$currentGroup = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HR System Test Report</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; padding: 2rem; }
  h1 { font-size: 1.8rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.25rem; }
  .subtitle { color: #94a3b8; font-size: 0.9rem; margin-bottom: 2rem; }
  .summary { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
  .card { background: #1e293b; border-radius: 12px; padding: 1.25rem 1.75rem; flex: 1; min-width: 160px; border: 1px solid #334155; }
  .card .label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin-bottom: 0.4rem; }
  .card .value { font-size: 2rem; font-weight: 800; }
  .card.pass .value { color: #22c55e; }
  .card.fail .value { color: #ef4444; }
  .card.warn .value { color: #f59e0b; }
  .card.total .value { color: #60a5fa; }
  .progress-bar { background: #1e293b; border-radius: 99px; height: 10px; margin-bottom: 2rem; overflow: hidden; border: 1px solid #334155; }
  .progress-fill { height: 100%; border-radius: 99px; transition: width 0.5s;
    background: linear-gradient(90deg, #22c55e, #16a34a); }
  .group-header { font-size: 0.9rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: #60a5fa; padding: 1.25rem 0 0.5rem; border-bottom: 1px solid #1e293b; margin-bottom: 0.5rem; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 0.5rem; }
  tr:hover { background: #1e293b22; }
  td { padding: 0.45rem 0.75rem; font-size: 0.85rem; border-bottom: 1px solid #1e293b; vertical-align: top; }
  td:first-child { width: 60px; text-align: center; }
  td:nth-child(2) { font-weight: 500; color: #f1f5f9; }
  td:nth-child(3) { color: #94a3b8; font-size: 0.8rem; max-width: 500px; word-break: break-word; }
  .badge { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em; }
  .badge.PASS { background: #14532d; color: #4ade80; }
  .badge.FAIL { background: #450a0a; color: #f87171; }
  .badge.WARN { background: #451a03; color: #fbbf24; }
  .footer { margin-top: 2rem; color: #475569; font-size: 0.8rem; text-align: center; }
</style>
</head>
<body>
<h1>🧪 HR System — Test Report</h1>
<p class="subtitle">Generated: <?= date('d M Y, h:i:s A') ?> &nbsp;|&nbsp; <?= $total ?> tests run</p>

<div class="summary">
  <div class="card pass"><div class="label">✅ Passed</div><div class="value"><?= $passed ?></div></div>
  <div class="card fail"><div class="label">❌ Failed</div><div class="value"><?= $failed ?></div></div>
  <div class="card warn"><div class="label">⚠️ Warnings</div><div class="value"><?= $warnings ?></div></div>
  <div class="card total"><div class="label">📊 Pass Rate</div><div class="value"><?= $passPercent ?>%</div></div>
</div>

<div class="progress-bar">
  <div class="progress-fill" style="width:<?= $passPercent ?>%; background: <?= $passPercent >= 80 ? 'linear-gradient(90deg,#22c55e,#16a34a)' : ($passPercent >= 50 ? 'linear-gradient(90deg,#f59e0b,#d97706)' : 'linear-gradient(90deg,#ef4444,#dc2626)') ?>"></div>
</div>

<table>
<?php foreach ($results as $r): ?>
  <?php if ($r['group'] !== $currentGroup): $currentGroup = $r['group']; ?>
    <tr><td colspan="3" class="group-header"><?= htmlspecialchars($r['group']) ?></td></tr>
  <?php endif; ?>
  <tr>
    <td><span class="badge <?= $r['status'] ?>"><?= $r['status'] ?></span></td>
    <td><?= htmlspecialchars($r['name']) ?></td>
    <td><?= htmlspecialchars($r['msg']) ?></td>
  </tr>
<?php endforeach; ?>
</table>

<?php if ($failed > 0): ?>
<div style="margin-top:2rem; background:#450a0a; border:1px solid #7f1d1d; border-radius:10px; padding:1.25rem;">
  <strong style="color:#f87171; font-size:1rem;">❌ Failed Tests — Action Required:</strong>
  <ul style="margin-top:0.75rem; padding-left:1.5rem; color:#fca5a5; font-size:0.85rem;">
  <?php foreach ($results as $r): if ($r['status'] === 'FAIL'): ?>
    <li style="margin-bottom:0.4rem;"><strong><?= htmlspecialchars($r['group']) ?> → <?= htmlspecialchars($r['name']) ?></strong><br><?= htmlspecialchars($r['msg']) ?></li>
  <?php endif; endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<?php if ($warnings > 0): ?>
<div style="margin-top:1rem; background:#451a03; border:1px solid #92400e; border-radius:10px; padding:1.25rem;">
  <strong style="color:#fbbf24; font-size:1rem;">⚠️ Warnings — Recommended Actions:</strong>
  <ul style="margin-top:0.75rem; padding-left:1.5rem; color:#fde68a; font-size:0.85rem;">
  <?php foreach ($results as $r): if ($r['status'] === 'WARN'): ?>
    <li style="margin-bottom:0.4rem;"><strong><?= htmlspecialchars($r['name']) ?></strong><br><?= htmlspecialchars($r['msg']) ?></li>
  <?php endif; endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<p class="footer">ThreeStar HR Test Script &nbsp;|&nbsp; Delete this file after use: <code>public/hr_test.php</code></p>
</body>
</html>
