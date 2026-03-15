<?php if (isset($_SESSION['success_message'])): ?>
        <div id="flash-message" class="flash_message <?=($error) ?>"> <!-- přidáme třídu pro styl hlášky -->
            <?= htmlspecialchars($_SESSION['success_message']) ?> <!-- zobrazíme hlášku z session -->
        </div>

    <!-- Po zobrazení hlášky ji odstraníme ze session, aby se neobjevovala znovu při obnovení stránky -->
    <?php unset($_SESSION['success_message']); ?> 
<?php endif; ?>
