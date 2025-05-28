
document.addEventListener('DOMContentLoaded', function() {
    initializeDateInputs();
    setupExportFormValidation();
    setupFormatCards();
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
function initializeDateInputs() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput && endDateInput) {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        startDateInput.valueAsDate = firstDay;
        endDateInput.valueAsDate = today;
    }
}
function setupExportFormValidation() {
    const exportForm = document.querySelector('form[name="export_form"]');
    if (exportForm) {
        exportForm.addEventListener('submit', function(e) {
            const dataType = document.getElementById('data_type').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const format = document.getElementById('format').value;
            if (!dataType || !startDate || !endDate || !format) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
            if (new Date(endDate) < new Date(startDate)) {
                e.preventDefault();
                alert('End date must be after start date');
                return false;
            }
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                submitButton.disabled = true;
            }
            return true;
        });
    }
    const scheduleForm = document.querySelector('form[name="schedule_form"]');
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function(e) {
            const dataType = document.getElementById('schedule_data_type').value;
            const frequency = document.getElementById('frequency').value;
            const format = document.getElementById('schedule_format').value;
            if (!dataType || !frequency || !format) {
                e.preventDefault();
                alert('Please fill in all scheduling fields');
                return false;
            }
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Setting up...';
                submitButton.disabled = true;
            }
            return true;
        });
    }
}
function setupFormatCards() {
    const formatCards = document.querySelectorAll('.card[data-format]');
    if (formatCards.length > 0) {
        formatCards.forEach(card => {
            card.addEventListener('click', function() {
                formatCards.forEach(c => c.classList.remove('border-3', 'selected-format'));
                this.classList.add('border-3', 'selected-format');
                const formatInput = document.getElementById('selected_format');
                if (formatInput) {
                    formatInput.value = this.getAttribute('data-format');
                }
            });
        });
    }
}
function previewExport() {
    const dataType = document.getElementById('data_type').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const format = document.getElementById('format').value;
    if (!dataType || !startDate || !endDate || !format) {
        alert('Please fill in all fields to generate a preview');
        return;
    }
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    if (previewModal) {
        const modalTitle = document.querySelector('#previewModal .modal-title');
        if (modalTitle) {
            modalTitle.textContent = `Preview: ${dataType} (${format.toUpperCase()})`;
        }
        const modalBody = document.querySelector('#previewModal .modal-body');
        if (modalBody) {
            modalBody.innerHTML = `
                <div class="alert alert-info">
                    <strong>Preview of ${dataType}</strong><br>
                    Date Range: ${startDate} to ${endDate}<br>
                    Format: ${format.toUpperCase()}
                </div>
                <p>In a real application, this would show a preview of the exported data.</p>
            `;
        }
        previewModal.show();
    }
}
function downloadReport() {
    const format = document.getElementById('format').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (!startDate || !endDate || !format) {
      alert('Please select date range and format!');
      return;
    }
    alert(`Exporting report from ${startDate} to ${endDate} as ${format.toUpperCase()}...`);
  }
  function scheduleExport() {
    alert('Scheduled export has been set successfully!');
  }
  