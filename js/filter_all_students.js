const input = document.querySelector('.search_text');
const allOneStudentsArray = Array.from(document.querySelectorAll('.one_student'));
const allStudentsDiv = document.querySelector('.all_students');

const studentsObjects = allOneStudentsArray.map( (oneStudent, index) => {
    return {
        id: index,
        studentName: oneStudent.querySelector('h2').textContent,
        studentHref: oneStudent.querySelector('a').href,      // uložíme jen URL, ne DOM element
        studentLinkText: oneStudent.querySelector('a').textContent,
        studentRoleText: oneStudent.querySelector('p').textContent
    }
})

input.addEventListener("input", () => {
    const inputText = input.value.toLowerCase();

    const filtredStudents = studentsObjects.filter( (oneStudent) => {
        return oneStudent.studentName.toLocaleLowerCase().includes(inputText);
    })

    allStudentsDiv.textContent = "";

    filtredStudents.map( (oneFilteredStudent) => {
        const newDiv = document.createElement('div');
        newDiv.classList.add("one_student");

        const newH2 = document.createElement('h2');
        newH2.textContent = oneFilteredStudent.studentName;
        newDiv.append(newH2);

        const newP = document.createElement('p');
        newP.textContent = oneFilteredStudent.studentRoleText;
        newDiv.append(newP);

        const newA = document.createElement('a');         // vytvoříme nový odkaz
        newA.href = oneFilteredStudent.studentHref;
        newA.textContent = oneFilteredStudent.studentLinkText;
        newA.className = 'btn btn-primary';
        newDiv.append(newA);

        allStudentsDiv.append(newDiv);
    })
})