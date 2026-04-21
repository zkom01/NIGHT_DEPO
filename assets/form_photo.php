<form action="./upload_photo.php" method="POST" enctype="multipart/form-data">
    <label for="chose_file" class="btn btn-primary">Vyberte obrázek</label>
    <input novalidate 
        type="file" 
        name="image" 
        id="chose_file" 
        style="display: none;">

    <div id="file-name" class="file-name-display">
            Žádný soubor nebyl vybrán
    </div>

    <section class="buttons-container">
        <button type="submit" name="submit" class="btn btn-primary">Nahrát</button>
        <a href="photos.php" class="btn btn-secondary">Zrušit</a>
    </section>

</form>