<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../appInitializer.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../controllers/AccountController.php';
require_once __DIR__ . '/../../controllers/LoanController.php';
$accountController = new AccountController();
$loanController = new LoanController();
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$accounts = $accountController->getUserAccounts($userId);
$loanTypes = $loanController->getLoanTypes();
$message = '';
$messageType = '';
$referenceNumber = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_loan'])) {
    $loanTypeId = $_POST['loan_type'] ?? '';
    $loanAmount = $_POST['loan_amount'] ?? 0;
    $loanTerm = $_POST['loan_term'] ?? 0;
    $purpose = $_POST['purpose'] ?? '';
    $accountId = $_POST['account_id'] ?? 0;
    $result = $loanController->submitLoanApplication(
        $userId,
        $loanTypeId,
        $loanAmount,
        $loanTerm,
        $purpose,
        $accountId
    );
    if ($result['success']) {
        $message = $result['message'];
        $messageType = 'success';
        $referenceNumber = $result['reference'];
    } else {
        $message = $result['message'];
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Loan Application specific styles */
        .loan-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }
        
        .loan-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            font-weight: 600;
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .loan-card-header.info {
            background-color: var(--info-color);
        }
        
        .loan-card-body {
            padding: 25px;
        }
        
        .loan-form-group {
            margin-bottom: 20px;
        }
        
        .loan-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .loan-form-input,
        .loan-form-select,
        .loan-form-textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .loan-form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .loan-form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }
        
        .loan-form-input:focus,
        .loan-form-select:focus,
        .loan-form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .loan-form-help {
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .loan-form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .loan-form-checkbox {
            margin-right: 8px;
        }
        
        .loan-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            margin-bottom: 12px;
        }
        
        .loan-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .loan-btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .loan-btn:hover {
            opacity: 0.9;
        }
        
        .loan-info-section {
            margin-top: 15px;
        }
        
        .loan-info-title {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 10px;
        }
        
        .loan-info-list {
            padding-left: 20px;
            margin-bottom: 15px;
        }
        
        .loan-info-list li {
            margin-bottom: 5px;
            color: var(--text-color);
        }
        
        .loan-calculation-result {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            background-color: rgba(var(--info-color-rgb), 0.1);
            border-left: 4px solid var(--info-color);
        }
        
        .loan-calculation-result h6 {
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--info-color);
        }
        
        .loan-calculation-result p {
            margin-bottom: 8px;
            color: var(--text-color);
        }
        
        .loan-calculation-result p:last-child {
            margin-bottom: 0;
        }
        
        .loan-calculation-result .small {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            position: relative;
            background-color: var(--card-bg);
            margin: 10% auto;
            padding: 0;
            border-radius: var(--border-radius);
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s;
        }
        
        .modal-header {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-title {
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }
        
        .modal-close {
            font-size: 24px;
            font-weight: bold;
            color: var(--text-secondary);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }
        
        .modal-body {
            padding: 20px;
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }
        
        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4 class="text-white">Banking System</h4>
                    <p class="text-white-50">Customer Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../FundTransfers/TransferWizerd.php">
                            <span class="nav-icon">💸</span> Fund Transfers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💰</span> Loan Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/PayBill.php">
                            <span class="nav-icon">📄</span> Bill Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
                            <span class="nav-icon">📤</span> Export Data
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a class="nav-link" href="../../controllers/UserAuthentication/Logout.php">
                            <span class="nav-icon">🚪</span> Logout
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Loan Application</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="LoanStatus.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-list me-1"></i> My Loans
                        </a>
                    </div>
                </div>
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <?php if ($referenceNumber): ?>
                            <br>Reference #: <?php echo $referenceNumber; ?>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Apply for a Loan</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="LoanApplication.php">
                                    <div class="mb-3">
                                        <label for="loan_type" class="form-label">Loan Type</label>
                                        <select class="form-select" id="loan_type" name="loan_type" required>
                                            <option value="">-- Select Loan Type --</option>
                                            <?php foreach ($loanTypes as $loanType): ?>
                                                <option value="<?php echo $loanType['loan_type_id']; ?>"><?php echo htmlspecialchars($loanType['type_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loan_amount" class="form-label">Loan Amount ($)</label>
                                        <input type="number" class="form-control" id="loan_amount" name="loan_amount" min="1000" step="100" required>
                                        <div class="form-text">Minimum loan amount: $1,000</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loan_term" class="form-label">Loan Term (Years)</label>
                                        <select class="form-select" id="loan_term" name="loan_term" required>
                                            <option value="">-- Select Term --</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="10">10 Years</option>
                                            <option value="15">15 Years</option>
                                            <option value="20">20 Years</option>
                                            <option value="30">30 Years</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Purpose of Loan</label>
                                        <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_id" class="form-label">Deposit Account</label>
                                        <select class="form-select" id="account_id" name="account_id" required>
                                            <option value="">-- Select Account --</option>
                                            <?php foreach ($accounts as $account): ?>
                                                <option value="<?php echo $account['account_id']; ?>">
                                                    <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Loan funds will be deposited to this account</div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                                        </label>
                                    </div>
                                    <!-- Loan Calculator Result -->
                                    <div id="loan_calculation_result" class="d-none mb-3"></div>
                                    <div class="d-grid gap-2">
                                        <button type="button" id="calculate_loan" class="btn btn-secondary mb-2">
                                            <i class="fas fa-calculator me-2"></i>Calculate Payment
                                        </button>
                                        <button type="submit" name="apply_loan" class="btn btn-primary" onclick="return validateLoanApplication()">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Loan Application
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Loan Information Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Loan Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Personal Loan</h6>
                                        <ul>
                                            <li>Interest Rate: 9.99% - 15.99%</li>
                                            <li>Term: 1-7 years</li>
                                            <li>Maximum Amount: $50,000</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Home Loan</h6>
                                        <ul>
                                            <li>Interest Rate: 4.25% - 6.50%</li>
                                            <li>Term: 10-30 years</li>
                                            <li>Maximum Amount: $1,000,000</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <h6>Auto Loan</h6>
                                        <ul>
                                            <li>Interest Rate: 3.99% - 7.25%</li>
                                            <li>Term: 1-7 years</li>
                                            <li>Maximum Amount: $100,000</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Education Loan</h6>
                                        <ul>
                                            <li>Interest Rate: 5.50% - 8.25%</li>
                                            <li>Term: 5-15 years</li>
                                            <li>Maximum Amount: $150,000</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Loan Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Loan Agreement</h6>
                    <p>By submitting this application, you agree to be bound by the terms and conditions of the loan agreement if your application is approved.</p>
                    <h6>2. Interest Rates</h6>
                    <p>Interest rates are determined based on your credit score, loan amount, and term. The final interest rate will be disclosed upon approval.</p>
                    <h6>3. Repayment</h6>
                    <p>You agree to repay the loan according to the payment schedule provided upon approval. Payments are due on the same day each month.</p>
                    <h6>4. Late Payments</h6>
                    <p>Late payments may result in additional fees and may be reported to credit bureaus, which could negatively impact your credit score.</p>
                    <h6>5. Early Repayment</h6>
                    <p>You may repay the loan in full at any time without penalty. Partial prepayments are also allowed.</p>
                    <h6>6. Default</h6>
                    <p>Failure to make payments as agreed may result in default. In the event of default, the entire unpaid balance may become immediately due.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https:
    <!-- Loan and Bill Payment JS -->
    <script src="../../../public/js/loanAndBillPayment.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loanTypeSelect = document.getElementById('loan_type');
            const loanTermSelect = document.getElementById('loan_term');
            if (loanTypeSelect && loanTermSelect) {
                loanTypeSelect.addEventListener('change', function() {
                    const loanType = this.value;
                    loanTermSelect.innerHTML = '<option value="">-- Select Term --</option>';
                    if (loanType === '1' || loanType === '3') { 
                        addTermOption(1, '1 Year');
                        addTermOption(2, '2 Years');
                        addTermOption(3, '3 Years');
                        addTermOption(5, '5 Years');
                        addTermOption(7, '7 Years');
                    } else if (loanType === '4') { 
                        addTermOption(5, '5 Years');
                        addTermOption(10, '10 Years');
                        addTermOption(15, '15 Years');
                    } else if (loanType === '2') { 
                        addTermOption(10, '10 Years');
                        addTermOption(15, '15 Years');
                        addTermOption(20, '20 Years');
                        addTermOption(30, '30 Years');
                    } else if (loanType === '5') { 
                        addTermOption(1, '1 Year');
                        addTermOption(3, '3 Years');
                        addTermOption(5, '5 Years');
                        addTermOption(10, '10 Years');
                    }
                });
                function addTermOption(value, text) {
                    const option = document.createElement('option');
                    option.value = value;
                    option.textContent = text;
                    loanTermSelect.appendChild(option);
                }
            }
            const calculateButton = document.getElementById('calculate_loan');
            const resultDiv = document.getElementById('loan_calculation_result');
            if (calculateButton && resultDiv) {
                calculateButton.addEventListener('click', function() {
                    const loanAmount = parseFloat(document.getElementById('loan_amount').value);
                    const loanTypeId = document.getElementById('loan_type').value;
                    const loanTerm = parseInt(document.getElementById('loan_term').value);
                    if (!loanAmount || !loanTypeId || !loanTerm) {
                        alert('Please fill in all required fields to calculate payment');
                        return;
                    }
                    const loanTypeOption = document.querySelector(`#loan_type option[value="${loanTypeId}"]`);
                    const loanTypeName = loanTypeOption.textContent;
                    let interestRate;
                    switch(loanTypeId) {
                        case '1': 
                            interestRate = 12.99;
                            break;
                        case '2': 
                            interestRate = 5.25;
                            break;
                        case '3': 
                            interestRate = 5.99;
                            break;
                        case '4': 
                            interestRate = 6.75;
                            break;
                        case '5': 
                            interestRate = 11.25;
                            break;
                        default:
                            interestRate = 10.00;
                    }
                    const monthlyRate = interestRate / 100 / 12;
                    const numPayments = loanTerm * 12;
                    const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));
                    const totalPayment = monthlyPayment * numPayments;
                    const totalInterest = totalPayment - loanAmount;
                    resultDiv.classList.remove('d-none');
                    resultDiv.classList.add('alert', 'alert-info');
                    resultDiv.innerHTML = `
                        <h6>Loan Calculation Result:</h6>
                        <p><strong>Loan Type:</strong> ${loanTypeName}</p>
                        <p><strong>Loan Amount:</strong> $${loanAmount.toFixed(2)}</p>
                        <p><strong>Term:</strong> ${loanTerm} year(s)</p>
                        <p><strong>Estimated Interest Rate:</strong> ${interestRate.toFixed(2)}%</p>
                        <p><strong>Monthly Payment:</strong> $${monthlyPayment.toFixed(2)}</p>
                        <p><strong>Total Payment:</strong> $${totalPayment.toFixed(2)}</p>
                        <p><strong>Total Interest:</strong> $${totalInterest.toFixed(2)}</p>
                        <p class="mb-0 small">Note: This is an estimate. Actual interest rate and payment may vary based on credit evaluation.</p>
                    `;
                });
            }
        });
    </script>
</body>
</html> 