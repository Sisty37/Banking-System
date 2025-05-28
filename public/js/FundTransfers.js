document.addEventListener("DOMContentLoaded", function () {
<<<<<<< HEAD
    const pageTitle = document.title;
    if (pageTitle === "Beneficiary Manager") validateBeneficiaryManager();
    else if (pageTitle === "Schedule Tool") validateScheduleTool();
    else if (pageTitle === "Transfer Wizard") validateTransferWizard();
  });
  function validateBeneficiaryManager() {
    const form = document.querySelector('form');
    const beneficiaryName = document.getElementById('beneficiaryName');
    const beneficiaryAccount = document.getElementById('beneficiaryAccount');
    form.addEventListener('submit', function (event) {
      event.preventDefault(); 
      if (beneficiaryName.value.trim() === '') {
        alert('Please enter a valid Beneficiary Name.');
        return;
      }
      const accountRegex = /^\d{10}$/; 
      if (!accountRegex.test(beneficiaryAccount.value.trim())) {
        alert('Please enter a valid 10-digit Account Number.');
        return;
      }
      console.log('Beneficiary Added:', beneficiaryName.value, beneficiaryAccount.value);
      alert('Beneficiary Added Successfully!');
    });
  }
  function validateScheduleTool() {
    const form = document.querySelector('form');
    const startDate = document.getElementById('startDate');
    const frequency = document.getElementById('frequency');
    const endDate = document.getElementById('endDate');
    form.addEventListener('submit', function (event) {
      event.preventDefault(); 
      if (!startDate.value) {
        alert('Please select a Start Date.');
        return;
      }
      if (frequency.value === '') {
        alert('Please select a Frequency for the transfer.');
        return;
      }
      if (endDate.value && new Date(endDate.value) < new Date(startDate.value)) {
        alert('End Date cannot be earlier than Start Date.');
        return;
      }
      console.log('Transfer Scheduled:', startDate.value, frequency.value, endDate.value);
      alert('Transfer Scheduled Successfully!');
    });
  }
  function validateTransferWizard() {
    const form = document.querySelector('form');
    const transferType = document.getElementById('transferType');
    const fromAccount = document.getElementById('fromAccount');
    const toAccount = document.getElementById('toAccount');
    const amount = document.getElementById('amount');
    form.addEventListener('submit', function (event) {
      event.preventDefault(); 
      if (transferType.value === '') {
        alert('Please select a Transfer Type.');
        return;
      }
      if (fromAccount.value === '') {
        alert('Please select a From Account.');
        return;
      }
      if (toAccount.value.trim() === '') {
        alert('Please enter a To Account.');
        return;
      }
      if (amount.value <= 0) {
        alert('Please enter a valid amount greater than 0.');
        return;
      }
      console.log('Transfer Initiated:', transferType.value, fromAccount.value, toAccount.value, amount.value);
      alert('Transfer Initiated Successfully!');
    });
  }
  
=======
  const pageTitle = document.title;
  if (pageTitle === "Beneficiary Manager") validateBeneficiaryManager();
  else if (pageTitle === "Schedule Tool") validateScheduleTool();
  else if (pageTitle === "Transfer Wizard") validateTransferWizard();
});

function validateBeneficiaryManager() {
  const form = document.querySelector('form');
  const beneficiaryName = document.getElementById('beneficiaryName');
  const beneficiaryAccount = document.getElementById('beneficiaryAccount');

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (beneficiaryName.value.trim() === '') {
      alert('Please enter a valid Beneficiary Name.');
      return;
    }
    const accountRegex = /^\d{10}$/;
    if (!accountRegex.test(beneficiaryAccount.value.trim())) {
      alert('Please enter a valid 10-digit Account Number.');
      return;
    }
    console.log('Beneficiary Added:', beneficiaryName.value, beneficiaryAccount.value);
    alert('Beneficiary Added Successfully!');
  });
}

function validateScheduleTool() {
  const form = document.querySelector('form');
  const startDate = document.getElementById('startDate');
  const frequency = document.getElementById('frequency');
  const endDate = document.getElementById('endDate');

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!startDate.value) {
      alert('Please select a Start Date.');
      return;
    }
    if (frequency.value === '') {
      alert('Please select a Frequency for the transfer.');
      return;
    }
    if (endDate.value && new Date(endDate.value) < new Date(startDate.value)) {
      alert('End Date cannot be earlier than Start Date.');
      return;
    }
    console.log('Transfer Scheduled:', startDate.value, frequency.value, endDate.value);
    alert('Transfer Scheduled Successfully!');
  });
}

function validateTransferWizard() {
  const form = document.querySelector('form');
  const transferType = document.getElementById('transferType');
  const fromAccount = document.getElementById('fromAccount');
  const toAccount = document.getElementById('toAccount');
  const amount = document.getElementById('amount');

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (transferType.value === '') {
      alert('Please select a Transfer Type.');
      return;
    }
    if (fromAccount.value === '') {
      alert('Please select a From Account.');
      return;
    }
    if (toAccount.value.trim() === '') {
      alert('Please enter a To Account.');
      return;
    }
    if (amount.value <= 0) {
      alert('Please enter a valid amount greater than 0.');
      return;
    }
    console.log('Transfer Initiated:', transferType.value, fromAccount.value, toAccount.value, amount.value);
    alert('Transfer Initiated Successfully!');
  });
}
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
