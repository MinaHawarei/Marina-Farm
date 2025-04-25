function toggleForm(modalId, animal = null) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');

    if (animal) {
        // تعبئة الحقول بالبيانات الموجودة
        const inputs = modal.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (animal[input.name]) {
                input.value = animal[input.name];
            }
        });
    }
}

// إغلاق عند الضغط خارج المودال
document.addEventListener('click', function (e) {
    const modal = document.getElementById('add-form');
    const formBox = modal.querySelector('form');

    if (!modal.classList.contains('hidden') && !formBox.contains(e.target) && !e.target.closest('button[onclick="toggleForm()"]')) {
        toggleForm();
    }
});

// إغلاق بزر ESC
document.addEventListener('keydown', function (e) {
    if (e.key === "Escape") {
        const modal = document.getElementById('add-form');
        if (!modal.classList.contains('hidden')) {
            toggleForm();
        }
    }
});

