/**
 * Funkce pro přepínání zdroje obrázku
 * @param {HTMLElement} element - Prvek <img>, který chceme měnit
 * @param {string} img1 - Název prvního obrázku
 * @param {string} img2 - Název druhého obrázku
 */
function toggleImage(element, img1, img2) {
    // Složku zjistíme dynamicky z aktuální src, aby cesta fungovala na root i v /admin/
    const imgDir = element.src.substring(0, element.src.lastIndexOf('/') + 1);
    if (element.src.includes(img1)) {
        element.src = imgDir + img2;
    } else {
        element.src = imgDir + img1;
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