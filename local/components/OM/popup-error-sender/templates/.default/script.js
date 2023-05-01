document.addEventListener('keydown', function(event) {
    if (event.altKey && event.code === 'Enter') {
        var selectedText = window.getSelection().toString().trim();
        if (selectedText.length > 0) {
            document.getElementById('selected-text').textContent = selectedText;
            document.getElementById('popup').style.display = 'block';
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('send-button').addEventListener('click', function () {
        var selectedText = document.getElementById('selected-text').textContent;

        BX.ajax.runComponentAction(
            'OM:popup-error-sender',
            'sendMail',
            {
                mode: 'class',
                data: {
                    text: selectedText
                }
            }
        )
        document.getElementById('popup').style.display = 'none';
    });

    document.getElementById('cancel-button').addEventListener('click', function () {
        document.getElementById('popup').style.display = 'none';
    });
});
