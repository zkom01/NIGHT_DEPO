document.getElementById('chose_file').addEventListener('change', function() {
    var fileName = this.files[0] ? this.files[0].name : "Žádný soubor nebyl vybrán";
    document.getElementById('file-name').textContent = fileName;
    
    // pokud je vybrán soubor, změna barvy textu
    if (this.files[0]) {
        document.getElementById('file-name').style.color = "#2ecc71";
    }
});
