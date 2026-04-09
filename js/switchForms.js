function switchForms() {
    var form1 = document.getElementById('form1');
    var form2 = document.getElementById('form2');
    var h1text = document.querySelector('#on_click h1');

    // Přepne třídu pro zobrazení druhého formuláře
    form1.classList.toggle('hiden_active');
    form2.classList.toggle('hiden_active');
    // Podmínka pro změnu textu
    if (form2.classList.contains('hiden_active')) {
        h1text.textContent = "Registrace";
    } else {
        h1text.textContent = "Přihlášení";
    }

}