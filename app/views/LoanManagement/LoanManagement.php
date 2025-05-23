<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../controllers/LoanController.php';
$loanController = new LoanController();
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$loanTypes = $loanController->getLoanTypes();
$loanStats = $loanController->getLoanStatistics($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Management - Banking System</title>
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
                    <h1 class="h2">Loan Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="LoanApplication.php" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-plus me-1"></i> Apply for Loan
                        </a>
                        <a href="LoanStatus.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-list me-1"></i> My Loans
                        </a>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Loans</h5>
                                <h3><?php echo $loanStats['total_loans']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Active Loans</h5>
                                <h3><?php echo $loanStats['active_loans']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Borrowed</h5>
                                <h3>$<?php echo number_format($loanStats['total_borrowed'], 2); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Outstanding Balance</h5>
                                <h3>$<?php echo number_format($loanStats['outstanding_balance'], 2); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Loan Options</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($loanTypes as $loanType): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header">
                                                    <h5 class="mb-0"><?php echo htmlspecialchars($loanType['type_name']); ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Interest Rate:</strong> <?php echo $loanType['interest_rate_min']; ?>% - <?php echo $loanType['interest_rate_max']; ?>%</p>
                                                    <p><strong>Max Amount:</strong> $<?php echo number_format($loanType['max_amount'], 2); ?></p>
                                                    <p><strong>Processing Fee:</strong> <?php echo $loanType['processing_fee']; ?>%</p>
                                                    <p><?php echo htmlspecialchars($loanType['description']); ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="LoanApplication.php?loan_type=<?php echo $loanType['loan_type_id']; ?>" class="btn btn-primary">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Loan Calculator</h5>
                            </div>
                            <div class="card-body">
                                <form id="loan-calculator-form">
                                    <div class="mb-3">
                                        <label for="loan-amount" class="form-label">Loan Amount ($)</label>
                                        <input type="number" class="form-control" id="loan-amount" min="1000" step="1000" value="10000" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="interest-rate" class="form-label">Interest Rate (%)</label>
                                        <input type="number" class="form-control" id="interest-rate" min="1" max="30" step="0.1" value="5.5" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loan-term" class="form-label">Loan Term (Years)</label>
                                        <select class="form-select" id="loan-term" required>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="10" selected>10 Years</option>
                                            <option value="15">15 Years</option>
                                            <option value="20">20 Years</option>
                                            <option value="30">30 Years</option>
                                        </select>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" id="calculate-loan-btn" class="btn btn-primary">Calculate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Calculation Results</h5>
                            </div>
                            <div class="card-body">
                                <div id="calculator-results" class="d-none">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Monthly Payment</h6>
                                            <h3 id="monthly-payment">$0.00</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Total Payment</h6>
                                            <h3 id="total-payment">$0.00</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Total Interest</h6>
                                            <h3 id="total-interest">$0.00</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Interest Percentage</h6>
                                            <h3 id="interest-percentage">0%</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6>Payment Breakdown</h6>
                                    <div class="progress mb-3" style="height: 25px;">
                                        <div id="principal-bar" class="progress-bar bg-primary" style="width: 0%">
                                            Principal
                                        </div>
                                        <div id="interest-bar" class="progress-bar bg-warning" style="width: 0%">
                                            Interest
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="LoanApplication.php" class="btn btn-success">Apply for This Loan</a>
                                    </div>
                                </div>
                                <div id="calculator-placeholder" class="text-center py-5">
                                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                    <p class="lead text-muted">Enter loan details and click "Calculate" to see results</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="loanFaqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                What documents do I need to apply for a loan?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                To apply for a loan, you'll typically need proof of identity (government-issued ID), proof of income (pay stubs, tax returns), proof of address (utility bills, lease agreement), and information about your existing debts and assets. Specific requirements may vary based on the loan type and amount.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                How long does the loan approval process take?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                The loan approval process typically takes 1-7 business days, depending on the loan type and amount. Personal loans may be approved within 1-3 business days, while home loans can take 30-45 days to process. Once approved, funds are usually disbursed within 24-48 hours.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Can I pay off my loan early?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                Yes, you can pay off your loan early without any prepayment penalties. Early repayment can save you money on interest over the life of the loan. You can make extra payments toward the principal at any time or pay off the entire remaining balance in one lump sum.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                What factors affect my loan interest rate?
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                Several factors affect your loan interest rate, including your credit score, income, debt-to-income ratio, loan amount, loan term, loan type, and current market conditions. A higher credit score and lower debt-to-income ratio typically result in lower interest rates.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                What happens if I miss a loan payment?
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                If you miss a loan payment, you may be charged a late fee, and it could negatively impact your credit score. Multiple missed payments could result in default, which may lead to collection actions. If you anticipate difficulty making a payment, contact us immediately to discuss possible solutions.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calculateBtn = document.getElementById('calculate-loan-btn');
            const resultsDiv = document.getElementById('calculator-results');
            const placeholderDiv = document.getElementById('calculator-placeholder');
            calculateBtn.addEventListener('click', function() {
                const loanAmount = parseFloat(document.getElementById('loan-amount').value);
                const interestRate = parseFloat(document.getElementById('interest-rate').value);
                const loanTerm = parseInt(document.getElementById('loan-term').value);
                if (isNaN(loanAmount) || isNaN(interestRate) || isNaN(loanTerm)) {
                    alert('Please enter valid values for all fields');
                    return;
                }
                const monthlyRate = interestRate / 100 / 12;
                const totalPayments = loanTerm * 12;
                const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -totalPayments));
                const totalPayment = monthlyPayment * totalPayments;
                const totalInterest = totalPayment - loanAmount;
                const interestPercentage = (totalInterest / loanAmount) * 100;
                document.getElementById('monthly-payment').textContent = '$' + monthlyPayment.toFixed(2);
                document.getElementById('total-payment').textContent = '$' + totalPayment.toFixed(2);
                document.getElementById('total-interest').textContent = '$' + totalInterest.toFixed(2);
                document.getElementById('interest-percentage').textContent = interestPercentage.toFixed(1) + '%';
                const principalPercentage = (loanAmount / totalPayment) * 100;
                const interestPercentage2 = (totalInterest / totalPayment) * 100;
                document.getElementById('principal-bar').style.width = principalPercentage + '%';
                document.getElementById('principal-bar').textContent = 'Principal: ' + principalPercentage.toFixed(1) + '%';
                document.getElementById('interest-bar').style.width = interestPercentage2 + '%';
                document.getElementById('interest-bar').textContent = 'Interest: ' + interestPercentage2.toFixed(1) + '%';
                resultsDiv.classList.remove('d-none');
                placeholderDiv.classList.add('d-none');
            });
        });
    </script>
</body>
</html>
