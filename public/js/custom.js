document.addEventListener('DOMContentLoaded', function() {
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    const modals = document.querySelectorAll('.modal');
    const closeButtons = document.querySelectorAll('.close');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const modal = document.querySelector(targetId);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
    window.addEventListener('click', function(e) {
        modals.forEach(modal => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            } else {
                dropdown.classList.add('show');
            }
        });
    });
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle')) {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
    const alertCloseButtons = document.querySelectorAll('.alert .close');
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        });
    });
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            if (target) {
                if (target.classList.contains('show')) {
                    target.classList.remove('show');
                } else {
                    const parentAccordion = this.closest('.accordion');
                    if (parentAccordion) {
                        const openItems = parentAccordion.querySelectorAll('.accordion-collapse.show');
                        openItems.forEach(item => {
                            item.classList.remove('show');
                        });
                    }
                    target.classList.add('show');
                }
            }
        });
    });
    const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tabs = this.closest('.nav-tabs').querySelectorAll('.nav-link');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            this.classList.add('active');
            const tabContents = document.querySelectorAll('.tab-content .tab-pane');
            tabContents.forEach(content => {
                content.classList.remove('active');
                content.classList.remove('show');
            });
            const targetId = this.getAttribute('href');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
                targetContent.classList.add('show');
            }
        });
    });
    const dataTables = document.querySelectorAll('.datatable');
    dataTables.forEach(table => {
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Search...';
        searchInput.className = 'datatable-search form-control mb-3';
        table.parentNode.insertBefore(searchInput, table);
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.indexOf(searchTerm) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        const headers = table.querySelectorAll('th');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                const index = Array.from(this.parentNode.children).indexOf(this);
                sortTable(table, index);
            });
        });
    });
    function sortTable(table, column) {
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const direction = table.getAttribute('data-sort-direction') === 'asc' ? 'desc' : 'asc';
        rows.sort((a, b) => {
            const cellA = a.querySelectorAll('td')[column].textContent.trim();
            const cellB = b.querySelectorAll('td')[column].textContent.trim();
            if (!isNaN(cellA) && !isNaN(cellB)) {
                return direction === 'asc' ? cellA - cellB : cellB - cellA;
            } else {
                return direction === 'asc' ? 
                    cellA.localeCompare(cellB) : 
                    cellB.localeCompare(cellA);
            }
        });
        const tbody = table.querySelector('tbody');
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        rows.forEach(row => {
            tbody.appendChild(row);
        });
        table.setAttribute('data-sort-direction', direction);
    }
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
    function validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        const emailFields = form.querySelectorAll('input[type="email"]');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        emailFields.forEach(field => {
            if (field.value.trim() && !emailRegex.test(field.value.trim())) {
                field.classList.add('is-invalid');
                isValid = false;
            }
        });
        return isValid;
    }
    const notificationIcon = document.querySelector('.notification-icon');
    if (notificationIcon) {
        notificationIcon.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
        });
    }
});
function loadContent(url, targetId) {
    const xhr = new XMLHttpRequest();
    const target = document.getElementById(targetId);
    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                target.innerHTML = this.responseText;
            } else {
                target.innerHTML = 'Error loading content';
            }
        }
    };
    xhr.open('GET', url, true);
    xhr.send();
}
function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}
function calculateLoan(principal, rate, years) {
    const monthlyRate = rate / 100 / 12;
    const numPayments = years * 12;
    const monthlyPayment = (principal * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));
    const totalPayment = monthlyPayment * numPayments;
    const totalInterest = totalPayment - principal;
    return {
        monthlyPayment: monthlyPayment,
        totalPayment: totalPayment,
        totalInterest: totalInterest
    };
} 