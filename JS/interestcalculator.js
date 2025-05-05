document.addEventListener("DOMContentLoaded", function () {
    const title = document.title;
  
    if (title === "Savings Projector") setupSavingsProjector();
    else if (title === "CD Compare") setupCDCompare();
    else if (title === "Loan Savings") setupLoanSavings();
  });
  
  function setupSavingsProjector() {
    document.querySelector("form").addEventListener("submit", function (e) {
      e.preventDefault();
      const initial = parseFloat(document.getElementById("initialAmount").value);
      const monthly = parseFloat(document.getElementById("monthlyContribution").value);
      const rate = parseFloat(document.getElementById("interestRate").value) / 100 / 12;
      const years = parseFloat(document.getElementById("years").value);
      const months = years * 12;
  
      let total = initial;
      for (let i = 0; i < months; i++) {
        total += monthly;
        total += total * rate;
      }
  
      document.getElementById("savingsResult").innerText =
        `Projected Savings: $${total.toFixed(2)}`;
    });
  }
  
  function setupCDCompare() {
    document.querySelector("form").addEventListener("submit", function (e) {
      e.preventDefault();
      const amount = parseFloat(document.getElementById("cdAmount").value);
      const rate1 = parseFloat(document.getElementById("rate1").value) / 100;
      const rate2 = parseFloat(document.getElementById("rate2").value) / 100;
      const term1 = parseFloat(document.getElementById("term1").value);
      const term2 = parseFloat(document.getElementById("term2").value);
  
      const future1 = amount * Math.pow(1 + rate1, term1);
      const future2 = amount * Math.pow(1 + rate2, term2);
  
      document.getElementById("cdResult").innerHTML =
        `Option 1: $${future1.toFixed(2)}<br>Option 2: $${future2.toFixed(2)}`;
    });
  }
  
  function setupLoanSavings() {
    document.querySelector("form").addEventListener("submit", function (e) {
      e.preventDefault();
      const amount = parseFloat(document.getElementById("loanAmount").value);
      const rate = parseFloat(document.getElementById("loanRate").value) / 100 / 12;
      const term = parseFloat(document.getElementById("loanTerm").value) * 12;
      const early = parseFloat(document.getElementById("earlyTerm").value) * 12;
  
      const monthly = (amount * rate) / (1 - Math.pow(1 + rate, -term));
      const earlyMonthly = (amount * rate) / (1 - Math.pow(1 + rate, -early));
  
      const savings = (monthly * term) - (earlyMonthly * early);
  
      document.getElementById("loanResult").innerText =
        `Estimated savings by early payoff: $${savings.toFixed(2)}`;
    });
  }
  