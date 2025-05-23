<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="sidebar-header mb-4 text-center text-white">
                        <h4>Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/customer_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountManagement/account_management.php">
                                <i class="fas fa-user-circle me-2"></i> Account Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../FundTransfer/fund_transfer.php">
                                <i class="fas fa-exchange-alt me-2"></i> Fund Transfers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="LoanManagement.php">
                                <i class="fas fa-hand-holding-usd me-2"></i> Loan Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../BillPayment/bill_payment.php">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Bill Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Notifications/notifications.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-white" href="../UserAuthentication/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
