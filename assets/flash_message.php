<?php if (isset($_SESSION['success_message'])): ?>
    
        <!-- přidáme třídu pro styl hlášky -->
        <div id="flash-message" class="flash_message <?=($_SESSION['success_message']['type']) ?>"> 
            <?= htmlspecialchars($_SESSION['success_message']['text']) ?> <!-- zobrazíme hlášku z session -->
        </div>

    <!-- Po zobrazení hlášky ji odstraníme ze session, aby se neobjevovala znovu při obnovení stránky -->
    <?php unset($_SESSION['success_message']); ?> 
<?php endif; ?>
