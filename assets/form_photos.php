<form action="./upload_photo.php" method="POST" enctype="multipart/form-data">
    <input 
        type="file" 
        name="image"
        required
    >
    <section class="buttons-container">
        <button type="submit" name="submit" class="btn btn-primary">Nahrát</button>
        <a href="index_admin.php" class="btn btn-secondary">Zpět</a>
    </section>

</form>