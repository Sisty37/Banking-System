function downloadReport() {
    const format = document.getElementById('format').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
  
    if (!startDate || !endDate || !format) {
      alert('Please select date range and format!');
      return;
    }
  
    alert(`Exporting report from ${startDate} to ${endDate} as ${format.toUpperCase()}...`);
    // Simulate download (in real app, trigger backend download)
  }
  
  function scheduleExport() {
    alert('Scheduled export has been set successfully!');
  }
  