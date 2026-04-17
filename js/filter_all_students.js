const input = document.querySelector('.search_text');
const allOneStudentsArray = Array.from(document.querySelectorAll('.one_student'));
const allStudentsDiv = document.querySelector('.all_students');

const studentsObjects = allOneStudentsArray.map( (oneStudent, index) => {
    return {
        id: index,
        studentName: oneStudent.querySelector('h2').textContent,
        studentLink: oneStudent.querySelector('a')
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
    newH2.textContent = oneFilteredStudent.studentName
    newDiv.append(newH2);
    newDiv.append(oneFilteredStudent.studentLink)

    allStudentsDiv.append(newDiv);
})

})