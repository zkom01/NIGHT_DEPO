/**
 * Funkce pro přepínání zdroje obrázku
 * @param {HTMLElement} element - Prvek <img>, který chceme měnit
 * @param {string} img1 - Cesta k prvnímu obrázku
 * @param {string} img2 - Cesta k druhému obrázku
 */
function toggleImage(element, img1, img2) {
    // includes() kontroluje, zda text v závorce je kdekoli v adrese
    if (element.src.includes(img1)) {
        element.src = "../img/" + img2; // Tady složíme cestu k novému obrázku
    } else {
        element.src = "../img/" + img1;
    }
}

// výběr HTML tagů
const menuNav = document.querySelector("header.menu nav")
const menuIcon = document.querySelector(".img_switch")

menuIcon.addEventListener("click", () => {
    // Přepne třídu pro navigaci
    menuNav.classList.toggle("active");

    // Přepne ikonku pomocí funkce
    toggleImage(menuIcon, "more_white.png", "close_white.png");    
})


