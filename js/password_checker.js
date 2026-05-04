const password1 = document.querySelector(".password_first")
const password2 = document.querySelector(".password_second")
const paragrphText = document.querySelector(".result_text")
const submitBtn = document.getElementById("hiden")

// KONTROLA: Pokud na stránce chybí hesla nebo tlačítko, skript se ukončí a nevyhodí chybu
if (password1 && password2 && submitBtn) {

    const checkPasswords = () => {
        const p1 = password1.value
        const p2 = password2.value

        const elements = [password1, password2, paragrphText]
        elements.forEach(el => { if(el) el.classList.remove("valid", "invalid") })

        if (p1 === "" && p2 === "") {
            if(paragrphText) paragrphText.textContent = "Zvolte heslo."
            submitBtn.disabled = true
            return
        }

        if (p1 === p2 && p1 !== "") {
            if(paragrphText) paragrphText.textContent = "Hesla jsou shodná."
            elements.forEach(el => { if(el) el.classList.add("valid") })
            submitBtn.disabled = false
        } else {
            if(paragrphText) paragrphText.textContent = "Hesla nejsou shodná"
            elements.forEach(el => { if(el) el.classList.add("invalid") })
            submitBtn.disabled = true
        }
    }

    // Inicializace
    submitBtn.disabled = true
    password1.addEventListener("input", checkPasswords)
    password2.addEventListener("input", checkPasswords)
}
