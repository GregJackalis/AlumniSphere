const event = new Event('buttonsCreated');

// Trigger the custom event when buttons are created
document.dispatchEvent(event);

// Listen for the custom event to select buttons
document.addEventListener('buttonsCreated', function() {
    const buttons = document.querySelectorAll('.btn.btn-primary.displayBtn.cvBtn');
    console.log(buttons);
});