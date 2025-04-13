
document.querySelectorAll('.donate-btn').forEach(button => {
    button.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        generatePixQRCode(value);
    });
});

function generatePixQRCode(value) {
    fetch('gerar_pix.php?valor=' + value)
        .then(response => response.json())
        .then(data => {
            if (data.qr_code) {
                document.getElementById('qr-code-container').innerHTML = '<img src="' + data.qr_code + '" alt="QR Code">';
                document.getElementById('popup').style.display = 'flex';
            }
        })
        .catch(error => console.error('Erro ao gerar QR Code Pix:', error));
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

function copyPixCode() {
    const pixCode = document.getElementById('qr-code-container').innerText;
    navigator.clipboard.writeText(pixCode).then(() => {
        alert('Código Pix copiado!');
    });
}
