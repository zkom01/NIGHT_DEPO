// js/search.js
const initSearch = (inputSelector, itemSelector, containerSelector) => {
    const input = document.querySelector(inputSelector);
    const container = document.querySelector(containerSelector);
    
    if (!input || !container) return; // Prevence chyb, pokud elementy na stránce nejsou

    const itemsArray = Array.from(document.querySelectorAll(itemSelector));

    const dataObjects = itemsArray.map((item, index) => {
        return {
            id: index,
            name: item.querySelector('h2')?.textContent || "",
            roleText: item.querySelector('p')?.textContent || "",
            linkHref: item.querySelector('a')?.href || "",
            linkText: item.querySelector('a')?.textContent || ""
        };
    });

    input.addEventListener("input", () => {
        const searchText = input.value.toLowerCase();
        const filteredData = dataObjects.filter(item => 
            item.name.toLowerCase().includes(searchText)
        );

        container.textContent = "";

        filteredData.forEach(data => {
            const newDiv = document.createElement('div');
            newDiv.classList.add(itemSelector.replace('.', ''));

            const h2 = document.createElement('h2');
            h2.textContent = data.name;
            newDiv.append(h2);

            const p = document.createElement('p');
            p.textContent = data.roleText;
            newDiv.append(p);

            // Zachování tvé struktury s buttons-container
            const btnSection = document.createElement('section');
            btnSection.classList.add('buttons-container');

            const a = document.createElement('a');
            a.href = data.linkHref;
            a.textContent = data.linkText;
            a.className = 'btn btn-primary';
            
            btnSection.append(a);
            newDiv.append(btnSection);

            container.append(newDiv);
        });
    });
};
