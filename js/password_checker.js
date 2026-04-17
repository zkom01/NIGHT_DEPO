const password1 = document.querySelector(".password_first")
const password2 = document.querySelector(".password_second")
const paragrphText = document.querySelector(".result_text")
// Vybereme submit tlačítko uvnitř kontejneru
const submitBtn = document.querySelector("#hiden") // tlačítko podle ID "hiden"

const checkPasswords = () => {
    const p1 = password1.value
    const p2 = password2.value

    // Reset stavů
    const elements = [password1, password2, paragrphText]
    elements.forEach(el => el.classList.remove("valid", "invalid"))

    // Pokud jsou pole prázdná
    if (p1 === "" && p2 === "") {
        paragrphText.textContent = "Zvolte heslo."
        submitBtn.disabled = true // Tlačítko je neaktivní
        return
    }

    // Porovnání
    if (p1 === p2 && p1 !== "") {
        paragrphText.textContent = "Hesla jsou shodná."
        elements.forEach(el => el.classList.add("valid"))
        submitBtn.disabled = false // Tlačítko se aktivuje
    } else {
        paragrphText.textContent = "Hesla nejsou shodná"
        elements.forEach(el => el.classList.add("invalid"))
        submitBtn.disabled = true // Tlačítko se deaktivuje
    }
}

// Inicializace: Tlačítko bude neaktivní hned po načtení stránky
submitBtn.disabled = true

password1.addEventListener("input", checkPasswords)
password2.addEventListener("input", checkPasswords)