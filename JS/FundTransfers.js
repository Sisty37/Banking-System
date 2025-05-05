document.addEventListener("DOMContentLoaded", function () {
    const pageTitle = document.title;
  
    // Call corresponding validation function based on the page title
    if (pageTitle === "Beneficiary Manager") validateBeneficiaryManager();
    else if (pageTitle === "Schedule Tool") validateScheduleTool();
    else if (pageTitle === "Transfer Wizard") validateTransferWizard();
  });
  
  // Beneficiary Manager Validation
  function validateBeneficiaryManager() {
    const form = document.querySelector('form');
    const beneficiaryName = document.getElementById('beneficiaryName');
    const beneficiaryAccount = document.getElementById('beneficiaryAccount');
  
    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent form submission
  
      // Validate Beneficiary Name
      if (beneficiaryName.value.trim() === '') {
        alert('Please enter a valid Beneficiary Name.');
        return;
      }
  
      // Validate Account Number
      const accountRegex = /^\d{10}$/; // Only 10 digit numbers allowed
      if (!accountRegex.test(beneficiaryAccount.value.trim())) {
        alert('Please enter a valid 10-digit Account Number.');
        return;
      }
  
      // If validation passes, allow form submission (for demo purposes, log to console)
      console.log('Beneficiary Added:', beneficiaryName.value, beneficiaryAccount.value);
      alert('Beneficiary Added Successfully!');
    });
  }
  
  // Schedule Tool Validation
  function validateScheduleTool() {
    const form = document.querySelector('form');
    const startDate = document.getElementById('startDate');
    const frequency = document.getElementById('frequency');
    const endDate = document.getElementById('endDate');
  
    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent form submission
  
      // Validate Start Date
      if (!startDate.value) {
        alert('Please select a Start Date.');
        return;
      }
  
      // Validate Frequency
      if (frequency.value === '') {
        alert('Please select a Frequency for the transfer.');
        return;
      }
  
      // Validate End Date (optional but should not be earlier than Start Date)
      if (endDate.value && new Date(endDate.value) < new Date(startDate.value)) {
        alert('End Date cannot be earlier than Start Date.');
        return;
      }
  
      // If validation passes, allow form submission (for demo purposes, log to console)
      console.log('Transfer Scheduled:', startDate.value, frequency.value, endDate.value);
      alert('Transfer Scheduled Successfully!');
    });
  }
  
  // Transfer Wizard Validation
  function validateTransferWizard() {
    const form = document.querySelector('form');
    const transferType = document.getElementById('transferType');
    const fromAccount = document.getElementById('fromAccount');
    const toAccount = document.getElementById('toAccount');
    const amount = document.getElementById('amount');
  
    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent form submission
  
      // Validate Transfer Type
      if (transferType.value === '') {
        alert('Please select a Transfer Type.');
        return;
      }
  
      // Validate From Account
      if (fromAccount.value === '') {
        alert('Please select a From Account.');
        return;
      }
  
      // Validate To Account
      if (toAccount.value.trim() === '') {
        alert('Please enter a To Account.');
        return;
      }
  
      // Validate Amount (must be a positive number)
      if (amount.value <= 0) {
        alert('Please enter a valid amount greater than 0.');
        return;
      }
  
      // If validation passes, allow form submission (for demo purposes, log to console)
      console.log('Transfer Initiated:', transferType.value, fromAccount.value, toAccount.value, amount.value);
      alert('Transfer Initiated Successfully!');
    });
  }
  