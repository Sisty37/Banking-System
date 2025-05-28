
document.addEventListener('DOMContentLoaded', function() {
    initLoanCalculator();
    initBillPayment();
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
function initLoanCalculator() {
    const loanAmountInput = document.getElementById('loan_amount');
    const loanTermSelect = document.getElementById('loan_term');
    const loanTypeSelect = document.getElementById('loan_type');
    const calculateBtn = document.getElementById('calculate_loan');
    if (loanAmountInput && loanTermSelect && loanTypeSelect && calculateBtn) {
        calculateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calculateLoanDetails();
        });
        loanAmountInput.addEventListener('change', calculateLoanDetails);
        loanTermSelect.addEventListener('change', calculateLoanDetails);
        loanTypeSelect.addEventListener('change', calculateLoanDetails);
    }
}
function calculateLoanDetails() {
    const loanAmount = parseFloat(document.getElementById('loan_amount').value);
    const loanTerm = parseInt(document.getElementById('loan_term').value);
    const loanType = document.getElementById('loan_type').value;
    const resultElement = document.getElementById('loan_calculation_result');
    if (!loanAmount || !loanTerm || !loanType || !resultElement) {
        return;
    }
    let interestRate;
    switch (loanType) {
        case 'personal':
            interestRate = 12.99; 
            break;
        case 'home':
            interestRate = 5.25; 
            break;
        case 'auto':
            interestRate = 4.99; 
            break;
        case 'education':
            interestRate = 6.75; 
            break;
        case 'business':
            interestRate = 9.50; 
            break;
        default:
            interestRate = 10.00; 
    }
    const monthlyRate = interestRate / 100 / 12;
    const numPayments = loanTerm * 12;
    const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));
    const totalPayment = monthlyPayment * numPayments;
    const totalInterest = totalPayment - loanAmount;
    resultElement.innerHTML = `
        <div class="alert alert-info">
            <h5>Loan Calculation Results</h5>
            <table class="table table-sm">
                <tr>
                    <th>Loan Amount:</th>
                    <td>$${loanAmount.toFixed(2)}</td>
                </tr>
                <tr>
                    <th>Interest Rate:</th>
                    <td>${interestRate.toFixed(2)}%</td>
                </tr>
                <tr>
                    <th>Loan Term:</th>
                    <td>${loanTerm} years (${numPayments} payments)</td>
                </tr>
                <tr>
                    <th>Monthly Payment:</th>
                    <td>$${monthlyPayment.toFixed(2)}</td>
                </tr>
                <tr>
                    <th>Total Payment:</th>
                    <td>$${totalPayment.toFixed(2)}</td>
                </tr>
                <tr>
                    <th>Total Interest:</th>
                    <td>$${totalInterest.toFixed(2)}</td>
                </tr>
            </table>
        </div>
    `;
    resultElement.classList.remove('d-none');
}
function initBillPayment() {
    const billerSelect = document.getElementById('biller_id');
    const billTypeSelect = document.getElementById('bill_type');
    const accountNumberInput = document.getElementById('account_number');
    const amountInput = document.getElementById('amount');
    const newBillerFields = document.getElementById('new_biller_fields');
    if (billerSelect) {
        billerSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value === 'new') {
                if (newBillerFields) newBillerFields.classList.remove('d-none');
                if (accountNumberInput) accountNumberInput.value = '';
                if (amountInput) amountInput.value = '';
            } else {
                if (newBillerFields) newBillerFields.classList.add('d-none');
                if (this.value !== '') {
                    const billType = selectedOption.getAttribute('data-type');
                    const accountNumber = selectedOption.getAttribute('data-account');
                    const lastAmount = selectedOption.getAttribute('data-amount');
                    if (billTypeSelect) billTypeSelect.value = billType || '';
                    if (accountNumberInput) accountNumberInput.value = accountNumber || '';
                    if (amountInput) amountInput.value = lastAmount || '';
                }
            }
        });
    }
    const savedBillers = document.querySelectorAll('.select-biller');
    savedBillers.forEach(biller => {
        biller.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            const account = this.getAttribute('data-account');
            const amount = this.getAttribute('data-amount');
            if (billTypeSelect) billTypeSelect.value = type || '';
            if (billerSelect) billerSelect.value = id || '';
            if (accountNumberInput) accountNumberInput.value = account || '';
            if (amountInput) amountInput.value = amount || '';
            const formHeader = document.querySelector('.card-header.bg-primary');
            if (formHeader) {
                formHeader.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}
function validateBillPayment() {
    const billType = document.getElementById('bill_type').value;
    const billerId = document.getElementById('biller_id').value;
    const accountNumber = document.getElementById('account_number').value;
    const amount = document.getElementById('amount').value;
    const sourceAccountId = document.getElementById('source_account_id').value;
    if (!billType || !billerId || !accountNumber || !amount || !sourceAccountId) {
        alert('Please fill in all required fields');
        return false;
    }
    if (parseFloat(amount) <= 0) {
        alert('Please enter a valid amount');
        return false;
    }
    return true;
}
function validateLoanApplication() {
    const loanType = document.getElementById('loan_type').value;
    const loanAmount = document.getElementById('loan_amount').value;
    const loanTerm = document.getElementById('loan_term').value;
    const purpose = document.getElementById('purpose').value;
    const accountId = document.getElementById('account_id').value;
    const terms = document.getElementById('terms').checked;
    if (!loanType || !loanAmount || !loanTerm || !purpose || !accountId) {
        alert('Please fill in all required fields');
        return false;
    }
    if (parseFloat(loanAmount) < 1000) {
        alert('Loan amount must be at least $1,000');
        return false;
    }
    if (!terms) {
        alert('You must agree to the terms and conditions');
        return false;
    }
    return true;
}
function generateAmortizationSchedule(loanAmount, interestRate, loanTermYears) {
    const monthlyRate = interestRate / 100 / 12;
    const numPayments = loanTermYears * 12;
    const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));
    let balance = loanAmount;
    const schedule = [];
    for (let i = 1; i <= numPayments; i++) {
        const interestPayment = balance * monthlyRate;
        const principalPayment = monthlyPayment - interestPayment;
        balance -= principalPayment;
        schedule.push({
            paymentNumber: i,
            paymentDate: new Date(new Date().setMonth(new Date().getMonth() + i)),
            paymentAmount: monthlyPayment,
            principal: principalPayment,
            interest: interestPayment,
            balance: balance > 0 ? balance : 0
        });
    }
    return schedule;
} 