/**
 * Global Alert Management System
 * Handles Bootstrap alerts with auto-hide functionality
 * Usage: Include this file in your pages and alerts will be managed automatically
 */

document.addEventListener('DOMContentLoaded', function () {
    // Function to handle alert auto-hide with manual dismissal support
    function setupAlertAutoHide(alert, delay) {
        let isManuallyDismissed = false;

        // Skip if alert is already dismissed
        if (alert.classList.contains('fade') && !alert.classList.contains('show')) {
            return;
        }

        // Listen for Bootstrap dismissal events
        alert.addEventListener('closed.bs.alert', function () {
            isManuallyDismissed = true;
        });

        // Also listen for click on close button as fallback
        const closeButton = alert.querySelector('.btn-close');
        if (closeButton) {
            closeButton.addEventListener('click', function () {
                isManuallyDismissed = true;
            });
        }

        // Auto-hide after delay only if not manually dismissed
        setTimeout(() => {
            if (alert.parentNode && alert.classList.contains('show') && !isManuallyDismissed) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, delay);
    }

    // Auto-hide success alerts after 3 seconds
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        // Trigger cart update event if it's a cart-related success
        if (alert.textContent.includes('تم إضافة') || alert.textContent.includes('تم تحديث') || alert.textContent.includes('تم حذف')) {
            document.dispatchEvent(new CustomEvent('cartUpdated'));
        }

        setupAlertAutoHide(alert, 3000);
    });

    // Auto-hide error alerts after 5 seconds (longer for errors)
    const errorAlerts = document.querySelectorAll('.alert-danger');
    errorAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 5000);
    });

    // Auto-hide warning alerts after 4 seconds
    const warningAlerts = document.querySelectorAll('.alert-warning');
    warningAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 4000);
    });

    // Auto-hide info alerts after 4 seconds
    const infoAlerts = document.querySelectorAll('.alert-info');
    infoAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 4000);
    });

    // Initialize form validation
    initializeFormValidation();

    // Initialize form submission handlers
    initializeFormHandlers();

    // Re-check for alerts after a short delay (for dynamically added alerts)
    setTimeout(() => {
        recheckAlerts();
    }, 100);
});

/**
 * Manual alert management functions
 * Can be called from other scripts if needed
 */
window.AlertManager = {
    /**
     * Show a custom alert
     * @param {string} message - Alert message
     * @param {string} type - Alert type (success, danger, warning, info)
     * @param {number} autoHideDelay - Auto-hide delay in milliseconds (0 = no auto-hide)
     */
    show: function (message, type = 'info', autoHideDelay = 4000) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Find the container (usually after page title)
        const container = document.querySelector('.container-fluid');
        if (container) {
            const pageTitle = container.querySelector('.page-title-box');
            if (pageTitle) {
                pageTitle.insertAdjacentHTML('afterend', alertHtml);
            } else {
                container.insertAdjacentHTML('afterbegin', alertHtml);
            }
        }

        // Auto-hide if delay is specified
        if (autoHideDelay > 0) {
            const alert = container.querySelector('.alert:last-child');
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                }
            }, autoHideDelay);
        }
    },

    /**
     * Hide all alerts
     */
    hideAll: function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        });
    },

    /**
     * Hide specific alert by type
     * @param {string} type - Alert type to hide
     */
    hideByType: function (type) {
        const alerts = document.querySelectorAll(`.alert-${type}`);
        alerts.forEach(function (alert) {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        });
    }
};

/**
 * Initialize form validation for confirm buttons
 * This function handles disabling confirm buttons until required fields are filled
 */
function initializeFormValidation() {
    // Define field configurations for different pages
    const fieldConfigs = {
        // Welding page
        'welding': ['thickness', 'total_length', 'passes', 'length', 'width', 'quantity'],
        // Rolling page
        'rolling': ['rollingname', 'thickness', 'length', 'diameter', 'width', 'quantity'],
        // Perforation page
        'perforation': ['thickness', 'length', 'width', 'perforationCount', 'punchDiameter', 'quantity'],
        // Materials normal page
        'materials-normal': ['item', 'thickness', 'length', 'width', 'quantity'],
        // Materials standard page
        'materials-standard': ['std_item', 'unit_weight', 'quantity'],
        // Cutting board page
        'cutting-board': ['thickness', 'length', 'width', 'cuttingqnty', 'quantity'],
        // Cutting bulbs page
        'cutting-bulbs': ['thickness', 'length', 'width', 'cuttinglength', 'quantity'],
        // Cutting pallets page
        'cutting-pallets': ['thickness', 'length', 'width', 'quantity'],
        // Folding pallets page
        'folding-pallets': ['thickness', 'length', 'width', 'count1', 'length1', 'count2', 'length2', 'count3', 'length3', 'count4', 'length4', 'quantity'],
        // Folding board page
        'folding-board': ['thickness', 'length', 'width', 'foldqnty', 'quantity'],
        // Folding ornaments page - form 1
        'folding-ornaments-1': ['thickness', 'length', 'width', 'quantity'],
        // Folding ornaments page - form 2
        'folding-ornaments-2': ['foldThickness', 'foldWidth', 'foldLength', 'foldQnty']
    };

    // Auto-detect page type based on URL or page-specific elements
    let pageType = detectPageType();

    if (pageType && fieldConfigs[pageType]) {
        setupFormValidation(fieldConfigs[pageType], pageType);
    }
}

/**
 * Detect the current page type
 */
function detectPageType() {
    const path = window.location.pathname;

    if (path.includes('welding')) return 'welding';
    if (path.includes('rolling')) return 'rolling';
    if (path.includes('perforation')) return 'perforation';
    if (path.includes('materials/normal')) return 'materials-normal';
    if (path.includes('materials/standard')) return 'materials-standard';
    if (path.includes('cutting/boards')) return 'cutting-board';
    if (path.includes('cutting/bulbs')) return 'cutting-bulbs';
    if (path.includes('cutting/pallet')) return 'cutting-pallets';
    if (path.includes('folding/pallet')) return 'folding-pallets';
    if (path.includes('folding/boards')) return 'folding-board';
    if (path.includes('folding/ornaments')) return 'folding-ornaments-1';

    return null;
}

/**
 * Setup form validation for a specific page
 */
function setupFormValidation(requiredFields, pageType) {
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmBtn1 = document.getElementById('confirmBtn1');
    const confirmBtn2 = document.getElementById('confirmBtn2');

    if (!confirmBtn && !confirmBtn1 && !confirmBtn2) {
        return; // No confirm buttons found
    }

    function checkFields() {
        let allFilled = true;
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            // Skip disabled fields as they are calculated dynamically
            if (!field || field.disabled) {
                return; // Skip this field
            }
            if (!field.value.trim() || field.value === 'null') {
                allFilled = false;
            }
        });

        // Update button states
        if (confirmBtn) {
            confirmBtn.disabled = !allFilled;
        }
        if (confirmBtn1) {
            confirmBtn1.disabled = !allFilled;
        }
        if (confirmBtn2) {
            // For folding ornaments page, check second form fields
            if (pageType === 'folding-ornaments-1') {
                const secondFormFields = ['foldThickness', 'foldWidth', 'foldLength', 'foldQnty'];
                let secondFormFilled = true;
                secondFormFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    // Skip disabled fields as they are calculated dynamically
                    if (!field || field.disabled) {
                        return; // Skip this field
                    }
                    if (!field.value.trim() || field.value === 'null') {
                        secondFormFilled = false;
                    }
                });
                confirmBtn2.disabled = !secondFormFilled;
            } else {
                confirmBtn2.disabled = !allFilled;
            }
        }
    }

    // Add event listeners to all required fields
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', checkFields);
            field.addEventListener('change', checkFields);
        }
    });

    // For folding ornaments page, also listen to second form fields
    if (pageType === 'folding-ornaments-1' && confirmBtn2) {
        const secondFormFields = ['foldThickness', 'foldWidth', 'foldLength', 'foldQnty'];
        secondFormFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', checkFields);
                field.addEventListener('change', checkFields);
            }
        });
    }

    // Initial check
    checkFields();
}

/**
 * Initialize form submission handlers
 * This function handles form submissions and ensures alerts work properly
 */
function initializeFormHandlers() {
    // Find all forms with confirm buttons
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            // Check if form has a confirm button
            const confirmBtn = form.querySelector('#confirmBtn, #confirmBtn1, #confirmBtn2');

            if (confirmBtn && confirmBtn.disabled) {
                e.preventDefault();
                return false;
            }

            // Allow form submission to proceed
            return true;
        });
    });

    // Handle success messages after form submission
    // This will be triggered by the server response
    document.addEventListener('formSubmitted', function (e) {
        const { success, message, type = 'success' } = e.detail;

        if (success) {
            // Show success alert
            AlertManager.show(message, type, 3000);
        }
    });

    // Handle cart update events
    document.addEventListener('cartUpdated', function () {
        // This event is already handled in the main alerts setup
        console.log('Cart updated event received');
    });
}

/**
 * Re-check for alerts that might have been added after page load
 */
function recheckAlerts() {
    // Re-check for success alerts
    const newSuccessAlerts = document.querySelectorAll('.alert-success:not([data-processed])');
    newSuccessAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        // Trigger cart update event if it's a cart-related success
        if (alert.textContent.includes('تم إضافة') || alert.textContent.includes('تم تحديث') || alert.textContent.includes('تم حذف')) {
            document.dispatchEvent(new CustomEvent('cartUpdated'));
        }
        setupAlertAutoHide(alert, 3000);
    });

    // Re-check for error alerts
    const newErrorAlerts = document.querySelectorAll('.alert-danger:not([data-processed])');
    newErrorAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 5000);
    });

    // Re-check for warning alerts
    const newWarningAlerts = document.querySelectorAll('.alert-warning:not([data-processed])');
    newWarningAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 4000);
    });

    // Re-check for info alerts
    const newInfoAlerts = document.querySelectorAll('.alert-info:not([data-processed])');
    newInfoAlerts.forEach(function (alert) {
        alert.setAttribute('data-processed', 'true');
        setupAlertAutoHide(alert, 4000);
    });
}
