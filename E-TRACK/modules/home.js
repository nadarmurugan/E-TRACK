document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transactionForm');
    const descriptionInput = document.getElementById('description');
    const amountInput = document.getElementById('amount');
    const typeSelect = document.getElementById('type');
    const transactionTable = document.getElementById('transactionTable').getElementsByTagName('tbody')[0];

    // Load transactions and summary from the database on page load
    loadTransactions();
    updateSummary();

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const description = descriptionInput.value.trim();
        const amount = parseFloat(amountInput.value).toFixed(2);
        const type = typeSelect.value;

        if (description && !isNaN(amount) && type) {
            addTransaction(description, amount, type);
        } else {
            showError('form-error', 'Please fill in all fields correctly.');
        }
    });

    function addTransaction(description, amount, type) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_transaction.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    displayTransaction(response.transaction);
                    updateSummary();  // Update summary after adding transaction
                } else {
                    showError('form-error', 'Error adding transaction.');
                }
            }
        };
        xhr.send(`description=${encodeURIComponent(description)}&amount=${amount}&type=${type}`);
    }

    function displayTransaction(transaction) {
        const row = transactionTable.insertRow();
        row.innerHTML = `
            <td>${transaction.description}</td>
            <td>₹${transaction.amount}</td>
            <td>${transaction.type}</td>
            <td><button class="delete-btn" data-id="${transaction.id}">Delete</button></td>
        `;

        // Add event listener to the new delete button
        row.querySelector('.delete-btn').addEventListener('click', function() {
            deleteTransaction(transaction.id, row);
        });
    }

    function deleteTransaction(id, row) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_transaction.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    row.remove();
                    updateSummary();  // Update summary after deleting transaction
                } else {
                    showError('form-error', 'Error deleting transaction.');
                }
            }
        };
        xhr.send(`id=${id}`);
    }

    function updateSummary() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_summary.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                try {
                    const summary = JSON.parse(xhr.responseText);
                    console.log('Summary data:', summary);  // Debugging line
                    if (summary.status === 'success') {
                        const income = parseFloat(summary.income).toFixed(2);
                        const expense = parseFloat(summary.expense).toFixed(2);
                        const remaining = parseFloat(summary.remaining).toFixed(2);
    
                        document.getElementById('incomeTotal').innerHTML = `<span>Income:</span> <span>₹${income}</span>`;
                        document.getElementById('expenseTotal').innerHTML = `<span>Expenses:</span> <span>₹${expense}</span>`;
                        document.getElementById('remainingAmount').innerHTML = `<span>Remaining:</span> <span>₹${remaining}</span>`;
                    } else {
                        showError('form-error', 'Error fetching summary.');
                    }
                } catch (e) {
                    showError('form-error', 'Error parsing summary data.');
                }
            }
        };
        xhr.send();
    }
    
    function loadTransactions() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_transactions.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const transactions = JSON.parse(xhr.responseText);
                transactions.forEach(transaction => displayTransaction(transaction));
            }
        };
        xhr.send();
    }

    function showError(elementId, message) {
        document.getElementById(elementId).textContent = message;
    }
});

