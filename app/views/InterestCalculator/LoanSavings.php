<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Loan Savings</title>
  <link rel="stylesheet" href="../../../public/css/InterestCalculator/LoanSavings.css">
</head>
<body>
  <h2>Loan Payoff Savings Calculator</h2>
  <form>
    <label for="loanAmount">Loan Amount:</label>
    <input type="number" id="loanAmount" required /><br><br>
    <label for="interest">Interest Rate (%):</label>
    <input type="number" step="0.01" id="interest" required /><br><br>
    <label for="currentTerm">Current Term (months):</label>
    <input type="number" id="currentTerm" required /><br><br>
    <label for="earlyTerm">Early Payoff Term (months):</label>
    <input type="number" id="earlyTerm" required /><br><br>
    <button type="submit">Calculate Savings</button>
  </form>
  <hr>
  <p>
    <a href="SavingsProjector.php">Back to Savings Projector</a> |
    <a href="CDCompare.php">Compare CD Options</a>
  </p>
  <script src="../../../public/js/interestcalculator.js"></script>
</body>
</html>

