document.addEventListener('DOMContentLoaded', function() {
    initAccountCards();
    initAlertDismissal();
    addAccountBoxListeners();
});

function initAccountCards() {
    const accountCards = document.querySelectorAll('.account-box');
    accountCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('active');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('active');
        });
    });
}

function initAlertDismissal() {
    const alertCloseButtons = document.querySelectorAll('.alert .close');
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.classList.add('fade-out');
            setTimeout(() => {
                this.parentElement.remove();
            }, 300);
        });
    });
}

function addAccountBoxListeners() {
    const accountBoxes = document.querySelectorAll('.account-box');
    accountBoxes.forEach(box => {
        box.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });
        box.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });
}

function makeTablesResponsive() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
}
