<?php if (isset($_SESSION['success_message'])): ?>
        <div id="flash-message" class="flash_message <?=($error) ?>"> <!-- přidáme třídu pro styl hlášky -->
            <?= htmlspecialchars($_SESSION['success_message']) ?> <!-- zobrazíme hlášku z session -->
        </div>

    <script>
        (function() {
            var msg = document.getElementById('flash-message');
            if (msg) {
                // Po načtení stránky se hláška postupně objeví
                setTimeout(function() {
                    msg.style.transition = "opacity 2s ease, transform 1s ease";
                    msg.style.opacity = "1";
                });

                // Po 2 sekundách začne mizet
                setTimeout(function() {
                    msg.style.transition = "opacity 2s ease, transform 1s ease";
                    msg.style.opacity = "0";

                    // Po dokončení animace odstraníme hlášku z DOM, aby nezůstávala jako prázdný element
                    setTimeout(function() { 
                        msg.remove(); 
                    }, 1000);
                }, 2000);
            }
        })();
    </script>
    
    <!-- Po zobrazení hlášky ji odstraníme ze session, aby se neobjevovala znovu při obnovení stránky -->
    <?php unset($_SESSION['success_message']); ?> 
<?php endif; ?>