const inputFile = document.getElementById("imagem");
const fileNameSpan = document.getElementById("file-name");

inputFile.addEventListener("change", function () {
    const fileName = this.files[0] ? this.files[0].name : "Nenhum arquivo escolhido";
    fileNameSpan.textContent = fileName; // Atualiza o texto abaixo
    const label = document.querySelector('label[for="imagem"]');
    if (fileName !== "Nenhum arquivo escolhido") {
        label.style.setProperty('--cor-verde', '#4CAF50'); // Adiciona uma cor de feedback
        label.setAttribute('data-text', fileName); // Adiciona data tag;
    }  

    //aplica foocus 
});


